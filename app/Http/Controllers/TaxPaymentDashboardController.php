<?php

namespace App\Http\Controllers;

use App\Ward;

use App\YesNo;

use App\TaxStsCode;

use App\RoadSurface;

use App\DueYear;

use DB;
use PDF;
use App\BuildingBusiness;

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

        $chartGroups['rvnsts']['title'] = 'Building Revenue Status';
        $chartGroups['rvnsts']['charts'] = array();
        $chartGroups['rvnsts']['charts'][] = $this->getBldgTxSts();
        $chartGroups['rvnsts']['charts'][] = $this->getBldgTxStsByWard();
        $chartGroups['rvnsts']['charts'][] = $this->getConcreteBeamBldgTxStsByWard();
        $chartGroups['rvnsts']['charts'][] = $this->getBldgTxStsByYocWard();
        
        
        $chartGroups['businessrvnsts']['title'] = 'Business Revenue Status';
        $chartGroups['businessrvnsts']['charts'] = array();
        $chartGroups['businessrvnsts']['charts'][] = $this->getBusinessWard();
        $chartGroups['businessrvnsts']['charts'][] = $this->getRegstrationStatus();
        $chartGroups['businessrvnsts']['charts'][] = $this->getBusinessMainCategoryByWard();
        $chartGroups['businessrvnsts']['charts'][] = $this->getBusinessTxSts();
        $chartGroups['businessrvnsts']['charts'][] = $this->getBusinessTxStsByWard();
        $chartGroups['businessrvnsts']['charts'][] = $this->getBusinessByAnnualRenewalMarkerAreas();
        $chartGroups['businessrvnsts']['charts'][] = $this->getBusinessByAnnualRenewalOtherAreas();
        
        
       
        //$chartGroups['businessrvnsts']['charts'][] = $this->getBusinessSubCategoryByWard();
        $chartGroups['rentrvnsts']['title'] = 'Rent Revenue Status';
        $chartGroups['rentrvnsts']['charts'][] = $this->getRentWard();
        $chartGroups['rentrvnsts']['charts'][] = $this->getRentHouseType();
         
      
        // $chartGroups['businessrvnsts']['charts'][] = $this->getBusinessSubCategoryByWard();
        
        
        return view('tax-payment-dashboard.index', compact('pageTitle', 'chartGroups'));
    }
    

    private function getBldgTxSts() {
        
        
        $query = "WITH bldg_tax_payment_status_due_years AS (
        SELECT 
            b.bin, 
            (CASE 
                WHEN btps.due_year is NULL THEN 99

                ELSE btps.due_year
            END) due_year_raw


        FROM
            bldg b
                    left join bldg_tax_payment_status btps ON btps.bin = b.bin
        )
        SELECT
           count(bdy.bin) AS c,
             dy.name, dy.value

        FROM 
                due_years dy
                LEFT JOIN
            bldg_tax_payment_status_due_years bdy
                ON bdy.due_year_raw = dy.value


                GROUP BY dy.value, dy.name
        ORDER BY 
        dy.value";
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

        $query = 'WITH bldg_tax_payment_status_due_years AS (
        SELECT 
        b.bin, 
	(CASE 
            WHEN btps.due_year is NULL THEN 99
            
            ELSE btps.due_year
        END) due_year_raw, b.ward
	
            
        FROM
            bldg b
                    left join bldg_tax_payment_status btps ON btps.bin = b.bin
        )
        SELECT
           count(bdy.bin) AS count,
             dy.value AS due_year, bdy.ward

        FROM 
	due_years dy
	LEFT JOIN
        bldg_tax_payment_status_due_years bdy
	ON bdy.due_year_raw = dy.value
	

	GROUP BY dy.value,  bdy.ward';

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
    private function getConcreteBeamBldgTxStsByWard() {
        $chart = array();

        $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
        $dueYears = array('No Due' => 'No Due', 'Due' => 'Due', 'Data To be Collected' => 'Data To be Collected');
     
        $query = "
        SELECT 
           COUNT(b.bin) AS count, 
            (CASE 
                WHEN btps.due_year is NOT NULL OR btps.due_year = 0 THEN 'No Due'
                            WHEN btps.due_year is NOT NULL OR (btps.due_year > 0 AND btps.due_year < 99) THEN 'Due'
                            WHEN btps.due_year is NULL OR btps.due_year = 99 THEN 'Data To be Collected'
                    END
            ) tax_due, b.ward AS ward


        FROM
        bldg b
        LEFT JOIN bldg_tax_payment_status btps ON btps.bin = b.bin
		WHERE b.consttyp = 1
	    GROUP BY btps.due_year, b.ward";

        $results = DB::select($query);
        
        $data = array();
        foreach($results as $row) {
            $data[$row->tax_due][$row->ward] = $row->count;
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
            'title' => 'Concrete Piller/Beam Tax Vs Ward',
            'type' => 'bar_stacked',
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $chart;
    }
    private function getBldgTxStsByYocWard() {
        $chart = array();

        $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
        $dueYears = array('No Due' => 'No Due', 'Due' => 'Due', 'Data To be Collected' => 'Data To be Collected');

        $query = "SELECT 
           COUNT(b.bin) AS count, 
            (CASE 
                WHEN btps.due_year is NOT NULL OR btps.due_year = 0 THEN 'No Due'
                            WHEN btps.due_year is NOT NULL OR (btps.due_year > 0 AND btps.due_year < 99) THEN 'Due'
                            WHEN btps.due_year is NULL OR btps.due_year = 99 THEN 'Data To be Collected'
                    END
            ) tax_due, b.ward AS ward


        FROM
        bldg b
        LEFT JOIN bldg_tax_payment_status btps ON btps.bin = b.bin
		WHERE b.yoc < 20
	    GROUP BY btps.due_year, b.ward";
	
        $results = DB::select($query);
        
        $data = array();
        foreach($results as $row) {
            $data[$row->tax_due][$row->ward] = $row->count;
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
            'title' => 'Year of construction( less than 20 years ) Tax Vs Ward',
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
        
        private function getRegstrationStatus() {
        
                
            $query = 'SELECT registration_status, COUNT(*) AS count 
            FROM bldg_business_tax
            WHERE registration_status IS NOT NULL 
            GROUP BY registration_status';
    
            $results = DB::select($query);
           
            $labels = array();
            $values = array();
            foreach($results as $row) {
                if ($row->registration_status) {
                    $labels[] = '"Yes"';
                } else {
                    $labels[] = '"No"';
                }
                $values[] = $row->count;
            }
          
            
            $background_colors = ['"rgba(175, 175, 175, 0.25)"', '"rgba(66, 134, 244, 0.25)"', '"rgba(0, 255, 255, 0.25)"', '"rgba(61, 229, 45, 0.25)"', '"rgba(158, 38, 244, 0.25)"', '"rgba(30, 0, 132, 0.25)"', '"rgba(255, 0, 0, 0.25)"'];
        $colors = ['"rgba(175, 175, 175, 0.5)"', '"rgba(66, 134, 244, 0.5)"'];

    
            $chart =[
                'title' => 'Registration Status',
                'type' => 'pie',
                'labels' => $labels,
                'values' => $values,
                'colors' => $colors,
                'background_colors' => $background_colors
            ];
    
            return $chart;
        }
    
        
        private function getBusinessWard() {
            
        $chart = array();

        $query = 'SELECT w.ward, COUNT(b.id) AS count'
                    . ' FROM wardpl w'
                    . ' LEFT JOIN bldg_business_tax b'
                    . ' ON b.ward = w.ward'
                    . ' GROUP BY w.ward'
                    . ' ORDER BY w.ward';

            $results = DB::select($query);

            $labels = array();
            $values = array();
            foreach($results as $row) {
                $labels[] = '"' . $row->ward . '"';
                $values[] = $row->count;
            }

            $chart = array(
                'title' => 'Business by Ward',
                'type' => 'bar',
                'labels' => $labels,
                'values' => $values,
                'datasetLabel' => '"No. of business"'
            );

            return $chart;
        }
        
       
    private function getBusinessTxSts() {
        
        
        
        $query = "WITH business_tax_payment_status_due_years AS (
        SELECT 
            b.id, 
            (CASE 
                WHEN btps.due_year is NULL THEN 99

                ELSE btps.due_year
            END) due_year_raw


        FROM
            bldg_business_tax b
                    left join business_tax_payment_status btps ON btps.registration = b.registration
        )
        SELECT
           count(bdy.id) AS c,
             dy.name, dy.value

        FROM 
                due_years dy
                LEFT JOIN
            business_tax_payment_status_due_years bdy
                ON bdy.due_year_raw = dy.value


                GROUP BY dy.value, dy.name
        ORDER BY 
        dy.value";
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
    private function getBusinessTxStsByWard() {
            
        $chart = array();

        $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
        $dueYears = array('No Due' => 'No Due', 'Due' => 'Due', 'Data To be Collected' => 'Data To be Collected');

        $query = "WITH business_tax_payment_status_due_years AS (SELECT 
        b.bin, 
	(CASE 
                WHEN btps.due_year is NOT NULL OR btps.due_year = 0 THEN 'No Due'
                            WHEN btps.due_year is NOT NULL OR (btps.due_year > 0 AND btps.due_year < 99) THEN 'Due'
                            WHEN btps.due_year is NULL OR btps.due_year = 99 THEN 'Data To be Collected'
                    END
        ) due_year_raw, b.ward
            
        FROM
            bldg_business_tax b
                    left join business_tax_payment_status btps ON btps.registration = b.registration
        )
        SELECT
           count(bdy.bin) AS count,
             bdy.due_year_raw AS due_year, bdy.ward
        FROM 
        business_tax_payment_status_due_years bdy
	GROUP BY bdy.due_year_raw,  bdy.ward";
        
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
            'title' => 'Tax Payment Tax Paid Status by Ward',
            'type' => 'bar_stacked',
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $chart;
      
    }
     private function getBusinessMainCategoryByWard() {
            
        $chart = array();

        $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
        $businessmaintype = BuildingBusiness::whereNotNull(['businessmaintype', 'ward'])->orderBy('businessmaintype')->groupBy('businessmaintype', 'ward')->pluck('businessmaintype', 'businessmaintype')->toArray();;

        $query = 'SELECT count(businessmaintype) as count, ward, businessmaintype from bldg_business_tax WHERE ward is NOT NULL AND businessmaintype is NOT NULL group by businessmaintype, ward';
        
        $results = DB::select($query);
       
        $data = array();
        foreach($results as $row) {
            $data[$row->businessmaintype][$row->ward] = $row->count;
        }
        
        $labels = array_map(function($ward) { return '"' . $ward . '"'; }, $wards);

        for ($i = 0; $i < 40; $i++) {
            $red = ($i % 5) * 51;
            $green = (floor($i / 5) % 5) * 51;
            $blue = (floor($i / 25) % 5) * 51;
            $color = sprintf('#%02X%02X%02X', $red, $green, $blue);
            $colors[] = '"' . $color . '"';
        }
            $datasets = array();
            $count = 0;
          
        
           foreach($businessmaintype as $key1=>$value1) {
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
            'title' => 'Business Main Category by Ward',
            'type' => 'bar_stacked',
            'labels' => $labels,
            'datasets' => $datasets,
           
        );

      
        return $chart;
      
    }

    // private function getBusinessSubCategoryByWard() {
            
    //     $chart = array();

    //     $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
    //     $businesstype = BuildingBusiness::whereNotNull(['businesstype', 'ward'])->orderBy('businesstype')->groupBy('businesstype', 'ward')->pluck('businesstype', 'businesstype')->toArray();;

    //     $query = 'SELECT count(businesstype) as count, ward, businesstype from bldg_business_tax WHERE ward is NOT NULL AND businesstype is NOT NULL group by businesstype, ward';
        
    //     $results = DB::select($query);
       
    //     $data = array();
    //     foreach($results as $row) {
    //         $data[$row->businesstype][$row->ward] = $row->count;
    //     }
       
    //     $labels = array_map(function($ward) { return '"' . $ward . '"'; }, $wards);

      
    //     $colors = array();


    //     for ($i = 0; $i < 196; $i++) {
    //         $red = ($i % 5) * 51;
    //         $green = (floor($i / 5) % 5) * 51;
    //         $blue = (floor($i / 25) % 5) * 51;
    //         $color = sprintf('#%02X%02X%02X', $red, $green, $blue);
    //         $colors[] = '"' . $color . '"';
    //     }

    //         $datasets = array();
    //         $count = 0;
       
    //         foreach($businesstype as $key1=>$value1) {
    //             $dataset = array();
    //             $dataset['label'] = '"' . $value1 . '"';
    //             $dataset['color'] = $colors[$count++];
    //             $dataset['data'] = array();
                
    //             foreach($wards as $key2=>$value2) {
    
    //                 $dataset['data'][] = isset($data[$key1][$key2]) ? $data[$key1][$key2] : '0';
    //             }
    //             $datasets[] = $dataset;
    //         }
            
    //     $chart = array(
    //         'title' => 'Business Category by Ward',
    //         'type' => 'bar_stacked',
    //         'labels' => $labels,
    //         'datasets' => $datasets
    //     );

    //     return $chart;
      
    // }
    
    
   
    
    private function getBusinessByAnnualRenewalMarkerAreas() {
        $chart = array();
            
        $query = "SELECT COUNT(businesstype) AS count, value_range
                                    
        FROM 
             (select bbt.businesstype, btr.annual_renewmarketarea, 
                                case 
                                        WHEN btr.annual_renewmarketarea is not null AND btr.annual_renewmarketarea between 0 AND 1000 THEN 0
                                        WHEN btr.annual_renewmarketarea between 1000 AND 3000 THEN 1
                                        WHEN btr.annual_renewmarketarea between 3000 AND 5000 THEN 2
                                        WHEN btr.annual_renewmarketarea between 5000 AND 10000 THEN 3
                                        WHEN btr.annual_renewmarketarea > 10000 THEN 4
                                        
                    END AS value_range

                  FROM bldg_business_tax bbt 
        LEFT JOIN business_tax_rates btr ON bbt.businesstype = btr.businesssubtype 
        WHERE bbt.businesstype is NOT NULL AND btr.annual_renewmarketarea is not null
        GROUP BY bbt.businesstype, btr.annual_renewmarketarea)a
        GROUP BY value_range ORDER BY value_range ASC";

        $results = DB::select($query);

        $labels = array( 0 => '"0-1000"', 1 => '"1000-3000"', 2 => '"3000-5000"', 3 => '"5000-10000"', 4 => '"10000+"' );
        $values = array();
        foreach($results as $row) {
            
            switch ($row->value_range) {
              case 1:
                $label = '0-1000';
                break;
              case 2:
                $label = '1000-3000';
                break;
              case 3:
                $label = '3000-5000';
                break;
             case 4:
                $label = '5000-10000';
                break;
              default:
                $label = '10000 Above';
            }
            
            $values[$row->value_range] = $row->count;
        }
   
        end($values);
        $max = key($values); //Get the final key as max!
        for($i = 0; $i < 5; $i++)
        {
            if(!isset($values[$i]))
            {
                $values[$i] = '0';
            }
        }
       
       ksort($values);
        

        $chart = array(
            'title' => 'Annual Renewal Rate by Price Range(Market Area)',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"No. of business"'
        );

        return $chart;
    }
    
    private function getBusinessByAnnualRenewalOtherAreas() {
        $chart = array();
            
        $query = "SELECT COUNT(businesstype) AS count, value_range
                                    
        FROM 
             (select bbt.businesstype, btr.annual_renewotherarea, 
                                case 
                                        WHEN btr.annual_renewotherarea is not null AND btr.annual_renewotherarea between 0 AND 1000 THEN 0
                                        WHEN btr.annual_renewotherarea between 1000 AND 3000 THEN 1
                                        WHEN btr.annual_renewotherarea between 3000 AND 5000 THEN 2
                                        WHEN btr.annual_renewotherarea between 5000 AND 10000 THEN 3
                                        WHEN btr.annual_renewotherarea > 10000 THEN 4
                                        
                    END AS value_range

                  FROM bldg_business_tax bbt 
        LEFT JOIN business_tax_rates btr ON bbt.businesstype = btr.businesssubtype 
        WHERE bbt.businesstype is NOT NULL AND btr.annual_renewotherarea is not null
        GROUP BY bbt.businesstype, btr.annual_renewotherarea)a
        GROUP BY value_range ORDER BY value_range ASC";

        $results = DB::select($query);

        $labels = array( 0 => '"0-1000"', 1 => '"1000-3000"', 2 => '"3000-5000"', 3 => '"5000-10000"', 4 => '"10000+"' );
        $values = array();
        foreach($results as $row) {
            
            switch ($row->value_range) {
              case 1:
                $label = '0-1000';
                break;
              case 2:
                $label = '1000-3000';
                break;
              case 3:
                $label = '3000-5000';
                break;
             case 4:
                $label = '5000-10000';
                break;
              default:
                $label = '10000 Above';
            }
            
            $values[$row->value_range] = $row->count;
        }
   
        end($values);
        $max = key($values); //Get the final key as max!
        for($i = 0; $i < 5; $i++)
        {
            if(!isset($values[$i]))
            {
                $values[$i] = '0';
            }
        }
       
       ksort($values);
        

        $chart = array(
            'title' => 'Annual Renewal Rate by Price Range(Other Area)',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"No. of business"'
        );

        return $chart;
    }
    
       private function getRentWard() {
            
        $chart = array();

        $query = 'SELECT w.ward, COUNT(b.id) AS count'
                    . ' FROM wardpl w'
                    . ' LEFT JOIN bldg_rent_tax b'
                    . ' ON b.ward = w.ward'
                    . ' GROUP BY w.ward'
                    . ' ORDER BY w.ward';

            $results = DB::select($query);

            $labels = array();
            $values = array();
            foreach($results as $row) {
                $labels[] = '"' . $row->ward . '"';
                $values[] = $row->count;
            }

            $chart = array(
                'title' => 'Rent by Ward',
                'type' => 'bar',
                'labels' => $labels,
                'values' => $values,
                'datasetLabel' => '"No. of Rents"'
            );

            return $chart;
        }
        
        private function getRentHouseType() {
        $chart = array();

        $query = "SELECT housetype, COUNT(*)"
             . " FROM bldg_rent_tax "
             . " WHERE housetype is not NULL"
             . " GROUP BY housetype";
        
        $results = DB::select($query);
        
        $labels = array();
        $values = array();

        foreach($results as $row) {
            $labels[] = '"' . $row->housetype . '"';
            $values[] = $row->count;
        }

        $colors = array('"#d00000"', '"#1e6091"', '"#8ac926"', '"#fde74c"', '"#fb5607"', '"#720e07"', '"#97bab3"', '"#56cfe1"', '"#362ec8"', '"#26532b"', '"#FF97C1"', '"#D07000"', '"#2A0944"', '"#A10035"', '"#61481C"');
        $chart = array(
            'title' => 'House Type',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }
       
    }

   


