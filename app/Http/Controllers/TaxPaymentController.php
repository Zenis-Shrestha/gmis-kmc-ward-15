<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TaxPaymentStatus;
use App\Ward;
use App\DueYear;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Validator;
use Datatables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\TaxPayment;
use Redirect;

class TaxPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Building Tax Payments";
        $wards = Ward::orderBy('ward', 'asc')->pluck('ward', 'ward')->all();
        $dueYears = DueYear::getInAscOrder();
        return view('taxpayment-info.index', compact('pageTitle','wards', 'dueYears'));
    }

    public function getData(Request $request)
    {

        $buildingData = DB::table('tax_payment_status AS tax')
                                ->leftjoin('due_years AS due', 'due.value', '=', 'tax.due_year')
                                ->leftjoin('bldg AS b', 'tax.bin', '=', 'b.bin')
                                ->select('tax.*', 'due.name', 'b.ward')
                                ->orderBy('tax.bin', 'DESC');

        return DataTables::of($buildingData)
            ->filter(function ($query) use ($request) {
                if ($request->dueyear_select) {
                    $query->where('due.name', $request->dueyear_select);
                }
                if ($request->ward_select) {
                    $query->where('b.ward', $request->ward_select);
                }
                if ($request->match) {
                    $query->where('tax.match', $request->match);
                }
            })
            ->make(true);
    
    }

    public function create()
    {
        $pageTitle = "Import Building Tax";
        return view('taxpayment-info.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        ini_set('max_execution_time', 600);
        Validator::extend('file_extension', function ($attribute, $value, $parameters, $validator) {
                if( !in_array( $value->getClientOriginalExtension(), $parameters ) ){
                return false;
            }
            else {
                return true;
            }
        }, 'File must be csv/excel format');
        $this->validate($request,
                ['excelfile' => 'required|file_extension:csv,xls,xlsx']
        );

        if (!$request->hasfile('excelfile')) {
            
            return redirect('tax-payment/data')->with('error','Excel file is required.');
        }
        if ($request->hasFile('excelfile')) {
                
                $filename = 'building-tax-payments.' . $request->file('excelfile')->getClientOriginalExtension();

                if (Storage::disk('importtax')->exists('/' . $filename)){
                    Storage::disk('importtax')->delete('/' . $filename);
                    //deletes if already exists
                }
                $stored = $request->file('excelfile')->storeAs('/', $filename, 'importtax');
                
                if ($stored)
                {

                    $location  = Storage::disk('importtax')->getDriver()->getAdapter()->getPathPrefix();
                  
                    //checking csv file has all heading row keys
                    Excel::load($location.$filename, function($reader) {

                        // Getting all results
                        $results = $reader->get();

                        // ->all() is a wrapper for ->get() and will work the same
                        $results = $reader->all();
                        $heading = $results->getHeading();
                        $heading_row_errors = array();
                        if ( count($heading) < 5 or count($heading) >  5 ) {
                           

                            return redirect()->route('tax-payment.create');

                            return back()->withErrors(['field_name' => ['Your custom message here.']]);

                            $heading_row_errors = "Total no. of columns must be 5";
                            return Redirect::back()->withErrors(['msg' => $heading_row_errors]);
                        } else {
                        if ($heading[0] != 'bin') {
                            
                            $heading_row_errors['bin'] = "Heading row : bin is required";
                        }
                        if ($heading[1] != 'owner_name') {
                            $heading_row_errors['owner_name'] = "Heading row : owner_name is required";
                        }
                        if ($heading[2] != 'gender') {
                            $heading_row_errors['gender'] = "Heading row : gender is required";
                        }
                        if ($heading[3] != 'contact_no') {
                            $heading_row_errors['contact_no'] = "Heading row : contact_no is required";
                        }
                        if ($heading[4] != 'last_payment_date') {
                            $heading_row_errors['last_payment_date'] = "Heading row : last_payment_date is required";
                        }
                        
                        }
                        if (count($heading_row_errors) > 0) {
                            
                        return Redirect('tax-payment/create')->withErrors(['msg' => $heading_row_errors]);

                          $heading_cell_errors = array();
                            foreach($results as $key => $value) 
                            {
                              if($value->bin == '')
                              {
                                 
                                   $heading_cell_errors['bin'] = "Heading row : bin is empty or null";
                              }
                              if (count($heading_cell_errors) > 0) {
                                 return Redirect::to('https://stackoverflow.com/');
                                  //return Redirect::back()->withErrors(['msg' => $heading_cell_errors]);
                                  return redirect()->route('tax-payment.create');

                                    //return Redirect('/tax-payment/create')->withErrors(['msg' => $heading_cell_errors]);
                               }

                            }
                        }
                        
                    });
                        
                            \DB::statement('TRUNCATE TABLE tax_payments RESTART IDENTITY');
                            \DB::statement('ALTER SEQUENCE IF exists tax_payments_id_seq RESTART WITH 1');
                    
                   //echo $location;die;
                    Excel::filter('chunk')->load($location.$filename)->chunk(1000, function($results)
                    {
                            $heading_cell_errors = array();
                            foreach($results as $key => $value) 
                            {
                              if($value->bin == '')
                              {
                                 
                                   $heading_cell_errors['bin'] = "Heading row : bin is empty or null";
                              }
                              if (count($heading_cell_errors) > 0) {
                                 return Redirect::to('https://stackoverflow.com/');
                                  //return Redirect::back()->withErrors(['msg' => $heading_cell_errors]);
                                  return redirect()->route('tax-payment.create');

                                    //return Redirect('/tax-payment/create')->withErrors(['msg' => $heading_cell_errors]);
                               }
                               else {
                                        $tax_data[] = ['bin' => $value->bin, 'owner_name' => $value->owner_name, 'gender' => $value->gender, 'contact_no' => $value->contact_no, 'last_payment_date' => $value->last_payment_date];
                                        TaxPayment::insert($tax_data);
                                        \Session::flash('success','File improted successfully.');
                               }
                            }
                            if(!empty($tax_data)){
                                
                            }
                            else{
                                return Redirect('taxpayment-info.create')->withErrors(['msg' => $heading_row_errors]);

                            }
                    });
                    $message = 'Successfully Imported Building Tax Payments From Excel.';
                    $filter = \DB::statement("select fnc_taxpaymentstatus()");
                    
                    if($filter){
                        $matchCount = DB::table('tax_payment_status')->where('match', true)->count();
                        $unMatchCount = DB::table('tax_payment_status')->where('match', false)->count();
                        $message = 'Successfully Imported Building Tax Payments From Excel.';
                        $message .= ' No. of matched row is '.$matchCount;
                        $message .= ' and no. of unmatched row is '.$unMatchCount.'.';
                    }
                    //\DB::statement('select taxpayment_info.fnc_insrtupd_taxbuildowner()');

                    return redirect('tax-payment')->with('success',$message);
                        }
                
                   
                    
                    
                    
                }
                else{
                    $message = 'Building Tax Payments Not Imported From Excel.';
                }

        
        
       // return redirect('tax-payment/create');
    }

    public function export()
    {
        
        $columns = ['Tax ID', 'Owner Name', 'Last Payment Date', 'Due Year', 'Existing Tax ID'];

        $query = TaxPaymentStatus::selectAll();
        
        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(13)
            ->setBackgroundColor(Color::rgb(228, 228, 228))
            ->build();
            
        $writer = WriterFactory::create(Type::CSV);
        $writer->openToBrowser('building-tax-payments.csv')
            ->addRowWithStyle($columns, $style); //Top row of excel
            
        $query->chunk(5000, function ($taxpayments) use ($writer) {
            $writer->addRows($taxpayments->toArray());
        });

        $writer->close();
    }
}
