<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TaxPaymentStatus;
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
use App\Imports\TaxImport;
use Maatwebsite\Excel\HeadingRowImport;
use MilanTarami\NepaliCalendar\Facades\NepaliCalendar;
use App\NepaliDateToday;

class TaxPaymentController extends Controller
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
        $pageTitle = "Building Tax Payments";
        $wards = Ward::orderBy('ward', 'asc')->pluck('ward', 'ward')->all();
        $dueYears = DueYear::getInAscOrder();
        return view('taxpayment-info.index', compact('pageTitle','wards', 'dueYears'));
    }

    public function getData(Request $request)
    {
        
        

        $buildingData = 
        DB::table('bldg_tax_payments as btp')
                        ->join('bldg_tax_payment_status AS tax', 'tax.bldg_tax_payments_id', '=', 'btp.id')
                        ->join('due_years AS due', 'due.value', '=', 'tax.due_year')
                        ->join('bldg AS b', 'tax.bin', '=', 'b.bin')
                        ->select(DB::raw("btp.bin,btp.owner_name,tax.ward,  (CASE WHEN tax.match IS TRUE THEN 'Y' ELSE 'N' END) as match_col, due.name, b.ward"))
                        //->groupBy('btp.bin', 'btp.owner_name', 'tax.ward', 'tax.match', 'due.name', 'b.ward')
                        ->distinct('btp.bin')
                        ->orderBy('btp.bin', 'DESC');
           /* $where = "WHERE 1=1";
                if ($request->dueyear_select) {
                    $where .= " AND due.name ilike '%" . trim($request->dueyear_select) . "'";
                }
                if ($request->ward_select) {
                    $where .= 'b.ward='.$request->ward_select;
                }
                if ($request->match) {
                    $where .= 'btp.match_col='. $request->match;
                }
                if ($request->owner_name) {
                    $where .= " AND btp.owner_name ilike '%" . trim($request->owner_name) . "'";
                }
        
        $buildingData = DB::select(DB::raw("SELECT btp.bin,btp.owner_name,tax.ward, (CASE WHEN tax.match IS TRUE THEN 'Y' ELSE 'N' END) as match_col, due.name, b.ward FROM (select distinct on(bin) id, bin, owner_name, fiscal_year, tax_paid_end_at from bldg_tax_payments) btp 
        left join bldg_tax_payment_status tax ON tax.bldg_tax_payments_id = btp.id
        left join due_years due ON due.value = tax.due_year
        left join bldg b ON tax.bin = b.bin $where"));*/
        return DataTables::of($buildingData)
        ->filter(function ($query) use ($request) {
            if ($request->name) {
                $query->where('due.name',  'ilike', '%'.trim($request->name).'%');
            }
            if ($request->ward) {
                $query->where('b.ward', $request->ward);
            }
            if ($request->match_col) {
                $query->where('btp.match_col', $request->match_col);
            }
            if ($request->owner_name) {
                $query->where('btp.owner_name',  'ilike', '%'.trim($request->owner_name).'%');
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
        }, 'File must be csv format');
        $this->validate($request,
                ['excelfile' => 'required|file_extension:csv,xls,xlsx']
        );

        if (!$request->hasfile('excelfile')) {
            
            return redirect('tax-payment/data')->with('error','CSV file is required.');
        }
        if ($request->hasFile('excelfile')) {
                
                $filename = 'building-tax-payments.' . $request->file('excelfile')->getClientOriginalExtension();

//                if (Storage::disk('importtax')->exists('/' . $filename)){
//                    Storage::disk('importtax')->delete('/' . $filename);
//                    //deletes if already exists
//                }
                exec("rm -rf /var/www/html/taxpayment/*");
              
                $stored = $request->file('excelfile')->storeAs('/', $filename, 'importtax');
                
                if ($stored)
                {
                    $storage = Storage::disk('importtax')->path('/');
                    $location = preg_replace('/\\\\/', '', $storage);

                    $file_selection = Storage::disk('importtax')->listContents();
                    $filename = $file_selection[0]['basename'];
                    
                    //checking csv file has all heading row keys
                    $headings = (new HeadingRowImport)->toArray($location.$filename);
                    $heading_row_errors = array();
                    if (!in_array("bin", $headings[0][0])) {
                        $heading_row_errors['bin'] = "Heading row : bin is required";
                    }
                    if (!in_array("owner_name", $headings[0][0])) {
                        $heading_row_errors['owner_name'] = "Heading row : owner_name is required";
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
                    $nepali_date_today_record = $nepali_date_today->first();
                    $nepali_date_today_record->date_today = $today_nepali;
                    $nepali_date_today_record->year = $year_nepali;
                    $nepali_date_today_record->fiscal_year_end = $fiscal_year_end . '-03-31';
                    $nepali_date_today_record->save();
                    
                    \DB::statement('TRUNCATE TABLE bldg_tax_payments RESTART IDENTITY');
                    \DB::statement('ALTER SEQUENCE IF exists bldg_tax_payments_id_seq RESTART WITH 1');
                    
                    $import = new TaxImport();
                    $import->import($location.$filename);
                   
                    $message = 'Successfully Imported Building Tax Payments From Excel.';
                    $filter = \DB::statement("select fnc_bldgtaxpaymentstatus()");
                    
                    if($filter){
                        $matchCount = DB::table('bldg_tax_payment_status')->where('match', true)->count();
                        $unMatchCount = DB::table('bldg_tax_payment_status')->where('match', false)->count();
                        $message = 'Successfully Imported Building Tax Payments From Excel.';
                        $message .= ' No. of matched row is '.$matchCount;
                        $message .= ' and no. of unmatched row is '.$unMatchCount.'.';
                    }
                    
                    \DB::statement('select fnc_insrtupd_taxbuildowner()');
                    return redirect('tax-payment')->with('success',$message);
                    
                }
                else{
                    $message = 'Building Tax Payments Not Imported From Excel.';
                }

        }
        flash('Could not import from excel. Try Again');
        return redirectredirect('tax-payment');
    }

    public function export()
    {
        
        $columns = ['bin', 'owner_name', 'fiscal_year'];
        $searchData = isset($_GET['searchData']) ? $_GET['searchData'] : null;
        $ward = isset($_GET['ward']) ? $_GET['ward'] : null;
        $name = isset($_GET['name']) ? $_GET['name'] : null;
        $match_col = isset($_GET['match_col']) ? $_GET['match_col'] : null;
        $owner_name = isset($_GET['owner_name']) ? $_GET['owner_name'] : null;

        $where = "WHERE 1=1";
        if (!empty($name)) {
            $where .= " AND due.name ilike '%" . trim($name) . "'";
        }
        if (!empty($ward)) {
            $where .= ' AND b.ward='.$ward;
        }
        if (!empty($owner_name)) {
           
            $where .= " AND btp.owner_name ilike '%" . trim($owner_name) . "'";
           
        }
        if (!empty($match_col)) {
            $where .= ' AND btp.match_col='. $match_col;
        }
      
        $buildingQuery = "SELECT DISTINCT ON (btp.bin) btp.bin, btp.owner_name, btp.fiscal_year
            FROM bldg_tax_payments AS btp
            JOIN bldg_tax_payment_status AS tax ON tax.bldg_tax_payments_id = btp.id
            JOIN due_years AS due ON due.value = tax.due_year
            JOIN bldg AS b ON tax.bin = b.bin $where
            ORDER BY btp.bin DESC, tax.ward";
        
        $query = DB::select($buildingQuery);
       
    
        $writer = WriterFactory::create(Type::CSV);
        $writer->openToBrowser('tax-payments.csv')
            ->addRow($columns); // Top row of the CSV file
        
        foreach ($query as $row) {
            $writer->addRow((array) $row);
        }
        
        
        $writer->close();
        
       
    }
}
