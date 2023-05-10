<?php

namespace App\Http\Controllers;

use App\Ward;

use App\YesNo;

use App\TaxStsCode;

use App\RoadSurface;

use DB;

class HomeController extends Controller
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
        $pageTitle = __("Dashboard");
        $chartGroups = array();
        $chartGroups['bldg']['title'] = 'Building Infrastructure';
        $chartGroups['bldg']['charts'] = array();
        $chartGroups['bldg']['charts'][] = $this->getBldgWard();
        $chartGroups['bldg']['charts'][] = $this->getBldgUse();
        $chartGroups['bldg']['charts'][] = $this->getBldgConstTyp();
        $chartGroups['bldg']['charts'][] = $this->getBldgFlrAr();
        $chartGroups['bldg']['charts'][] = $this->getBldgAge();
        $chartGroups['bldg']['charts'][] = $this->getBldgPrmtSts();
        $chartGroups['bldg']['charts'][] = $this->getBldgPrmtStsByWard();
        $chartGroups['bldg']['charts'][] = $this->getBldgAddZone();

        $chartGroups['wtrsnt']['title'] = 'Water and Sanitation Facility';
        $chartGroups['wtrsnt']['charts'] = array();
        $chartGroups['wtrsnt']['charts'][] = $this->getBldgToilet();
        $chartGroups['wtrsnt']['charts'][] = $this->getBldgToiletByWard();
        $chartGroups['wtrsnt']['charts'][] = $this->getBldgDrnkWtr();
        $chartGroups['wtrsnt']['charts'][] = $this->getBldgWstDrng();

        $chartGroups['sclsts']['title'] = 'Social Status';
        $chartGroups['sclsts']['charts'] = array();
        $chartGroups['sclsts']['charts'][] = $this->getBldgHhSize();
        $chartGroups['sclsts']['charts'][] = $this->getBldgHhSizeByWard();
        $chartGroups['sclsts']['charts'][] = $this->getBldgPopSize();
        $chartGroups['sclsts']['charts'][] = $this->getBldgPopSizeByWard();
        $chartGroups['sclsts']['charts'][] = $this->getBldgSngWomanByWard();
        $chartGroups['sclsts']['charts'][] = $this->getBldgGt60YrByWard();

        $chartGroups['road']['title'] = 'Road Infrastructure';
        $chartGroups['road']['charts'] = array();
        $chartGroups['road']['charts'][] = $this->getRdLenByRdSurf();
        $chartGroups['road']['charts'][] = $this->getRdLenByWard();
        
        return view('home.index', compact('pageTitle', 'chartGroups'));
    }

    private function getBldgWard() {
        $chart = array();
            
        $query = 'SELECT w.ward, COUNT(b.gid) AS count'
                . ' FROM wardpl w'
                . ' LEFT JOIN bldg b'
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
            'title' => 'Ward',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"No. of buildings"'
        );

        return $chart;
    }

    private function getBldgUse() {
        $chart = array();

        $query = 'SELECT bu.id, bu.name, COUNT(b.gid) AS count'
                . ' FROM building_use bu'
                . ' LEFT JOIN bldg b'
                . ' ON b.bldguse = bu.value'
                . ' GROUP BY bu.id'
                . ' ORDER BY bu.id';

        $results = DB::select($query);
        
        $labels = array();
        $values = array();

        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $colors = array('"#d00000"', '"#1e6091"', '"#8ac926"', '"#fde74c"', '"#fb5607"', '"#720e07"', '"#97bab3"', '"#56cfe1"', '"#362ec8"', '"#26532b"', '"#FF97C1"', '"#D07000"', '"#2A0944"', '"#A10035"', '"#61481C"');
        $chart = array(
            'title' => 'Building Use',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgConstTyp() {
        $chart = array();
            
        $query = 'SELECT bc.id, bc.name, COUNT(b.gid) AS count'
                . ' FROM building_construction bc'
                . ' LEFT JOIN bldg b'
                . ' ON b.consttyp = bc.value'
                . ' GROUP BY bc.id'
                . ' ORDER BY bc.id';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }
        
        $colors = array('"#4f772d"', '"#053c5e"');

        $chart = array(
            'title' => 'Construction Type',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

 
    private function getBldgFlrAr() {
        $chart = array();
            
        $query = "SELECT id, name, COUNT(*) AS count"
                . " FROM"
                . " (SELECT"
                . " CASE"
                . " WHEN flrar < 1000 THEN 1"
                . " WHEN flrar >= 1000 AND flrar < 2000 THEN 2"
                . " WHEN flrar >= 2000 THEN 3"
                . " END AS id,"
                . " CASE"
                . " WHEN flrar < 1000 THEN '<1000'"
                . " WHEN flrar >= 1000 AND flrar < 2000 THEN '1000 - 2000'"
                . " WHEN flrar >= 2000 THEN '2000+'"
                . " END AS name"
                . " FROM bldg) AS tbl"
                . " GROUP BY id, name"
                . " ORDER BY id";

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $chart = array(
            'title' => 'Floor Area',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"No. of buildings"'
        );

        return $chart;
    }

    private function getBldgAge() {
        $chart = array();
            
        $query = "SELECT id, name, COUNT(*) AS count"
                . " FROM"
                . " (SELECT"
                . " CASE"
                . " WHEN age < 10 THEN 1"
                . " WHEN age >= 10 AND age < 25 THEN 2"
                . " WHEN age >= 25 AND age < 50 THEN 3"
                . " WHEN age >= 50 THEN 4"
                . " END AS id,"
                . " CASE"
                . " WHEN age < 10 THEN '<10'"
                . " WHEN age >= 10 AND age < 25 THEN '10 - 25'"
                . " WHEN age >= 25 AND age < 50 THEN '25 - 50'"
                . " WHEN age >= 50 THEN '50+'"
                . " END AS name"
                . " FROM (SELECT 2074 - yoc AS age FROM bldg WHERE yoc > 0) AS tbl) AS tbl"
                . " GROUP BY id, name"
                . " ORDER BY id";

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $chart = array(
            'title' => 'Age of Building',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"No. of buildings"'
        );

        return $chart;
    }

    private function getBldgPrmtSts() {
        $chart = array();
            
        $query = 'SELECT yn.id, yn.name, COUNT(b.gid) AS count'
                . ' FROM yes_no yn'
                . ' LEFT JOIN bldg b'
                . ' ON b.bprmtyn = yn.value'
                . ' GROUP BY yn.id'
                . ' ORDER BY yn.id';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $colors = array('"#007700"', '"#bb0000"', '"#000077"', '"#bbbb00"');

        $chart = array(
            'title' => 'Permit Status',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgPrmtStsByWard() {
        $chart = array();

        $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
        $yesNos = YesNo::orderBy('id')->pluck('name', 'value')->toArray();

        $query = 'SELECT bprmtyn, ward, COUNT(*) AS count'
                . ' FROM bldg'
                . ' GROUP BY bprmtyn, ward';

        $results = DB::select($query);
        
        $data = array();
        foreach($results as $row) {
            $data[$row->bprmtyn][$row->ward] = $row->count;
        }
        
        $labels = array_map(function($ward) { return '"' . $ward . '"'; }, $wards);
        $colors = array('"#007700"', '"#bb0000"', '"#000077"', '"#bbbb00"');
        $datasets = array();
        $count = 0;
        foreach($yesNos as $key1=>$value1) {
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
            'title' => 'Permit Status by Ward',
            'type' => 'bar_stacked',
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $chart;
    }

    private function getBldgAddZone() {
        $chart = array();

        $query = 'SELECT a.value, a.name, COUNT(b.gid) AS count'
                . ' FROM addzone a'
                . ' LEFT JOIN bldg b'
                . ' ON b.addrzn = a.value'
                . ' GROUP BY a.value, a.name'
                . ' ORDER BY a.value, a.name';

        $results = DB::select($query);
        
        $labels = array();
        $values = array();

        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $colors = array('"#d3b934"', '"#38bde2"', '"#9468cd"', '"#f03d7f"');

        $chart = array(
            'title' => 'Address Zone',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgTxSts() {
        $chart = array();
            
        $query = 'SELECT ts.id, ts.name, COUNT(b.gid) AS count'
                . ' FROM tax_status_code ts'
                . ' LEFT JOIN bldg b'
                . ' ON b.btxsts = ts.value'
                . ' GROUP BY ts.id'
                . ' ORDER BY ts.id';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }
        $colors = array('"#38761d"', '"#6AFF00"', '"#b6d7a8"', '"#F7FF00"', '"#FF6900"', '"#FF0000"', '"#eeeeee"');

        $chart = array(
            'title' => 'Tax Payment Status',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgTxStsByWard() {
        $chart = array();

        $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
        $taxStsCodes = TaxStsCode::orderBy('id')->pluck('name', 'value')->toArray();

        $query = 'SELECT btxsts, ward, COUNT(*) AS count'
                . ' FROM bldg'
                . ' GROUP BY btxsts, ward';

        $results = DB::select($query);
        
        $data = array();
        foreach($results as $row) {
            $data[$row->btxsts][$row->ward] = $row->count;
        }
        
        $labels = array_map(function($ward) { return '"' . $ward . '"'; }, $wards);
        $colors = array('"#e05ad1"', '"#e74e62"', '"#47dcc8"', '"#2d74e6"', '"#df9317"', '"#3ec94e"', '"#702ee3"');
        $datasets = array();
        $count = 0;
        foreach($taxStsCodes as $key1=>$value1) {
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

    private function getBldgToilet() {
        $chart = array();
            
        $query = 'SELECT yn.id, yn.name, COUNT(b.gid) AS count'
                . ' FROM yes_no yn'
                . ' LEFT JOIN bldg b'
                . ' ON b.toilyn = yn.value'
                . ' GROUP BY yn.id'
                . ' ORDER BY yn.id';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $colors = array('"#007700"', '"#bb0000"', '"#000077"', '"#bbbb00"');

        $chart = array(
            'title' => 'Toilet Facility',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgToiletByWard() {
        $chart = array();

        $wards = Ward::orderBy('ward')->pluck('ward', 'ward')->toArray();
        $yesNos = YesNo::orderBy('id')->pluck('name', 'value')->toArray();

        $query = 'SELECT toilyn, ward, COUNT(*) AS count'
                . ' FROM bldg'
                . ' GROUP BY toilyn, ward';

        $results = DB::select($query);
        
        $data = array();
        foreach($results as $row) {
            $data[$row->toilyn][$row->ward] = $row->count;
        }
        
        $labels = array_map(function($ward) { return '"' . $ward . '"'; }, $wards);
        $colors = array('"#007700"', '"#bb0000"', '"#000077"', '"#bbbb00"');
        $datasets = array();
        $count = 0;
        foreach($yesNos as $key1=>$value1) {
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
            'title' => 'Toilet by Ward',
            'type' => 'bar_stacked',
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $chart;
    }

    private function getBldgDrnkWtr() {
        $chart = array();
            
        $query = 'SELECT dw.id, dw.name, COUNT(b.gid) AS count'
                . ' FROM drinking_water_source dw'
                . ' LEFT JOIN bldg b'
                . ' ON b.drnkwtr = dw.value'
                . ' GROUP BY dw.id'
                . ' ORDER BY dw.id';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $colors = array('"#7ccaee"', '"#1426ea"', '"#88d143"', '"#e3426f"', '"#8110ea"', '"#e0d985"', '"#54e265"', '"#c96fbf"', '"#dc845a"');

        $chart = array(
            'title' => 'Drinking Water Source',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgWstDrng() {
        $chart = array();
            
        $query = 'SELECT wd.id, wd.name, COUNT(b.gid) AS count'
                . ' FROM toilet_waste_drainage wd'
                . ' LEFT JOIN bldg b'
                . ' ON b.wwdischg = wd.value'
                . ' GROUP BY wd.id'
                . ' ORDER BY wd.id';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $colors = array('"#d45b78"', '"#52e026"', '"#c129ef"', '"#e2cb7c"', '"#4edaba"', '"#1a45d3"');

        $chart = array(
            'title' => 'Waste Water and Drainage System',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgHhSize() {
        $chart = array();
            
        $query = "SELECT id, name, COUNT(*) AS count"
                . " FROM"
                . " (SELECT"
                . " CASE"
                . " WHEN hhcount = 1 THEN 1"
                . " WHEN hhcount = 2 THEN 2"
                . " WHEN hhcount > 2 THEN 3"
                . " END AS id,"
                . " CASE"
                . " WHEN hhcount = 1 THEN '1'"
                . " WHEN hhcount = 2 THEN '2'"
                . " WHEN hhcount > 2 THEN '2+'"
                . " END AS name"
                . " FROM bldg) AS tbl"
                . " GROUP BY id, name"
                . " HAVING name IS NOT NULL"
                . " ORDER BY id";

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $colors = array('"#dae85c"', '"#9942e5"', '"#18dc11"');

        $chart = array(
            'title' => 'Household Size',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgHhSizeByWard() {
        $chart = array();
            
        $query = 'SELECT w.ward, SUM(b.hhcount) AS sum'
                . ' FROM wardpl w'
                . ' LEFT JOIN bldg b'
                . ' ON b.ward = w.ward'
                . ' GROUP BY w.ward'
                . ' ORDER BY w.ward';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->ward . '"';
            $values[] = $row->sum;
        }

        $chart = array(
            'title' => 'Number of Households by Ward',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"No. of households"'
        );

        return $chart;
    }

    private function getBldgPopSize() {
        $chart = array();
            
        $query = "SELECT id, name, COUNT(*) AS count"
                . " FROM"
                . " (SELECT"
                . " CASE"
                . " WHEN hhpop = 1 THEN 1"
                . " WHEN hhpop >= 2 AND hhpop <=5 THEN 2"
                . " WHEN hhpop > 5 THEN 3"
                . " END AS id,"
                . " CASE"
                . " WHEN hhpop = 1 THEN '1'"
                . " WHEN hhpop >= 2 AND hhpop <=5 THEN '2 - 5'"
                . " WHEN hhpop > 5 THEN '5+'"
                . " END AS name"
                . " FROM bldg) AS tbl"
                . " GROUP BY id, name"
                . " HAVING name IS NOT NULL"
                . " ORDER BY id";

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->count;
        }

        $colors = array('"#80eddd"', '"#ea45a5"', '"#420ccb"');

        $chart = array(
            'title' => 'Population Size',
            'type' => 'pie',
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors
        );

        return $chart;
    }

    private function getBldgPopSizeByWard() {
        $chart = array();
            
        $query = 'SELECT w.ward, SUM(b.hhcount) AS sum'
                . ' FROM wardpl w'
                . ' LEFT JOIN bldg b'
                . ' ON b.ward = w.ward'
                . ' GROUP BY w.ward'
                . ' ORDER BY w.ward';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->ward . '"';
            $values[] = $row->sum;
        }

        $chart = array(
            'title' => 'Population Size by Ward',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"Population Size"'
        );

        return $chart;
    }

    private function getBldgSngWomanByWard() {
        $chart = array();
            
        $query = 'SELECT w.ward, COUNT(b.gid) AS count'
                . ' FROM wardpl w'
                . ' LEFT JOIN bldg b'
                . ' ON b.ward = w.ward'
                . ' AND b.sngwoman > 0'
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
            'title' => 'Buildings with Single Women by Ward',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"No. of buildings"'
        );

        return $chart;
    }

    private function getBldgGt60YrByWard() {
        $chart = array();
            
        $query = 'SELECT w.ward, COUNT(b.gid) AS count'
                . ' FROM wardpl w'
                . ' LEFT JOIN bldg b'
                . ' ON b.ward = w.ward'
                . ' AND b.gt60yr > 0'
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
            'title' => 'Buildings with Old Age People by Ward',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"No. of buildings"'
        );

        return $chart;
    }

    /*
    private function getRdLenByRdSurf() {
        $chart = array();

        $roadSurfaces = RoadSurface::orderBy('id')->pluck('name', 'value')->toArray();
        $roadLengthRanges = array(
            1 => '<50',
            2 => '50 - 100',
            3 => '100 - 150',
            4 => '150 - 200',
            5 => '>=200'
        );
        
        $query = 'SELECT rdlenrng, rdsurf, COUNT(*) AS count'
                . ' FROM'
                . ' (SELECT'
                . ' CASE'
                . ' WHEN rdlen < 50 THEN 1'
                . ' WHEN rdlen >= 50 AND rdlen < 100 THEN 2'
                . ' WHEN rdlen >= 100 AND rdlen < 150 THEN 3'
                . ' WHEN rdlen >= 150 AND rdlen < 200 THEN 4'
                . ' WHEN rdlen >= 200 THEN 5'
                . ' END AS rdlenrng, rdsurf'
                . ' FROM road) AS tbl'
                . ' GROUP BY rdlenrng, rdsurf';

        $results = DB::select($query);
        
        $data = array();
        foreach($results as $row) {
            $data[$row->rdlenrng][$row->rdsurf] = $row->count;
        }
        
        $labels = array_map(function($roadSurface) { return '"' . $roadSurface . '"'; }, $roadSurfaces);
        $colors = array('"#cfe679"', '"#66d27d"', '"#9278f0"', '"#44b5d4"', '"#cc42ac"');
        $datasets = array();
        $count = 0;
        foreach($roadLengthRanges as $key1=>$value1) {
            $dataset = array();
            $dataset['label'] = '"' . $value1 . '"';
            $dataset['color'] = $colors[$count++];
            $dataset['data'] = array();
            foreach($roadSurfaces as $key2=>$value2) {
                $dataset['data'][] = isset($data[$key1][$key2]) ? $data[$key1][$key2] : '0';
            }
            $datasets[] = $dataset;
        }

        $chart = array(
            'title' => 'Road Length by Road Surface',
            'type' => 'bar_stacked',
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $chart;
    }
    */

    private function getRdLenByRdSurf() {
        $chart = array();
            
        $query = 'SELECT rs.id, rs.name, SUM(r.rdlen) AS sum'
                . ' FROM road_surface rs'
                . ' LEFT JOIN road r'
                . ' ON r.rdsurf = rs.value'
                . ' GROUP BY rs.id'
                . ' ORDER BY rs.id';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->name . '"';
            $values[] = $row->sum;
        }

        $chart = array(
            'title' => 'Road Length by Road Surface',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"Road Length"'
        );

        return $chart;
    }

    private function getRdLenByWard() {
        $chart = array();
            
        $query = 'SELECT w.ward, SUM(r.rdlen) AS sum'
                . ' FROM wardpl w'
                . ' LEFT JOIN road r'
                . ' ON ST_Intersects(w.geom, r.geom)'
                . ' GROUP BY w.ward'
                . ' ORDER BY w.ward';

        $results = DB::select($query);

        $labels = array();
        $values = array();
        foreach($results as $row) {
            $labels[] = '"' . $row->ward . '"';
            $values[] = $row->sum;
        }

        $chart = array(
            'title' => 'Road Length by Ward',
            'type' => 'bar',
            'labels' => $labels,
            'values' => $values,
            'datasetLabel' => '"Road Length"'
        );

        return $chart;
    }
}
