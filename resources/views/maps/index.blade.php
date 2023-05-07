@extends('layoutMap')

@section('content')
<div class="content-wrapper map-container">
    <!-- <svg width="300px" height="300px" xmlns="http://www.w3.org/2000/svg" id="canvas">
    <text x="10" y="50" font-size="30">My SVG</text>
    </svg> -->
        <div class="map-toolbar clearfix">
            <div class="col-md-5 controls-div">
                <ul>
                    <a href="#" id="zoomin_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Zoom In"><i class="fa fa-search-plus"></i></a>
                 	<a href="#" id="zoomout_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Zoom Out"><i class="fa fa-search-minus"></i></a>
                 	<a href="#" id="zoomfull_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Dharan Municipality"><i class="fa fa-globe"></i></a>
                    <a href="#" id="pan_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Navigate"><i class="fa fa-arrows"></i></a>
                    <!-- <a href="#" id="navprev_control" class="btn btn-default glyphicon glyphicon-arrow-left" data-toggle="tooltip" data-placement="bottom" title="Previous View"></a>
                    <a href="#" id="navnext_control" class="btn btn-default glyphicon glyphicon-arrow-right" data-toggle="tooltip" data-placement="bottom" title="Next View"></a> -->
                    <a href="#" id="buildinginfo_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Building Info"><i class="fa fa-building"></i></a>

                    <a href="#" id="roadinfo_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Road Info"><i class="fa fa-road"></i></a>
                    <a href="#" id="identify_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Info"><i class="fa fa-info-circle"></i></a>
                    <a href="#" id="coordinate_control" class="btn btn-default map-control" style="padding:6px 14px!important;" data-toggle="tooltip" data-placement="bottom" title="Coordinate Information"><i class="fa fa-map-pin"></i></a>
                    <a href="#" id="linemeasure_control" class="btn btn-default map-control" style="padding:4px 6px!important;" data-toggle="tooltip" data-placement="bottom" title="Measure Distance"><img src="{{ asset('/img/distance_off.png') }}"></a>
                    <a href="#" id="polymeasure_control" class="btn btn-default map-control" style="padding:4px 6px!important;" data-toggle="tooltip" data-placement="bottom" title="Measure Area"><img src="{{ asset('/img/area_off.png') }}"></a>
                    <a href="#" id="print_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Print"><i class="fa fa-print"></i></a>
                    <a href="#" id="removemarkers_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Remove Markers"><i class="fa fa-trash"></i></a>
                </ul>
            </div>
            <div class="col-md-3">
                <form class="form-inline" name="building_search_form" id="building_search_form">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Locate House</div>
                            <input type="text" class="form-control" id="bin_text" placeholder="BIN" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <form class="form-inline" name="street_search_form" id="street_search_form">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Search Street</div>
                            <input type="text" class="form-control" id="street_search_keyword_text" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="col-md-4">
                <form class="form-inline" name="text_search_form" id="text_search_form">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search_keyword_text"/>
                            <div class="input-group-addon">In</div>
                            <select class="form-control" id="search_layer_select">
                                <option value="places">Places</option>
                                <option value="pubsrv">Public Services</option>
                                <option value="roadline">Roads</option>
                            </select>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div> -->
            <div class="col-md-1 text-right">
                <a href="#" id="map-right-sidebar-toggle" class="btn btn-default">
                  <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>
       
        <div id="map">
            <div id="gmap" style="width: 100%; height: 100%; visibility: hidden;"></div>
            <div id="olmap" style="position: absolute; top: 0; left: 0; right: 0; bottom:0;"></div>
            <div id="popup" class="ol-popup" style="display: none;">
                <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                <div id="popup-content"></div>
            </div>
           
            <div class="popup-tab" id="popup-tab">
                <a href="#" id="container-popup-closer" class="ol-popup-closer"></a>
                
                <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="#building_" aria-controls="analysis" role="tab"  data-toggle="tab">Building Details</a></li>
                        <li role="presentation"><a href="#building-business-tax_" aria-controls="analysis" role="tab" data-toggle="tab">Business Details</a></li>
                        <li role="presentation"><a href="#building-rent-tax_" aria-controls="analysis" role="tab" data-toggle="tab">Rent Details</a></li>
                </ul>
                

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane  " id="building_">
                                 </div>
                  <div role="tabpanel" class="tab-pane " id="building-business-tax_">
                  </div>
                  <div role="tabpanel" class="tab-pane " id="building-rent-tax_">
                  </div>
                    
                 </div>
               
                 <div><strong>Export to:</strong>
                 <form method="get" action="/getExportCSV">
                            <input type="hidden" name="lat" value="" id="lat" />
                            <input type="hidden" name="long" value="" id="long" />
                            <input type="hidden" name="bin" value="" id="bin" />
                            
                            <button type="submit" id="buildings-export-btn"  class="btn btn-default">Excel</button>
                        </form>
