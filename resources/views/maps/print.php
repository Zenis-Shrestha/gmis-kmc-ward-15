
@push('scripts')

<script src="{{ asset ('/js/html2canvas.min.js') }}"></script>
<script src="{{ asset ('/js/html2canvas.js') }}"></script>

<script src="{{ asset ('/js/FileSaver.js') }}"></script>

<script type="text/javascript">
var layer = '{{ Input::get('layer') }}';
var field = '{{ Input::get('field') }}';
var val = '{{ Input::get('val') }}';
var map;
var vdcpl,
    distpl,
    riverln,
    roadln,
    landusepl,
    settelmentpl,
    vsats,
    system_sites,
    microwaves,
    microwave_stations,
    optical_links,
    nodes;
gurl="http://127.0.0.1:9090/geoserver/wms";
//gurl="http://202.166.221.38:9090/geoserver/wms";
gurl_legend = gurl + "?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=";
$(function(){
    //$("#footer-content").attr("style","padding-left:"+$(".main-sidebar").width()+"px;");

    $(".sidebar-left .slide-submenu").on("click", function () { var i = $(this); i.closest(".sidebar-body").fadeOut("slide", function () { $(".mini-submenu-left").fadeIn(), applyMargins() }) }), $(".mini-submenu-left").on("click", function () { var i = $(this); $(".sidebar-left .sidebar-body").toggle("slide"), i.hide(), applyMargins() }), $(".sidebar-right .slide-submenu").on("click", function () { var i = $(this); i.closest(".sidebar-body").fadeOut("slide", function () { $(".mini-submenu-right").fadeIn(), applyMargins() }) }), $(".mini-submenu-right").on("click", function () { var i = $(this); $(".sidebar-right .sidebar-body").toggle("slide"), i.hide(), applyMargins() }), $(window).on("resize", applyMargins);
    var options = {
        numZoomLevels: 7,
        //maxExtent: new OpenLayers.Bounds(80, 26, 89, 31).transform('EPSG:4326', 'EPSG:900913'),
        projection: new OpenLayers.Projection("EPSG:900913"),
        displayProjection: new OpenLayers.Projection("EPSG:4326"),
        controls: [],
        eventListeners: {
            "changelayer": mapLayerChanged
        }
    };

    map = new OpenLayers.Map('map', options);
    gmap = new OpenLayers.Layer.Google(
    	"Google Streets",
    	{type: google.maps.MapTypeId.ROADMAP,numZoomLevels: 23,MAX_ZOOM_LEVEL: 22}
    );
    ghyb = new OpenLayers.Layer.Google(
    	"Google Hybrid",
    	{type: google.maps.MapTypeId.HYBRID,numZoomLevels: 23,MAX_ZOOM_LEVEL: 22}
    );
    gtrn = new OpenLayers.Layer.Google(
        "Google Terrain",
        {type: google.maps.MapTypeId.TERRAIN,numZoomLevels: 23,MAX_ZOOM_LEVEL: 22}
    );
    gsat = new OpenLayers.Layer.Google(
    	"Google Satellite",
    	{type: google.maps.MapTypeId.SATELLITE,numZoomLevels: 23,MAX_ZOOM_LEVEL: 22}
    );
    osm = new OpenLayers.Layer.OSM("OpenStreet Map");

    distpl = new OpenLayers.Layer.WMS("District", gurl, { layers: 'nta:distpl',transparent: true},{isBaseLayer: false });
    riverln = new OpenLayers.Layer.WMS("River", gurl, { layers: 'nta:river',transparent: true},{isBaseLayer: false });
    roadln = new OpenLayers.Layer.WMS("Road", gurl, { layers: 'nta:road',transparent: true},{isBaseLayer: false });
    landusepl = new OpenLayers.Layer.WMS("Landuse", gurl, { layers: 'nta:landuse',transparent: true},{isBaseLayer: false });
    settelmentpl = new OpenLayers.Layer.WMS("Settelment", gurl, { layers: 'nta:settelment',transparent: true},{isBaseLayer: false });
    natpl = new OpenLayers.Layer.WMS("Nepal", gurl, { layers: 'nta:natpl',transparent: true }, { isBaseLayer: false });
    vdcpl = new OpenLayers.Layer.WMS("VDC", gurl, { layers: 'nta:vdcpl',transparent: true }, { isBaseLayer: false });
    vsats = new OpenLayers.Layer.WMS("VSATs", gurl, { layers: 'nta:vsats',transparent: true }, { isBaseLayer: false });
    system_sites = new OpenLayers.Layer.WMS("System Sites", gurl, { layers: 'nta:system_sites',transparent: true }, { isBaseLayer: false });
    microwaves = new OpenLayers.Layer.WMS("Microwaves", gurl, { layers: 'nta:microwaves',transparent: true }, { isBaseLayer: false });
    microwave_stations = new OpenLayers.Layer.WMS("Microwave Stations", gurl, { layers: 'nta:microwave_stations',transparent: true }, { isBaseLayer: false });
    optical_links = new OpenLayers.Layer.WMS("Optical Fibre", gurl, { layers: 'nta:optical_links',transparent: true }, { isBaseLayer: false });
    nodes = new OpenLayers.Layer.WMS("Optical Nodes", gurl, { layers: 'nta:nodes',transparent: true }, { isBaseLayer: false });
    isp_wireless_sites = new OpenLayers.Layer.WMS("ISP Wireless Site", gurl, { layers: 'nta:isp_wireless_sites',transparent: true }, { isBaseLayer: false });
    pstn_exchanges = new OpenLayers.Layer.WMS("PSTN Exchange", gurl, { layers: 'nta:pstn_exchanges',transparent: true }, { isBaseLayer: false });
    vdcpl.setVisibility(false);
    distpl.setVisibility(false);
    riverln.setVisibility(false);
    roadln.setVisibility(false);
    landusepl.setVisibility(false);
    settelmentpl.setVisibility(false);
    vsats.setVisibility(false);
    system_sites.setVisibility(false);
    microwaves.setVisibility(false);
    microwave_stations.setVisibility(false);
    optical_links.setVisibility(false);
    nodes.setVisibility(false);
    isp_wireless_sites.setVisibility(false);
    pstn_exchanges.setVisibility(false);
    map.addLayers([osm,gmap,ghyb,gsat,gtrn,natpl,distpl,riverln,roadln,landusepl,settelmentpl,vdcpl,vsats]);

    map.addControl(new OpenLayers.Control.LayerSwitcher({ 'div': OpenLayers.Util.getElement('layerswitcher') }));
    //map.setCenter(new OpenLayers.LonLat(10.2, 48.9), 7);
    map.setCenter(new OpenLayers.LonLat(83.86, 28.48).transform('EPSG:4326', 'EPSG:900913'), 7);
    //map.zoomToMaxExtent();

    nav = new OpenLayers.Control.NavigationHistory();
    map.addControl(nav);
    zoomWheel = new OpenLayers.Control.Navigation({'zoomWheelEnabled': true});
	map.addControl(zoomWheel);
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
    //wmsgetfeatureinfo_control.activate();
    map.addControl(new OpenLayers.Control.ScaleLine())

    var dragControl = new OpenLayers.Control.DragPan({title:'Drag map', displayClass: 'olControlPanMap'});
    var zoomBoxIn = new OpenLayers.Control.ZoomBox({ title: "Zoom in box", displayClass: 'olControlZoomOutBox', out: true });
    var zoomBoxOut = new OpenLayers.Control.ZoomBox({ title: "Zoom Out box" })
    map.addControl(dragControl);
    map.addControl(zoomBoxIn);
    map.addControl(zoomBoxOut);




// Define three colors that will be used to style the cluster features
            // depending on the number of features they contain.
            var colors = {
                low: "rgb(255, 113, 113)",
                middle: "rgb(255, 56, 56)",
                high: "rgb(255, 0, 0)"
            };

            // Define three rules to style the cluster features.
            var lowRule = new OpenLayers.Rule({
                filter: new OpenLayers.Filter.Comparison({
                    type: OpenLayers.Filter.Comparison.LESS_THAN,
                    property: "count",
                    value: 15
                }),
                symbolizer: {
                    fillColor: colors.low,
                    fillOpacity: 0.9,
                    strokeColor: colors.low,
                    strokeOpacity: 0.5,
                    strokeWidth: 12,
                    pointRadius: 10,
                    label: "${count}",
                    labelOutlineWidth: 1,
                    fontColor: "#ffffff",
                    fontOpacity: 0.8,
                    fontSize: "12px"
                }
            });
            var middleRule = new OpenLayers.Rule({
                filter: new OpenLayers.Filter.Comparison({
                    type: OpenLayers.Filter.Comparison.BETWEEN,
                    property: "count",
                    lowerBoundary: 15,
                    upperBoundary: 50
                }),
                symbolizer: {
                    fillColor: colors.middle,
                    fillOpacity: 0.9,
                    strokeColor: colors.middle,
                    strokeOpacity: 0.5,
                    strokeWidth: 12,
                    pointRadius: 15,
                    label: "${count}",
                    labelOutlineWidth: 1,
                    fontColor: "#ffffff",
                    fontOpacity: 0.8,
                    fontSize: "12px"
                }
            });
            var highRule = new OpenLayers.Rule({
                filter: new OpenLayers.Filter.Comparison({
                    type: OpenLayers.Filter.Comparison.GREATER_THAN,
                    property: "count",
                    value: 50
                }),
                symbolizer: {
                    fillColor: colors.high,
                    fillOpacity: 0.9,
                    strokeColor: colors.high,
                    strokeOpacity: 0.5,
                    strokeWidth: 12,
                    pointRadius: 20,
                    label: "${count}",
                    labelOutlineWidth: 1,
                    fontColor: "#ffffff",
                    fontOpacity: 0.8,
                    fontSize: "12px"
                }
            });

            // Create a Style that uses the three previous rules
            var style = new OpenLayers.Style(null, {
                rules: [lowRule, middleRule, highRule]
            });
// Create a vector layers
var vsat_cluster = new OpenLayers.Layer.Vector("VSAT Cluster", {
	protocol: new OpenLayers.Protocol.HTTP({
		url: "http://192.168.0.104:9090/geoserver/nta/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=nta:vsats&CQL_FILTER=errflag='0'&outputFormat=application%2Fjson",
		format: new OpenLayers.Format.GeoJSON()
	}),
	renderers: ['Canvas','SVG'],
    strategies: [
        new OpenLayers.Strategy.Fixed(),
        new OpenLayers.Strategy.AnimatedCluster({
            distance: 45,
            animationMethod: OpenLayers.Easing.Expo.easeOut,
            animationDuration: 10
        })
    ],
    projection: new OpenLayers.Projection("EPSG:4326"),
	styleMap:  new OpenLayers.StyleMap(style)
});
// Create a vector layers
var system_site_cluster = new OpenLayers.Layer.Vector("System-Site Cluster", {
	protocol: new OpenLayers.Protocol.HTTP({
		url: "http://192.168.0.104:9090/geoserver/nta/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=nta:system_sites&CQL_FILTER=errflag='0'&outputFormat=application%2Fjson",
		format: new OpenLayers.Format.GeoJSON()
	}),
	renderers: ['Canvas','SVG'],
    strategies: [
        new OpenLayers.Strategy.Fixed(),
        new OpenLayers.Strategy.AnimatedCluster({
            distance: 45,
            animationMethod: OpenLayers.Easing.Expo.easeOut,
            animationDuration: 10
        })
    ],
    projection: new OpenLayers.Projection("EPSG:4326"),
	styleMap:  new OpenLayers.StyleMap(style)
});
var microwavestations_cluster = new OpenLayers.Layer.Vector("Microwave-Stations Cluster", {
    protocol: new OpenLayers.Protocol.HTTP({
        url: "http://192.168.0.104:9090/geoserver/nta/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=nta:microwave_stations&CQL_FILTER=errflag='0'&outputFormat=application%2Fjson",
        format: new OpenLayers.Format.GeoJSON()
    }),
    renderers: ['Canvas','SVG'],
    strategies: [
        new OpenLayers.Strategy.Fixed(),
        new OpenLayers.Strategy.AnimatedCluster({
            distance: 45,
            animationMethod: OpenLayers.Easing.Expo.easeOut,
            animationDuration: 10
        })
    ],
    projection: new OpenLayers.Projection("EPSG:4326"),
    styleMap:  new OpenLayers.StyleMap(style)
});
vsat_cluster.setVisibility(false);
system_site_cluster.setVisibility(false);
microwavestations_cluster.setVisibility(false);
map.addLayers([vsat_cluster,system_sites,system_site_cluster,microwaves,microwave_stations,microwavestations_cluster,nodes,optical_links,isp_wireless_sites,pstn_exchanges]);

// style the sketch fancy
            var sketchSymbolizers = {
                "Point": {
                    pointRadius: 4,
                    graphicName: "square",
                    fillColor: "white",
                    fillOpacity: 1,
                    strokeWidth: 1,
                    strokeOpacity: 1,
                    strokeColor: "#333333"
                },
                "Line": {
                    strokeWidth: 3,
                    strokeOpacity: 1,
                    strokeColor: "#666666",
                    strokeDashstyle: "dash"
                },
                "Polygon": {
                    strokeWidth: 2,
                    strokeOpacity: 1,
                    strokeColor: "#666666",
                    fillColor: "white",
                    fillOpacity: 0.3
                }
            };
            var style = new OpenLayers.Style();
            style.addRules([
                new OpenLayers.Rule({symbolizer: sketchSymbolizers})
            ]);
            var styleMap = new OpenLayers.StyleMap({"default": style});
// allow testing of specific renderers via "?renderer=Canvas", etc
            var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
            renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
measureControls = {
                line: new OpenLayers.Control.Measure(
                    OpenLayers.Handler.Path, {
                        persist: true,
                        handlerOptions: {
                            layerOptions: {
                                renderers: renderer,
                                styleMap: styleMap
                            }
                        }
                    }
                ),
                polygon: new OpenLayers.Control.Measure(
                    OpenLayers.Handler.Polygon, {
                        persist: true,
                        handlerOptions: {
                            layerOptions: {
                                renderers: renderer,
                                styleMap: styleMap
                            }
                        }
                    }
                )
            };

            var control;
            for(var key in measureControls) {
                control = measureControls[key];
                control.events.on({
                    "measure": handleMeasurements,
                    "measurepartial": handleMeasurements
                });
                map.addControl(control);
            }

    //$("#legend_body").append($(".olControlAttribution"));
    applyInitialUIState();
    applyMargins();

    $("#zoomin_control").bind("click", function () {
    	for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
    	wmsgetfeatureinfo_control.deactivate();
    	zoomBoxIn.deactivate();
        zoomBoxOut.activate();
    });
    $("#zoomout_control").bind("click", function () {
    	wmsgetfeatureinfo_control.deactivate();
    	for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
        zoomBoxOut.deactivate();
        zoomBoxIn.activate();
    });
    $("#zoomfull_control").bind("click", function () {
    	wmsgetfeatureinfo_control.deactivate();
    	for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
        zoomBoxOut.deactivate();
        zoomBoxIn.deactivate();
        map.zoomToMaxExtent()
    });
    $("#identify_control").bind("click", function () {
    	wmsgetfeatureinfo_control.activate();
    	for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
        zoomBoxOut.deactivate();
        zoomBoxIn.deactivate();
    });
    $("#pan_control").bind("click", function () {
        wmsgetfeatureinfo_control.deactivate();
        for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
        zoomBoxOut.deactivate();
        zoomBoxIn.deactivate();
        dragControl.activate();
    });
    $("#navnext_control").bind("click", function () {
    	wmsgetfeatureinfo_control.deactivate();
    	for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
        zoomBoxOut.deactivate();
        zoomBoxIn.deactivate();
        nav.nextTrigger();
    });
    $("#navprev_control").bind("click", function () {
    	wmsgetfeatureinfo_control.deactivate();
    	for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
        zoomBoxOut.deactivate();
        zoomBoxIn.deactivate();
        nav.previousTrigger();
    });
    $("#linemeasure_control").bind("click", function () {
    	wmsgetfeatureinfo_control.deactivate();
    	for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
        zoomBoxOut.deactivate();
        zoomBoxIn.deactivate();
        toggleControl("line");
    });
    $("#polymeasure_control").bind("click", function () {
    	wmsgetfeatureinfo_control.deactivate();
    	for(key in measureControls) {
    		var control = measureControls[key];
       		control.deactivate();
        }
        zoomBoxOut.deactivate();
        zoomBoxIn.deactivate();
        toggleControl("polygon");
    });

    // update filter and redraw when form is submitted

    enableLegend();

    system_sites.events.register("visibilitychanged", system_sites, function(){
        system_site_cluster.setVisibility(false);
        enableLegend();
        updateFilter();
    });
    vsats.events.register("visibilitychanged", vsats, function(){
        vsat_cluster.setVisibility(false);
        enableLegend();
        updateFilter();
    });
    natpl.events.register("visibilitychanged", natpl, function(){
        enableLegend();
        updateFilter();
    });
    distpl.events.register("visibilitychanged", distpl, function(){
        enableLegend();
        updateFilter();
    });
    riverln.events.register("visibilitychanged", riverln, function(){
        enableLegend();
        updateFilter();
    });
    roadln.events.register("visibilitychanged", roadln, function(){
        enableLegend();
        updateFilter();
    });
    landusepl.events.register("visibilitychanged", landusepl, function(){
        enableLegend();
        updateFilter();
    });
    settelmentpl.events.register("visibilitychanged", settelmentpl, function(){
        enableLegend();
        updateFilter();
    });
    vdcpl.events.register("visibilitychanged", vdcpl, function(){
        enableLegend();
        updateFilter();
    });
    microwaves.events.register("visibilitychanged", microwaves, function(){
        enableLegend();
        updateFilter();
    });
    microwave_stations.events.register("visibilitychanged", microwave_stations, function(){
        microwavestations_cluster.setVisibility(false);
        enableLegend();
        updateFilter();
    });
    nodes.events.register("visibilitychanged", nodes, function(){
        enableLegend();
        updateFilter();
    });
    optical_links.events.register("visibilitychanged", optical_links, function(){
        enableLegend();
        updateFilter();
    });
    pstn_exchanges.events.register("visibilitychanged", pstn_exchanges, function(){
        enableLegend();
        updateFilter();
    });
    isp_wireless_sites.events.register("visibilitychanged", system_site_cluster, function(){
        enableLegend();
        updateFilter();
    });
    vsat_cluster.events.register("visibilitychanged", vsat_cluster, function(){
        vsats.setVisibility(false);
        enableLegend();
        updateFilter();
    });
    system_site_cluster.events.register("visibilitychanged", system_site_cluster, function(){
        system_sites.setVisibility(false);
        enableLegend();
        updateFilter();
    });
    microwavestations_cluster.events.register("visibilitychanged", microwavestations_cluster, function(){
        microwave_stations.setVisibility(false);
        enableLegend();
        updateFilter();
    });
});

