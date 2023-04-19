<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title>Map Viewer </title>
    <link rel="stylesheet" href="{{ asset('/theme/default/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
    <style type="text/css">
      body { overflow: hidden; }

      .navbar-offset { margin-top: 50px; }
      #map { position: absolute; top: 50px; bottom: 0px; left: 0px; right: 0px; }
      #map .ol-zoom { font-size: 1.2em; }

      .zoom-top-opened-sidebar { margin-top: 5px; }
      .zoom-top-collapsed { margin-top: 45px; }

      .mini-submenu{
        display:none;  
        background-color: rgba(255, 255, 255, 0.46);
        border: 1px solid rgba(0, 0, 0, 0.9);
        border-radius: 4px;
        padding: 9px;  
        /*position: relative;*/
        width: 42px;
        text-align: center;
      }

      .mini-submenu-left {
        position: absolute;
        top: 60px;
        left: .5em;
        z-index: 40;
      }
      .mini-submenu-right {
        position: absolute;
        top: 60px;
        right: .5em;
        z-index: 40;
      }

      #map { z-index: 35; }

      .sidebar { z-index: 45; }

      .main-row { position: relative; top: 0; }

      .mini-submenu:hover{
        cursor: pointer;
      }

      .slide-submenu{
        background: rgba(0, 0, 0, 0.45);
        display: inline-block;
        padding: 0 8px;
        border-radius: 4px;
        cursor: pointer;
      }

    </style>
    
  </head>
  <body>
    <div class="container">
      <nav class="navbar navbar-fixed-top navbar-default" role="navigation">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">IMIS Map Viewer </a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                <ul style="padding-top:5px">
                    <a href="#" id="zoomin_control" class="btn btn-default glyphicon glyphicon-zoom-in"></a>
                     <a href="#" id="zoomout_control" class="btn btn-default glyphicon glyphicon-zoom-out"></a>
                     <a href="#" id="zoomfull_control" class="btn btn-default glyphicon glyphicon-globe"></a>
                    <a href="#" id="pan_control" class="btn btn-default glyphicon glyphicon-move"></a>
                    <a href="#" id="navprev_control" class="btn btn-default glyphicon glyphicon-arrow-left"></a>
                    <a href="#" id="navnext_control" class="btn btn-default glyphicon glyphicon-arrow-right"></a>
                    <a href="#" id="identify_control" class="btn btn-default glyphicon glyphicon-info-sign"></a>
                    
                </ul>
                    </li>
            <!--  <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                  <li class="divider"></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>-->
            </ul>
            <form class="navbar-form navbar-left" name="cql_form" id="cql_form">
              <div class="form-group">
                <input type="text" id="cql" class="form-control" placeholder="Search">
                {!! Form::select('district', 
                      (['' => 'Select a district'] + $districts), 
                          null, 
                          ['class' => 'form-control', 'id' => 'district'])
                !!}
                {!! Form::select('district', 
                      (['' => 'Select a operator'] + $operators), 
                          null, 
                          ['class' => 'form-control', 'id' => 'operator'])
                !!}
              </div>
              <button type="submit" class="btn btn-default">Search</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
              <!--<li><a href="#">Link</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </li>-->
            </ul>
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        </div>
      </nav>
      <div class="navbar-offset"></div>
      <div id="map">
      </div>
      <div class="row main-row">
        <div class="col-sm-4 col-md-3 sidebar sidebar-left pull-left">
          <div class="panel-group sidebar-body" id="accordion-left">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#layers">
                    <i class="fa fa-list-alt"></i>
                    Layers
                  </a>
                  <span class="pull-right slide-submenu">
                    <i class="glyphicon glyphicon-chevron-left"></i>
                  </span>
                    
                </h4>
              </div>
              <div id="layers" class="panel-collapse collapse in">
                <div class="panel-body list-group" id="layerswitcher">
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
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#properties">
                    <i class="glyphicon glyphicon-tasks"></i>
                    Legend
                  </a>
                    
                </h4>
              </div>
              <div id="legend" class="panel-collapse collapse in">
                <div class="panel-body" id="legend_body">
                 
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-md-6 mid"></div>
        <!--<div class="col-sm-4 col-md-3 sidebar sidebar-right pull-right">
          <div class="panel-group sidebar-body" id="accordion-right">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#taskpane">
                    <i class="glyphicon glyphicon-list-alt"></i>
                    Task Pane
                  </a>
                  <span class="pull-right slide-submenu">
                    <i class="glyphicon glyphicon-chevron-right"></i>
                  </span>
                </h4>
              </div>
              <div id="taskpane" class="panel-collapse collapse in">
                <div class="panel-body" id="taskpane_body">
                  
                </div>
              </div>
            </div>
          </div>
        </div>-->
      </div>
      <div class="mini-submenu mini-submenu-left pull-left">
        <i class="glyphicon glyphicon-tasks"></i>
      </div>
      <div class="mini-submenu mini-submenu-right pull-right">
        <i class="glyphicon glyphicon-list-alt"></i>
      </div>
    </div>
    <script type="text/javascript" src="{{ asset ('/ol/lib/openlayers.js') }}"></script>
    <script src="{{ asset ("/js/jQuery-2.1.4.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset ('/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('/js/map_layout.js') }}"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=places&sensor=false"></script>

    <script type="text/javascript">
        gurl="http://202.166.221.38:9090/geoserver/wms";
        gurl_legend = gurl + "?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=";

      $(function(){
       $(".sidebar-left .slide-submenu").on("click", function () { var i = $(this); i.closest(".sidebar-body").fadeOut("slide", function () { $(".mini-submenu-left").fadeIn(), applyMargins() }) }), $(".mini-submenu-left").on("click", function () { var i = $(this); $(".sidebar-left .sidebar-body").toggle("slide"), i.hide(), applyMargins() }), $(".sidebar-right .slide-submenu").on("click", function () { var i = $(this); i.closest(".sidebar-body").fadeOut("slide", function () { $(".mini-submenu-right").fadeIn(), applyMargins() }) }), $(".mini-submenu-right").on("click", function () { var i = $(this); $(".sidebar-right .sidebar-body").toggle("slide"), i.hide(), applyMargins() }), $(window).on("resize", applyMargins);
        var options = {
            numZoomLevels: 10,
            maxExtent: new OpenLayers.Bounds(80, 26, 89, 31),
            projection: new OpenLayers.Projection("EPSG:900913"),
            displayProjection: new OpenLayers.Projection("EPSG: 4326")
        };

       map = new OpenLayers.Map('map', options);
        gphy = new OpenLayers.Layer.Google(
            "Google Physical"
        );
        gmap = new OpenLayers.Layer.Google(
            "Google Streets"
        );
        ghyb = new OpenLayers.Layer.Google(
            "Google Hybrid"
        );
        gsat = new OpenLayers.Layer.Google(
            "Google Satellite"
        );
        osm = new OpenLayers.Layer.OSM("OpenStreet Map");
        gmap = new OpenLayers.Layer.Google("Google Streets");
        distpl = new OpenLayers.Layer.WMS("District", gurl, { layers: 'nta:distpl',transparent: true},{isBaseLayer: false,attribution:"<img src='"+gurl_legend+"nta:distpl' />" });
        regpl = new OpenLayers.Layer.WMS("Development Region", gurl, { layers: 'nta:regpl',transparent: true }, { isBaseLayer: false,attribution: "<img src='" + gurl_legend + "nta:regpl' />" });
        vdc = new OpenLayers.Layer.WMS("VDC", gurl, { layers: 'nta:vdcpl',transparent: true }, { isBaseLayer: false,attribution: "<img src='" + gurl_legend + "nta:vdcpl' />" });
        vsat = new OpenLayers.Layer.WMS("VSAT", gurl, { layers: 'nta:vsats',transparent: true }, { isBaseLayer: false,attribution: "<img src='" + gurl_legend + "nta:vsats' />" });
        system_site = new OpenLayers.Layer.WMS("System Sites", gurl, { layers: 'nta:system_sites',transparent: true }, { isBaseLayer: false,attribution: "<img src='" + gurl_legend + "nta:system_sites' />" });
        
        map.addLayers([osm,gmap,gphy,ghyb,gsat,regpl,distpl,vdc,vsat,system_site]);

        map.addControl(new OpenLayers.Control.LayerSwitcher({ 'div': OpenLayers.Util.getElement('layerswitcher') }));
        //map.setCenter(new OpenLayers.LonLat(10.2, 48.9), 7);
        //map.setCenter(new OpenLayers.LonLat(83.86, 28.48).transform('EPSG:4326', 'EPSG:3857'), 7);
        map.zoomToMaxExtent();



        nav = new OpenLayers.Control.NavigationHistory();
        map.addControl(nav);
        map.addControl(new OpenLayers.Control.Attribution({ template: "${layers}" }));
        OpenLayers.ProxyHost = "./js/proxy.php?url=";
         popups = {};
        wmsgetfeatureinfo_control = new OpenLayers.Control.WMSGetFeatureInfo({
            /*title: 'Identify features by clicking',
            queryVisible: true,
            maxFeatures: 50,
            output:'features',
            infoFormat:'application/json',
            format: new OpenLayers.Format.JSON,*/
            drillDown: true,
            queryVisible: true,
            autoActivate:false,
            eventListeners: {
                getfeatureinfo: function (evt) {
                    var text;
                    var match = evt.text.match(/<body[^>]*>([\s\S]*)<\/body>/);
                    if (match && !match[1].match(/^\s*$/)) {
                        text = match[1];
                    } else {
                        text = "No features in that area.<br>";
                    }
                    var popupId = evt.xy.x + "," + evt.xy.y;
                    var popup = popups[popupId];
                    if (!popup || !popup.map) {
                        popup = new OpenLayers.Popup.FramedCloud(
                            popupId,
                            map.getLonLatFromPixel(evt.xy),
                            null,
                            " ",
                            null,
                            true,
                            function (evt) {
                                delete popups[this.id];
                                this.hide();
                                OpenLayers.Event.stop(evt);
                            }
                        );
                        popups[popupId] = popup;
                        map.addPopup(popup, true);
                    }
                    popup.setContentHTML(popup.contentHTML + text);
                    popup.show();
                    /*
                    selectedFeaturesParse(event.features);

                    if(selectedFeatures.length > 0){                                    
                        popup = new OpenLayers.Popup.FramedCloud(
                            "featurePopup",
                            map.getLonLatFromPixel(event.xy),                       
                            null,
                            buildInfoControlTextAndVectors(),
                            null,
                            true
                        );

                        map.addPopup(popup);
                    }   
                    */
                    //$('#taskpane_body').html(buildInfoControlTextAndVectors());
                }
            }
        });
        map.addControl(wmsgetfeatureinfo_control);
        wmsgetfeatureinfo_control.activate();
        map.addControl(new OpenLayers.Control.ScaleLine())

        $("#legend_body").append($(".olControlAttribution"));
        applyInitialUIState();
        applyMargins();

        $("#zoomin_control").bind("click", function () {
            map.zoomIn();
        });
        $("#zoomout_control").bind("click", function () {
            map.zoomOut();
        });
        $("#zoomfull_control").bind("click", function () {
            map.zoomToMaxExtent()
        });
        $("#identify_control").bind("click", function () {
            wmsgetfeatureinfo_control.activate();
        });
        $("#pan_control").bind("click", function () {
            wmsgetfeatureinfo_control.deactivate()
        });
        $("#navnext_control").bind("click", function () {
            nav.nextTrigger();
        });
        $("#navprev_control").bind("click", function () {
            nav.previousTrigger();
        });

// update filter and redraw when form is submitted

function updateFilter() {
    var district = $("#district").val();
    var operator = $("#operator").val();
    delete vsat.params.CQL_FILTER;
    delete distpl.params.CQL_FILTER;
    delete system_site.params.CQL_FILTER;
    var filterParams;

    if(district != '')
    {
      filterParams = {
          filter: null,
          cql_filter: "district LIKE '" + district + "'",
          featureId: null
      };
      vsat.mergeNewParams(filterParams);
      distpl.mergeNewParams(filterParams);
      //system_site.mergeNewParams(filterParams);
    }
    if(operator != '')
    {
      filterParams = {
          filter: null,
          cql_filter: "ntaoprcd LIKE '" + operator + "'",
          featureId: null
      };
      vsat.mergeNewParams(filterParams);
      system_site.mergeNewParams(filterParams);
    }
    vsat.redraw();
    distpl.redraw();
    system_site.redraw();
    return false;
}

var form = document.getElementById("cql_form");
form.onsubmit = updateFilter;
});
function selectedFeaturesParse(jsonObject) {

    selectedFeatures = [];

    for (var i=0 ; i < jsonObject.features.length; i++ ){
        selectedFeatures.push({
            ntavsatid:jsonObject.features[i].properties.ntavsatid, 
            stnname: jsonObject.features[i].properties.stnname,
            district: jsonObject.features[i].properties.district,
            vdc: jsonObject.features[i].properties.vdc,
            ward: jsonObject.features[i].properties.ward,
            stnname: jsonObject.features[i].properties.stnname,
            downlink: jsonObject.features[i].properties.downlink,
            uplink: jsonObject.features[i].properties.uplink,       
            modtechq: jsonObject.features[i].modtechq           
        });

    }       
}

function buildInfoControlTextAndVectors(){

    var record; 
    var geojson_format = new OpenLayers.Format.GeoJSON({
                'internalProjection': new OpenLayers.Projection("EPSG:3857"),
                'externalProjection': new OpenLayers.Projection("EPSG:4326")
            });

    var feature;    

    var info = "<div class=\"info\">";

    for (var i=0 ; i < selectedFeatures.length; i++ ){

        record = selectedFeatures[i];

        // Aproveita o mesmo ciclo  que itera as formas selecionadas para desenhar também os vectores
        //**********************************************************
        feature = geojson_format.read(record.geom);
        //vectors.addFeatures(feature);
        //**********************************************************

        info += "<div class=\"inner\"><table>"
        info += "<tr><td><b>NTAVSATID : </b><td>" + record.ntavsatid + "</td></tr>";
        info += "<tr><td><b>STNNAME : </b><td>" + record.stnname + "</td></tr>";
        info += "<tr><td><b>DISTRICT : </b><td>" + record.district + "</td></tr>";
        info += "<tr><td><b>VDC : </b><td>" + record.vdc + "</td></tr>";
        info += "<tr><td><b>WARD: </b><td>" + record.ward + "</td></tr>";
        info += "<tr><td><b>DOWNLINK : </b><td>" + record.downlink + "</td></tr>";
        info += "<tr><td><b>UPLINK : </b><td>" + record.uplink + "</td></tr>";
        info += "<tr><td><b>MODTECHQ : </b><td>" + record.modtechq + "</td></tr></table></div>";


        if (i!= (selectedFeatures.length-1)){
            info += "<br />";
        }

    }
    info += "</div>"
    //vectors.redraw();
    return info;
}

    </script>
  </body>
</html>