</div>
            </div>


            <div id="report-popup" class="ol-popup" style="display: none;">
          
                <a href="#" id="report-popup-closer" class="ol-popup-closer"></a>
                <div id="report-popup-content"></div>
            </div>
            <div id="export-popup" class="ol-popup" style="display: none;">
                <a href="#" id="export-popup-closer" class="ol-popup-closer"></a>
                <div id="export-popup-content">
                
                </div>
            </div>

            <div id="export-area-popup" class="ol-area-popup">
                <a href="#" id="export-area-popup-closer" class="ol-popup-closer"></a>
                <div id="export-area-popup-content">
                
                 <form method="get" action="/getAreaExportCSV">
                 <strong>Export to:</strong>
                 <input type="hidden" name="geom" value="" id="geom" />
                            <button type="submit" id="buildings-export-btn"  class="btn btn-default">CSV</button>
                            
                        </form>
                </div>
            </div>
            <div id="map-right-sidebar">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#layers-tab" aria-controls="layers" role="tab" data-toggle="tab">Layers</a></li>
                    <li role="presentation"><a href="#analysis-tab" aria-controls="analysis" role="tab" data-toggle="tab">Spatial Analysis</a></li>
                    <li role="presentation"><a href="#road-tab" aria-controls="analysis" role="tab" data-toggle="tab">Road Details</a></li>
                    <li role="presentation"><a href="#search-results-tab" aria-controls="analysis" role="tab" data-toggle="tab">Search Results</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="layers-tab">
                        <div>
                            <div>
                                <label for="base_layer_select">Base Layer</label>
                            </div>
                            <div>
                                <select id="base_layer_select">
                                    <option value="">None</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="">Overlays</label>
                            </div>
                            <div id="overlay_checkbox_container"></div>
                        </div>
                        <!--
                        <div>
                            <div>
                                <label for="">Extra Overlays</label>
                            </div>
                            <div id="extra_overlay_checkbox_container"></div>
                        </div>
                         -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="analysis-tab">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-1">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                            Find Nearest Road
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-1">
                                    <div class="panel-body">
                                        <a href="#" id="nearestroad_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Nearest Road"><i class="fa fa-road"></i></a>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-2">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-2" aria-expanded="true" aria-controls="collapse-2">
                                            Find Due Buildings
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-2">
                                    <div class="panel-body">
                                        <a href="#" id="duebuildings_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Due Buildings"><i class="fa fa-building"></i></a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-3">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                    <i class=" more-less glyphicon glyphicon-plus" style="float:right;"></i>
                                    Filter by Wards
                                </a>
                                </h4>     
                                </div>
                                <div id="collapse-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-3">
                                    <div class="panel-body">
                                        <form role="form" name="ward_form" id="ward_form">

                                                <div class="form-group">
                                                    <label for="ward">Wards</label>
                                                    {!! Form::select('ward', $wards,null,
                                        ['id' => 'ward', 'multiple' => true, 'style' => 'width: 100%'])
                                        !!}
                                                </div>
                                          
                                            <div class="form-group">
                                                <label for="ward_overlay">Overlays</label>
                                                <select id="ward_overlay"  multiple="multiple" style="width: 100%">
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-default">Filter</button>
                                            <button type="button" class="btn btn-default" id="ward_clear_button">Clear</button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Export <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" id="export_ward_filter_json">JSON</a></li>
                                                    <li><a href="#" id="export_ward_filter_kml">KML</a></li>
                                                    <li><a href="#" id="export_ward_filter_shp">Shape File</a></li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-11">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-11" aria-expanded="false" aria-controls="collapse-11">
                                    <i class=" more-less glyphicon glyphicon-plus" style="float:right;"></i>
                                    Filter by Laws
                                </a>
                                </h4> 
                                    
                                </div>
                                <div id="collapse-11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-11">
                                    <div class="panel-body">
                                        <form role="form" name="bylaw_form" id="bylaw_form">
                                            <div class="form-group">
                                                <label for="bylaw">By Laws</label>
                                                {!! Form::select('bylaw',
                                                $bylaws,
                                                null,
                                                ['class' => 'form-control', 'id' => 'bylaw', 'multiple' => true])
                                                !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="bylaw_overlay">Overlays</label>
                                                <select id="bylaw_overlay" class="form-control" multiple="multiple">
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-default">Filter</button>
                                            <button type="button" class="btn btn-default" id="bylaw_clear_button">Clear</button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Export <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" id="export_bylaw_filter_json">JSON</a></li>
                                                    <li><a href="#" id="export_bylaw_filter_kml">KML</a></li>
                                                    <li><a href="#" id="export_bylaw_filter_shp">Shape File</a></li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-4">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-4" aria-expanded="true" aria-controls="collapse-4">
                                            Find Containments to be emptied
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-4">
                                    <div class="panel-body">
                                        <form class="form-inline" name="containment_days_form" id="containment_days_form" style="margin-bottom: 15px">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Next</div>
                                                    <input type="text" class="form-control" id="emptying_days" />
                                                    <div class="input-group-addon">Days</div>
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                        <form class="form-inline" name="containment_week_form" id="containment_week_form" style="margin-bottom: 15px">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon" style="width:100%; text-align: left;">Next Week</div>
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                        <form role="form" name="containment_date_form" id="containment_date_form">
                                            <div class="input-group">
                                                <div class="input-group-addon">Date</div>
                                                <input type="text" class="form-control" id="next_emptying_date" />
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-5">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-5" aria-expanded="true" aria-controls="collapse-5">
                                            Filter by Water Logging Area
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-5">
                                    <div class="panel-body">
                                        <form role="form" name="watlog_form" id="watlog_form">
                                            <div class="form-group">
                                                <label for="watlog_overlay">Overlays</label>
                                                <select id="watlog_overlay" class="form-control" multiple="multiple">
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-default">Filter</button>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-6">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-6" aria-expanded="false" aria-controls="collapse-6">
                                    <i class=" more-less glyphicon glyphicon-plus" style="float:right;"></i>
                                    Report Information Tool
                                </a>
                                </h4> 
                                    
                                </div>
                                <div id="collapse-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-6">
                                    <div class="panel-body">
                                        <a href="#" id="report_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Report Information Tool"><i class="fa fa-file-text"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-10">

                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-10" aria-expanded="false" aria-controls="collapse-10">
                                    <i class=" more-less glyphicon glyphicon-plus" style="float:right;"></i>
                                    Filter Buildings
                                </a>
                                </h4> 
                                   
                                </div>
                                <div id="collapse-10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-10">
                                    <div class="panel-body">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="bldg_sngwoman_checkbox" name="bldg_sngwoman_checkbox" value="1" />
                                                Show only buildings with single women
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="bldg_gt60yr_checkbox" name="bldg_gt60yr_checkbox" value="1" />
                                                Show only buildings with old age people
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="bldg_dsblppl_checkbox" name="bldg_dsblppl_checkbox" value="1" />
                                                Show only buildings with disabled people
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-7">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-7" aria-expanded="true" aria-controls="collapse-7">
                                            Filter Buildings by Structure Type
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-7">
                                    <div class="panel-body">
                                        <div id="building_structype_checkbox_container">
                                            @foreach(['Katcha', 'Tin Shed', 'Semi Pucca', 'Pucca', 'No Info', 'Others'] as $structype)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="{{$structype}}" value="{{$structype}}" />
                                                    {{$structype}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-8">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-8" aria-expanded="true" aria-controls="collapse-8">
                                            Filter Informal Settlements by Toilet
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-8">
                                    <div class="panel-body">
                                        <div id="settarea_setttoilet_checkbox_container">
                                            @foreach(['1 Toilet&gt;15 People', '1 Toilet&lt;15 People', 'Individual Toilet', 'No Toilet Available'] as $setttoilet)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="{{$setttoilet}}" value="{{$setttoilet}}" />
                                                    {{$setttoilet}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-9">

                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-9" aria-expanded="false" aria-controls="collapse-9">
                                    <i class=" more-less glyphicon glyphicon-plus" style="float:right;"></i>
                                    Export
                                </a>
                                </h4> 
                                </div>
                                <div id="collapse-9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-9">
                                    <div class="panel-body">
                                        <a href="#" id="export_control" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Export"><i class="fa fa-share-square-o"></i></a>
                                    </div>
                                </div>
                            </div>




                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-15">

                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-15" aria-expanded="false" aria-controls="collapse-15">
                                    <i class=" more-less glyphicon glyphicon-plus" style="float:right;"></i>
                                    Summary Information
                                </a>
                                </h4> 
                                </div>
                                <div id="collapse-15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-15">
                                    <div class="panel-body">
                                        <a href="#" id="export_control_2" class="btn btn-default map-control" data-toggle="tooltip" data-placement="bottom" title="Export"><i class="fa fa-share-square-o"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-12">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-12" aria-expanded="true" aria-controls="collapse-12">

                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-12">
                                    <div class="panel-body">

                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <!-- <a href="#" id="radiusfilter_control" class="btn btn-default glyphicon glyphicon-filter" data-toggle="tooltip" data-placement="bottom" title="Radius Filter"></a> -->
                    </div>
                   
                    
                    <div role="tabpanel" class="tab-pane active" id="road-tab">
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="search-results-tab">
                    </div>
                </div>
            </div>
        </div>

      <div class="row main-row"></div>

      <div class="mini-submenu mini-submenu-top-left pull-left">
        <i class="glyphicon glyphicon-tasks"></i>
      </div>
      <div class="mini-submenu mini-submenu-top-right pull-right">
        <i class="glyphicon glyphicon-list-alt"></i>
      </div>
      <div class="mini-submenu mini-submenu-bottom-left pull-left" style="display: block;">
        <i class="fa fa-table"></i>
      </div>
      <div class="col-md-3 sidebar sidebar-top-left" style="display: none;">
          <div class="panel-group sidebar-body map__" id="accordion-left">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#analysis">
                    <i class="fa fa-list-alt"></i>
                    Spatial Analysis
                  </a>
                  <span class="pull-right slide-submenu">
                    <i class="glyphicon glyphicon-chevron-left"></i>
                  </span>

                </h4>
              </div>
              <div id="analysis" class="panel-collapse collapse in">
                <div class="panel-body list-group">

                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-3 sidebar sidebar-top-right" style="display: none;">
        <div class="panel-group sidebar-body map__" id="accordion-left">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" href="#layers">
                  <i class="fa fa-list-alt"></i>
                  Layers
                </a>
                <span class="pull-right slide-submenu">
                  <i class="glyphicon glyphicon-chevron-right"></i>
                </span>

              </h4>
            </div>
            <div id="layers" class="panel-collapse collapse in">
              <div class="panel-body list-group" id="layerswitcher">
              <!--
              <div>Base Layer</div>
              <div id="base-layers-div"></div>
              -->

              <!--  <a href="#" class="list-group-item">
                  <i class="fa fa-globe"></i> Open Street Map
                </a>
                <a href="#" class="list-group-item">
                  <i class="fa fa-globe"></i> Bing
                </a>
                <a href="#" class="list-group-item">
                  <i class="fa fa-globe"></i> WMS
                </a>-->
              </div>
            </div>

          </div>


        </div>
      </div>
      <div class="col-md-6 sidebar sidebar-bottom-left">
          <div class="panel-group sidebar-body map__" style="display: none;">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#featureinfo-collapse">
                    <i class="fa fa-table"></i>
                    Info
                  </a>
                  <span class="pull-right slide-submenu">
                    <i class="glyphicon glyphicon-chevron-left"></i>
                  </span>

                </h4>
              </div>
              <div id="featureinfo-collapse" class="panel-collapse collapse in">
                <div class="panel-body list-group">

                </div>
              </div>

            </div>


          </div>
      </div>
</div><!-- /.content-wrapper -->
<footer class="main-footer" style="position:fixed;right:0;bottom:0;width: 100%;z-index:35;padding:7px;height:35px;">
  <!-- To the right -->
  <div class="pull-right hidden-xs">
      <strong>Developed by:</strong> <a href="http://www.innovativesolution.com.np">Innovative Solution Pvt. Ltd.</a>
  </div>
  <!-- Default to the left -->
  <div id="footer-content">
      <div id="output"></div>
  </div>

</footer>
<script type="text/javascript">
// Google Map
var gmap;
function initMap() {
    gmap = new google.maps.Map(document.getElementById('gmap'), {
        disableDefaultUI: true,
        keyboardShortcuts: false,
        draggable: false,
        disableDoubleClickZoom: true,
        scrollwheel: false,
        streetViewControl: false,
        // center: {lat: 22.8456, lng: 89.5403},
        // zoom: 12
    });
}
</script>
@stop
@push('scripts')
<script src="{{ asset ('/js/html2canvas.min.js') }}"></script>
<script src="{{ asset ('/js/html2canvas.js') }}"></script>


<script type="text/javascript">
$(document).ready(function(){
  
    function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);


    $('#map-right-sidebar .nav-tabs').scrollingTabs({
        scrollToTabEdge: true,
        disableScrollArrowsOnFullyScrolled: true  
    });
    
    function displayAjaxLoader() {
        if($('.ajax-modal').length == 0) {
            $('body').append('<div class="ajax-modal"><div class="ajax-modal-content"><div class="loader"></div></div></div>');
        }
    }

    function removeAjaxLoader() {
        $('.ajax-modal').remove();
    }

    function displayAjaxError() {
        displayAjaxErrorModal('An error occurred');
    }

    function displayAjaxErrorModal(message) {
        if($('.ajax-modal').length > 0) {
            var html = '<div class="ajax-modal-message">';
            html += '<span>' + message + '</span>';
            html += '<a href="#" class="ajax-modal-close-btn"><i class="fa fa-times"></i></a>';
            html += '</div>';

            $('.ajax-modal-content').html(html);
        }
    }

    $('body').on('click', 'a.ajax-modal-close-btn', function (e) {
        e.preventDefault();
        removeAjaxLoader();
    });

    $('#map-right-sidebar-toggle').click(function(e){
        e.preventDefault();
        var sidebar = $('#map-right-sidebar');
        if(sidebar.css('right') == '0px') {
            sidebar.animate({ right: sidebar.outerWidth() * -1});
        }
        else {
            sidebar.animate({ right: 0});
        }
    });

    $(".sidebar-top-left .slide-submenu").on("click", function () {
        var i = $(this);
        i.closest(".sidebar-body").fadeOut("slide", function () {
            $(".mini-submenu-top-left").fadeIn();
            applyMargins();
        })
    });

    $(".mini-submenu-top-left").on("click", function () {
        var i = $(this);
        $(".sidebar-top-left .sidebar-body").fadeIn("slide");
        i.hide();
        applyMargins();
    });

    $(".sidebar-top-right .slide-submenu").on("click", function () {
        var i = $(this);
        i.closest(".sidebar-body").fadeOut("slide", function () {
            $(".mini-submenu-top-right").fadeIn();
            applyMargins();
        });
    });

    $(".mini-submenu-top-right").on("click", function () {
        var i = $(this);
        $(".sidebar-top-right .sidebar-body").fadeIn("slide");
        i.hide();
        applyMargins();
    });

    $(".sidebar-bottom-left .slide-submenu").on("click", function () {
        var i = $(this);
        i.closest(".sidebar-body").fadeOut("slide", function () {
            $(".mini-submenu-bottom-left").fadeIn();
            applyMargins();
        })
    });

    $(".mini-submenu-bottom-left").on("click", function () {
        var i = $(this);
        $(".sidebar-bottom-left .sidebar-body").fadeIn("slide");
        i.hide();
        applyMargins();
    });

    $(window).on("resize", applyMargins);

    $('#next_emptying_date').datepicker({
        format: "yyyy-mm-dd",
        startDate: new Date(),
        todayHighlight: true
    });

    var layer = '{{ Input::get('layer') }}';
    var field = '{{ Input::get('field') }}';
    var val = '{{ Input::get('val') }}';
    var action = '{{ Input::get('action') }}';
    var currentControl = '';
   
    // OpenLayers Map
    var map = new ol.Map({
        controls: ol.control.defaults().extend([new ol.control.ScaleLine()]),
        interactions: ol.interaction.defaults({
            altShiftDragRotate: false,
            dragPan: false,
            rotate: false,
            // mouseWheelZoom: false,
            doubleClickZoom: false
        }).extend([new ol.interaction.DragPan({kinetic: null})]),
        target: 'olmap',
        view: new ol.View({
            // center: ol.proj.transform([89.5403, 22.8456], 'EPSG:4326', 'EPSG:3857'),
            // zoom: 12,
            minZoom: 12,
            maxZoom: 19,
            // extent: ol.proj.transformExtent([89.4831, 22.7661, 89.5829, 22.9093], 'EPSG:4326', 'EPSG:3857')
        })
    });
//    
//var abc = ol.proj.transform(map.getView().getCenter(), 'EPSG:3857', 'EPSG:4326');
//console.log(abc);
//    bounds.extend(new OpenLayers.LonLat(4,5));
//    bounds.extend(new OpenLayers.LonLat(5,6));
//    bounds.toBBOX(); // returns 4,5,5,6

//     var mapbounds = map.getExtent();
//    console.log(mapbounds);
//    console.log(mapbounds.transform('EPSG:4326', 'EPSG:3857'));
    // URL of GeoServer
    var gurl = "<?php echo Config::get("constants.GURL_URL"); ?>/";
    
    var gurl_wms = gurl + 'wms';
    var gurl_wfs = gurl + 'wfs';
    // URL of GeoServer Legends
    var gurl_legend = gurl_wms + "?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=";

    // URL of GeoServer Legends
    var gurl_legend = gurl_wms + "?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=";


    // Base Layers Object
    var bLayer = {
        osm: { name: 'OpenStreetMap', type: 'osm' },
        bing_aerial: { name: 'Bing Aerial', type: 'bing', imagerySet: 'Aerial' },
        bing_aerial_labels: { name: 'Bing Aerial with Labels', type: 'bing', imagerySet: 'AerialWithLabels' },
        bing_road: { name: 'Bing Road', type: 'bing', imagerySet: 'Road' },
        bing_collins_bart: { name: 'Bing Collins Bart', type: 'bing', imagerySet: 'collinsBart' },
        bing_ordnance_survey: { name: 'Bing Ordnance Survey', type: 'bing', imagerySet: 'ordnanceSurvey' },
        google_streets: { name: 'Google Streets', type: 'google', mapType: 'roadmap' },
        google_hybrid: { name: 'Google Hybrid', type: 'google', mapType: 'hybrid' },
        google_satellite: { name: 'Google Satellite', type: 'google', mapType: 'satellite' },
        google_terrain: { name: 'Google Terrain', type: 'google', mapType: 'terrain' }
    };

    // HTML for Base Layers select box
    var html = '';
    // Looping through Base Layers Object
    $.each(bLayer, function(key, value){
        var layer;
        if(value.type == 'osm') {
            // Creating layer object
            layer = new ol.layer.Tile({
                visible: false,
                source: new ol.source.OSM()
            });
        }
        else if(value.type == 'bing') {
            // Creating layer object
            layer = new ol.layer.Tile({
                visible: false,
                source: new ol.source.BingMaps({
                    key: 'AlonC1vgjxPDct_RRLBn9Yyq41IXw5otDfbJRDfbNZQRblZC1Eum9BmE-zs499ED',
                    imagerySet: value.imagerySet
                })
            });
        }

        // if layer object has been created for the current Base Layer
        if(layer) {
            // Adding layer to OpenLayers Map
            map.addLayer(layer);
            // Assigning layer to layer property of the current Base Layer
            bLayer[key].layer = layer;

            /*
            html += '<div class="radio">';
            html += '<label>';
            html += '<input type="radio" name="base_layer" value="' + key + '"/>';
            html += value.name;
            html += '</label>';
            html += '</div>';
            */
        }

        // select box option for the current Base Layer
        html += '<option value="' + key + '">' + value.name + '</option>'
    });

    /*
    $('#base-layers-div').html(html);

    $('#base-layers-div').on('change', 'input[name=base_layer][type=radio]', function(){
        var selectedLayer = $(this).val();
        $.each(bLayer, function(key, value) {
            bLayer[key].layer.setVisible(key == selectedLayer);
        });
    });

    $('input[name=base_layer][type=radio]:first').click();
    */

    // adding HTML to select box
    $('#base_layer_select').append(html);

    // Handler for Base Layer select box change
    $('#base_layer_select').change(function(){
        var selected = $(this).val();
        if(selected && bLayer[selected]) { // if selected option is not 'None' or selected option exists in Base Layers Object
            if(bLayer[selected].type == 'google') { // if selected option is Google Map
                // Hide all Base Layers
                $.each(bLayer, function(key, value) {
                    if(bLayer[key].layer) {
                        bLayer[key].layer.setVisible(false);
                    }
                });
                // Set Google Map Type
                gmap.setMapTypeId(bLayer[selected].mapType);
                // Set centre and zoom of Google Map to those of OpenLayers Map
                onCenterChanged();
                onResolutionChanged();
                // Add handler to OpenLayers view centre change and zoom change events
                map.getView().on('change:center', onCenterChanged);
                map.getView().on('change:resolution', onResolutionChanged);
                // Make Google Map visible
                $('#gmap').css('visibility', 'visible');
                // Add handler to window resize
                $(window).on('resize', onWindowResize);
            }
            else { // if seleceted option is OpenStreetMap or Bing Map
                // Make Google Map invisible
                $('#gmap').css('visibility', 'hidden');
                // Show selected Base Layer and hide other Base Layers
                $.each(bLayer, function(key, value) {
                    if(bLayer[key].layer) {
                        bLayer[key].layer.setVisible(key == selected);
                    }
                });
                // Remove handler from OpenLayers view centre change and zoom change events
                map.getView().un('change:center', onCenterChanged);
                map.getView().un('change:resolution', onResolutionChanged);
                // Remove handler to window resize
                $(window).off('resize', onWindowResize);
            }
        }
        else { // if selected option is 'None' or selected options does not exists in Base Layers Object
            // Make Google Map invisible
            $('#gmap').css('visibility', 'hidden');
            // Hide all Base Layers
            $.each(bLayer, function(key, value) {
                if(bLayer[key].layer) {
                    bLayer[key].layer.setVisible(false);
                }
            });
            // Remove handler from OpenLayers view centre change and zoom change events
            map.getView().un('change:center', onCenterChanged);
            map.getView().un('change:resolution', onResolutionChanged);
            // Remove handler to window resize
            $(window).off('resize', onWindowResize);
        }
    });

    // Handler for OpenLayers view centre change event
    function onCenterChanged() {
        // Get centre of OpenLayers Map
        var center = ol.proj.transform(map.getView().getCenter(), 'EPSG:3857', 'EPSG:4326');
        // Set centre of Google Map to that of OpenLayers Map
        gmap.setCenter(new google.maps.LatLng(center[1], center[0]));
    }

    // Handler for OpenLayers view zoom change event
    function onResolutionChanged() {
        // Set zoom of Google Map to that of OpenLayers map
        gmap.setZoom(map.getView().getZoom());
    }

    // Handler for window resize
    function onWindowResize() {
        google.maps.event.trigger(gmap, 'resize');
        // Set centre and zoom of Google Map to those of OpenLayers Map
        onCenterChanged();
        onResolutionChanged();
    }

    // Trigger Base Layer select box change
    $('#base_layer_select').trigger('change');

    // Filters Object
    var mFilter = {
        ward: '',
        toilet: '',
        building_structype: '',
        settarea_setttoilet: '',
        bldg_sngwoman: '',
        bldg_gt60yr: '',
        bldg_dsblppl: '',
        bylaw: '',
    };

    // Overlays Group Object
    var mLayerGroup = {
        administrative_boundaries: 'Administrative Boundaries',
        buildings: 'Buildings',
        transportation: 'Transportation',
        land_cover: 'Land Cover',
        building_planning_bylaws: 'Building and Planning By Laws',
        topography: 'Topography',
        public_services_utilities: 'Public Services &amp; Utilities',
        location: 'Location',
        business: 'Business',
        rent: 'Rent',
    };

    // Overlays Object
    var mLayer = {
        addzone: {
            name: 'Address Zone',
            styles: {
                addzone_none: {
                    name: 'None',
                    clipLegend: false,
                    showCount: false
                },
                addzone_name_sld: {
                    name: 'Name',
                    clipLegend: false,
                    showCount: false
                }
            },
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'administrative_boundaries',
        },
        munipl: {
            name: 'Municipal Boundary',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'administrative_boundaries',
        },
        wardpl: {
            name: 'Ward Boundary',
            styles: {
                wardpl_none: {
                    name: 'None',
                    clipLegend: false,
                    showCount: false
                },
                wardpl_new_wards: {
                    name: 'Ward No.',
                    clipLegend: true,
                    showCount: true
                },
            },
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'administrative_boundaries',
        },
        bldg: {
            name: 'Buildings',
            styles: {
                bldg_none: {
                    name: 'None',
                    clipLegend: false,
                    showCount: false
                },
                bldg_bldguse: {
                    name: 'Building Use',
                    clipLegend: true,
                    showCount: true
                },
                bldg_flrcount: {
                    name: 'Number of Floors',
                    clipLegend: true,
                    showCount: true
                },
                bldg_consttyp: {
                    name: 'Construction Type',
                    clipLegend: true,
                    showCount: true
                },
                bldg_toilyn: {
                    name: 'Toilet',
                    clipLegend: true,
                    showCount: true
                },
                bldg_hhcount: {
                    name: 'Number of Households',
                    clipLegend: true,
                    showCount: true
                },
                bldg_btxsts: {
                    name: 'Building Tax Paid Status',
                    clipLegend: true,
                    showCount: true
                },
                bldg_sngwoman: {
                    name: 'Single Women',
                    clipLegend: true,
                    showCount: true
                },
                bldg_gt60yr: {
                    name: 'Old Age People',
                    clipLegend: true,
                    showCount: true
                },
                bldg_dsblppl: {
                    name: 'Disabled People',
                    clipLegend: true,
                    showCount: true
                },
                bldg_businessno: {
                    name: 'Number of Business',
                    clipLegend: true,
                    showCount: true
                },
                bldg_rentno: {
                    name: 'Number of Rent',
                    clipLegend: true,
                    showCount: true
                },
                bldg_business_tax_status: {
                    name: 'Business Tax Status',
                    clipLegend: true,
                    showCount: true
                },
            },
            clipLegend: true,
            filters: [],
            group: 'buildings',
        },
        
        bldg_tax_payment_status: {
            name: 'Tax Payment Status',
            styles: {},
            clipLegend: true,
            showCount: true,
            filters: [],
            group: 'buildings',
        },
        
        @if(auth()->user()->can('Tax Payment Status Buildings Map Layer') || auth()->user()->can('Water Payment Status Map Layer'))
        @can('Tax Payment Status Buildings Map Layer')
        bldg_tax_status_layer: {
            name: 'Building Tax Payment Status',
            styles: {},
            clipLegend: true,
            showCount: true,
            filters: [],
        },
        @endcan
        @endif
        bldg_business_tax: {
            name: 'Building Business Tax',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'business',
        },
        business_tax_status_layer: {
            name: 'Tax Payment Status',
            styles: {},
            clipLegend: true,
            showCount: true,
            filters: [],
            group: 'business',
        },
        bldg_rent_tax: {
            name: 'Building Rent Tax',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'rent',
        },
        bridgeedge: {
            name: 'Bridge',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'transportation',
        },
        road: {
            name: 'Roads Segments',
            styles: {
                road_none: {
                    name: 'None',
                    clipLegend: false,
                    showCount: false
                },
                road_rdwidth: {
                    name: 'Road Width',
                    clipLegend: false,
                    showCount: false
                },
                road_rdsurf: {
                    name: 'Road Surface',
                    clipLegend: true,
                    showCount: true
                }
            },
            clipLegend: true,
            filters: [],
            group: 'transportation',
        },
        roadedge: {
            name: 'Road Edge',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'transportation',
        },
        roadpl: {
            name: 'Road Polygon',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'transportation',
        },
        rdshoulder: {
            name: 'Road Shoulder',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'transportation',
        },
        street: {
            name: 'Street',
            styles: {
                street_none: {
                    name: 'None',
                    clipLegend: false,
                    showCount: false
                },
                street_addrzn: {
                    name: 'Address Zone',
                    clipLegend: true,
                    showCount: true
                }
            },
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'transportation',
        },
        landuse: {
            name: 'Existing Land Use',
            styles: {
                landuse_none: {
                    name: 'None',
                    clipLegend: false,
                    showCount: false
                },
                landuse_luclass: {
                    name: 'Category',
                    clipLegend: true,
                    showCount: true
                }
            },
            clipLegend: true,
            showCount: true,
            filters: [],
            group: 'land_cover',
        },
        river: {
            name: 'Rivers',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'land_cover',
        },
        ponds: {
            name: 'Ponds',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'land_cover',
        },
        bylaws: {
            name: 'Building and planning by-laws',
            styles: {
                bylaws_none: {
                    name: 'None',
                    clipLegend: false,
                    showCount: false
                },
                bylaws_name: {
                    name: 'Name',
                    clipLegend: true,
                    showCount: true
                }
            },
            clipLegend: true,
            showCount: true,
            filters: [],
            group: 'building_planning_bylaws',
        },
        contour: {
            name: 'Contour',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'topography',
        },
        spotht: {
            name: 'Spot Height',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'topography',
        },
        education: {
            name: 'Education',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        finance: {
            name: 'Finance',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        health: {
            name: 'Health',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        hotel_resturants: {
            name: 'Hotels &amp; Restaurants',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        institution: {
            name: 'Institution',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        monument: {
            name: 'Monument',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        municipal_offices: {
            name: 'Municipal Offices',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        public_utility: {
            name: 'Public Utility',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        recreation: {
            name: 'Recreation',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        religious: {
            name: 'Religious',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        security: {
            name: 'Security',
            styles: {},
            clipLegend: true,
            showCount: false,
            filters: [],
            group: 'public_services_utilities',
        },
        location: {
            name: 'Location points',
            styles: {},
            clipLegend: false,
            showCount: false,
            filters: [],
            group: 'location',
        }
    };

    // Add filter to layer
    function addFilterToLayer(layer, filter) {
        if(mLayer.hasOwnProperty(layer) && mFilter.hasOwnProperty(filter)) {
            var index = mLayer[layer].filters.indexOf(filter);
            if(index == -1) {
                mLayer[layer].filters.push(filter);
            }
        }
    }

    // Remove filter from layer
    function removeFilterFromLayer(layer, filter) {
        if(mLayer.hasOwnProperty(layer) && mFilter.hasOwnProperty(filter)) {
            var index = mLayer[layer].filters.indexOf(filter);
            if(index != -1) {
                mLayer[layer].filters.splice(index, 1);
            }
        }
    }

    addFilterToLayer('building', 'building_structype');
    addFilterToLayer('settarea', 'settarea_setttoilet');
    addFilterToLayer('bldg', 'bldg_sngwoman');
    addFilterToLayer('bldg', 'bldg_gt60yr');
    addFilterToLayer('bldg', 'bldg_dsblppl');

    // HTML for Overlay Group collapsibles
    var html = '';

    // Looping through Overlay Group Object and creating collapsibles
    $.each(mLayerGroup, function(key, value){
        var id = key + '-collapse';
        html += '<div class="collapse-heading">';
        html += '<a href="#' + id + '" class="collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="' + id + '">' + value + '</a>';
        html += '</div>';
        html += '<div class="collapse-body collapse" id="' + id + '"></div>';
    });

    // Set Overlay Group collapsibles HTML to container
    $('#overlay_checkbox_container').html(html);

    // HTML for Ward Filter Overlays select options
    var wardOverlayOptionsHTML = '';
    // HTML for Water Logging Area Filter Overlays select options
    var watlogOverlayOptionsHTML = '';
    // HTML for By Laws Overlays select options
    var bylawOverlayOptionsHTML = '';

    // Looping through Overlays Object and creating layer object
    $.each(mLayer, function(key, value){
        // creating layer object
        var layer = new ol.layer.Tile({
            visible: false,
            source: new ol.source.TileWMS({
                url: gurl_wms,
                params: {
                    'LAYERS': 'dharan_gmis:' + key,
                    'TILED': true,
                    'CQL_FILTER': null
                },
                serverType: 'geoserver',
                crossOrigin: 'anonymous'
            })
        });

        // Setting name to layer
        layer.set('name', key);

        // Assigning layer to layer property of the current Overlay
        mLayer[key].layer = layer;

        // Adding layer to OpenLayers Map
        map.addLayer(layer);

        // Adding HTML for the current Overlay checkbox
        var html = '<div class="checkbox">';
        html += '<label>';
        html += '<input type="checkbox" name="' + key + '" value="' + key + '" />';
        html += value.name;
        html += '</label>';
        html += '</div>';

        // Adding HTML for the current Overlay style select container
        html += '<div id="' + key + '_overlay_style_select_container" style="display:none;padding-left:15px;">';
        var keys = Object.keys(value.styles);
        if(keys.length > 0) { // if the current Overlay has styles
            html += '<select name="' + key + '">';
            for(var i = 0; i < keys.length; i++) {
                html += '<option value="' + keys[i] + '">' + value.styles[keys[i]].name + '</option>';
            }
            html += '</select>';
        }
        html += '</div>';

        // Adding HTML for the current Overlay legend container
        html += '<div id="' + key + '_overlay_legend_container" style="padding-left:15px;">';
        html += '</div>';

        // Set current Overlays checkbox HTML to its Layer Group collapsible
        $('#' + value.group + '-collapse').append(html);

        // Adding HTML for the current Overlay option in Ward Filter Overlay Select
        if(['munipl', 'wardpl'].indexOf(key) == -1) {
            wardOverlayOptionsHTML += '<option value="' + key +'">' + value.name + '</option>';
        }
        // Adding HTML for the current Overlay option in Water Logging Area Filter Overlay Select
        if(['citypl', 'watlog'].indexOf(key) == -1) {
            watlogOverlayOptionsHTML += '<option value="' + key +'">' + value.name + '</option>';
        }
        // Adding HTML for the current Overlay option in By Law Filter Overlay Select
        if(['munipl', 'bylaws'].indexOf(key) == -1) {
            bylawOverlayOptionsHTML += '<option value="' + key +'">' + value.name + '</option>';
        }
    });

    // Set Overlays options HTML to select boxes
    $('#ward_overlay').html(wardOverlayOptionsHTML);
    $('#watlog_overlay').html(watlogOverlayOptionsHTML);
    $('#bylaw_overlay').html(bylawOverlayOptionsHTML);

    // Handler for Overlays checkbox change
    $('#overlay_checkbox_container').on('change', 'input[type=checkbox]', function(){
        // Get name attribute of the changed Overlay checkbox
        var key = $(this).attr('name');

        if($(this).is(':checked')) { // if the Overlay checkbox is checked
            // Make the Overlay layer visible in map
            mLayer[key].layer.setVisible(true);
            // Show Ovelay style select container
            $('#' + key + '_overlay_style_select_container').show();

            if(Object.keys(mLayer[key].styles).length > 0) { // if the current Overlay has styles
                // Trigger Overlay style select change
                $('#overlay_checkbox_container select[name=' + key +']').change();
            }
            else { // if the current Overlay does not have styles
                // Set legend image HTML for the Overlay
                var html = '<img class="' + (mLayer[key].clipLegend ? 'clip-legend' : '') + '" src="' + gurl_legend + 'dharan_gmis:' + key + (mLayer[key].showCount ? '&LEGEND_OPTIONS=countMatched:TRUE': '') + '" id="'+ key + '" />';
                // Set HTML to the Overlay container
                $('#' + key + '_overlay_legend_container').html(html);
            }
        }
        else { // if the Overlay checkbox is unchecked
            // Make the Overlay layer invisible in map
            mLayer[key].layer.setVisible(false);
            // Hide Ovelay style select container
            $('#' + key + '_overlay_style_select_container').hide();
            // Set empty HTML to the Overlay container
            $('#' + key + '_overlay_legend_container').html('');
        }
    });

    // Handler for Overlays style select change
    $('#overlay_checkbox_container').on('change', 'select', function(){
        // Get name attribute of the changed Overlay style select
        var key = $(this).attr('name');
        // Get selected style
        var style = $(this).val();
        // Set selected style to parameters
        mLayer[key].layer.get('source').updateParams({STYLES: 'dharan_gmis:' + style});
        // Set legend image HTML for the Overlay with selected style
        var html = '<img class="' + (mLayer[key].styles[style].clipLegend ? 'clip-legend' : '') + '" src="' + gurl_legend + 'dharan_gmis:' + key + (mLayer[key].styles[style].showCount ? '&LEGEND_OPTIONS=countMatched:TRUE': '') + '&STYLE=dharan_gmis:' + style + '" id="'+ key + '" />';
        // Set HTML to the Overlay container
        $('#' + key + '_overlay_legend_container').html(html);
    });

    // Check munipl Overlay checkbox
    showLayer('munipl');

    // Check Overlay checkbox
    function showLayer(layer) {
        var elem = $('#overlay_checkbox_container input[type=checkbox][name=' + layer + ']');
        if(!elem.is(':checked')) { // if the checkbox is not checked
            // Trigger checkbox click event
            elem.click();
        }

        // Show the Overlay Group collapsible of the Overlay
        $('#' + mLayer[layer].group + '-collapse').collapse('show');
    }

    // Uncheck Overlay checkbox
    function hideLayer(layer) {
        var elem = $('#overlay_checkbox_container input[type=checkbox][name=' + layer + ']');
        if(elem.is(':checked')) { // if the checkbox is checked
            // Trigger checkbox click event
            elem.click();
        }
    }

    // Display clustering when zoom is less than 16
    /*
    map.getView().on('change:resolution', function(){
        if(map.getView().getZoom() < 16) {
            mLayer.contain.layer.get('source').updateParams({STYLES: 'dharan_gmis:cluster_contain'});
        }
        else {
            mLayer.contain.layer.get('source').updateParams({STYLES: null});
        }
    });
    */

    // Extra Overlays Object
    var eLayer = {};

    // Add extra overlay to Extra Overlays Object
    function addExtraLayer(key, name, layer) {
        // adding as property of Extra Overlays Object
        eLayer[key] = { name: name, layer: layer };

        // Adding layer to OpenLayers Map
        map.addLayer(layer);

        /*
        // Adding HTML for the Extra Overlay checkbox
        var html = '<div class="checkbox">';
        html += '<label>';
        html += '<input type="checkbox" name="' + key + '" value="' + key + '" />';
        html += name;
        html += '</label>';
        html += '</div>';

        // Adding HTML for the Extra Overlay legend container
        html += '<div id="' + key + '_extra_overlay_legend_container">';
        html += '</div>';

        // Appending Extra Overlay checkbox HTML to container
        $('#extra_overlay_checkbox_container').append(html);
        */
    }

    // Handler for Extra Overlays checkbox change
    /*
    $('#extra_overlay_checkbox_container').on('change', 'input[type=checkbox]', function(){
        // Get name attribute of the changed Extra Overlay checkbox
        var key = $(this).attr('name');
        // HTML for the Extra Overlay legend container
        var html = '';

        if($(this).is(':checked')) { // if the Extra Overlay checkbox is checked
            // Make the Extra Overlay layer visible in map
            eLayer[key].layer.setVisible(true);
            // Set legend image HTML for the Extra Overlay
            // html = '<img src="' + gurl_legend + 'dharan_gmis:' + key + '" style="display:block;padding-left:15px;" id="'+ key + '" />';

            if(key == 'measure' && staticMeasureTooltip) {
                staticMeasureTooltip.getElement().classList.remove('hidden');
            }
        }
        else { // if the Extra Overlay checkbox is unchecked
            // Make the Extra Overlay layer invisible in map
            eLayer[key].layer.setVisible(false);

            if(key == 'measure' && staticMeasureTooltip) {
                staticMeasureTooltip.getElement().classList.add('hidden');
            }
        }

        // Set HTML to the Extra Overlay container
        $('#' + key + '_extra_overlay_legend_container').html(html);
    });
    */

    // Check Extra Overlay checkbox
    /*
    function showExtraLayer(layer) {
        var elem = $('#extra_overlay_checkbox_container input[type=checkbox][name=' + layer + ']');
        if(!elem.is(':checked')) { // if the checkbox is not checked
            // Trigger checkbox click event
            elem.click();
        }
    }
    */

    // Uncheck Extra Overlay checkbox
    /*
    function hideExtraLayer(layer) {
        var elem = $('#extra_overlay_checkbox_container input[type=checkbox][name=' + layer + ']');
        if(elem.is(':checked')) { // if the checkbox is checked
            // Trigger checkbox click event
            elem.click();
        }
    }
    */

    // Disable all controls
    function disableAllControls() {
        map.removeInteraction(draw);
        map.removeInteraction(drag);
        map.un('pointermove', pointerMoveHandler);
        map.un('pointermove', hoverOnBuildingHandler);
        map.un('pointermove', hoverOnBuildingBusinessTaxHandler);
        map.un('pointermove', hoverOnBuildingRentTaxHandler);
        map.un('pointermove', hoverOnRoadHandler);
        map.un('pointermove', hoverOnLayerHandler);
        map.getViewport().removeEventListener('mouseout', mouseOutHandler);
        createMeasureTooltip();
        createHelpTooltip();
        map.un('singleclick', displayBuildingInformation);
        map.un('singleclick', displayRoadInformation);
        map.un('singleclick', displayFeatureInformation);
        map.un('singleclick', findNearestRoad);
        map.un('singleclick', displayCoordinateInformation);
        if(eLayer.measure) {
            eLayer.measure.layer.getSource().clear();
        }
        if(eLayer.report_polygon) {
            eLayer.report_polygon.layer.getSource().clear();
        }
        if(eLayer.export_polygon) {
            eLayer.export_polygon.layer.getSource().clear();
        }
        if(eLayer.export_drawn_polygon) {
            eLayer.export_drawn_polygon.layer.getSource().clear();
        }
        map.removeOverlay(staticMeasureTooltip);
    }

    // Add handler to zoom in button click
    $('#zoomin_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        currentControl = '';
        // $('#pan_control').addClass('map-control-active');
        if(map.getView().getZoom() < map.getView().getMaxZoom()) {
            map.getView().setZoom(map.getView().getZoom() + 1);
        }
    });

    // Add handler to zoom out button click
    $('#zoomout_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        currentControl = '';
        // $('#pan_control').addClass('map-control-active');
        if(map.getView().getZoom() > map.getView().getMinZoom()) {
            map.getView().setZoom(map.getView().getZoom() - 1);
        }
    });

    // Add handler to zoom city button click
    $('#zoomfull_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        currentControl = '';
        // $('#pan_control').addClass('map-control-active');
        zoomToCity();
    });

    // Add handler to navigate button click
    $('#pan_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        currentControl = '';
        // $('#pan_control').addClass('map-control-active');
    });

    // Add handler to building info button click
    $('#buildinginfo_control').click(function(e){
        showLayer('bldg');
        showLayer('bldg_business_tax');
        showLayer('bldg_rent_tax');
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'buildinginfo_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'buildinginfo_control';
            $('#buildinginfo_control').addClass('map-control-active');
            map.on('pointermove', hoverOnBuildingHandler);
            map.on('singleclick', displayBuildingInformation);
        }
    });
    
  

// Add handler to building rent tax info button click
    $('#buildingrenttaxinfo_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'buildingrenttaxinfo_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'buildingrenttaxinfo_control';
            $('#buildingrenttaxinfo_control').addClass('map-control-active');
            map.on('pointermove', hoverOnBuildingRentTaxHandler);
            map.on('singleclick', displayBuildingRentTaxInformation);
        }
    }); 
    // Add handler to road info button click
    $('#roadinfo_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'roadinfo_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'roadinfo_control';
            $('#roadinfo_control').addClass('map-control-active');
            map.on('pointermove', hoverOnRoadHandler);
            map.on('singleclick', displayRoadInformation);
        }
    });

    // Add handler to info button click
    $('#identify_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'identify_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'identify_control';
            $('#identify_control').addClass('map-control-active');
            map.on('pointermove', hoverOnLayerHandler);
            map.on('singleclick', displayFeatureInformation);
        }
    });

    // Add handler to info button click
    $('#coordinate_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'coordinate_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'coordinate_control';
            $('#coordinate_control').addClass('map-control-active');
            map.on('singleclick', displayCoordinateInformation);
        }
    });

    // Add handler to length measure button click
    $('#linemeasure_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'linemeasure_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'linemeasure_control';
            addMeasureControl('length');
            $('#linemeasure_control').addClass('map-control-active');
        }
    });

    // Add handler to area measure button click
    $('#polymeasure_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'polymeasure_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'polymeasure_control';
            addMeasureControl('area');
            $('#polymeasure_control').addClass('map-control-active');
        }
    });

    // variable for storing draw interaction
    var draw;

    var wgs84Sphere = new ol.Sphere(6378137);

    /**
    * Currently drawn feature.
    * @type {ol.Feature}
    */
    var sketch;

    /**
    * The help tooltip element.
    * @type {Element}
    */
    var helpTooltipElement;

    /**
    * Overlay to show the help messages.
    * @type {ol.Overlay}
    */
    var helpTooltip;

    /**
    * The measure tooltip element.
    * @type {Element}
    */
    var measureTooltipElement;

    /**
    * Overlay to show the measurement.
    * @type {ol.Overlay}
    */
    var measureTooltip;

    /**
    * Overlay to show the static measurement.
    * @type {ol.Overlay}
    */
    var staticMeasureTooltip;

    /**
    * Message to show when the user is drawing a polygon.
    * @type {string}
    */
    var continuePolygonMsg = 'Click to continue drawing the polygon';

    /**
    * Message to show when the user is drawing a line.
    * @type {string}
    */
    var continueLineMsg = 'Click to continue drawing the line';

    /**
    * Handle pointer move.
    * @param {ol.MapBrowserEvent} evt The event.
    */
    var pointerMoveHandler = function(evt) {
        if (evt.dragging) {
            return;
        }
        /** @type {string} */
        var helpMsg = 'Click to start drawing';

        if (sketch) {
            var geom = (sketch.getGeometry());
            if (geom instanceof ol.geom.Polygon) {
                helpMsg = continuePolygonMsg;
            } else if (geom instanceof ol.geom.LineString) {
                helpMsg = continueLineMsg;
            }
        }

        helpTooltipElement.innerHTML = helpMsg;
        helpTooltip.setPosition(evt.coordinate);

        helpTooltipElement.classList.remove('hidden');
    };

    /**
    * Format length output.
    * @param {ol.geom.LineString} line The line.
    * @return {string} The formatted length.
    */
    var formatLength = function(line) {
        var length;
        // if (geodesicCheckbox.checked) {
        //     var coordinates = line.getCoordinates();
        //     length = 0;
        //     var sourceProj = map.getView().getProjection();
        //     for (var i = 0, ii = coordinates.length - 1; i < ii; ++i) {
        //         var c1 = ol.proj.transform(coordinates[i], sourceProj, 'EPSG:4326');
        //         var c2 = ol.proj.transform(coordinates[i + 1], sourceProj, 'EPSG:4326');
        //         length += wgs84Sphere.haversineDistance(c1, c2);
        //     }
        // } else {
        //     length = Math.round(line.getLength() * 100) / 100;
        // }

        var coordinates = line.getCoordinates();
        length = 0;
        var sourceProj = map.getView().getProjection();
        for (var i = 0, ii = coordinates.length - 1; i < ii; ++i) {
            var c1 = ol.proj.transform(coordinates[i], sourceProj, 'EPSG:4326');
            var c2 = ol.proj.transform(coordinates[i + 1], sourceProj, 'EPSG:4326');
            length += wgs84Sphere.haversineDistance(c1, c2);
        }

        var output;
        if (length > 100) {
            output = (Math.round(length / 1000 * 100) / 100) + ' ' + 'km';
        } else {
            output = (Math.round(length * 100) / 100) + ' ' + 'm';
        }
        return output;
    };

    /**
    * Format area output.
    * @param {ol.geom.Polygon} polygon The polygon.
    * @return {string} Formatted area.
    */
    var formatArea = function(polygon) {
        var area;
        // if (geodesicCheckbox.checked) {
        //     var sourceProj = map.getView().getProjection();
        //     var geom = /** @type {ol.geom.Polygon} */(polygon.clone().transform(
        //         sourceProj, 'EPSG:4326'));
        //     var coordinates = geom.getLinearRing(0).getCoordinates();
        //     area = Math.abs(wgs84Sphere.geodesicArea(coordinates));
        // }
        // else {
        //     area = polygon.getArea();
        // }

        var sourceProj = map.getView().getProjection();
        var geom = /** @type {ol.geom.Polygon} */(polygon.clone().transform(
            sourceProj, 'EPSG:4326'));
        var coordinates = geom.getLinearRing(0).getCoordinates();
        area = Math.abs(wgs84Sphere.geodesicArea(coordinates));

        var output;
        if (area > 10000) {
            output = (Math.round(area / 1000000 * 100) / 100) + ' ' + 'km<sup>2</sup>';
        }
        else {
            output = (Math.round(area * 100) / 100) + ' ' + 'm<sup>2</sup>';
        }
        return output;
    };

    var mouseOutHandler = function() {
        helpTooltipElement.classList.add('hidden');
    }

    // Add measure control to map
    function addMeasureControl(measureType) {
        var type = (measureType == 'area' ? 'Polygon' : 'LineString');

        map.on('pointermove', pointerMoveHandler);
        map.getViewport().addEventListener('mouseout', mouseOutHandler);
        if(helpTooltipElement) {
            helpTooltipElement.classList.remove('hidden');
        }

        if(!eLayer.measure) {
            var measureLayer = new ol.layer.Vector({
                // visible: false,
                source: new ol.source.Vector(),
                style: new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: 'rgba(255, 255, 255, 0.2)'
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#ffcc33',
                        width: 2
                    }),
                    image: new ol.style.Circle({
                        radius: 7,
                        fill: new ol.style.Fill({
                            color: '#ffcc33'
                        })
                    })
                })
            });

            addExtraLayer('measure', 'Measure', measureLayer);
        }

        draw = new ol.interaction.Draw({
            source: eLayer.measure.layer.getSource(),
            type: /** @type {ol.geom.GeometryType} */ (type),
            style: new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(255, 255, 255, 0.2)'
                }),
                stroke: new ol.style.Stroke({
                    color: 'rgba(0, 0, 0, 0.5)',
                    lineDash: [10, 10],
                    width: 2
                }),
                image: new ol.style.Circle({
                    radius: 5,
                    stroke: new ol.style.Stroke({
                        color: 'rgba(0, 0, 0, 0.7)'
                    }),
                    fill: new ol.style.Fill({
                        color: 'rgba(255, 255, 255, 0.2)'
                    })
                })
            })
        });
        map.addInteraction(draw);

        createMeasureTooltip();
        createHelpTooltip();

        var listener;
        draw.on('drawstart',
        function(evt) {
            eLayer.measure.layer.getSource().clear();
            map.removeOverlay(staticMeasureTooltip);

            // set sketch
            sketch = evt.feature;

            /** @type {ol.Coordinate|undefined} */
            var tooltipCoord = evt.coordinate;

            listener = sketch.getGeometry().on('change', function(evt) {
                var geom = evt.target;
                var output;
                if (geom instanceof ol.geom.Polygon) {
                    output = formatArea(geom);
                    tooltipCoord = geom.getInteriorPoint().getCoordinates();
                } else if (geom instanceof ol.geom.LineString) {
                    output = formatLength(geom);
                    tooltipCoord = geom.getLastCoordinate();
                }
                measureTooltipElement.innerHTML = output;
                measureTooltip.setPosition(tooltipCoord);
            });
        }, this);

        draw.on('drawend',
        function() {
            // showExtraLayer('measure');
            measureTooltipElement.className = 'tooltip tooltip-static';
            measureTooltip.setOffset([0, -7]);
            // copy reference of measureTooltip object to staticMeasureTooltip so that it can be referenced later
            staticMeasureTooltip = measureTooltip;
            // unset sketch
            sketch = null;
            // unset tooltip so that a new one can be created
            measureTooltipElement = null;
            createMeasureTooltip();
            ol.Observable.unByKey(listener);
        }, this);
    }

    /**
    * Creates a new help tooltip
    */
    function createHelpTooltip() {
        if (helpTooltipElement) {
            helpTooltipElement.parentNode.removeChild(helpTooltipElement);
        }
        helpTooltipElement = document.createElement('div');
        helpTooltipElement.className = 'tooltip hidden';
        helpTooltip = new ol.Overlay({
            element: helpTooltipElement,
            offset: [15, 0],
            positioning: 'center-left'
        });
        map.addOverlay(helpTooltip);
    }

    /**
    * Creates a new measure tooltip
    */
    function createMeasureTooltip() {
        if (measureTooltipElement) {
            measureTooltipElement.parentNode.removeChild(measureTooltipElement);
        }
        measureTooltipElement = document.createElement('div');
        measureTooltipElement.className = 'tooltip tooltip-measure';
        measureTooltip = new ol.Overlay({
            element: measureTooltipElement,
            offset: [0, -15],
            positioning: 'bottom-center'
        });
        map.addOverlay(measureTooltip);
    }

    // Add handler to print button click
    $('#print_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        currentControl = '';
        // $('#pan_control').addClass('map-control-active');
        printMap();
    });

    // Add handler to remove markers button click
    $('#removemarkers_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        currentControl = '';
        // $('#pan_control').addClass('map-control-active');
        $.each(eLayer, function(key, value){
            value.layer.getSource().clear();
        });
        map.removeOverlay(staticMeasureTooltip);
    });

    function printMap(){
        var body            = $('body'),
        mapContainer       = $('div#map'),
        mapContainerParent = mapContainer.parent(),

        printContainer     = $('<div>');

        body.prepend(printContainer);
        // printContainer.css('margin-left','-210px').append(mapContainer);
        printContainer.append(mapContainer);

        var content = body.children()
        .not('script')
        .not(printContainer)
        .detach();

        var script_html = '';

        script_html += printContainer.wrap('<div/>').parent().html();
        $(this).unwrap('<div/>');


        var win = window.open();
        win.document.write(script_html);
        win.document.getElementById('map-right-sidebar').remove();

        win.document.getElementsByClassName('ol-overlaycontainer-stopevent')[0].remove();

        win.document.getElementById('map').style.position = 'relative';
        win.document.getElementById('map').style.width = $('#map').width();
        win.document.getElementById('map').style.height = $('#map').height();

        win.document.getElementsByTagName('canvas')[0].style.width = 'auto';
        win.document.getElementsByTagName('canvas')[0].style.height = 'auto';

        var oldCanvas = document.getElementsByTagName('canvas')[0];
        var newCanvas = win.document.getElementsByTagName('canvas')[0];
        var context = newCanvas.getContext('2d');

        context.drawImage(oldCanvas, 0, 0);


        if((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1 )
        {
            alert('Opera');
        }
        else if(navigator.userAgent.indexOf("Chrome") != -1 )
        {
            setTimeout(function(){

                win.document.close();
                win.focus();
                win.print();
                win.close();


            }, 2000);
        }
        else if(navigator.userAgent.indexOf("Safari") != -1)
        {
            setTimeout(function(){

                win.document.close();
                win.focus();
                win.print();
                win.close();

            }, 2000);
        }
        else if(navigator.userAgent.indexOf("Firefox") != -1 )
        {
            win.close();
        }
        else{
            setTimeout(function(){

                win.document.close();
                win.focus();
                win.print();
                win.close();
                //win.close();
                //return true;
            }, 6000);
        }



        body.prepend(content);
        mapContainerParent.prepend(mapContainer);
        printContainer.remove();



    }

    // Add handler to nearest road button click
    $('#nearestroad_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'nearestroad_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'nearestroad_control';
            $('#nearestroad_control').addClass('map-control-active');
            map.on('singleclick', findNearestRoad);
        }
    });

    // Add handler to due buildings button click
    $('#duebuildings_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        currentControl = '';
        // $('#pan_control').addClass('map-control-active');
        displayDueBuildings();
    });

    /**
    * Elements that make up the popup for report.
    */
    var containers = document.getElementById('popup-tab');
    var containerPopupCloser = document.getElementById('container-popup-closer');


    /**
    * Create an overlay to anchor the popup to the map.
    */
    var Overlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
        element: containers,
        autoPan: true,
        autoPanAnimation: {
            duration: 250
        }
    }));
    

 
    $(containers).show();

    map.addOverlay(Overlay);
    containerPopupCloser.onclick = function() {
        Overlay.setPosition(undefined);
        containerPopupCloser.blur();
        return false;
    };

      /**
    * Elements that make up the popup for report.
    */
    var reportPopupContainer = document.getElementById('report-popup');
    var reportPopupContent = document.getElementById('report-popup-content');
    var reportPopupCloser = document.getElementById('report-popup-closer');


    /**
    * Create an overlay to anchor the popup to the map.
    */
    var reportPopupOverlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
        element: reportPopupContainer,
        autoPan: true,
        autoPanAnimation: {
            duration: 250
        }
    }));

    $(reportPopupContainer).show();

    map.addOverlay(reportPopupOverlay);
    /**
    * Add a click handler to hide the popup for report.
    * @return {boolean} Don't follow the href.
    */
    reportPopupCloser.onclick = function() {
        reportPopupOverlay.setPosition(undefined);
        reportPopupCloser.blur();
        return false;
    };

    var drag;

    /**
       * @constructor
       */
      var Drag = function() {

        ol.interaction.Pointer.call(this, {
          handleDownEvent: Drag.prototype.handleDownEvent,
          handleDragEvent: Drag.prototype.handleDragEvent,
          handleMoveEvent: Drag.prototype.handleMoveEvent,
          handleUpEvent: Drag.prototype.handleUpEvent
        });

        /**
         * @type {ol.Pixel}
         * @private
         */
        this.coordinate_ = null;

        /**
         * @type {string|undefined}
         * @private
         */
        this.cursor_ = 'pointer';

        /**
         * @type {ol.Feature}
         * @private
         */
        this.feature_ = null;

        /**
         * @type {string|undefined}
         * @private
         */
        this.previousCursor_ = undefined;

        this.layer = '';

        this.dragged_ = false;

      };
      ol.inherits(Drag, ol.interaction.Pointer);


      /**
       * @param {ol.MapBrowserEvent} evt Map browser event.
       * @return {boolean} `true` to start the drag sequence.
       */
      Drag.prototype.handleDownEvent = function(evt) {
        var map = evt.map;
        var layer = this.layer;

        var feature = map.forEachFeatureAtPixel(evt.pixel,
            function(feature) {
                if(eLayer[layer] && eLayer[layer].layer.getSource().getFeatures().indexOf(feature) != -1) {
                  return feature;
                }
            });

        if (feature) {
          this.coordinate_ = evt.coordinate;
          this.feature_ = feature;
        }

        return !!feature;
      };


      /**
       * @param {ol.MapBrowserEvent} evt Map browser event.
       */
      Drag.prototype.handleDragEvent = function(evt) {
        if(this.layer == 'export_polygon') {
            $('#export-popup-closer').click();
        }

        this.dragged_ = true;

        var deltaX = evt.coordinate[0] - this.coordinate_[0];
        var deltaY = evt.coordinate[1] - this.coordinate_[1];

        var geometry = /** @type {ol.geom.SimpleGeometry} */
            (this.feature_.getGeometry());
        geometry.translate(deltaX, deltaY);

        this.coordinate_[0] = evt.coordinate[0];
        this.coordinate_[1] = evt.coordinate[1];
      };


      /**
       * @param {ol.MapBrowserEvent} evt Event.
       */
      Drag.prototype.handleMoveEvent = function(evt) {
        if (this.cursor_) {
          var map = evt.map;
          var layer = this.layer;

          var feature = map.forEachFeatureAtPixel(evt.pixel,
              function(feature) {
                if(eLayer[layer] && eLayer[layer].layer.getSource().getFeatures().indexOf(feature) != -1) {
                  return feature;
                }
              });
          var element = evt.map.getTargetElement();
          if (feature) {
            if (element.style.cursor != this.cursor_) {
              this.previousCursor_ = element.style.cursor;
              element.style.cursor = this.cursor_;
            }
          } else if (this.previousCursor_ !== undefined) {
            element.style.cursor = this.previousCursor_;
            this.previousCursor_ = undefined;
          }
        }
      };


      /**
       * @return {boolean} `false` to stop the drag sequence.
       */
      Drag.prototype.handleUpEvent = function() {
        if(this.dragged_) {
            if(this.layer == 'export_polygon') {
                displayExportPopup(this.feature_.getGeometry());
            }
            this.dragged_ = false;
        }

        this.coordinate_ = null;
        this.feature_ = null;
        return false;
      };

    // Add handler to report information tool button click
    $('#report_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'report_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'report_control';
            $('#report_control').addClass('map-control-active');

            if(!eLayer.report_polygon) {
                var reportPolygonLayer = new ol.layer.Vector({
                    // visible: false,
                    source: new ol.source.Vector()
                });

                addExtraLayer('report_polygon', 'Report Polygon', reportPolygonLayer);
            }

            // map.removeInteraction(draw);
            draw = new ol.interaction.Draw({
                source: eLayer.report_polygon.layer.getSource(),
                type: 'Polygon'
            });

            draw.on('drawstart', function(evt){
                eLayer.report_polygon.layer.getSource().clear();
                reportPopupOverlay.setPosition(undefined);
            });
            draw.on('drawend', function(evt){
                // showExtraLayer('report_polygon');
                var format = new ol.format.WKT();
                var geom = format.writeGeometry(evt.feature.getGeometry().clone().transform('EPSG:3857', 'EPSG:4326'));

                displayAjaxLoader();
                var url = '{{ url("getPolygonReport") }}';
                $.ajax({
                    url:url,
                    type: 'post',
                    data: { geom: geom },
                    success: function(data){
                        removeAjaxLoader();
                        reportPopupContent.innerHTML = data;
                        reportPopupOverlay.setPosition(evt.feature.getGeometry().getInteriorPoint().getCoordinates());
                    },
                    error: function(data) {
                        displayAjaxError();
                    }
                });
            });

            map.addInteraction(draw);
        }
    });

    // Handler for building structype checkbox change
    $('#building_structype_checkbox_container').on('change', 'input[type=checkbox]', function(){
        var checkedList = [];
        $('#building_structype_checkbox_container input[type=checkbox]').each(function(){
            if($(this).is(':checked')) {
                checkedList.push("structype = '" + $(this).attr('name') + "'");
            }
        });

        if(checkedList.length > 0) {
            mFilter.building_structype = '(' + checkedList.join(' OR ') + ')';
        }
        else {
            mFilter.building_structype = '';
        }

        updateAllCQLFiltersParams();
        showLayer('building');
    });

    // Handler for informal settlements toilet checkbox change
    $('#settarea_setttoilet_checkbox_container').on('change', 'input[type=checkbox]', function(){
        var checkedList = [];
        $('#settarea_setttoilet_checkbox_container input[type=checkbox]').each(function(){
            if($(this).is(':checked')) {
                checkedList.push("setttoilet = '" + $(this).attr('name') + "'");
            }
        });

        if(checkedList.length > 0) {
            mFilter.settarea_setttoilet = '(' + checkedList.join(' OR ') + ')';
        }
        else {
            mFilter.settarea_setttoilet = '';
        }

        updateAllCQLFiltersParams();
        showLayer('settarea');
    });

    /**
    * Elements that make up the popup for export.
    */
    var exportPopupContainer = document.getElementById('export-popup');
    var exportPopupContent = document.getElementById('export-popup-content');
    var exportPopupCloser = document.getElementById('export-popup-closer');

    /**
    * Create an overlay to anchor the popup to the map.
    */
    var exportPopupOverlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
        element: exportPopupContainer,
        autoPan: true,
        autoPanAnimation: {
            duration: 250
        }
    }));

    $(exportPopupContainer).show();

    map.addOverlay(exportPopupOverlay);

    /**
    * Add a click handler to hide the popup for export.
    * @return {boolean} Don't follow the href.
    */
    exportPopupCloser.onclick = function() {
        exportPopupOverlay.setPosition(undefined);
        exportPopupCloser.blur();
        return false;
    };


       /**
    * Elements that make up the popup for export.
    */
    var exportAreaPopupContainer = document.getElementById('expor-area-popup');
    var exportAreaPopupContent = document.getElementById('export-area-popup-content');
    var exportPopupCloser = document.getElementById('export-area-popup-closer');

    /**
    * Create an overlay to anchor the popup to the map.
    */
    var exportAreaPopupOverlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
        element: exportAreaPopupContainer,
        autoPan: true,
        autoPanAnimation: {
            duration: 250
        }
    }));

    $(exportAreaPopupContainer).show();

    map.addOverlay(exportAreaPopupOverlay);

    /**
    * Add a click handler to hide the popup for export.
    * @return {boolean} Don't follow the href.
    */
    exportPopupCloser.onclick = function() {
        exportAreaPopupOverlay.setPosition(undefined);
        exportPopupCloser.blur();
        return false;
    };


    // Add handler to report information tool button click
    $('#export_control').click(function(e){
        e.preventDefault();
        disableAllControls();
        $('.map-control').removeClass('map-control-active');
        if(currentControl == 'export_control') {
            currentControl = '';
            // $('#pan_control').addClass('map-control-active');
        }
        else {
            currentControl = 'export_control';
            $('#export_control').addClass('map-control-active');

            if(!eLayer.export_polygon) {
                var exportPolygonLayer = new ol.layer.Vector({
                    // visible: false,
                    source: new ol.source.Vector()
                });

                addExtraLayer('export_polygon', 'Export Polygon', exportPolygonLayer);
            }

            // map.removeInteraction(draw);
            draw = new ol.interaction.Draw({
                source: eLayer.export_polygon.layer.getSource(),
                type: 'Polygon'
            });

            draw.on('drawstart', function(evt){
                eLayer.export_polygon.layer.getSource().clear();
                exportPopupOverlay.setPosition(undefined);
            });
            draw.on('drawend', function(evt){
                displayExportPopup(evt.feature.getGeometry());
            });

            map.addInteraction(draw);
            drag = new Drag();
            drag.layer = 'export_polygon';
            map.addInteraction(drag);
        }
    });


    function displayExportPopup(geometry) {
        // showExtraLayer('export_polygon');
        var format = new ol.format.WKT();
        var geom = format.writeGeometry(geometry.clone().transform('EPSG:3857', 'EPSG:4326'));

        var layers = [];
        $.each(mLayer, function(key, value) {
            // if(value.layer.getVisible()) {
                layers.push('dharan_gmis:' + key);
            // }
        });

        var exportLink = gurl_wfs + '?request=GetFeature&service=WFS&version=1.0.0&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=' + layers.join(',') + '&CQL_FILTER=WITHIN(geom, ' + geom + ')&outputFormat=';

        var html = '';
        html += '<div>Export to:</div>'
        html += '<div class="btn-group">'
        html += '<a href="' + exportLink + 'JSON" target="_blank" class="btn btn-default">JSON</a>';
        html += '<a href="' + exportLink + 'KML" target="_blank" class="btn btn-default">KML</a>';
        html += '<a href="' + exportLink + 'SHAPE-ZIP" target="_blank" class="btn btn-default">Shape File</a>';
        html += '</div>';
        exportPopupContent.innerHTML = html;
        exportPopupOverlay.setPosition(geometry.getInteriorPoint().getCoordinates());
    }


    $('#export_control_2').click(function(e) {
    e.preventDefault();
    disableAllControls();
    $('.map-control').removeClass('map-control-active');
    if (currentControl == 'export_control_2') {
        currentControl = '';
    } else {
        currentControl = 'export_control_2';
        $('#export_control_2').addClass('map-control-active');

        if (!eLayer.expor_drawn_polygon) {
            var exportDrawnPolygonLayer = new ol.layer.Vector({
                source: new ol.source.Vector()
            });
            addExtraLayer('export_drawn_polygon', 'Export Drawn Polygon', exportDrawnPolygonLayer);
        }

        draw = new ol.interaction.Draw({
            source: eLayer.export_drawn_polygon.layer.getSource(),
            type: 'Polygon'
        });

        draw.on('drawstart', function(evt) {
            eLayer.export_drawn_polygon.layer.getSource().clear();
            popup.setPosition(undefined);
        });

        draw.on('drawend', function(evt) {
            var format = new ol.format.WKT();
    var geom = format.writeGeometry(evt.feature.getGeometry().clone().transform('EPSG:3857', 'EPSG:4326'));
    document.getElementById('geom').value = geom;
    popup.setPosition(evt.feature.getGeometry().getLastCoordinate());
    
            });
                    
   

        map.addInteraction(draw);
    }
});


    if(layer != '' && field != '' && val != ''){
        handleZoomToExtent(layer, field, val, true, null);

        if(layer == 'contain') {
            if(action == 'containment-buildings') {
                displayContainmentBuildings(field, val);
            }
            else if(action == 'containment-road') {
                displayContainmentRoad(field, val);
            }
        }
    }

    // Set map zoom to city
    zoomToCity();

    // Set map zoom to city
    function zoomToCity() {
        map.getView().setCenter(ol.proj.transform([87.2610, 26.7828], 'EPSG:4326', 'EPSG:3857'));
        map.getView().setZoom(12);
    }

    var hoverOnBuildingHandler = function(evt) {
        if (evt.dragging) {
            return;
        }
        var pixel = map.getEventPixel(evt.originalEvent);
        var hit = map.forEachLayerAtPixel(pixel, function(layer) {
            if(layer.get('name') == 'bldg') {
                return true;
            }
        });
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    };
    
    var hoverOnBuildingBusinessTaxHandler = function(evt) {
        if (evt.dragging) {
            return;
        }
        var pixel = map.getEventPixel(evt.originalEvent);
        var hit = map.forEachLayerAtPixel(pixel, function(layer) {
            if(layer.get('name') == 'bldg_business_tax') {
                return true;
            }
        });
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    }; 
    
    var hoverOnBuildingRentTaxHandler = function(evt) {
        if (evt.dragging) {
            return;
        }
        var pixel = map.getEventPixel(evt.originalEvent);
        var hit = map.forEachLayerAtPixel(pixel, function(layer) {
            if(layer.get('name') == 'bldg_rent_tax') {
                return true;
            }
        });
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    }; 


    function addTabIfDataExists(id, title, data) {
    // Check if tab with same ID already exists
    if ($('#popup-tab').find('#' + id).length) {
      // Tab already exists, do not append
      return;
    }

    // Create new tab
    var tab = '<li role="presentation"><a href="#' + id + '" aria-controls="analysis" role="tab" data-toggle="tab">' + title + '</a></li>';
    $('#popup-tab .nav-tabs').append(tab);

    // Create new tab content
    var tabContent = '<div role="tabpanel" class="tab-pane" id="' + id + '">' + data + '</div>';
    $('#popup-tab .tab-content').append(tabContent);
  }
                                  
    // Display information about building
    function displayBuildingInformation(evt) {
       
        var coordinate = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
        var long = coordinate[0];
        var lat = coordinate[1];

        $('#lat').val( lat);
        $('#long').val(long);
     

        // $('#map-right-sidebar #building-tab').html("");

                        if(eLayer.selected_buildings) {
                            eLayer.selected_buildings.layer.getSource().clear();
                        }
                        else {
                            var layer = new ol.layer.Vector({
                                // visible: false,
                                source: new ol.source.Vector()
                            });

                            addExtraLayer('selected_buildings', 'Selected Buildings', layer);
                        }

        // showExtraLayer('selected_buildings');

        displayAjaxLoader();
        var url = '{{ url("getBuildingInformation") }}' +  '/' + long + '/' + lat;
        
        $.ajax({
            url: url,
            type: 'get',
            success: function(data)
          
            {
                              var bin  = data.data1[0].bin;
                              $('#bin').val(bin);

                            if(data != null) {
                               
                              
                                    var format = new ol.format.WKT();
                                    var html = '';
                                    var htmlbusiness = '';
                                    var htmlrent ='';
                                    var buildingStyle = new ol.style.Style({
                                        stroke: new ol.style.Stroke({
                                            color: '#ffff00',
                                            width: 3
                                        }),
                                    });
                                    var buildingFeature = format.readFeature(data.data1[0].geom, {
                                        dataProjection: 'EPSG:4326',
                                        featureProjection: 'EPSG:3857'
                                    });
                                
                                    buildingFeature.setStyle(buildingStyle);
                                    eLayer.selected_buildings.layer.getSource().addFeature(buildingFeature);

                                    var buildingGeom = buildingFeature.getGeometry();
                                  
                                        var buildingCenter = ol.extent.getCenter(buildingGeom.getExtent());

                                        Overlay.setPosition(buildingCenter);

            
                                        if( data.data1[0]){
                                        html += '<table class="table table-bordered table-striped">';
                                        html += '<thead>'
                                        html += '<tr>';
                                        html += '<th>BIN</th>';
                                        html += '<th>House Owner</th>';
                                        html += '<th>Metric Address</th>';
                                        html += '<th>Street</th>';
                                        html += '<th>Ward</th>';
                                        html += '<th>Year of Construction</th>';
                                        html += '<th>Construction Type</th>';
                                        html += '<th>Building Use</th>';
                                        html += '<th>Tax Status</th>';
                                        html +='</tr>'
                                        html += '</thead>'
                                        html += '<tbody>'
                                        html += '<tr>'
                                        html += '<td>' + data.data1[0].bin + '</td>';
                                        html += '<td>' + data.data1[0].hownr + '</td>';
                                        html += '<td>' + data.data1[0].haddr + '</td>';
                                        html += '<td>' + data.data1[0].street + '</td>';
                                        html += '<td>' + data.data1[0].ward + '</td>';
                                        html += '<td>' + data.data1[0].yoc + '</td>';
                                        html += '<td>' + data.data1[0].construction_type + '</td>';
                                        html += '<td>' + data.data1[0].building_use + '</td>';
                                        html += '<td>' + data.data1[0].tax_status + '</td>';
                                        html += '</tr>';
                                        html += '</tbody>'
                                        html += '</table>';
                                        
                                        
                                        html += '<div>';
                                        if(data.data1[0].photo_path){
                                            html += '<div style="display: flex; justify-content: center; align-items: center;">';
                                            html += '<img src="' + data.data1[0].photo_path + '" style="height:250px;" />';
                                            html += '</div>';

                                        }
                                        else {
                                            html += '<div style="text-align: center;">';
                                            html += 'No Photo Available';
                                            html += '</div>';
                                        }
                                        html += '</div>';
                                        
                                        addTabIfDataExists('building_', 'Building Details', html);
                                   
                                        $('#popup-tab  #building_').html(html);

                                    }
                                    
                                  if(data.data2 != ''){
                                    
                                    var buildingStyle_business = new ol.style.Style({
                                        image: new ol.style.Icon({
                                            anchor: [0.55, 1],
                                            src: '{{ url("/")}}/img/marker-green.png'
                                        })
                                                
                                  
                                    });
                                    var buildingFeature_business = format.readFeature(data.data2[0].geom, {
                                        dataProjection: 'EPSG:4326',
                                        featureProjection: 'EPSG:3857'
                                    });
                                    
                                    buildingFeature_business.setStyle(buildingStyle_business);
                                    eLayer.selected_buildings.layer.getSource().addFeature(buildingFeature_business);
                                   
                            htmlbusiness += '<table class="table table-bordered table-striped">';
                            htmlbusiness += '<thead>';
                            htmlbusiness += '<tr>';
                            htmlbusiness += '<th>SN</th>';
                            htmlbusiness += '<th>Business Name</th>';
                            htmlbusiness += '<th>Road Name</th>';
                            htmlbusiness += '<th>House Number</th>';
                            htmlbusiness += '<th>Owner Phone</th>';
                            htmlbusiness += '<th>House Owner Email</th>';
                            htmlbusiness += '<th>Business Owner</th>';
                            htmlbusiness += '<th>Business Type</th>';
                            htmlbusiness += '<th>Category</th>';
                            htmlbusiness += '<th>Business Operation Date</th>';
                            htmlbusiness += '<th>Business Registration</th>';
                            htmlbusiness += '<th>Tax Last Date</th>';
                            htmlbusiness += '<th>Business Owner Mobile</th>';
                            htmlbusiness += '<th>Email</th>';
                            htmlbusiness += '<th>Remarks</th>';
                            htmlbusiness += '</tr>';
                            htmlbusiness += '</thead>';
                            htmlbusiness += '<tbody>';
                            
                                        for(var i = 0; i < data.data2.length; i++) {
                                            htmlbusiness += '<tr>';
                            htmlbusiness += '<td>' + (i+1) + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].businessname + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].roadname + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].houseno + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].ownerphone + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].houseownermail + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].businesowner + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].businesstype + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].category + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].businessoprdate + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].registration + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].taxlastdate + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].businessownermobile + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].email + '</td>';
                            htmlbusiness += '<td>' + data.data2[i].remarks + '</td>';
                            htmlbusiness += '</tr>';
                             }
                             
                            htmlbusiness += '</tbody>';
                            htmlbusiness += '</table>';
                        
                            addTabIfDataExists('building-business-tax_', 'Business Details', htmlbusiness);
                                    } 
                            if(data.data2 == ''){
                                $('#popup-tab .nav-tabs a[href="#building-business-tax_"]').parent().remove();
                                 $('#popup-tab #building-business-tax_').remove();

                            }

                            if(data.data3 !=''){

                                var buildingStyle_rent = new ol.style.Style({
                                    image: new ol.style.Icon({
                                            anchor: [0.55, 1],
                                            src: '{{ url("/")}}/img/marker.png'
                                        })
                                    });
                                    var buildingFeature_rent = format.readFeature(data.data3[0].geom, {
                                        dataProjection: 'EPSG:4326',
                                        featureProjection: 'EPSG:3857'
                                    });
                                    
                                    buildingFeature_rent.setStyle(buildingStyle_rent);
                                    eLayer.selected_buildings.layer.getSource().addFeature(buildingFeature_rent);

                            htmlrent += '<table class="table table-bordered table-striped">';
                            htmlrent += '<thead>';
                            htmlrent += '<tr>';
                            htmlrent += '<th>SN</th>';
                            htmlrent += '<th>Road Name</th>';
                            htmlrent += '<th>House Numner</th>';
                            htmlrent += '<th>House Owner Number</th>';
                            htmlrent += '<th>House Owner Email</th>';
                            htmlrent += '<th>House Type</th>';
                            htmlrent += '<th>Length</th>';
                            htmlrent += '<th>Width</th>';
                            htmlrent += '<th>Area</th>';
                            htmlrent += '<th>Renter Name</th>';
                            htmlrent += '<th>Rent Purpose</th>';
                            htmlrent += '<th>Rent Start</th>';
                            htmlrent += '<th>MOnthly Rent</th>';
                            htmlrent += '<th>Rent Responsible</th>';
                            htmlrent += '<th>Rent Increase Per Year</th>';
                            htmlrent += '<th>Rent Mobile Number</th>';
                            htmlrent += '<th>Remarks</th>';
                            htmlrent += '<tr>';
                            htmlrent += '</thead>';
                            htmlrent += '<tbody>';
                            
                            for(var i = 0; i < data.data3.length; i++) {
                            
                            htmlrent += '<tr>';
                            htmlrent += '<td>' + (i+1) + '</td>';
                            htmlrent += '<td>' + data.data3[i].roadname + '</td>';
                            htmlrent += '<td>' + data.data3[i].houseno + '</td>';
                            htmlrent += '<td>' + data.data3[i].hownernumber + '</td>';
                            htmlrent += '<td>' + data.data3[i].howneremail + '</td>';
                            htmlrent += '<td>' + data.data3[i].housetype + '</td>';
                            htmlrent += '<td>' + data.data3[i].length + '</td>';
                            htmlrent += '<td>' + data.data3[i].width + '</td>';
                            htmlrent += '<td>' + data.data3[i].area + '</td>';
                            htmlrent += '<td>' + data.data3[i].rentername + '</td>';
                            htmlrent += '<td>' + data.data3[i].rentpurpose + '</td>';
                            htmlrent += '<td>' + data.data3[i].rentstart + '</td>';
                            htmlrent += '<td>' + data.data3[i].monthlyrent + '</td>';
                            htmlrent += '<td>' + data.data3[i].rentaxresponsible + '</td>';
                            htmlrent += '<td>' + data.data3[i].rentincreseperyear + '</td>';
                            htmlrent += '<td>' + data.data3[i].rentmobilenumber + '</td>';
                            htmlrent += '<td>' + data.data3[i].remarks + '</td>';
                            htmlrent += '</tr>';
                        }
                             
                             htmlrent += '</tbody>';
                             htmlrent += '</table>';

                             addTabIfDataExists('building-rent-tax_', 'Rent Details', htmlrent);
                           
                            }
                            if(data.data3 == ''){
                               
                                $('#popup-tab .nav-tabs a[href="#building-rent-tax_"]').parent().remove();
                                 $('#popup-tab #building-rent-tax_').remove();

                            }
                          

                        $('#popup-tab  #building_').html(html);
                        $('#popup-tab  #building-business-tax_').html(htmlbusiness);
                        $('#popup-tab #building-rent-tax_').html(htmlrent);
                        $('#popup-tab .nav-tabs a').on('click', function (e) {
                            e.preventDefault();
                            
                            $(this).tab('show');
                           
                            });
                            
                            $('#popup-tab .nav-tabs a:first').click();

                               removeAjaxLoader();
                                    
                                }
                                else {
                                    displayAjaxErrorModal('Building Not Found');
                                }
                },
                error: function(data) {
                displayAjaxError();
            }
        });

    } 


    
    var hoverOnRoadHandler = function(evt) {
        if (evt.dragging) {
            return;
        }
        var pixel = map.getEventPixel(evt.originalEvent);
        var hit = map.forEachLayerAtPixel(pixel, function(layer) {
            if(layer.get('name') == 'road') {
                return true;
            }
        });
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    };

    // Display information about road
    /*
    function displayRoadInformation(evt) {
        var coordinate = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
        var long = coordinate[0];
        var lat = coordinate[1];

        $('#map-right-sidebar #road-tab').html("");

        if(eLayer.selected_roads) {
            eLayer.selected_roads.layer.getSource().clear();
        }
        else {
            var layer = new ol.layer.Vector({
                // visible: false,
                source: new ol.source.Vector()
            });

            addExtraLayer('selected_roads', 'Selected Roads', layer);
        }

        // showExtraLayer('selected_roads');

        displayAjaxLoader();
        var url = '{{ url("getRoadInformation") }}' + '/' + long + '/' + lat;
        $.ajax({
            url: url,
            type: 'get',
            success: function(data){
                if(data && Array.isArray(data)) {
                    if(data.length > 0) {
                        var format = new ol.format.WKT();
                        var html = '';

                        var roadStyle = new ol.style.Style({
                            stroke: new ol.style.Stroke({
                                color: '#ffff00',
                                width: 3
                            }),
                        });

                        for(var i = 0; i < data.length; i++) {
                            html += '<table class="table">';
                            html += '<tr>';
                            html += '<th>ID</th>';
                            html += '<td>' + data[i].id + '</td>';
                            html += '</tr>';
                            // html += '<tr>';
                            // html += '<th>House Owner</th>';
                            // html += '<td>' + data[i].hownr + '</td>';
                            // html += '</tr>';
                            // html += '<tr>';
                            // html += '<th>Ward</th>';
                            // html += '<td>' + data[i].ward + '</td>';
                            // html += '</tr>';
                            // html += '<tr>';
                            // html += '<th>Year of Construction</th>';
                            // html += '<td>' + data[i].yoc + '</td>';
                            // html += '</tr>';
                            // html += '<tr>';
                            // html += '<th>Construction Type</th>';
                            // html += '<td>' + data[i].construction_type + '</td>';
                            // html += '</tr>';
                            // html += '<tr>';
                            // html += '<th>Building Use</th>';
                            // html += '<td>' + data[i].building_use + '</td>';
                            // html += '</tr>';
                            // html += '<tr>';
                            // html += '<th>Tax Status</th>';
                            // html += '<td>' + data[i].btxsts + '</td>';
                            // html += '</tr>';
                            // html += '<tr>';
                            // html += '<td colspan="2">';
                            // html += '<img src="' + data[i].photo_path + '" style="max-width:100%;" />';
                            // html += '</td>';
                            // html += '</tr>';
                            html += '</table>';

                            var roadFeature = format.readFeature(data[i].geom, {
                                dataProjection: 'EPSG:4326',
                                featureProjection: 'EPSG:3857'
                            });

                            roadFeature.setStyle(roadStyle);

                            eLayer.selected_roads.layer.getSource().addFeature(roadFeature);
                        }

                        $('#map-right-sidebar #road-tab').html(html);
                        $('#map-right-sidebar .nav-tabs a[href="#road-tab"]').tab('show');
                        $('#map-right-sidebar .nav-tabs').scrollingTabs('scrollToActiveTab');

                        removeAjaxLoader();
                    }
                    else {
                        displayAjaxErrorModal('Road Not Found');
                    }
                }
            },
            error: function(data) {
                displayAjaxError();
            }
        });
    }
    */

    function displayRoadInformation(evt) {
        $('#map-right-sidebar #road-tab').html("");

        if(eLayer.selected_roads) {
            eLayer.selected_roads.layer.getSource().clear();
        }
        else {
            var layer = new ol.layer.Vector({
                // visible: false,
                source: new ol.source.Vector(),
                style: new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: '#ffff00',
                        width: 3
                    }),
                })
            });

            addExtraLayer('selected_roads', 'Selected Roads', layer);
        }

        // showExtraLayer('selected_roads');

        var viewResolution = /** @type {number} */ (map.getView().getResolution());

        var wmsSource = new ol.source.TileWMS({
            url: gurl_wms,
            params: {
                'LAYERS': 'dharan_gmis:view_road',
                'FEATURE_COUNT': 10
            }
        });

        var url = wmsSource.getGetFeatureInfoUrl(
            evt.coordinate, viewResolution, 'EPSG:3857',
            {'INFO_FORMAT': 'application/json'});
        if(!url) {
            alert('Failed to generate URL');
            return;
        }

        displayAjaxLoader();

        $.ajax({
            url: url,
            type: 'get',
            success: function(data){
                
                if(data && data.features && Array.isArray(data.features)) {
                    if(data.features.length > 0) {
                        eLayer.selected_roads.layer.getSource().addFeatures((new ol.format.GeoJSON()).readFeatures(data));

                        var html = '';
                        for(var i = 0; i < data.features.length; i++) {
                            html += '<table class="table">';
                            html += '<tr>';
                            html += '<th>ID</th>';
                            html += '<td>' + data.features[i].properties.id + '</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>Street Code</th>';
                            html += '<td>' + data.features[i].properties.strtcd + '</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>Street Name</th>';
                            html += '<td>' + data.features[i].properties.strtnm + '</td>';
                            html += '</tr>';
                            html += '<th>Road Length</th>';
                            html += '<td>' + data.features[i].properties.rdlen + '</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>Road Width</th>';
                            html += '<td>' + data.features[i].properties.rdwidth + '</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>Road Hierarchy</th>';
                            html += '<td>' + data.features[i].properties.rdhier_name + '</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>Road Surface</th>';
                            html += '<td>' + data.features[i].properties.rdsurf_name + '</td>';
                            html += '</tr>';
                            html += '</table>';
                        }

                        $('#map-right-sidebar #road-tab').html(html);
                        $('#map-right-sidebar .nav-tabs a[href="#road-tab"]').tab('show');
                        $('#map-right-sidebar .nav-tabs').scrollingTabs('scrollToActiveTab');

                        removeAjaxLoader();
                    }
                    else {
                        displayAjaxErrorModal('Road Not Found');
                    }
                }
            },
            error: function(data) {
                displayAjaxError();
            }
        });
    }

    var hoverOnLayerHandler = function(evt) {
        if (evt.dragging) {
            return;
        }
        var pixel = map.getEventPixel(evt.originalEvent);
        var hit = map.forEachLayerAtPixel(pixel, function() {
            return true;
        });
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    };

    // Display information about feature
    function displayFeatureInformation(evt) {
        $('#featureinfo-collapse .panel-body').html('');
        var viewResolution = /** @type {number} */ (map.getView().getResolution());
        var layers = [];
        $.each(mLayer, function(key, value) {
            if(value.layer.getVisible()) {
                layers.push('dharan_gmis:' + key);
            }
        });

        if(layers.length > 0) {
            var wmsSource = new ol.source.TileWMS({
                url: gurl_wms,
                params: {
                    'LAYERS': layers.join(','),
                    'FEATURE_COUNT': 10
                }
            });

            var url = wmsSource.getGetFeatureInfoUrl(
                evt.coordinate, viewResolution, 'EPSG:3857',
                {'INFO_FORMAT': 'text/html'});
            if (url) {
              $('#featureinfo-collapse .panel-body').html('<iframe seamless src="' + url + '"></iframe>');
            }
        }

        $('#featureinfo-collapse').collapse('show');
        $(".mini-submenu-bottom-left").click();
    }

    var popupAreaCloser = document.getElementById('export-area-popup-closer');
    // Create the popup