function enableLegend(){
    if($("input[name='System Sites']:checked").length > 0){
        $("#system_sites").remove();
        $("<img src='" + gurl_legend + "nta:system_sites' style='display:block;padding-left:15px;' id='system_sites' />").insertAfter($("label:contains('System Sites')"));
        $("#system_sites").next('br').remove();
        $("#system_sites").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='VSATs']:checked").length > 0){
        $("#vsats").remove();
        $("<img src='" + gurl_legend + "nta:vsats' style='display:block;padding-left:15px;' id='vsats' />").insertAfter($("label:contains('VSATs')"));
        $("#vsats").next('br').remove();
        $("#vsats").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='Nepal']:checked").length > 0){
        $("#natpl").remove();
        $("<img src='" + gurl_legend + "nta:natpl' style='display:block;padding-left:15px;' id='natpl' />").insertAfter($("label:contains('Nepal')"));
        $("#natpl").next('br').remove();
        $("#natpl").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='District']:checked").length > 0){
        $("#distpl").remove();
        $("<img src='" + gurl_legend + "nta:distpl' style='display:block;padding-left:15px;' id='distpl' />").insertAfter($("label:contains('District')"));
        $("#distpl").next('br').remove();
        $("#distpl").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='River']:checked").length > 0){
        $("#riverln").remove();
        $("<img src='" + gurl_legend + "nta:river' style='display:block;padding-left:15px;' id='riverln' />").insertAfter($("label:contains('River')"));
        $("#riverln").next('br').remove();
        $("#riverln").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='Road']:checked").length > 0){
        $("#roadln").remove();
        $("<img src='" + gurl_legend + "nta:road' style='display:block;padding-left:15px;' id='roadln' />").insertAfter($("label:contains('Road')"));
        $("#roadln").next('br').remove();
        $("#roadln").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='Landuse']:checked").length > 0){
        $("#landusepl").remove();
        $("<img src='" + gurl_legend + "nta:landuse' style='display:block;padding-left:15px;' id='landusepl' />").insertAfter($("label:contains('Landuse')"));
        $("#landusepl").next('br').remove();
        $("#landusepl").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='Settelment']:checked").length > 0){
        $("#settelmentpl").remove();
        $("<img src='" + gurl_legend + "nta:settelment' style='display:block;padding-left:15px;' id='settelmentpl' />").insertAfter($("label:contains('Settelment')"));
        $("#settelmentpl").next('br').remove();
        $("#settelmentpl").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='VDC']:checked").length > 0){
        $("#vdcpl").remove();
        $("<img src='" + gurl_legend + "nta:vdcpl' style='display:block;padding-left:15px;' id='vdcpl' />").insertAfter($("label:contains('VDC')"));
        $("#vdcpl").next('br').remove();
        $("#vdcpl").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='Microwaves']:checked").length > 0){
        $("#microwaves").remove();
        $("<img src='" + gurl_legend + "nta:microwaves' style='display:block;padding-left:15px;' id='microwaves' />").insertAfter($("label:contains('Microwaves')"));
        $("#microwaves").next('br').remove();
        $("#microwaves").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='Microwave Stations']:checked").length > 0){
        $("#microwave_stations").remove();
        $("<img src='" + gurl_legend + "nta:microwave_stations' style='display:block;padding-left:15px;' id='microwave_stations' />").insertAfter($("label:contains('Microwave Stations')"));
        $("#microwave_stations").next('br').remove();
        $("#microwave_stations").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='Optical Nodes']:checked").length > 0){
        $("#optical_links").remove();
        $("<img src='" + gurl_legend + "nta:nodes' style='display:block;padding-left:15px;' id='nodes' />").insertAfter($("label:contains('Optical Nodes')"));
        $("#nodes").next('br').remove();
        $("#nodes").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='Optical Fibre']:checked").length > 0){
        $("#optical_links").remove();
        $("<img src='" + gurl_legend + "nta:optical_links' style='display:block;padding-left:15px;' id='optical_links' />").insertAfter($("label:contains('Optical Fibre')"));
        $("#optical_links").next('br').remove();
        $("#optical_links").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='PSTN Exchange']:checked").length > 0){
        $("#pstn_exchanges").remove();
        $("<img src='" + gurl_legend + "nta:pstn_exchanges' style='display:block;padding-left:15px;' id='pstn_exchanges' />").insertAfter($("label:contains('PSTN Exchange')"));
        $("#pstn_exchanges").next('br').remove();
        $("#pstn_exchanges").prev('label').attr('style','margin-bottom:0px');
    }
    if($("input[name='ISP Wireless Site']:checked").length > 0){
        $("#isp_wireless_sites").remove();
        $("<img src='" + gurl_legend + "nta:isp_wireless_sites' style='display:block;padding-left:15px;' id='isp_wireless_sites' />").insertAfter($("label:contains('ISP Wireless Site')"));
        $("#isp_wireless_sites").next('br').remove();
        $("#isp_wireless_sites").prev('label').attr('style','margin-bottom:0px');
    }
}
function printMap(){

//  $("div.olMap").nextAll().remove();
// // list.css('height','100%');
// $('aside.main-sidebar').remove();
// $('header.main-header').remove();
// $('div.box').remove();
//$('.right-side').remove();
// $("#OpenLayers_Map_2_OpenLayers_ViewPort").css('overflow','unset');

var content = $('div#map').html(); //has to be first.
var win = window.open();
console.log(content);
win.document.write(content);
$('.right-side').remove();
console.log(navigator.userAgent);

 if(navigator.userAgent.indexOf("Chrome") != -1)
    {

       setInterval(function(){
       win.print();
       return true;
       }, 500);

       setInterval(function(){
        win.close();
   // window.location.href="http://localhost/nta/maps";
   return true;
   }, 500);


    }
    else{
             win.print();
             win.close();
            // window.location.href="http://localhost/nta/maps";
    }


}
function printMaps1(){
    //var url = 'http://202.166.221.38:9090/geoserver/pdf/print.pdf?spec={"units":"degrees","srs":"EPSG:4326","layout":"A4","dpi":"300","maptitle":"This is the map title","comment":"This is the map comment","resourcesUrl": "http://202.166.221.38:9090/img","layers":[{"baseURL":"http://202.166.221.38:9090/geoserver/workspace/wms","opacity":1,"singleTile":true,"type":"WMS","layers":["nta:vsats"],"format":"image/jpeg","styles":[""]}],"pages":[{"center":[83.86, 28.48],"scale":500,"rotation":0}]}';
    var lay = '';
    $('.dataLayersDiv input:checked').each(function() {
        var layname = $(this).attr('name');
        if(layname == 'Nepal'){
            lay += 'nta:natpl,';
        }
        if(layname == 'District'){
            lay += 'nta:distpl,';
        }
        if(layname == 'River'){
            lay += 'nta:riverln,';
        }
        if(layname == 'Road'){
            lay += 'nta:roadln,';
        }
        if(layname == 'Landuse'){
            lay += 'nta:landusepl,';
        }
        if(layname == 'Settelment'){
            lay += 'nta:settelmentpl,';
        }
        if(layname == 'VDC'){
            lay += 'nta:vdcpl,';
        }
        if(layname == 'VSATs'){
            lay += 'nta:vsats,';
        }
        if(layname == 'System Sites'){
            lay += 'nta:system_sites,';
        }
        if(layname == 'Microwaves'){
            lay += 'nta:microwaves,';
        }
        if(layname == 'Microwave Stations'){
            lay += 'nta:microwave_stations,';
        }
        if(layname == 'Optical Nodes'){
            lay += 'nta:nodes,';
        }
        if(layname == 'Optical Fibre'){
            lay += 'nta:optical_links,';
        }
    });
    lay = lay.substring(0,lay.length - 1)
    var EPSG4326 = new OpenLayers.Projection("EPSG:4326");
    var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
    var bounds = map.getExtent().clone();
    bounds = bounds.transform(EPSG900913, EPSG4326);
    bbox = bounds.toBBOX();
    var url = 'http://localhost:9090/geoserver/nta/wms?service=WMS&version=1.1.0&request=GetMap&layers=' + lay + '&styles=&bbox=' + bbox + '&width=768&height=386&srs=EPSG:4326&format=application%2Fpdf';
  console.log(url);
    window.open(url, '_blank');
}

