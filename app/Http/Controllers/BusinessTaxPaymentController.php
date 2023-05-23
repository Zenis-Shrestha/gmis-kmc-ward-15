<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessTaxPaymentStatus;
use App\Ward;
use App\DueYear;
use DataTables;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\AbstractWriter;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BusinessTaxImport;
use Maatwebsite\Excel\HeadingRowImport;
use MilanTarami\NepaliCalendar\Facades\NepaliCalendar;
use App\NepaliDateToday;

class BusinessTaxPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Tax Payments";
        $wards = Ward::orderBy('ward', 'asc')->pluck('ward', 'ward')->all();
        $dueYears = DueYear::getInAscOrder();
        return view('business-taxpayment-info.index', compact('pageTitle','wards', 'dueYears'));
    }

    public function getData(Request $request)
    {

        $buildingData = DB::table('business_tax_payment_status AS tax')
                                ->leftjoin('due_years AS due', 'due.value', '=', 'tax.due_year')
                                ->leftjoin('bldg_business_tax AS b', 'tax.registration', '=', 'b.registration')
                                ->select('tax.*', 'due.name', 'b.ward')
                                ->orderBy('tax.business_tax_payment_id', 'DESC');

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
        $pageTitle = "Import Business Tax";
        return view('business-taxpayment-info.create', compact('pageTitle'));
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
        }, 'File must be csv format');
        $this->validate($request,
                ['excelfile' => 'required|file_extension:csv']
        );

        if (!$request->hasfile('excelfile')) {
            
            return redirect('business-tax-payment/data')->with('error','CSV file is required.');
        }
        if ($request->hasFile('excelfile')) {
                
                $filename = 'business-tax-payments.' . $request->file('excelfile')->getClientOriginalExtension();

                if (Storage::disk('importbusinesstax')->exists('/' . $filename)){
                    Storage::disk('importbusinesstax')->delete('/' . $filename);
                    //deletes if already exists
                }
                $stored = $request->file('excelfile')->storeAs('/', $filename, 'importbusinesstax');
                
                if ($stored)
                {
                    $storage = Storage::disk('importbusinesstax')->path('/');
                    $location = preg_replace('/\\\\/', '', $storage);

                    $file_selection = Storage::disk('importbusinesstax')->listContents();
                    $filename = $file_selection[0]['basename'];
                    //checking csv file has all heading row keys
                    $headings = (new HeadingRowImport)->toArray($location.$filename);
                    $heading_row_errors = array();
                    if (!in_array("registration", $headings[0][0])) {
                        $heading_row_errors['registration'] = "Heading row : registration is required";
                    }
                    
                    if (!in_array("fiscal_year", $headings[0][0])) {
                        $heading_row_errors['fiscal_year'] = "Heading row : fiscal_year is required";
                    }
                    if (count($heading_row_errors) > 0) {
                    return back()->withErrors($heading_row_errors);
                    }
                    $today_nepali = NepaliCalendar::AD2BS(today());
                    $year_nepali = substr($today_nepali, 0, 4);
                    $fiscal_year_end = $year_nepali + 1;
                    $nepali_date_today = new NepaliDateToday();
                    $nepali_date_today_record = $nepali_date_today->skip(1)->take(1)->first();
                    $nepali_date_today_record->date_today = $today_nepali;
                    $nepali_date_today_record->year = $year_nepali;
                    $nepali_date_today_record->fiscal_year_end = $fiscal_year_end . '-03-31';
                    $nepali_date_today_record->save();
                    
                    \DB::statement('TRUNCATE TABLE business_tax_payments RESTART IDENTITY');
                    \DB::statement('ALTER SEQUENCE IF exists business_tax_payments_id_seq RESTART WITH 1');
                    
                    $import = new BusinessTaxImport();
                    $import->import($location.$filename);
                   
                    $message = 'Successfully Imported Business Tax Payments From Excel.';
                    $filter = \DB::statement("select fnc_businesstaxpaymentstatus()");
                    
                    if($filter){
                        $matchCount = DB::table('business_tax_payment_status')->where('match', true)->count();
                        $unMatchCount = DB::table('business_tax_payment_status')->where('match', false)->count();
                        $message = 'Successfully Imported Business Tax Payments From Excel.';
                        $message .= ' No. of matched row is '.$matchCount;
                        $message .= ' and no. of unmatched row is '.$unMatchCount.'.';
                    }
                    

                    return redirect('business-tax-payment')->with('success',$message);
                    
                }
                else{
                    $message = 'Business Tax Payments Not Imported From Excel.';
                }

        }
        flash('Could not import from excel. Try Again');
        return redirectredirect('business-tax-payment');
    }

    public function export()
    {
        
        $columns = ['registration', 'Ward', 'Due Year', 'Due Year', 'Match'];

        $query = BusinessTaxPaymentStatus::selectAll();
        
        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(13)
            ->setBackgroundColor(Color::rgb(228, 228, 228))
            ->build();
            
        $writer = WriterFactory::create(Type::CSV);
        $writer->openToBrowser('business-tax-payments.csv')
            ->addRowWithStyle($columns, $style); //Top row of excel
            
        $query->chunk(5000, function ($taxpayments) use ($writer) {
            $writer->addRows($taxpayments->toArray());
        });

        $writer->close();
    }
}
