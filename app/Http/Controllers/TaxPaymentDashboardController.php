<?php

namespace App\Http\Controllers;

use App\Ward;

use App\YesNo;

use App\TaxStsCode;

use App\RoadSurface;

use App\DueYear;

use DB;
use PDF;
class TaxPaymentDashboardController extends Controller
{
    /**
     * Creating new controller instance
     *
     * @return  void
     */
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
        $pageTitle = __("Tax Status Dashboard");
        $chartGroups = array();

        $chartGroups['rvnsts']['title'] = 'Revenue Status';
        $chartGroups['rvnsts']['charts'] = array();
        $chartGroups['rvnsts']['charts'][] = $this->getBldgTxSts();
        $chartGroups['rvnsts']['charts'][] = $this->getBldgTxStsByWard();

        return view('tax-payment-dashboard.index', compact('pageTitle', 'chartGroups'));
    }
    

    private function getBldgTxSts() {
        
        
        $query = "SELECT dy.value, dy.name, COUNT(b.bin) as c"
                . " FROM due_years dy LEFT JOIN ".'bldg_tax_payment_status'." b"
                . " ON dy.value = b.due_year"
                . " GROUP BY dy.value, dy.name ORDER BY dy.value ASC";

        $results = DB::select($query);
        $labels = array();
        $values = array();

        foreach ($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->c;
        }

        $background_colors = ['"rgba(175, 175, 175, 0.25)"', '"rgba(66, 134, 244, 0.25)"', '"rgba(0, 255, 255, 0.25)"', '"rgba(61, 229, 45, 0.25)"', '"rgba(158, 38, 244, 0.25)"', '"rgba(30, 0, 132, 0.25)"', '"rgba(255, 0, 0, 0.25)"'];
        $colors = ['"rgba(175, 175, 175, 0.5)"', '"rgba(66, 134, 244, 0.5)"', '"rgba(0, 255, 255, 0.5)"', '"rgba(61, 229, 45, 0.5)"', '"rgba(158, 38, 244, 0.5)"', '"rgba(30, 0, 132, 0.5)"', '"rgba(255, 0, 0, 0.5)"'];

        $chart = [
            'title' => 'Tax Payment Status',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors,
            'background_colors' => $background_colors
        ];

        return $chart;
    }

    private function getBldgTxStsByWard() {
        $chart = array();

        $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
        $dueYears = DueYear::orderBy('id')->pluck('name', 'value')->toArray();

        $query = 'SELECT due_year, ward, COUNT(*) AS count'
                . ' FROM bldg_tax_payment_status'
                . ' GROUP BY due_year, ward';

        $results = DB::select($query);
        
        $data = array();
        foreach($results as $row) {
            $data[$row->due_year][$row->ward] = $row->count;
        }
        
        $labels = array_map(function($ward) { return '"' . $ward . '"'; }, $wards);
        $colors = ['"rgba(175, 175, 175, 0.5)"', '"rgba(66, 134, 244, 0.5)"', '"rgba(0, 255, 255, 0.5)"', '"rgba(61, 229, 45, 0.5)"', '"rgba(158, 38, 244, 0.5)"', '"rgba(30, 0, 132, 0.5)"', '"rgba(255, 0, 0, 0.5)"'];
        $datasets = array();
        $count = 0;
        foreach($dueYears as $key1=>$value1) {
            $dataset = array();
            $dataset['label'] = '"' . $value1 . '"';
            $dataset['color'] = $colors[$count++];
            $dataset['data'] = array();
            foreach($wards as $key2=>$value2) {
                $dataset['data'][] = isset($data[$key1][$key2]) ? $data[$key1][$key2] : '0';
            }
            $datasets[] = $dataset;
        }

        $chart = array(
            'title' => 'Tax Payment Status by Ward',
            'type' => 'bar_stacked',
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $chart;
    }
    
    public function buildingsTaxReportPdf(){
        $query = "SELECT w.ward, count(b.bin),
        COUNT(DISTINCT b.bin) filter (where btps.due_year = '0' AND due_year is not Null)  AS no_due,
        COUNT(DISTINCT b.bin) filter (where btps.due_year > '0'AND due_year is not Null)  AS due,
        COUNT(DISTINCT b.bin) filter (where due_year is Null)  AS no_data
        FROM wardpl w LEFT JOIN bldg b ON b.ward = w.ward
        LEFT JOIN bldg_tax_payment_status btps
        ON b.bin= btps.bin
        GROUP BY w.ward
        ORDER BY w.ward ASC";
        $results_one = DB::select($query);
       

        $detailed_query = "SELECT w.ward, count(b.bin),
        COUNT(DISTINCT b.bin) filter (where btps.due_year = '0' AND due_year is not Null)  AS no_due,
        COUNT(DISTINCT b.bin) filter (where btps.due_year = '1' AND due_year is not Null)  AS due_one,
		COUNT(DISTINCT b.bin) filter (where btps.due_year = '2' AND due_year is not Null)  AS due_two,
		COUNT(DISTINCT b.bin) filter (where btps.due_year = '3' AND due_year is not Null)  AS due_three,
		COUNT(DISTINCT b.bin) filter (where btps.due_year = '4' AND due_year is not Null)  AS due_four,
		COUNT(DISTINCT b.bin) filter (where btps.due_year >= '5' AND due_year is not Null)  AS due_five,
        COUNT(DISTINCT b.bin) filter (where due_year is Null)  AS no_data
        FROM wardpl w LEFT JOIN bldg b ON b.ward = w.ward
        LEFT JOIN bldg_tax_payment_status btps
        ON b.bin= btps.bin
        GROUP BY w.ward
        ORDER BY w.ward ASC";
        $results_two = DB::select($detailed_query);
           
            return PDF::loadView('tax-payment-dashboard.buildings_tax_report', compact("results_one", "results_two"))->inline('Buildings Tax Report.pdf');
    
              
        }
    }

   


