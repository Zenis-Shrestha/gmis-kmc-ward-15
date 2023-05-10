<?php

Auth::routes();

Route::get('/', 'HomeController@index');

// Replace "create" with "add"
Route::get('user/add', 'UserController@add')->name('user.add');
Route::resource('user', 'UserController', ['except' => ['create']]);

Route::resource('roles', 'RoleController');

Route::resource('role_permission', 'RolesPermissionsController');

Route::get('maps', 'MapsController@index');
Route::resource('importexcel', 'ImportExcelController');

Route::get('buildings/data', 'BuildingController@getData');
Route::get('buildings/export', 'BuildingController@export');
// Replace "create" with "add"
Route::get('buildings/add', 'BuildingController@add')->name('buildings.add');
Route::resource('buildings', 'BuildingController', ['except' => ['create']]);

Route::get('buildings/photos/{building_id}', 'BuildingController@downloadPhoto');
Route::get('/buildings/building_infoexport', 'BuildingController@building_infoexport')->name('building_infoexport');

Route::get('buildings/new-photos/{building_id}', 'BuildingController@downloadNewPhoto');



Route::get('building-business/business-sub-types','BuildingBusinessController@getBusinessSubTypes')->name('buildings-business.get-business-sub-types');
Route::get('building-business/business-details','BuildingBusinessController@getBusinessDetails')->name('buildings-business.get-business-details');

Route::get('buildings-business/data', 'BuildingBusinessController@getData');
Route::get('buildings-business/export', 'BuildingBusinessController@export');
// Replace "create" with "add"
Route::get('buildings-business/add', 'BuildingBusinessController@add')->name('buildings-business.add');
Route::resource('buildings-business', 'BuildingBusinessController', ['except' => ['create']]);

Route::get('buildings-rent/data', 'BuildingRentController@getData');
Route::get('building-rent/rent-details','BuildingRentController@getRentDetails')->name('buildings-rent.get-rent-details');
Route::get('buildings-rent/export', 'BuildingRentController@export');
Route::get('buildings-rent/add', 'BuildingRentController@add')->name('buildings.add');
Route::resource('buildings-rent', 'BuildingRentController', ['except' => ['create']]);

Route::get('get-bin-numbers','BuildingController@getBinNumbers')->name('buildings.get-bin-numbers');
Route::get('get-wards', 'BuildingController@getWards')->name('buildings.get-wards');


Route::get('streets/data', 'StreetController@getData');
Route::get('streets/export', 'StreetController@export');
// Replace "create" with "add"
Route::get('streets/add', 'StreetController@add')->name('streets.add');
Route::resource('streets', 'StreetController', ['except' => ['create']]);

Route::get('add-zones/data', 'AddZoneController@getData');
Route::get('add-zones/export', 'AddZoneController@export');
// Replace "create" with "add"
Route::get('add-zones/add', 'AddZoneController@add')->name('add-zones.add');
Route::resource('add-zones', 'AddZoneController', ['except' => ['create']]);

Route::get('building-constructions/data', 'BuildingConstrController@getData');
Route::get('building-constructions/export', 'BuildingConstrController@export');
// Replace "create" with "add"
Route::get('building-constructions/add', 'BuildingConstrController@add')->name('building-constructions.add');
Route::resource('building-constructions', 'BuildingConstrController', ['except' => ['create']]);

Route::get('building-uses/data', 'BuildingUseController@getData');
Route::get('building-uses/export', 'BuildingUseController@export');
// Replace "create" with "add"
Route::get('building-uses/add', 'BuildingUseController@add')->name('building-uses.add');
Route::resource('building-uses', 'BuildingUseController', ['except' => ['create']]);

Route::get('water-srcs/data', 'DrnkWtrSrcController@getData');
Route::get('water-srcs/export', 'DrnkWtrSrcController@export');
// Replace "create" with "add"
Route::get('water-srcs/add', 'DrnkWtrSrcController@add')->name('water-srcs.add');
Route::resource('water-srcs', 'DrnkWtrSrcController', ['except' => ['create']]);

Route::get('tax-sts-codes/data', 'TaxStsCodeController@getData');
Route::get('tax-sts-codes/export', 'TaxStsCodeController@export');
// Replace "create" with "add"
Route::get('tax-sts-codes/add', 'TaxStsCodeController@add')->name('tax-sts-codes.add');
Route::resource('tax-sts-codes', 'TaxStsCodeController', ['except' => ['create']]);

