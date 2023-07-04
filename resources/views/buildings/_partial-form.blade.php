<style>
      #map {
        width: 1000px;
        height: 900px; /* 100% of the viewport height - navbar height */
      }
      #olmap {
          width: 900px;
          height: 900px;
          border: 1px solid #000000;
          margin-top: 20px;
      }
      a.skiplink {
        position: absolute;
        clip: rect(1px, 1px, 1px, 1px);
        padding: 0;
        border: 0;
        height: 1px;
        width: 1px;
        overflow: hidden;
      }
      a.skiplink:focus {
        clip: auto;
        height: auto;
        width: auto;
        background-color: #fff;
        padding: 0.3em;
      }
      #map:focus {
        outline: #4A74A8 solid 0.15em;
      }
      .boxD{
          xdisplay: none;
      }
    </style>
<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">

<link rel="stylesheet" href="https://unpkg.com/ol-layerswitcher@3.8.3/dist/ol-layerswitcher.css" />
<style>
    .layer-switcher{
        top: 0.5em;
    }
    .layer-switcher button{
        width: 25px;
        height: 25px;
        background-position: unset;
        background-size: contain;
    }
</style>
<div class="box-body">
    <div class="form-group col-md-6">
        {!! Form::label('bin', __('Building Identification Number'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            @if(isset($building))
            {!! Form::label('bin', $building->bin, ['class' => 'form-control', 'placeholder' => __('Building Identification Number')]) !!}
            @else
            {!! Form::label('bin', $nextBin, ['class' => 'form-control', 'placeholder' => __('Building Identification Number')]) !!}
            @endif
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('bldgcd', __('Building Code'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('bldgcd', null, ['class' => 'form-control', 'placeholder' => __('Building Code')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('ward', __('Ward'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('ward', $wards, null, ['class' => 'form-control', 'placeholder' => __('--- Choose ward ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('tole', __('Place/Location'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('tole', null, ['class' => 'form-control', 'placeholder' => __('Place/Location')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('oldhno', __('Old House Number'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('oldhno', null, ['class' => 'form-control', 'placeholder' => __('Old House Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('haddr', __('Metric House Address'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('haddr', null, ['class' => 'form-control', 'placeholder' => __('Metric House Address')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('haddrplt', __('Metric House Address Plate Distributed (Y/N)'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::checkbox('haddrplt') !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('strtcd', __('Street'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('strtcd', $streets, null, ['class' => 'form-control', 'placeholder' => __('--- Choose street ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('bldguse', __('Building Use'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('bldguse', $buildingUses, null, ['class' => 'form-control', 'placeholder' => __('--- Choose building use ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('hownr', __('House Owner Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('hownr', null, ['class' => 'form-control', 'placeholder' => __('House Owner Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('owner_contact', __('House Owner Contact Number'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('owner_contact', null, ['class' => 'form-control', 'placeholder' => __('House Owner Contact Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('yoc', __('Year of Construction'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('yoc', null, ['class' => 'form-control', 'placeholder' => __('Year of Construction')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('flrcount', __('Number of Floors'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('flrcount', null, ['class' => 'form-control', 'placeholder' => __('Number of Floors')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
                {!! Form::label('flrar', __('Floor Area In Sqft'), ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                   {!! Form::text('flrar', null, ['class' => 'form-control', 'placeholder' => __('Floor Area In Sqft')]) !!}
                </div>
    </div>
            
    <div class="form-group col-md-6">
        {!! Form::label('bprmtno', __('Building Permit Number'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('bprmtno', null, ['class' => 'form-control', 'placeholder' => __('Building Permit Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('consttyp', __('Construction Type'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('consttyp', $constructionTypes, null, ['class' => 'form-control', 'placeholder' => __('--- Choose construction type ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('toilyn', __('Toilet'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('toilyn', $yesNo, null, ['class' => 'form-control', 'placeholder' => __('--- Choose option ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('hhcount', __('Number of households'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('hhcount', null, ['class' => 'form-control', 'placeholder' => __('Number of households')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('hhpop', __('Household populations'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('hhpop', null, ['class' => 'form-control', 'placeholder' => __('Household populations')]) !!}
        </div>
    </div>
    {{-- <div class="form-group col-md-6">
        {!! Form::label('txpyrid', __('Tax Payer\'s ID'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('txpyrid', null, ['class' => 'form-control', 'placeholder' => __('Tax Payer\'s ID')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('txpyrname', __('Tax Payer\'s Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('txpyrname', null, ['class' => 'form-control', 'placeholder' => __('Tax Payer\'s Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('btxsts', __('Building Tax Paid Status'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('btxsts', $taxStatuses, null, ['class' => 'form-control', 'placeholder' => __('--- Choose tax paid status ---')]) !!}
        </div>
    </div> --}}

    <div class="form-group col-md-6">
        {!! Form::label('sngwoman', __('Single Woman'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('sngwoman', null, ['class' => 'form-control', 'placeholder' => __('Single Woman')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('gt60yr', __('Greater than 60 year'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('gt60yr', null, ['class' => 'form-control', 'placeholder' => __('Greater than 60 year')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('dsblppl', __('Number of disabled people'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('dsblppl', null, ['class' => 'form-control', 'placeholder' => __('Number of disabled people')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('offcnm', __('Office Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('offcnm', null, ['class' => 'form-control', 'placeholder' => __('Office Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
                {!! Form::label('house_new_photo','House Photo',['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::file('house_new_photo', ['class' => 'form-control']) !!}
                </div>
    </div>
    <div class="form-group col-md-6">
       {!! Form::label('footprint_option','Footprint',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            <input type="radio" name="footprint_option" value="draw_plygon" {{ (@$geom)? "checked" : "checked" }} > Draw Polygon
            @if(!@$building)
            <input type="radio" name="footprint_option" value="upload_kml"> KML
            @endif
        </div>
        
        
    </div>
    <div class="form-group col-md-6 row"></div>
    @if(!@$building)
    <div class="form-group col-md-12 upload_kml boxD">
                {!! Form::label('kml_file','KML File',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::file('kml_file', ['class' => 'form-control']) !!}
                </div>
    </div>
    @endif
    <div class="form-group col-md-12 row draw_plygon boxD" >
            {!! Form::label('geom','Draw Building Polygon',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <a class="skiplink" href="#map">Go to map</a>
            <!--<div id="map" class="map" tabindex="0">-->
                <div id="olmap"></div>
            <div id="popup" class="ol-popup" style="display: none;">
                <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                <div id="popup-content"></div>
            </div>

            </div>
            <input type="hidden" name="geom" id="geom" value="{{ @$geom }}" />
    </div>
</div>

<div class="box-footer">
    <a href="{{ action('BuildingController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.chosen-select').chosen();
   
    $('input[name="footprint_option"]:radio').click(function(){
        var inputValue = $(this).attr("value");
        console.log(inputValue);
        var targetBox = $("." + inputValue);
        console.log(targetBox);
        $(".boxD").not(targetBox).css('display', 'none');
        $(targetBox).css('display', 'block');
    });
});
</script>

    <script src="https://openlayers.org/en/v4.6.5/build/ol.js"></script>
    <script src="https://unpkg.com/ol-layerswitcher@3.8.3"></script>
    <script>

        var workspace = '<?php echo Config::get("constants.GEOSERVER_WORKSPACE"); ?>';
        // URL of GeoServer
        var gurl = "<?php echo Config::get("constants.GURL_URL"); ?>/";
        var gurl_wms = gurl + 'wms';
        var gurl_wfs = gurl + 'wfs';
        var authkey = '<?php echo Config::get("constants.AUTH_KEY"); ?>';
        // URL of GeoServer Legends
        var gurl_legend = gurl_wms + "?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=";
         var munipl = new ol.layer.Image({
            visible: true,
            title: "Municipality Boundary",
            source: new ol.source.ImageWMS({
                url: gurl_wms,
                params: {
                    'LAYERS': workspace + ':' + 'munipl',
                    'TILED': true,
                },
                serverType: 'geoserver',
//crossOrigin: 'anonymous'
                transition: 0,
            })
        });
        var buildingsLayer = new ol.layer.Image({
            visible: true,
            title: "Buildings",
            source: new ol.source.ImageWMS({
                url: gurl_wms,
                params: {
                    'LAYERS': workspace + ':' + 'bldg',
                    'TILED': true,
                    'STYLES': 'bldg_none'
                },
                serverType: 'geoserver',
                //crossOrigin: 'anonymous'
                transition: 0,
            })
        });
    
        var wardsLayer = new ol.layer.Tile({
            visible: true,
            title: "Wards",
            source: new ol.source.TileWMS({
                url: gurl_wms,
                params: {
                    'LAYERS': workspace + ':' + 'wardpl',
                    'TILED': true,
                    'STYLES': 'wardpl_none'

                },
                serverType: 'geoserver',
                //crossOrigin: 'anonymous'
                transition: 0,
            })
        });
       

        var googleLayerHybrid =new ol.layer.Tile({
            visible:false,
            title: "Google Satellite & Roads",
            type: "base",
            source: new ol.source.TileImage({ url: 'http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}' }),
        });
        var googleLayerRoadmap=new ol.layer.Tile({
            title: "Google Road Map",
            type: "base",
            source: new ol.source.TileImage({ url: 'http://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}' }),
        });

        var layerSwitcher = new LayerSwitcher({
            startActive: true,
            reverse: true,
            groupSelectStyle: 'group'
        });
        var map = new ol.Map({
            interactions: ol.interaction.defaults({
                altShiftDragRotate: false,
                dragPan: false,
                rotate: false,
                // mouseWheelZoom: false,
                doubleClickZoom: false
            }).extend([new ol.interaction.DragPan({kinetic: null})]),
            target: 'olmap',
            controls: ol.control.defaults({ attribution: false }),
            layers: [
                new ol.layer.Group({
                    title: 'Base maps',
                    layers: [
                        googleLayerHybrid,googleLayerRoadmap
                    ]
                }),
                new ol.layer.Group({
                    title: 'Layers',
                    fold: 'open',
                    layers: [
                        munipl,wardsLayer,buildingsLayer
                    ]
                })
            ],
            view: new ol.View({
                center: ol.proj.transform([87.2751,26.7981], 'EPSG:4326', 'EPSG:3857'),
                // zoom: 12,
                minZoom: 12.5,
                maxZoom: 22,
                //extent: ol.proj.transformExtent([85.32348539192756,27.58711426558866,85.44082675863419, 27.684646263435823 ], 'EPSG:4326', 'EPSG:3857')
            })
        });
        map.addControl(layerSwitcher);
        var eLayer = {};
        // Add extra overlay to Extra Overlays Object
        function addExtraLayer(key, name, layer) {
            // adding as property of Extra Overlays Object
            eLayer[key] = { name: name, layer: layer };

            // Adding layer to OpenLayers Map
            map.addLayer(layer);

        }
        if(!eLayer.report_polygon_buffer) {
            var reportPolygonBufferLayer = new ol.layer.Vector({

                source: new ol.source.Vector(),
                style: new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: '#0000FF',
                        width: 3
                    }),
                })
            });


            addExtraLayer('report_polygon_buffer', 'Report Polygon Buffer', reportPolygonBufferLayer);
        }
        draw = new ol.interaction.Draw({
            source: eLayer.report_polygon_buffer.layer.getSource(),
            type: 'Polygon'
        });
        map.addInteraction(draw);
        draw.on('drawstart', function(evt){
            eLayer.report_polygon_buffer.layer.getSource().clear();
        });
        draw.on('drawend', function(evt){
            var format = new ol.format.WKT();
            var geom = format.writeGeometry(evt.feature.getGeometry().clone().transform('EPSG:3857', 'EPSG:4326'));
            $('#geom').val(geom);
        });
        <?php if(@$geom) { ?>
        var format = new ol.format.WKT();
        var feature = format.readFeature('<?php echo $geom; ?>', {
            dataProjection: 'EPSG:4326',
            featureProjection: 'EPSG:3857'
        });

        eLayer.report_polygon_buffer.layer.getSource().addFeature(feature);

        <?php } ?>
        setInitialZoom();

        function setInitialZoom() {
            @if(isset($building) && $lat && $long)
            map.getView().setCenter(ol.proj.transform([<?php echo $long;?>, <?php echo $lat;?>], 'EPSG:4326', 'EPSG:3857'));
            map.getView().setZoom(18);
            @else
            map.getView().setCenter(ol.proj.transform([87.2751,26.7981], 'EPSG:4326', 'EPSG:3857'));
            map.getView().setZoom(12);
            @endif
        }
        $(document).ready(function(){

            @isset($hotspotIdentification->date_added)
                $('.date').datepicker().datepicker('setDate',moment("{{$hotspotIdentification->date_added}}").format('YYYY/MM/DD'));
            @endisset

            $('.chosen-select').chosen();

            $('#getpointbycoordinates_control').click(function(e){
                e.preventDefault();
                disableAllControls();
                $('.map-control').removeClass('map-control-active');
                currentControl = '';

                $('#coordinate_search_modal').modal('show');
            });

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

            map.on('singleclick', function (evt) {
                //map.on('singleclick', displayCoordinateInformation);
            });



            function displayAjaxLoader() {
                if($('.ajax-modal').length == 0) {
                    $('body').append('<div class="ajax-modal"><div class="ajax-modal-content"><div class="loader"></div></div></div>');
                }
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
            function removeAjaxLoader() {
                $('.ajax-modal').remove();
            }

            // Display information about coordinate
            function displayCoordinateInformation(evt) {
                var coordinate = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
                var html = '';
                html += '<div style="padding:10px;">';
                html += '<form class="form-inline" id="feature_info_form">';
                html += ' <div class="form-group">';
                html += '<div class="input-group">';
                html += '<select class="form-control" id="ward_select" name="ward_select">';
                html += ' <option value="">Select a ward</option>';
                html += ' <option value="1">1</option>';
                html += ' <option value="2">2</option>';
                html += ' <option value="3">3</option>';
                html += ' <option value="4">4</option>';
                html += ' <option value="5">5</option>';
                html += ' <option value="6">6</option>';
                html += ' <option value="7">7</option>';
                html += ' <option value="8">8</option>';
                html += ' <option value="9">9</option>';
                html += ' <option value="10">10</option>';
                html += ' </select>';
                html += ' <span class="input-group-btn">';
                html += ' <button type="submit" class="btn btn-default">';
                html += ' <i class="fa fa-search"></i>';
                html += ' </button>';
                html += ' </span>';
                html += ' </div>';
                html += ' </div>';
                html += ' <input type="hidden" id="feature_info_long" value="" />';
                html += ' <input type="hidden" id="feature_info_lat" value="" />';
                html += ' </form></div>';
                popupContent.innerHTML = html;
                popupOverlay.setPosition(evt.coordinate);
            }


            $(document).on('change','#ward',function(){
                var ward =  this.value;
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
                //displayAjaxLoader();
                var url = '{{ url("hotspot-identifications/ward-center-coordinates") }}';
                $.ajax({
                    url:url,
                    type: 'get',
                    data: { ward: ward },
                    success: function(data){

//                        if(data.geom) {
//                            var format = new ol.format.WKT();
//                            var feature = format.readFeature(data.geom, {
//                                dataProjection: 'EPSG:4326',
//                                featureProjection: 'EPSG:3857'
//                            });
//
//                            if(feature.getGeometry() instanceof ol.geom.MultiLineString) {
//                                eLayer.searchResultMarkers.layer.getSource().addFeature(feature);
//                            }
//                        }
//                        handleZoomToExtent('jhe_wardpl', 'ward', ward, false, function(){
//                            removeAjaxLoader();
//                        });
                        var format = new ol.format.WKT();


                        var feature = format.readFeature(data.geom, {
                            dataProjection: 'EPSG:4326',
                            featureProjection: 'EPSG:3857'
                        });

                        feature.setStyle(
                            new ol.style.Style({
                                stroke: new ol.style.Stroke({color: '#00bfff',
                                    width: 3
                                })
                            })
                        );
                        eLayer.searchResultMarkers.layer.getSource().addFeature(feature);
                        handleZoomToExtent('jhe_wardpl', 'ward', data.ward, false, function(){
                            removeAjaxLoader();
                        });

                    },
                    error: function(data) {
                        displayAjaxError();
                    }
                });
            });

            function handleZoomToExtent(layer, field, val, showMarker, callback) {
                var url = '{{ url("getExtent") }}' + '/' + layer + '/' + field + '/' + val;
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data){
                        var extent = ol.proj.transformExtent([parseFloat(data.xmin), parseFloat(data.ymin), parseFloat(data.xmax), parseFloat(data.ymax)], 'EPSG:4326', 'EPSG:3857');
                        map.getView().fit(extent);

                        if(showMarker) {

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

                        //showLayer(layer);

                        if(callback) {
                            callback();
                        }
                    },
                    error: function(data) {

                    }
                });
            }
            
               
               $('#strtcd').prepend('<option selected="">{{$building->strtcd ?? '' }}</option>').select2({
                    ajax: {
                        url:"{{ route('buildings.get-street-names') }}",
                        data: function (params) {
                            return {
                                search: params.term,
                                page: params.page || 1
                            };
                        },
                    },
                    placeholder: 'Street Name',
                    allowClear: true,
                    closeOnSelect: true,
                });

                  
        });
    </script>
@endpush