var popup = new ol.Overlay({
  element: document.getElementById('export-area-popup'),
  autoPan: true,
  autoPanAnimation: {
    duration: 250
  }
});
// Add the popup to the map
map.addOverlay(popup);

popupAreaCloser.onclick = function() {
        popup.setPosition(undefined);
        popupCloser.blur();
        return false;
    };


    /**
    * Elements that make up the popup.
    */
    var popupContainer = document.getElementById('popup');
    var popupContent = document.getElementById('popup-content');
    var popupCloser = document.getElementById('popup-closer');


    /**
    * Create an overlay to anchor the popup to the map.
    */
    var popupOverlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
        element: popupContainer,
        autoPan: true,
        autoPanAnimation: {
            duration: 250
        }
    }));

    $(popupContainer).show();

    map.addOverlay(popupOverlay);

    /**
    * Add a click handler to hide the popup.
    * @return {boolean} Don't follow the href.
    */
    popupCloser.onclick = function() {
        popupOverlay.setPosition(undefined);
        popupCloser.blur();
        return false;
    };

    // Display information about coordinate
    function displayCoordinateInformation(evt) {
        var coordinate = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');

        var html = '<div style="text-decoration:underline;">EPSG:3587</div>';
        html += '<table style="margin-bottom: 10px;">';
        html += '<tr>';
        html += '<td style="padding-right:5px;">Longitude</td>';
        html += '<td>' + evt.coordinate[0] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td style="padding-right:5px;">Latitude</td>';
        html += '<td>' + evt.coordinate[1] + '</td>';
        html += '</tr>';
        html += '<table>';
        html += '<div style="text-decoration:underline;">EPSG:4326</div>';
        html += '<table>';
        html += '<tr>';
        html += '<td style="padding-right:5px;">Longitude</td>';
        html += '<td>' + coordinate[0] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td style="padding-right:5px;">Latitude</td>';
        html += '<td>' + coordinate[1] + '</td>';
        html += '</tr>';
        html += '<table>';

        popupContent.innerHTML = html;
        popupOverlay.setPosition(evt.coordinate);
    }


 


    function displayContainmentBuildings(field, val) {
        var url = '{{ url("getContainmentBuildings") }}' + '/' + field + '/' + val;
        $.ajax({
            url: url,
            type: 'get',
            success: function(data){
                for(var i = 0; i < data.length; i++) {
                    if(data[i].lat && data[i].long) {
                        if(!eLayer.markers) {
                            var markerLayer = new ol.layer.Vector({
                                // visible: false,
                                source: new ol.source.Vector()
                            });

                            addExtraLayer('markers', 'Markers', markerLayer);
                            // showExtraLayer('markers');
                        }

                        var feature = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(data[i].long), parseFloat(data[i].lat)], 'EPSG:4326', 'EPSG:3857'))
                        });

                        var style = new ol.style.Style({
                            image: new ol.style.Icon({
                                anchor: [0.5, 1],
                                src: '{{ url("/")}}/img/building-purple.png'
                            })
                        });

                        feature.setStyle(style);

                        eLayer.markers.layer.getSource().addFeature(feature);
                    }
                }

                showLayer('building');
            },
            error: function(data) {

            }
        });
    }

    function displayContainmentRoad(field, val) {
        var url = '{{ url("getContainmentRoad") }}' + '/' + field + '/' + val;
        $.ajax({
            url: url,
            type: get,
            success: function(data){
                if(data.c_lat && data.c_long && data.r_lat && data.r_long) {
                    if(!eLayer.markers) {
                        var markerLayer = new ol.layer.Vector({
                            // visible: false,
                            source: new ol.source.Vector()
                        });

                        addExtraLayer('markers', 'Markers', markerLayer);
                        // showExtraLayer('markers');
                    }

                    var markerFeature = new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.transform([parseFloat(data.r_long), parseFloat(data.r_lat)], 'EPSG:4326', 'EPSG:3857'))
                    });

                    var markerStyle = new ol.style.Style({
                        image: new ol.style.Icon({
                            anchor: [0.5, 1],
                            src: '{{ url("/")}}/img/road-blue.png'
                        })
                    });

                    markerFeature.setStyle(markerStyle);

                    eLayer.markers.layer.getSource().addFeature(markerFeature);

                    if(!eLayer.line) {
                        var lineLayer = new ol.layer.Vector({
                            // visible: false,
                            source: new ol.source.Vector()
                        });

                        addExtraLayer('line', 'Line', lineLayer);
                        // showExtraLayer('line');
                    }

                    var lineFeature = new ol.Feature({
                        geometry: new ol.geom.LineString([
                            ol.proj.transform([parseFloat(data.c_long), parseFloat(data.c_lat)], 'EPSG:4326', 'EPSG:3857'),
                            ol.proj.transform([parseFloat(data.r_long), parseFloat(data.r_lat)], 'EPSG:4326', 'EPSG:3857')
                        ])
                    });

                    var lineStyle = new ol.style.Style({
                        stroke: new ol.style.Stroke({
                            color: '#ff0000',
                        }),
                    });

                    lineFeature.setStyle(lineStyle);

                    eLayer.line.layer.getSource().addFeature(lineFeature);
                }

                showLayer('roadline');
            },
            error: function(data) {

            }
        });
    }

    function findNearestRoad(evt){
        var coordinate = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
        var long = coordinate[0];
        var lat = coordinate[1];

        if(eLayer.nearest_road_markers) {
            eLayer.nearest_road_markers.layer.getSource().clear();
        }
        else {
            var layer = new ol.layer.Vector({
                // visible: false,
                source: new ol.source.Vector()
            });

            addExtraLayer('nearest_road_markers', 'Nearest Road Markers', layer);
        }

        if(eLayer.nearest_road_line) {
            eLayer.nearest_road_line.layer.getSource().clear();
        }
        else {
            var layer = new ol.layer.Vector({
                // visible: false,
                source: new ol.source.Vector()
            });

            addExtraLayer('nearest_road_line', 'Nearest Road Line', layer);
        }

        // showExtraLayer('nearest_road_markers');
        // showExtraLayer('nearest_road_line');

        var markerFeature = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.transform(coordinate, 'EPSG:4326', 'EPSG:3857'))
        });

        var markerStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                src: '{{ url("/")}}/img/pin-blue.png'
            })
        });

        markerFeature.setStyle(markerStyle);

        eLayer.nearest_road_markers.layer.getSource().addFeature(markerFeature);

        displayAjaxLoader();
        var url = '{{ url("getNearestRoad") }}' + '/' + long + '/' + lat;
        $.ajax({
            url: url,
            type: 'get',
            success: function(data){
                if(data.lat && data.long) {
                    var markerFeature1 = new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.transform([parseFloat(data.long), parseFloat(data.lat)], 'EPSG:4326', 'EPSG:3857'))
                    });

                    var markerStyle1 = new ol.style.Style({
                        image: new ol.style.Icon({
                            anchor: [0.5, 1],
                            src: '{{ url("/")}}/img/road-yellow.png'
                        })
                    });

                    markerFeature1.setStyle(markerStyle1);

                    eLayer.nearest_road_markers.layer.getSource().addFeature(markerFeature1);

                    var lineFeature = new ol.Feature({
                        geometry: new ol.geom.LineString([
                            ol.proj.transform(coordinate, 'EPSG:4326', 'EPSG:3857'),
                            ol.proj.transform([parseFloat(data.long), parseFloat(data.lat)], 'EPSG:4326', 'EPSG:3857')
                        ])
                    });

                    var lineStyle = new ol.style.Style({
                        stroke: new ol.style.Stroke({
                            color: '#9000ff',
                        }),
                    });

                    lineFeature.setStyle(lineStyle);

                    eLayer.nearest_road_line.layer.getSource().addFeature(lineFeature);
                }

                removeAjaxLoader();

                showLayer('roadline');
            },
            error: function(data) {
                displayAjaxError();
            }
        });
    }

    // Display markers on buildings that have taxes on due
    function displayDueBuildings() {
        if(eLayer.building_markers) {
            eLayer.building_markers.layer.getSource().clear();
        }
        else {
            var layer = new ol.layer.Vector({
                // visible: false,
                source: new ol.source.Vector()
            });

            addExtraLayer('building_markers', 'Building Markers', layer);
        }

        // showExtraLayer('building_markers');

        displayAjaxLoader();
        var url = '{{ url("getDueBuildings") }}';
        $.ajax({
            url: url,
            type: 'get',
            success: function(data){
                for(var i = 0; i < data.length; i++) {
                    if(data[i].lat && data[i].long) {
                        var feature = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(data[i].long), parseFloat(data[i].lat)], 'EPSG:4326', 'EPSG:3857'))
                        });

                        var style = new ol.style.Style({
                            image: new ol.style.Icon({
                                anchor: [0.5, 1],
                                src: '{{ url("/")}}/img/building-green.png'
                            })
                        });

                        feature.setStyle(style);

                        eLayer.building_markers.layer.getSource().addFeature(feature);
                    }
                }

                removeAjaxLoader();

                showLayer('building');
                zoomToCity();
            },
            error: function(data) {
                displayAjaxError();
            }
        });
    }

    // Add handler to building search form submit
    $('#building_search_form').submit(function(){
        var bin = $('#bin_text').val().trim();

        if(!bin) {
            alert('Please enter BIN');
        }
        else {
            if(eLayer.searchResultBuilding) {
                eLayer.searchResultBuilding.layer.getSource().clear();
            }
            else {
                var searchResultBuildingLayer = new ol.layer.Vector({
                    // visible: false,
                    source: new ol.source.Vector()
                });

                addExtraLayer('searchResultBuilding', 'Search Result Building', searchResultBuildingLayer);
            }

            // showExtraLayer('searchResultBuilding');

            displayAjaxLoader();
            var url = '{{ url("searchBuildingByBIN") }}' + '/' + bin;
            $.ajax({
                url: url,
                type: 'get',
                success: function(data){
                    if(data) {
                        var format = new ol.format.WKT();

                        var buildingFeature = format.readFeature(data.geom, {
                            dataProjection: 'EPSG:4326',
                            featureProjection: 'EPSG:3857'
                        });

                        var buildingStyle = new ol.style.Style({
                            stroke: new ol.style.Stroke({
                                color: '#00bfff',
                                width: 3
                            }),
                        });

                        buildingFeature.setStyle(buildingStyle);

                        eLayer.searchResultBuilding.layer.getSource().addFeature(buildingFeature);
                        handleZoomToExtent('bldg', 'bin', data.bin, false, function(){
                            removeAjaxLoader();
                        });
                    }
                    else {
                        displayAjaxErrorModal('Building Not Found');
                    }
                },
                error: function(data) {
                    displayAjaxError();
                }
            });
        }

        return false;
    });

    // Add handler to street search form submit
    $('#street_search_form').submit(function(){
        var keyword = $('#street_search_keyword_text').val().trim();

        if(!keyword) {
            alert('Please enter keyword');
        }
        else {
            $('#map-right-sidebar #search-results-tab').html("");
            
            displayAjaxLoader();
            var url = '{{ url("searchStreetsByKeywords") }}' + '/' + keyword;
            $.ajax({
                url: url,
                type: 'get',
                success: function(data){
                    if(data && Array.isArray(data)) {
                        if(data.length > 0) {
                            var html = '';
    
                            for(var i = 0; i < data.length; i++) {
                                html += '<table class="table table-bordered">';
                                html += '<tr>';
                                html += '<th>Street ID</th>';
                                html += '<td>' + data[i].id + '</td>';
                                html += '</tr>';
                                html += '<tr>';
                                html += '<th>Name</th>';
                                html += '<td>' + data[i].strtnm + '</td>';
                                html += '</tr>';
                                html += '<tr>';
                                html += '<th>Street Code</th>';
                                html += '<td>' + data[i].strtcd + '</td>';
                                html += '</tr>';
                                html += '</table>';
                            }
    
                            $('#map-right-sidebar #search-results-tab').html(html);
                            $('#map-right-sidebar .nav-tabs a[href="#search-results-tab"]').tab('show');
                            $('#map-right-sidebar .nav-tabs').scrollingTabs('scrollToActiveTab');
    
                            removeAjaxLoader();
                        }
                        else {
                            displayAjaxErrorModal('No Results Found');
                        }
                    }
                },
                error: function(data) {
                    displayAjaxError();
                }
            });
        }

        return false;
    });

    // Add handler to text search form submit
    $('#text_search_form').submit(function(){
        var keyword = $('#search_keyword_text').val().trim();
        var layer = $('#search_layer_select').val();

        if(!keyword) {
            alert('Please type keyword to search');
        }
        else {
            if(eLayer.searchResultMarkers) {
                eLayer.searchResultMarkers.layer.getSource().clear();
            }
            else {
                var searchResultMarkerLayer = new ol.layer.Vector({
                    // visible: false,
                    source: new ol.source.Vector()
                });

                addExtraLayer('searchResultMarkers', 'Search Result Markers', searchResultMarkerLayer);
            }

            // showExtraLayer('markers');

            displayAjaxLoader();
            var url = '{{ url("searchByKeywords") }}' + '/' + layer + '/' + keyword;
            $.ajax({
                url: url,
                type: 'get',
                success: function(data){
                    if(data.points) {
                        var format = new ol.format.WKT();
                        for(var i = 0; i < data.points.length; i++) {
                            var markerFeature = format.readFeature(data.points[i], {
                                dataProjection: 'EPSG:4326',
                                featureProjection: 'EPSG:3857'
                            });

                            var markerStyle = new ol.style.Style({
                                image: new ol.style.Icon({
                                    anchor: [0.5, 1],
                                    src: '{{ url("/")}}/img/pin-purple.png'
                                })
                            });

                            markerFeature.setStyle(markerStyle);

                            eLayer.searchResultMarkers.layer.getSource().addFeature(markerFeature);
                        }
                    }

                    if(data.geoms) {
                        var format = new ol.format.WKT();
                        for(var i = 0; i < data.geoms.length; i++) {
                            var feature = format.readFeature(data.geoms[i], {
                                dataProjection: 'EPSG:4326',
                                featureProjection: 'EPSG:3857'
                            });

                            if(feature.getGeometry() instanceof ol.geom.MultiLineString) {
                                eLayer.searchResultMarkers.layer.getSource().addFeature(feature);
                            }
                        }
                    }

                    removeAjaxLoader();
                    showLayer(layer);
                    zoomToCity();
                },
                error: function(data) {
                    displayAjaxError();
                }
            });
        }

        return false;
    });

    // Add handler to ward filer form submit
    $('#ward_form').submit(function(){
        var selectedWards = $('#ward').val();
        var selectedLayers = $('#ward_overlay').val();
        if(selectedWards && selectedLayers) {
            var filters = [];
            $.each(selectedWards, function(index, value){
                filters.push('ward=' + value);
            });

            mFilter.ward = "INTERSECTS(geom, collectGeometries(queryCollection('dharan_gmis:wardpl', 'geom', '" + filters.join(' OR ') + "')))";

            $.each(mLayer, function(key, value){
                if(selectedLayers.indexOf(key) != -1) {
                    addFilterToLayer(key, 'ward');
                }
                else {
                    removeFilterFromLayer(key, 'ward');
                }
            });

            showLayer('wardpl');
        }
        else {
            mFilter.ward = '';
            $.each(mLayer, function(key, value){
                removeFilterFromLayer(key, 'ward');
            });
        }

        updateAllCQLFiltersParams();
        if(selectedLayers) {
            $.each(selectedLayers, function(index, value){
                showLayer(value);
            });
        }
        return false;
    });

    // Add handler to ward filter clear button
    $('#ward_clear_button').click(function(){
        $('#ward').val('');
        $('#ward_overlay').val('');
        $('#ward_form').submit();
    });
    
    // Add handler to export ward filter to json button
    $('#export_ward_filter_json').click(function(e){
        e.preventDefault();
        exportWardFilter('json');
    });
    
    // Add handler to export ward filter to kml button
    $('#export_ward_filter_kml').click(function(e){
        e.preventDefault();
        exportWardFilter('kml');
    });
    
    // Add handler to export ward filter to shp button
    $('#export_ward_filter_shp').click(function(e){
        e.preventDefault();
        exportWardFilter('shp');
    });

    function exportWardFilter(format) {
        if(['json', 'kml', 'shp'].indexOf(format) == -1) {
            return;
        }
        
        var selectedWards = $('#ward').val();
        var selectedLayers = $('#ward_overlay').val();
        if(!selectedWards || !selectedLayers) {
            alert('Please select wards and overlays.')
            return;
        }

        var filters = [];
        $.each(selectedWards, function(index, value){
            filters.push('ward=' + value);
        });

        var layers = [];
        $.each(selectedLayers, function(index, value) {
            layers.push('dharan_gmis:' + value);
        });

        var outputFormat;
        if(format == 'json') {
            outputFormat = 'JSON';
        }
        else if(format == 'kml') {
            outputFormat = 'KML';
        }
        else {
            outputFormat = 'SHAPE-ZIP';
        }
        
        var exportLink = gurl_wfs + "?request=GetFeature&service=WFS&version=1.0.0&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=" + layers.join(',') + "&CQL_FILTER=INTERSECTS(geom, collectGeometries(queryCollection('dharan_gmis:wardpl', 'geom', '" + filters.join(' OR ') + "')))&outputFormat=" + outputFormat;
        

        window.open(exportLink);
    }

    // Add handler to bylaw filer form submit
    $('#bylaw_form').submit(function(){
        var selectedByLaws = $('#bylaw').val();
        var selectedLayers = $('#bylaw_overlay').val();
        if(selectedByLaws && selectedLayers) {
            var filters = [];
            $.each(selectedByLaws, function(index, value){
                filters.push("name=''" + value + "''");
            });

            mFilter.bylaw = "INTERSECTS(geom, collectGeometries(queryCollection('dharan_gmis:bylaws', 'geom', '" + filters.join(' OR ') + "')))";

            $.each(mLayer, function(key, value){
                if(selectedLayers.indexOf(key) != -1) {
                    addFilterToLayer(key, 'bylaw');
                }
                else {
                    removeFilterFromLayer(key, 'bylaw');
                }
            });

            showLayer('bylaws');
        }
        else {
            mFilter.bylaw = '';
            $.each(mLayer, function(key, value){
                removeFilterFromLayer(key, 'bylaw');
            });
        }

        updateAllCQLFiltersParams();
        if(selectedLayers) {
            $.each(selectedLayers, function(index, value){
                showLayer(value);
            });
        }
        return false;
    });

    // Add handler to bylaw filter clear button
    $('#bylaw_clear_button').click(function(){
        $('#bylaw').val('');
        $('#bylaw_overlay').val('');
        $('#bylaw_form').submit();
    });
    
    // Add handler to export bylaw filter to json button
    $('#export_bylaw_filter_json').click(function(e){
        e.preventDefault();
        exportByLawFilter('json');
    });
    
    // Add handler to export bylaw filter to kml button
    $('#export_bylaw_filter_kml').click(function(e){
        e.preventDefault();
        exportByLawFilter('kml');
    });
    
    // Add handler to export bylaw filter to shp button
    $('#export_bylaw_filter_shp').click(function(e){
        e.preventDefault();
        exportByLawFilter('shp');
    });

    function exportByLawFilter(format) {
        if(['json', 'kml', 'shp'].indexOf(format) == -1) {
            return;
        }
        
        var selectedByLaws = $('#bylaw').val();
        var selectedLayers = $('#bylaw_overlay').val();
        if(!selectedByLaws || !selectedLayers) {
            alert('Please select bylaws and overlays.')
            return;
        }

        var filters = [];
        $.each(selectedByLaws, function(index, value){
            filters.push("name=''" + value + "''");
        });

        var layers = [];
        $.each(selectedLayers, function(index, value) {
            layers.push('dharan_gmis:' + value);
        });

        var outputFormat;
        if(format == 'json') {
            outputFormat = 'JSON';
        }
        else if(format == 'kml') {
            outputFormat = 'KML';
        }
        else {
            outputFormat = 'SHAPE-ZIP';
        }
        
        var exportLink = gurl_wfs + "?request=GetFeature&service=WFS&version=1.0.0&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=" + layers.join(',') + "&CQL_FILTER=INTERSECTS(geom, collectGeometries(queryCollection('dharan_gmis:bylaws', 'geom', '" + filters.join(' OR ') + "')))&outputFormat=" + outputFormat;
        

        window.open(exportLink);
    }

    $('#containment_days_form').submit(function(){
        var days = Number($('#emptying_days').val());
        if(!days) {
            alert('Please enter number of days');
        }
        else if(!Number.isInteger(days) || days < 0) {
            alert('Invalid input for number of days');
        }
        else {
            var startDate = moment().format('YYYY-MM-DD');
            var endDate = moment().add(days, 'days').format('YYYY-MM-DD');

            displayNextEmptyingContainments(startDate, endDate);
        }

        return false;
    });

    $('#containment_week_form').submit(function(){
        var startDate = moment().format('YYYY-MM-DD');
        var endDate = moment().add(7, 'days').format('YYYY-MM-DD');

        displayNextEmptyingContainments(startDate, endDate);

        return false;
    });

    $('#containment_date_form').submit(function(){
        var date = $('#next_emptying_date').val();
        if(!date) {
            alert('Please select a date');
        }
        else {
            displayNextEmptyingContainments(date, date);
        }

        return false;
    });

    // Display markers on containments to be emptied
    function displayNextEmptyingContainments(startDate, endDate) {
        if(eLayer.containment_markers) {
            eLayer.containment_markers.layer.getSource().clear();
        }
        else {
            var layer = new ol.layer.Vector({
                // visible: false,
                source: new ol.source.Vector()
            });

            addExtraLayer('containment_markers', 'Containment Markers', layer);
        }

        // showExtraLayer('containment_markers');

        displayAjaxLoader();
        var url = '{{ url("getNextEmptyingContainments") }}' + '/' + startDate + '/' + endDate;
        $.ajax({
            url: url,
            type: 'get',
            success: function(data){
                for(var i = 0; i < data.length; i++) {
                    if(data[i].lat && data[i].long) {
                        var feature = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(data[i].long), parseFloat(data[i].lat)], 'EPSG:4326', 'EPSG:3857'))
                        });

                        var style = new ol.style.Style({
                            image: new ol.style.Icon({
                                anchor: [0.5, 1],
                                src: '{{ url("/")}}/img/containment.png'
                            })
                        });

                        feature.setStyle(style);

                        eLayer.containment_markers.layer.getSource().addFeature(feature);
                    }
                }

                removeAjaxLoader();

                showLayer('contain');
                zoomToCity();
            },
            error: function(data) {
                displayAjaxError();
            }
        });
    }

    // Add handler to single women filter checkbox change
    $('#bldg_sngwoman_checkbox').on('change', function(){
        if($(this).is(':checked')) {
            mFilter.bldg_sngwoman = 'sngwoman > 0';
            showLayer('bldg');
        }
        else {
            mFilter.bldg_sngwoman = '';
        }

        updateAllCQLFiltersParams();
    });

    // Add handler to old age filter checkbox change
    $('#bldg_gt60yr_checkbox').on('change', function(){
        if($(this).is(':checked')) {
            mFilter.bldg_gt60yr = 'gt60yr > 0';
            showLayer('bldg');
        }
        else {
            mFilter.bldg_gt60yr = '';
        }

        updateAllCQLFiltersParams();
    });

    // Add handler to disabled people filter checkbox change
    $('#bldg_dsblppl_checkbox').on('change', function(){
        if($(this).is(':checked')) {
            mFilter.bldg_dsblppl = 'dsblppl > 0';
            showLayer('bldg');
        }
        else {
            mFilter.bldg_dsblppl = '';
        }

        updateAllCQLFiltersParams();
    });

    // Add handler to water logging area filter checkbox change
    /*
    $('#watlog_checkbox').on('change', function(){
        if($(this).is(':checked')) {
            mFilter.watlog = "INTERSECTS(geom, collectGeometries(queryCollection('watlog', 'geom', 'INCLUDE')))"
            showLayer('watlog');
        }
        else {
            mFilter.watlog = '';
        }

        updateAllCQLFiltersParams();
    });
    */

    // Add handler to water logging area filer form submit
    $('#watlog_form').submit(function(){
        var selectedLayers = $('#watlog_overlay').val();
        if(selectedLayers) {
            mFilter.watlog = "INTERSECTS(geom, collectGeometries(queryCollection('dharan_gmis:watlog', 'geom', 'INCLUDE')))"

            $.each(mLayer, function(key, value){
                if(selectedLayers.indexOf(key) != -1) {
                    addFilterToLayer(key, 'watlog');
                }
                else {
                    removeFilterFromLayer(key, 'watlog');
                }
            });

            showLayer('watlog');
        }
        else {
            mFilter.watlog = '';
            $.each(mLayer, function(key, value){
                removeFilterFromLayer(key, 'watlog');
            });
        }

        updateAllCQLFiltersParams();
        if(selectedLayers) {
            $.each(selectedLayers, function(index, value){
                showLayer(value);
            });
        }
        return false;
    });

    function updateAllCQLFiltersParams() {
        $.each(mLayer, function(key, value){
            updateCQLFilterParams(key);
        });
    }

    function updateCQLFilterParams(layer) {
        if(mLayer[layer]) {
            var cqlFilters = [];
            $.each(mLayer[layer].filters, function(index, value) {
                if(mFilter[value]) {
                    cqlFilters.push(mFilter[value]);
                }
            });

            var cql_filter = cqlFilters.length > 0 ? cqlFilters.join(" AND ") : null;
            mLayer[layer].layer.get('source').updateParams({CQL_FILTER: cql_filter});
        }
    }

    function handleZoomToExtent(layer, field, val, showMarker, callback) {
        var url = '{{ url("getExtent") }}' + '/' + layer + '/' + field + '/' + val;
        $.ajax({
            url: url,
            type: 'get',
            success: function(data){
                var extent = ol.proj.transformExtent([parseFloat(data.xmin), parseFloat(data.ymin), parseFloat(data.xmax), parseFloat(data.ymax)], 'EPSG:4326', 'EPSG:3857');
                map.getView().fit(extent);

                if(showMarker) {
                    if(data.long && data.lat){
                        if(!eLayer.markers) {
                            var markerLayer = new ol.layer.Vector({
                                // visible: false,
                                source: new ol.source.Vector()
                            });

                            addExtraLayer('markers', 'Markers', markerLayer);
                            // showExtraLayer('markers');
                        }

                        var markerFeature = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(data.long), parseFloat(data.lat)], 'EPSG:4326', 'EPSG:3857'))
                        });

                        var markerStyle = new ol.style.Style({
                            image: new ol.style.Icon({
                                anchor: [0.5, 1],
                                src: '{{ url("/")}}/img/pin-red.png'
                            })
                        });

                        markerFeature.setStyle(markerStyle);

                        eLayer.markers.layer.getSource().addFeature(markerFeature);

                        map.getView().setCenter(ol.proj.transform([parseFloat(data.long), parseFloat(data.lat)], 'EPSG:4326', 'EPSG:3857'));
                        map.getView().setZoom(16);
                    }

                    if(data.long1 && data.lat1){
                        if(!eLayer.markers) {
                            var markerLayer = new ol.layer.Vector({
                                // visible: false,
                                source: new ol.source.Vector()
                            });

                            addExtraLayer('markers', 'Markers', markerLayer);
                            // showExtraLayer('markers');
                        }

                        var markerFeature = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(data.long1), parseFloat(data.lat1)], 'EPSG:4326', 'EPSG:3857'))
                        });

                        var markerStyle = new ol.style.Style({
                            image: new ol.style.Icon({
                                anchor: [0.5, 1],
                                src: '{{ url("/")}}/img/pin-purple.png'
                            })
                        });

                        markerFeature.setStyle(markerStyle);

                        eLayer.markers.layer.getSource().addFeature(markerFeature);
                    }

                    if(data.geom) {
                        var format = new ol.format.WKT();
                        var feature = format.readFeature(data.geom, {
                            dataProjection: 'EPSG:4326',
                            featureProjection: 'EPSG:3857'
                        });

                        if(feature.getGeometry() instanceof ol.geom.MultiLineString) {
                            if(!eLayer.markers) {
                                var markerLayer = new ol.layer.Vector({
                                    // visible: false,
                                    source: new ol.source.Vector()
                                });

                                addExtraLayer('markers', 'Markers', markerLayer);
                                // showExtraLayer('markers');
                            }

                            feature.setStyle(new ol.style.Style({
                                stroke: new ol.style.Stroke({
                                    color: '#ed1f24',
                                    width: 3
                                }),
                            }));
                            eLayer.markers.layer.getSource().addFeature(feature);
                        }
                    }
                }

                showLayer(layer);
                
                if(callback) {
                    callback();
                }
            },
            error: function(data) {

            }
        });
    }

    function updateMapSize() {
        map.updateSize();
        google.maps.event.trigger(gmap, 'resize');
        onCenterChanged();
        onResolutionChanged();
    }

    $(document).on('expanded.pushMenu collapsed.pushMenu', function(){
        setTimeout(updateMapSize, 300);
    });

    function setSidebarTabContentHeight() {
        // var height = $('#map-right-sidebar').outerHeight() - $('#map-right-sidebar .nav-tabs').outerHeight();
        var height = window.innerHeight - $('#map-right-sidebar .nav-tabs').offset().top - $('#map-right-sidebar .nav-tabs').outerHeight() - $('footer').outerHeight();
        $('#map-right-sidebar .tab-content').height(height);
    }

    // Fix min-height of content-wrapper on window load
    $(window).on('load', function(){
        $(window).trigger('resize');
        updateMapSize();
    });

    $(window).on('resize', function(){
        setSidebarTabContentHeight();
    });
});
</script>
@endpush