Route::get('drainages/data', 'DrainageController@getData');
Route::get('drainages/export', 'DrainageController@export');
// Replace "create" with "add"
Route::get('drainages/add', 'DrainageController@add')->name('drainages.add');
Route::resource('drainages', 'DrainageController', ['except' => ['create']]);

Route::get('verf-yes-nos/data', 'VerfYesNoController@getData');
Route::get('verf-yes-nos/export', 'VerfYesNoController@export');
// Replace "create" with "add"
Route::get('verf-yes-nos/add', 'VerfYesNoController@add')->name('verf-yes-nos.add');
Route::resource('verf-yes-nos', 'VerfYesNoController', ['except' => ['create']]);

Route::get('yes-nos/data', 'YesNoController@getData');
Route::get('yes-nos/export', 'YesNoController@export');
// Replace "create" with "add"
Route::get('yes-nos/add', 'YesNoController@add')->name('yes-nos.add');
Route::resource('yes-nos', 'YesNoController', ['except' => ['create']]);

Route::get('road-hierarchies/data', 'RoadHierarchyController@getData');
Route::get('road-hierarchies/export', 'RoadHierarchyController@export');
// Replace "create" with "add"
Route::get('road-hierarchies/add', 'RoadHierarchyController@add')->name('road-hierarchies.add');
Route::resource('road-hierarchies', 'RoadHierarchyController', ['except' => ['create']]);

Route::get('road-surfaces/data', 'RoadSurfaceController@getData');
Route::get('road-surfaces/export', 'RoadSurfaceController@export');
// Replace "create" with "add"
Route::get('road-surfaces/add', 'RoadSurfaceController@add')->name('road-surfaces.add');
Route::resource('road-surfaces', 'RoadSurfaceController', ['except' => ['create']]);

Route::get('roads/data', 'RoadController@getData');
Route::get('roads/export', 'RoadController@export');
// Replace "create" with "add"
Route::get('roads/add', 'RoadController@add')->name('roads.add');
Route::resource('roads', 'RoadController', ['except' => ['create']]);

// Tax Payment routes
Route::get('report', 'TaxPaymentDashboardController@buildingsTaxReportPdf');
Route::get('business-report', 'BuildingBusinessController@businessTaxReportPdf');
Route::get('rent-report', 'BuildingRentController@rentReportPdf');

Route::resource('tax-payment-dashboard','TaxPaymentDashboardController');

Route::get('tax-payment/data', 'TaxPaymentController@getData')->name('tax-payment.getData');
Route::get('tax-payment/export', 'TaxPaymentController@export')->name('tax-payment.export');
Route::resource('tax-payment','TaxPaymentController');

Route::get('business-tax-payment/data', 'BusinessTaxPaymentController@getData')->name('business-tax-payment.getData');
Route::get('business-tax-payment/export', 'BusinessTaxPaymentController@export')->name('business-tax-payment.export');
Route::resource('business-tax-payment','BusinessTaxPaymentController');