function mapLayerChanged(event){
    //$("<img src='http://202.166.221.38:9090/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=nta:system_sites' style='display:block;padding-left:15px;' />").insertAfter($("label:contains('System Sites')"));
}

function updateFilter() {
        var district = $("#district").val();
        var vdc = $("#vdc").val();
        var operator = $("#operator").val();
        var errflag = '0';
        delete vsats.params.CQL_FILTER;
        delete distpl.params.CQL_FILTER;
        delete riverln.params.CQL_FILTER;
        delete roadln.params.CQL_FILTER;
        delete landusepl.params.CQL_FILTER;
        delete settelmentpl.params.CQL_FILTER;
        delete system_sites.params.CQL_FILTER;
        delete microwave_stations.params.CQL_FILTER;
        //delete microwaves.params.CQL_FILTER;
        delete nodes.params.CQL_FILTER;
        delete optical_links.params.CQL_FILTER;
        var filterParams;
        if(vdc != '')
        {
            filterParams = {
              filter: null,
              cql_filter: "vdc_name LIKE '" + vdc + "'",
              featureId: null
            };
            vsats.mergeNewParams(filterParams);
            //new OpenLayers.StyleMap(style)
            //distpl.mergeNewParams(filterParams);
            handleZoomToExtent("vdcpl","vdc_name",vdc);
            district = '';

            //system_site.mergeNewParams(filterParams);
        }
        if(district != '')
        {
            filterParams = {
              filter: null,
              cql_filter: "district LIKE '" + district + "'",
              featureId: null
            };
            vsats.mergeNewParams(filterParams);
            //new OpenLayers.StyleMap(style)
            //distpl.mergeNewParams(filterParams);
            handleZoomToExtent("distpl","district",district);
            //system_site.mergeNewParams(filterParams);
        }

        if(River != '')
        {
            filterParams = {
              filter: null,
              cql_filter: "river LIKE '" + river + "'",
              featureId: null
            };
            vsats.mergeNewParams(filterParams);
            //new OpenLayers.StyleMap(style)
            //distpl.mergeNewParams(filterParams);
            handleZoomToExtent("riverln","river",river);
            //system_site.mergeNewParams(filterParams);
        }

        if(Road != '')
        {
            filterParams = {
              filter: null,
              cql_filter: "road LIKE '" + road + "'",
              featureId: null
            };
            vsats.mergeNewParams(filterParams);
            //new OpenLayers.StyleMap(style)
            //distpl.mergeNewParams(filterParams);
            handleZoomToExtent("roadln","road",road);
            //system_site.mergeNewParams(filterParams);
        }

        if(Landuse != '')
        {
            filterParams = {
              filter: null,
              cql_filter: "landuse LIKE '" + landuse + "'",
              featureId: null
            };
            vsats.mergeNewParams(filterParams);
            //new OpenLayers.StyleMap(style)
            //distpl.mergeNewParams(filterParams);
            handleZoomToExtent("landusepl","landuse",landuse);
            //system_site.mergeNewParams(filterParams);
        }
        if(Settelment != '')
        {
            filterParams = {
              filter: null,
              cql_filter: "settelment LIKE '" + settelment + "'",
              featureId: null
            };
            vsats.mergeNewParams(filterParams);
            //new OpenLayers.StyleMap(style)
            //distpl.mergeNewParams(filterParams);
            handleZoomToExtent("settelmentpl","settelment",settelment);
            //system_site.mergeNewParams(filterParams);
        }

        if(errflag != '')
        {
          filterParams = {
              filter: null,
              cql_filter: "errflag = '" + errflag + "'",
              featureId: null
          };
          vsats.mergeNewParams(filterParams);
          system_sites.mergeNewParams(filterParams);
          microwave_stations.mergeNewParams(filterParams);
          //microwaves.mergeNewParams(filterParams);
          //optical_links.mergeNewParams(filterParams);
          //nodes.mergeNewParams(filterParams);
        }
        if(operator != '')
        {
          filterParams = {
              filter: null,
              cql_filter: "oprcd LIKE '" + operator + "'",
              featureId: null
          };
          vsats.mergeNewParams(filterParams);
          system_sites.mergeNewParams(filterParams);
          microwave_stations.mergeNewParams(filterParams);
          //microwaves.mergeNewParams(filterParams);
          optical_links.mergeNewParams(filterParams);
          nodes.mergeNewParams(filterParams);
          //vsat_cluster.mergeNewParams(filterParams);
        }

        vsats.redraw();
        distpl.redraw();
        riverln.redraw();
        roadln.redraw();
        landusepl.redraw();
        settelmentpl.redraw();
        system_sites.redraw();
        microwave_stations.redraw();
        microwaves.redraw();
        optical_links.redraw();
        nodes.redraw();
        //vsat_cluster.redraw();
        //printMap();
        return false;
    }
    if((layer != '' && field != '' && val != '')){
        handleZoomToExtent(layer,field,val);
    }
    function handleZoomToExtent(layer,field,val) {
        var url = '{{ url("getExtent") }}' + '/' + layer + '/' + field + '/' + val;
        $.get(url , function(data){
            var extent = new OpenLayers.Bounds(data.xmin,data.ymin,data.xmax,data.ymax).transform('EPSG:4326', 'EPSG:900913');
            map.zoomToExtent(extent);
            switch(layer){
                case 'distpl':
                    distpl.setVisibility(true);
                    break;
                case 'riverln':
                    riverln.setVisibility(true);
                    break;
                case 'roadln':
                    roadln.setVisibility(true);
                    break;
                case 'landusepl':
                    landusepl.setVisibility(true);
                    break;
                 case 'settelmentpl':
                    settelmentpl.setVisibility(true);
                    break;
                case 'vdcpl':
                    vdcpl.setVisibility(true);
                    break;
                case 'vsats':
                    vsats.setVisibility(true);
                    break;
                case 'system_sites':
                    system_sites.setVisibility(true);
                    break;
                case 'microwaves':
                    microwaves.setVisibility(true);
                    break;
                case 'microwave_stations':
                    microwave_stations.setVisibility(true);
                    break;
                case 'optical_links':
                    optical_links.setVisibility(true);
                    break;
                case 'nodes':
                    nodes.setVisibility(true);
                    break;
                case 'isp_wireless_sites':
                    isp_wireless_sites.setVisibility(true);
                    break;
                case 'pstn_exchanges':
                    pstn_exchanges.setVisibility(true);
                    break;
                default:
                    //Statements executed when none of the values match the value of the expression
                    break;
            }
        });

    }


function handleMeasurements(event) {
            var geometry = event.geometry;
            var units = event.units;
            var order = event.order;
            var measure = event.measure;
            var element = document.getElementById('output');
            var out = "";
            if(order == 1) {
                out += "<b>measure: </b>" + measure.toFixed(3) + " " + units;
            } else {
                out += "<b>measure: </b>" + measure.toFixed(3) + " " + units + "<sup>2</" + "sup>";
            }
            element.innerHTML = out;
        }

        function toggleControl(keyval) {
            for(key in measureControls) {
            	if(key == keyval)
            	{
            		var control = measureControls[key];
               		control.activate();
            	}
            }
        }


    $('.dropdown-toggle').dropdown();
    $('ul.dropdown-menu input[type=checkbox], ul.dropdown-menu input[type=radio]').change(function(){
        $(this).closest('ul').closest('li').addClass('open');
    });
    $("#district").on('change',function(e){
        var id = e.target.value;
        var url = '{{ url("getVDC") }}' + '/' + id;
        $.get(url , function(data){
            //success data
            $('#vdc').html('<option value="">Select a VDC</option>');
            $.each(data, function(index, vdcObj){
                $('#vdc').append('<option value="' + vdcObj.vdc_name + '">' + vdcObj.vdc_name + '</option>');
            });
        });
    });
</script>
@endpush