Route::get('getExtent/{val1}/{val2}/{val3}', function ($val1, $val2, $val3) {
    if (in_array($val1, array("bldg_business_tax", "bldg_rent_tax"))) {
        $xmin = array_pluck(DB::select(DB::raw("select st_xmin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmin')[0];
        $ymin = array_pluck(DB::select(DB::raw("select st_ymin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymin')[0];
        $xmax = array_pluck(DB::select(DB::raw("select st_xmax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmax')[0];
        $ymax = array_pluck(DB::select(DB::raw("select st_ymax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymax')[0];

        $lat = array_pluck(DB::select(DB::raw("select ST_Y (ST_Transform (geom, 4326)) as lat from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'lat')[0];
        $long = array_pluck(DB::select(DB::raw("select ST_X (ST_Transform (geom, 4326)) as long from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'long')[0];

        $data = array(
            'xmin' => $xmin,
            'ymin' => $ymin,
            'xmax' => $xmax,
            'ymax' => $ymax,
            'lat' => $lat,
            'long' => $long,
        );
    }
    else if (in_array($val1, array("contain"))) {
        $xmin = array_pluck(DB::select(DB::raw("select st_xmin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmin')[0];
        $ymin = array_pluck(DB::select(DB::raw("select st_ymin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymin')[0];
        $xmax = array_pluck(DB::select(DB::raw("select st_xmax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmax')[0];
        $ymax = array_pluck(DB::select(DB::raw("select st_ymax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymax')[0];

        $lat = array_pluck(DB::select(DB::raw("select ST_Y (ST_Transform (geom, 4326)) as lat from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'lat')[0];
        $long = array_pluck(DB::select(DB::raw("select ST_X (ST_Transform (geom, 4326)) as long from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'long')[0];

        $data = array(
            'xmin' => $xmin,
            'ymin' => $ymin,
            'xmax' => $xmax,
            'ymax' => $ymax,
            'lat' => $lat,
            'long' => $long,
        );
    } else if (in_array($val1, array("bldg", "settarea"))) {
        $xmin = array_pluck(DB::select(DB::raw("select st_xmin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmin')[0];
        $ymin = array_pluck(DB::select(DB::raw("select st_ymin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymin')[0];
        $xmax = array_pluck(DB::select(DB::raw("select st_xmax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmax')[0];
        $ymax = array_pluck(DB::select(DB::raw("select st_ymax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymax')[0];

        $lat = array_pluck(DB::select(DB::raw("select ST_Y (ST_Transform (ST_Centroid(geom), 4326)) as lat from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'lat')[0];
        $long = array_pluck(DB::select(DB::raw("select ST_X (ST_Transform (ST_Centroid(geom), 4326)) as long from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'long')[0];

        $data = array(
            'xmin' => $xmin,
            'ymin' => $ymin,
            'xmax' => $xmax,
            'ymax' => $ymax,
            'lat' => $lat,
            'long' => $long,
        );
    } else if (in_array($val1, array("road", "street"))) {
        $xmin = array_pluck(DB::select(DB::raw("select st_xmin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmin')[0];
        $ymin = array_pluck(DB::select(DB::raw("select st_ymin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymin')[0];
        $xmax = array_pluck(DB::select(DB::raw("select st_xmax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmax')[0];
        $ymax = array_pluck(DB::select(DB::raw("select st_ymax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymax')[0];

        $geom = array_pluck(DB::select(DB::raw("select ST_AsText(geom) AS geom from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'geom')[0];

        $data = array(
            'xmin' => $xmin,
            'ymin' => $ymin,
            'xmax' => $xmax,
            'ymax' => $ymax,
            'geom' => $geom,
        );
    } else if (in_array($val1, array("microwaves", "optical_links"))) {
        $xmin = array_pluck(DB::select(DB::raw("select st_xmin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmin')[0];
        $ymin = array_pluck(DB::select(DB::raw("select st_ymin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymin')[0];
        $xmax = array_pluck(DB::select(DB::raw("select st_xmax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmax')[0];
        $ymax = array_pluck(DB::select(DB::raw("select st_ymax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymax')[0];

        $lat = $long = $lat1 = $long1 = '';

        if ($val1 == 'microwaves') {
            $queryA = 'SELECT ms.lat, ms.long'
                . ' FROM microwave_stations ms'
                . ' JOIN microwaves m'
                . ' ON m.mwstncodea = ms.mwstncode'
                . ' WHERE m.' . $val2 . ' = ?';

            $queryB = 'SELECT ms.lat, ms.long'
                . ' FROM microwave_stations ms'
                . ' JOIN microwaves m'
                . ' ON m.mwstncodeb = ms.mwstncode'
                . ' WHERE m.' . $val2 . ' = ?';
        } else if ($val1 == 'optical_links') {
            $queryA = 'SELECT n.lat, n.long'
                . ' FROM nodes n'
                . ' JOIN optical_links o'
                . ' ON o.orgnodeid = n.nodeid'
                . ' WHERE o.' . $val2 . ' = ?';

            $queryB = 'SELECT n.lat, n.long'
                . ' FROM nodes n'
                . ' JOIN optical_links o'
                . ' ON o.endnodeid = n.nodeid'
                . ' WHERE o.' . $val2 . ' = ?';
        }

        $resultsA = DB::select($queryA, [$val3]);

        $resultsB = DB::select($queryB, [$val3]);

        if (count($resultsA) > 0) {
            $lat = $resultsA[0]->lat;
            $long = $resultsA[0]->long;
        }

        if (count($resultsB) > 0) {
            $lat1 = $resultsB[0]->lat;
            $long1 = $resultsB[0]->long;
        }

        $data = array(
            'xmin' => $xmin,
            'ymin' => $ymin,
            'xmax' => $xmax,
            'ymax' => $ymax,
            'lat' => $lat,
            'long' => $long,
            'lat1' => $lat1,
            'long1' => $long1,
        );
    } else {
        $xmin = array_pluck(DB::select(DB::raw("select st_xmin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmin')[0];
        $ymin = array_pluck(DB::select(DB::raw("select st_ymin(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymin')[0];
        $xmax = array_pluck(DB::select(DB::raw("select st_xmax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_xmax')[0];
        $ymax = array_pluck(DB::select(DB::raw("select st_ymax(ST_Extent(geom)) from " . $val1 . " where " . $val2 . " = '" . $val3 . "'")), 'st_ymax')[0];

        $data = array(
            'xmin' => $xmin,
            'ymin' => $ymin,
            'xmax' => $xmax,
            'ymax' => $ymax,

        );
    }

    return $data;
});

Route::get('getContainmentBuildings/{field}/{val}', function ($field, $val) {
    $query = "SELECT bin, ST_Y (ST_Transform (ST_Centroid(geom), 4326)) as lat, ST_X (ST_Transform (ST_Centroid(geom), 4326)) as long"
        . " FROM building"
        . " WHERE bin IN"
        . " ("
        . " SELECT bc.bin"
        . " FROM build_contain bc"
        . " JOIN contain c"
        . " ON bc.containcd = c.containcd::CHARACTER VARYING"
        . " WHERE c." . $field . " = '" . $val . "'"
        . " )";

    $results = DB::select($query);

    $data = array();

    foreach ($results as $row) {
        $coord = array();
        $coord['lat'] = $row->lat;
        $coord['long'] = $row->long;
        $data[] = $coord;
    }

    return $data;
});

Route::get('getContainmentRoad/{field}/{val}', function ($field, $val) {
    $c_lat = $c_long = $r_lat = $r_long = '';

    $c_query = "SELECT ST_Y (ST_Transform (geom, 4326)) as c_lat, ST_X (ST_Transform (geom, 4326)) as c_long"
        . " FROM contain"
        . " WHERE " . $field . " = '" . $val . "'";

    $c_results = DB::select($c_query);

    if (count($c_results) > 0) {
        $c_lat = $c_results[0]->c_lat;
        $c_long = $c_results[0]->c_long;

        $r_query = "SELECT r.gid, ST_AsEWKT(ref_geom),r.ROADNAM, ST_Y(ST_ClosestPoint(ST_Transform(r.geom,4326), ref_geom)) As r_lat, ST_X(ST_ClosestPoint(ST_Transform(r.geom,4326), ref_geom)) As r_long"
            . " FROM roadline As r, ST_Transform(ST_SetSRID(ST_Point(" . $c_long . "," . $c_lat . "),4326),4326) AS ref_geom"
            . " WHERE ST_DWithin(ST_Transform(r.geom,4326), ref_geom, 1000)"
            . " ORDER BY ST_Distance(ST_Transform(r.geom,4326),ref_geom) LIMIT 1";

        $r_results = DB::select($r_query);

        if (count($r_results > 0)) {
            $r_lat = $r_results[0]->r_lat;
            $r_long = $r_results[0]->r_long;
        }
    }

    $data = array(
        'c_lat' => $c_lat,
        'c_long' => $c_long,
        'r_lat' => $r_lat,
        'r_long' => $r_long,
    );

    return $data;
});

Route::get('getNearestRoad/{long}/{lat}', function ($long, $lat) {
    $r_lat = $r_long = '';

    $r_query = "SELECT r.gid, ST_AsEWKT(ref_geom),r.ROADNAM, ST_Y(ST_ClosestPoint(ST_Transform(r.geom,4326), ref_geom)) As r_lat, ST_X(ST_ClosestPoint(ST_Transform(r.geom,4326), ref_geom)) As r_long"
        . " FROM roadline As r, ST_Transform(ST_SetSRID(ST_Point(" . $long . "," . $lat . "),4326),4326) AS ref_geom"
        . " WHERE ST_DWithin(ST_Transform(r.geom,4326), ref_geom, 1000)"
        . " ORDER BY ST_Distance(ST_Transform(r.geom,4326),ref_geom) LIMIT 1";

    $r_results = DB::select($r_query);

    if (count($r_results > 0)) {
        $r_lat = $r_results[0]->r_lat;
        $r_long = $r_results[0]->r_long;
    }

    $data = array(
        'lat' => $r_lat,
        'long' => $r_long,
    );

    return $data;
});

Route::get('getNextEmptyingContainments/{date}', function ($date) {
    /*$query = "SELECT containcd, ST_Y (ST_Transform (geom, 4326)) as lat, ST_X (ST_Transform (geom, 4326)) as long"
    . " FROM contain"
    . " WHERE containcd::CHARACTER VARYING IN"
    . " ("
    . " SELECT containcd"
    . " FROM emptying_services"
    . " WHERE nextemptytime = '" . $date . "'"
    . " )";*/

    $query = "SELECT containcd, ST_Y (ST_Transform (geom, 4326)) as lat, ST_X (ST_Transform (geom, 4326)) as long"
        . " FROM contain"
        . " WHERE ward = 31"
        . " ORDER BY RANDOM()"
        . " LIMIT 15";

    $results = DB::select($query);

    $data = array();

    foreach ($results as $row) {
        $coord = array();
        $coord['lat'] = $row->lat;
        $coord['long'] = $row->long;
        $data[] = $coord;
    }

    return $data;
});

Route::get('getContainmentsByRadius/{long}/{lat}', function ($long, $lat) {
    $circle_query = "SELECT ST_AsGeoJSON(ST_Transform(ST_Buffer(ST_GeomFromText('POINT(" . $long . " " . $lat . ")', 4326), 0.001), 900913)) AS circle";
    $circle = array_pluck(DB::select(DB::raw($circle_query)), 'circle')[0];

    $containments_query = "SELECT row_to_json(fc) As containments"
        . " FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features"
        . " FROM (SELECT 'Feature' As type"
        . " , ST_AsGeoJSON(ST_Transform(bu.geom, 900913))::json As geometry"
        . " , row_to_json((SELECT b FROM (SELECT gid, containtyp) As b"
        . " )) As properties"
        . " FROM contain As bu, ST_Buffer(ST_GeomFromText('POINT(" . $long . " " . $lat . ")', 4326), 0.001) As circle_geom"
        . " WHERE ST_Contains(circle_geom, bu.geom)"
        . " ) As f )  As fc";

    $containments = array_pluck(DB::select(DB::raw($containments_query)), 'containments')[0];

    $data = array(
        "circle" => $circle,
        "containments" => $containments,
    );
    return $data;
});

Route::get('getDueBuildings', function () {
    $query = "SELECT bin, ST_Y (ST_Transform (ST_Centroid(geom), 4326)) as lat, ST_X (ST_Transform (ST_Centroid(geom), 4326)) as long"
        . " FROM building"
        . " WHERE bin IN"
        . " ("
        . " SELECT bin"
        . " FROM holding_taxes"
        . " WHERE status = 'due'"
        . " )";

    $results = DB::select($query);

    $data = array();

    foreach ($results as $row) {
        $coord = array();
        $coord['lat'] = $row->lat;
        $coord['long'] = $row->long;
        $data[] = $coord;
    }

    return $data;
});

Route::post('getPolygonReport', function(Illuminate\Http\Request $request){
    if($request->geom) {
        $buildingQuery1 = "SELECT bu.value, bu.name, COUNT(b.*) AS count"
                    . " FROM building_use bu"
                    . " LEFT JOIN bldg b"
                    . " ON b.bldguse = bu.value"
                    . " AND (ST_Within(b.geom, ST_GeomFromText('" . $request->geom . "', 4326)))"
                    . " GROUP BY bu.value, bu.name"
                    . " ORDER BY bu.value";

        $buildingResults1 = DB::select($buildingQuery1);

        $total = 0;

        $html = '<table class="table table-condensed">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Building Use</th>';
        $html .= '<th>No. of buildings</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach($buildingResults1 as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row->name . '</td>';
            $html .= '<td>' . $row->count . '</td>';
            $html .= '</tr>';
            $total += $row->count;
        }
        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '<th>Total</th>';
        $html .= '<th>' . $total . '</th>';
        $html .= '</tfoot>';
        $html .= '</table>';

        $buildingQuery2 = "SELECT bc.value, bc.name, COUNT(b.*) AS count"
                        . " FROM building_construction bc"
                        . " LEFT JOIN bldg b"
                        . " ON b.consttyp = bc.value"
                        . " AND (ST_Within(b.geom, ST_GeomFromText('" . $request->geom . "', 4326)))"
                        . " GROUP BY bc.value, bc.name"
                        . " ORDER BY bc.value";

        $buildingResults2 = DB::select($buildingQuery2);

        $total = 0;

        $html .= '<table class="table table-condensed">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Construction Type</th>';
        $html .= '<th>No. of buildings</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach($buildingResults2 as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row->name . '</td>';
            $html .= '<td>' . $row->count . '</td>';
            $html .= '</tr>';
            $total += $row->count;
        }
        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '<th>Total</th>';
        $html .= '<th>' . $total . '</th>';
        $html .= '</tfoot>';
        $html .= '</table>';

        return $html;
    }
    else {
        return "The 'geom' field is required";
    }
});

Route::get('searchByKeywords/{layer}/{keywords}', function($layer, $keywords){
    $layer = trim($layer);
    $keywords = trim($keywords);

    $points = [];
    $geoms = [];

    if(in_array($layer, ['places', 'pubsrv', 'roadline']) && $keywords) {
        $keywordArr = explode(' ', $keywords);
        $tsQueries = [];

        foreach($keywordArr as $keyword) {
            if($keyword != '') {
                $tsQueries[] = "plainto_tsquery('" . $keyword . "')";
            }
        }

        if(count($tsQueries) > 0) {
            if($layer == 'places') {
                $points = array_pluck(DB::select(DB::raw("select ST_AsText(geom) AS point from places where document @@ (" . implode(' || ', $tsQueries) . ")")), 'point');
            }
            else if($layer == 'pubsrv') {
                $points = array_pluck(DB::select(DB::raw("select ST_AsText(geom) AS point from pubsrv where document @@ (" . implode(' || ', $tsQueries) . ")")), 'point');
            }
            else if($layer == 'roadline') {
                // $points = array_pluck(DB::select(DB::raw("select ST_AsText((ST_DumpPoints(geom)).geom) AS point from roadline where document @@ (" . implode(' || ', $tsQueries) . ")")), 'point');
                $geoms = array_pluck(DB::select(DB::raw("select ST_AsText(geom) AS geom from roadline where document @@ (" . implode(' || ', $tsQueries) . ")")), 'geom');
            }
        }
    }

    return array(
        'points' => $points,
        'geoms' => $geoms
    );
});

Route::get('searchBuildingByBIN/{bin}', function($bin){
    $bin = trim($bin);
    $data = array();

    if($bin) {
        $building_query = "SELECT gid, ST_AsText(geom) AS geom FROM bldg WHERE bin = " . $bin . " LIMIT 1";
        $results = DB::select($building_query);
        if(count($results) > 0) {
            $row = $results[0];
            $data['bin'] = $bin;
            $data['geom'] = $row->geom;
        }
    }

    return count($data) > 0 ? $data : null;
});





Route::get('getBuildingInformation/{long}/{lat}', function ($long, $lat) {

    //Building Information
   
    $buildings_query = "SELECT b.gid, b.bin, b.ward, b.tole, b.haddr, b.hownr, b.yoc, b.flrcount, bu.name AS building_use, bc.name AS construction_type, t.name AS tax_status, s.strtnm AS street, ST_AsText(b.geom) AS geom"
        . " FROM bldg b"
        . " LEFT JOIN building_use bu"
        . " ON b.bldguse = bu.value"
        . " LEFT JOIN building_construction bc"
        . " ON b.consttyp = bc.value"
        . " LEFT JOIN tax_status_code t"
        . " ON b.btxsts = t.value"
        . " LEFT JOIN street s"
        . " ON b.strtcd = s.strtcd"
        . " WHERE ST_Contains(b.geom, ST_GeomFromText('POINT(" . $long . " " . $lat . ")', 4326))";

    $results_buildings = DB::select($buildings_query);

    $data1 = array();

    foreach ($results_buildings as $row) {
        $building = array();
        $building['gid'] = $row->gid ? $row->gid : '';
        $building['bin'] = $row->bin ? $row->bin : '';
        $building['ward'] = $row->ward ? $row->ward : '';
        $building['tole'] = $row->tole ? $row->tole : '';
        $building['haddr'] = $row->haddr ? $row->haddr : '';
        $building['hownr'] = $row->hownr ? $row->hownr : '';
        $building['yoc'] = $row->yoc ? $row->yoc : '';
        $building['flrcount'] = $row->flrcount ? $row->flrcount : '';
        $building['building_use'] = $row->building_use ? $row->building_use : '';
        $building['construction_type'] = $row->construction_type ? $row->construction_type : '';
        $building['tax_status'] = $row->tax_status ? $row->tax_status : '';
        $building['street'] = $row->street ? $row->street : '';
        $building['geom'] = $row->geom ? $row->geom : '';
         if(File::exists(storage_path('app/new-photos/' . $row->bin . '.jpg'))) {
             $photo_path =  url('buildings/new-photos/' . $row->bin);
           
         }
         else if(File::exists(storage_path('app/photos/' . $row->bin . '.JPG'))) {
             $photo_path =  url('buildings/photos/' . $row->bin);
         }
         else{
             $photo_path = '';
         }
       
        $building['photo_path'] = $photo_path;
        $data1[] = $building;
    }

   //Building Business Information
        $buildings_business_query = "SELECT bin,ward,roadname,houseno,houseownername,ownerphone,houseownermail,businesowner,businessname,businesstype,category,businessoprdate,registration,oldinternalnumber,taxlastdate,businessownermobile,email,remarks,
            ST_AsText(geom) AS geom"
        . " FROM bldg_business_tax"
        . " WHERE bin = ".(int)$data1[0]['bin'];

        $results_buildings_business = DB::select($buildings_business_query);
        $data2= array();

    foreach ($results_buildings_business as $row) {
        $building = array();
        $building['bin'] = $row->bin ? $row->bin : '';
        $building['ward'] = $row->ward ? $row->ward : '';
        $building['roadname'] = $row->roadname ? $row->roadname : '';
        $building['houseno'] = $row->houseno ? $row->houseno : '';
        $building['houseownername'] = $row->houseownername ? $row->houseownername : '';
        $building['ownerphone'] = $row->ownerphone ? $row->ownerphone : '';
        $building['houseownermail'] = $row->houseownermail ? $row->houseownermail : '';
        $building['businesowner'] = $row->businesowner ? $row->businesowner : '';
        $building['businessname'] = $row->businessname ? $row->businessname : '';
        $building['businesstype'] = $row->businesstype ? $row->businesstype : '';
        $building['category'] = $row->category ? $row->category : '';
        $building['businessoprdate'] = $row->businessoprdate ? $row->businessoprdate : '';
        $building['registration'] = $row->registration ? $row->registration : '';
        $building['oldinternalnumber'] = $row->oldinternalnumber ? $row->oldinternalnumber : '';
        $building['taxlastdate'] = $row->taxlastdate ? $row->taxlastdate : '';
        $building['businessownermobile'] = $row->businessownermobile ? $row->businessownermobile : '';
        $building['email'] = $row->email ? $row->email : '';
        $building['remarks'] = $row->remarks ? $row->remarks : '';
        $building['geom'] = $row->geom ? $row->geom : '';
        $data2[] = $building;
    }

    //Building_Rent_Information

 
$buildings_rent_query = "SELECT bin,ward,roadname,houseno,taxpayercode,hownername,hownernumber,howneremail,
    housetype,length,width,area,rentername,rentpurpose,rentstart,monthlyrent,rentaxresponsible,rentmobilenumber,rentincreseperyear,remarks,
     ST_AsText(geom) AS geom"
    . " FROM bldg_rent_tax"
    . " WHERE bin = ".(int)$data1[0]['bin'];

$results_buildings_rent = DB::select($buildings_rent_query);

$data3 = array();

foreach ($results_buildings_rent as $row) {
    $building = array();
    $building['bin'] = $row->bin ? $row->bin : '';
    $building['ward'] = $row->ward ? $row->ward : '';
    $building['taxpayercode'] = $row->taxpayercode ? $row->taxpayercode : '';
    $building['roadname'] = $row->roadname ? $row->roadname : '';
    $building['houseno'] = $row->houseno ? $row->houseno : '';
    $building['hownername'] = $row->hownername ? $row->hownername : '';
    $building['hownernumber'] = $row->hownernumber ? $row->hownernumber : '';
    $building['howneremail'] = $row->howneremail ? $row->howneremail : '';
    $building['housetype'] = $row->housetype ? $row->housetype : '';
    $building['length'] = $row->length ? $row->length : '';
    $building['width'] = $row->width ? $row->width : '';
    $building['area'] = $row->area ? $row->area : '';
    $building['rentername'] = $row->rentername ? $row->rentername : '';
    $building['rentpurpose'] = $row->rentpurpose ? $row->rentpurpose : '';
    $building['rentstart'] = $row->rentstart ? $row->rentstart : '';
    $building['monthlyrent'] = $row->monthlyrent ? $row->monthlyrent : '';
    $building['rentaxresponsible'] = $row->rentaxresponsible ? $row->rentaxresponsible : '';
    $building['rentincreseperyear'] = $row->rentincreseperyear ? $row->rentincreseperyear : '';
    $building['rentmobilenumber'] = $row->rentmobilenumber ? $row->rentmobilenumber : '';
    $building['remarks'] = $row->remarks ? $row->remarks : '';
    $building['geom'] = $row->geom ? $row->geom : '';
    $data3[] = $building;
}


return ([
    'data1' => $data1,
    'data2' => $data2,
    'data3' =>  $data3 ]);

}); 



Route::get('getRoadInformation/{long}/{lat}', function ($long, $lat) {
    $roads_query = "SELECT r.id, ST_AsText(r.geom) as geom"
        . " FROM road As r"
        // . " LEFT JOIN building_use bu"
        // . " ON b.bldguse = bu.value"
        // . " LEFT JOIN building_construction bc"
        // . " ON b.consttyp = bc.value"
        // . " LEFT JOIN tax_status_code t"
        // . " ON b.btxsts = t.value"
        . " WHERE ST_Contains(r.geom, ST_GeomFromText('POINT(" . $long . " " . $lat . ")', 4326))";

    $results = DB::select($roads_query);

    $data = array();

    foreach ($results as $row) {
        $road = array();
        $road['id'] = $row->id;
        // $road['bin'] = $row->bin;
        // $road['ward'] = $row->ward;
        // $road['tole'] = $row->tole;
        // $road['hownr'] = $row->hownr;
        // $road['yoc'] = $row->yoc;
        // $road['flrcount'] = $row->flrcount;
        // $road['building_use'] = $row->building_use;
        // $road['construction_type'] = $row->construction_type;
        // $road['tax_status'] = $row->tax_status;
        $road['geom'] = $row->geom;
        // $road['photo_path'] = asset('img/building.jpg');
        $data[] = $road;
    }

    return $data;
});

Route::get('searchStreetsByKeywords/{keywords}', function($keywords){
    $keywords = trim($keywords);

    $data = array();

    if($keywords) {
        $keywordArr = explode(' ', $keywords);
        $tsQueries = [];

        foreach($keywordArr as $keyword) {
            if($keyword != '') {
                $tsQueries[] = "plainto_tsquery('" . $keyword . "')";
            }
        }

        if(count($tsQueries) > 0) {
            $street_query = "SELECT id, strtcd, strtnm"
                        . " FROM street"
                        . " WHERE document @@ (" . implode(' || ', $tsQueries) . ")";

            $results = DB::select($street_query);

            $data = array();

            foreach ($results as $row) {
                $street = array();
                $street['id'] = $row->id;
                $street['strtcd'] = $row->strtcd;
                $street['strtnm'] = $row->strtnm;
                $data[] = $street;
            }
        }
    }

    return $data;
});


Route::get('getExportCSV', 'MapsController@getBuildingsReportCSV')->name('export-buildings');
Route::get('getAreaExportCSV', 'MapsController@getBuildingsAreaReportCSV')->name('export-buildings');













