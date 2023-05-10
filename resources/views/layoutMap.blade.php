<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $pageTitle }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link type="image/vnd.microsoft.icon" rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset("/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset("/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link href="{{ asset('/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/jquery.scrolling-tabs.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/theme/default/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
    <style type="text/css">
      body {
          overflow: hidden;
      }
      .sidebar-mini.sidebar-collapse .main-sidebar {
          width: 0 !important;
      }

      .navbar-offset {
          margin-top: 50px;
      }
      .map-container {
          position: relative;
      }
      .sidebar-mini.sidebar-collapse .map-container {
          margin-left: 0 !important;
      }
      #map {
          z-index: 35;
          position: absolute;
          top: 45px;
          bottom: 0;
          left: 0;
          right: 0;
      }
      /*#olmap .ol-zoom {
          font-size: 1.2em;
      }*/
      #olmap .ol-scale-line {
          left: 45px;
          background: rgba(0,0,0,0.8);
      }
      .zoom-top-opened-sidebar {
          margin-top: 5px;
      }
      .zoom-top-collapsed {
          margin-top: 45px;
      }

      .map-toolbar {
          z-index: 99;
          padding: 5px 0;
          border-bottom: 1px solid #ddd;
      }

      .controls-div ul {
          margin: 0;
          padding: 0;
      }

      .map-control-active {
          background: #d4efcb;
          border-color: #659e53;
      }

      .map-control-active:hover, .map-control-active:focus {
          background: #bfd8b6 !important;
          border-color: #59884a !important;
      }

      #map-right-sidebar {
          background: #fff;
          position: absolute;
          top: 0;
          bottom: 0;
          right: 0;
          width: 250px;
      }

      #popup-tab{
        display: inline-block;
      }
     

      #map-right-sidebar .tab-content {
          overflow-y: scroll;
          border-left: 1px solid #ddd;
      }

      #map-right-sidebar .tab-content .tab-pane {
          padding: 5px;
      }

      img.clip-legend {
          clip-path: inset(0 0 20px 0);
          margin-bottom: -20px;
      }

      .mini-submenu{
        display:none;
        background-color: rgba(255, 255, 255, 0.46);
        border: 1px solid rgba(0, 0, 0, 0.9);
        border-radius: 4px;
        padding: 4px;
        /*position: relative;*/
        width: 30px;
        text-align: center;
      }

      .mini-submenu-top-left {
        position: absolute;
        top: 60px;
        left: 10px;
        z-index: 40;
      }
      .mini-submenu-top-right {
        position: absolute;
        top: 60px;
        right: 10px;
        z-index: 40;
      }
      .mini-submenu-bottom-left {
        position: absolute;
        left: 10px;
        bottom: 4px;
        z-index: 40;
      }
      .sidebar-top-left {
          position: absolute;
          padding: 0;
          top: 60px;
          left: 0;
      }
      .sidebar-top-right {
          position: absolute;
          padding: 0;
          top: 60px;
          right: 0;
      }
      .sidebar-bottom-left {
          position: absolute;
          padding: 0;
          left: 25%;
          bottom: 4px;
      }
      .map-container .sidebar {
          min-height: auto;
      }
      .map-container .sidebar .panel-group {
          margin-bottom: 0;
      }
      .sidebar-bottom-left .panel-body {
          min-height: 150px !important;
          max-height: 150px !important;
          height: 150px !important;
          padding: 0;
      }
      .sidebar-bottom-left .panel-body iframe {
          width: 100%;
          height: 100%;
          display: block;
          border: none;
      }

      .sidebar {
          z-index: 45;
      }

      .main-row {
          position: relative; top: 0;
      }

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

      .olControlPanel div {
          display:block;
          width:  24px;
          height: 24px;
          margin: 5px;
          background-color:white;
        }

        .olControlPanel .olControlDrawFeatureItemActive {
          width:  22px;
          height: 22px;
          background-image: url("img/draw_line_on.png");
        }
        .olControlPanel .olControlDrawFeatureItemInactive {
          width:  22px;
          height: 22px;
          background-image: url("img/draw_line_off.png");
        }
        .olControlPanel .olControlZoomBoxItemInactive {
          width:  22px;
          height: 22px;
          background-color: orange;
          background-image: url("img/drag-rectangle-off.png");
        }
        .olControlPanel .olControlZoomBoxItemActive {
          width:  22px;
          height: 22px;
          background-color: blue;
          background-image: url("img/drag-rectangle-on.png");
        }
        .olControlPanel .olControlZoomToMaxExtentItemInactive {
          width:  18px;
          height: 18px;
          background-image: url("img/zoom-world-mini.png");
        }

        .sidebar .panel-body {
              min-height: 420px;
              max-height: 420px;
              overflow-y: auto;
        }

        #overlay_checkbox_container .collapse-heading a {
            color: #000;
        }

        #overlay_checkbox_container .collapse-heading a:before {
            content: "\f07c";
            font-family: FontAwesome;
            display: inline-block;
            width: 20px;
            color: #496d41;
        }

        #overlay_checkbox_container .collapse-heading a.collapsed:before {
            content: "\f07b";
        }

        #overlay_checkbox_container .collapse-body {
            padding-left: 20px;
        }

        #overlay_checkbox_container .checkbox {
            margin: 0;
        }

        #olmap .tooltip {
        position: relative;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 4px;
        color: white;
        padding: 4px 8px;
        opacity: 0.7;
        white-space: nowrap;
      }
      #olmap .tooltip-measure {
        opacity: 1;
        font-weight: bold;
      }
      #olmap .tooltip-static {
        background-color: #ffcc33;
        color: black;
        border: 1px solid white;
      }
      #olmap .tooltip-measure:before,
      #olmap .tooltip-static:before {
        border-top: 6px solid rgba(0, 0, 0, 0.5);
        border-right: 6px solid transparent;
        border-left: 6px solid transparent;
        content: "";
        position: absolute;
        bottom: -6px;
        margin-left: -7px;
        left: 50%;
      }
      #olmap .tooltip-static:before {
        border-top-color: #ffcc33;
      }

      .popup-tab{
        display: inline-block;
        
    background-color: white;
    -webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
    filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #cccccc;
    bottom: 12px;
      }
      .ol-tab{
        position: absolute;
    background-color: white;
    -webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
    filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #cccccc;
    bottom: 12px;
      }
      .ol-area-popup{
        position: absolute;
        background-color: white;
        -webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
        filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #cccccc;
        bottom: 12px;
        min-width: 150px;
      }
      .ol-popup {
        position: absolute;
        background-color: white;
        -webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
        filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #cccccc;
        bottom: 12px;
        min-width: 280px;
      }

  .ol-popup:after, .ol-popup:before {
        top: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
      }
      .ol-popup:after {
        border-top-color: white;
        border-width: 10px;
        left: 48px;
        margin-left: -10px;
      }
      .ol-popup:before {
        border-top-color: #cccccc;
        border-width: 11px;
        left: 48px;
        margin-left: -11px;
      }
      .ol-popup-closer {
        text-decoration: none;
        position: absolute;
        top: 2px;
        right: 8px;
      }
      .ol-popup-closer:after {
        content: "✖";
      }

      .ol-zoom {
          display: none;
      }

      #report-popup-content {
        max-height: 200px;
        overflow-y: scroll;
      }

      .ajax-modal {
        position: absolute;
        background-color: rgba(0,0,0,0.6);
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 99999;
        display: table;
        text-align: center;
    }
    .ajax-modal-content{
        display: table-cell;
        vertical-align: middle;
    }
    .ajax-modal-message {
        display: inline-block;
        padding: 15px;
        color: #a94442;
        background-color: #f2dede;
        border: 1px solid #ebccd1;
        border-radius: 4px;
    }
    .ajax-modal-message span {
        display: inline-block;
        padding-right: 15px;
    }
    .ajax-modal-close-btn {
        color: #8a6d3b;
        opacity: 0.4;
    }
    .ajax-modal-close-btn:hover {
        color: #000;
    }
    .loader {
        margin: 100px auto;
        font-size: 12px;
        width: 1em;
        height: 1em;
        border-radius: 50%;
        position: relative;
        text-indent: -9999em;
        -webkit-animation: load5 1.1s infinite ease;
        animation: load5 1.1s infinite ease;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
    }
    @-webkit-keyframes load5 {
        0%,
        100% {
            box-shadow: 0em -2.6em 0em 0em #ffffff, 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.5), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7);
        }
        12.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.7), 1.8em -1.8em 0 0em #ffffff, 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5);
        }
        25% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.5), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7), 2.5em 0em 0 0em #ffffff, 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        37.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5), 2.5em 0em 0 0em rgba(255, 255, 255, 0.7), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        50% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.5), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.7), 0em 2.5em 0 0em #ffffff, -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        62.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.5), 0em 2.5em 0 0em rgba(255, 255, 255, 0.7), -1.8em 1.8em 0 0em #ffffff, -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        75% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.5), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.7), -2.6em 0em 0 0em #ffffff, -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        87.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.5), -2.6em 0em 0 0em rgba(255, 255, 255, 0.7), -1.8em -1.8em 0 0em #ffffff;
        }
    }
    @keyframes load5 {
        0%,
        100% {
            box-shadow: 0em -2.6em 0em 0em #ffffff, 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.5), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7);
        }
        12.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.7), 1.8em -1.8em 0 0em #ffffff, 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5);
        }
        25% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.5), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7), 2.5em 0em 0 0em #ffffff, 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        37.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5), 2.5em 0em 0 0em rgba(255, 255, 255, 0.7), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        50% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.5), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.7), 0em 2.5em 0 0em #ffffff, -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        62.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.5), 0em 2.5em 0 0em rgba(255, 255, 255, 0.7), -1.8em 1.8em 0 0em #ffffff, -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        75% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.5), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.7), -2.6em 0em 0 0em #ffffff, -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
        }
        87.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.5), -2.6em 0em 0 0em rgba(255, 255, 255, 0.7), -1.8em -1.8em 0 0em #ffffff;
        }
    }

    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">

      @include('header')

      <!-- Left side column. contains the sidebar -->
      @include('sidebar')
      <!-- =============================================== -->
        @yield('content')
    </div><!-- ./wrapper -->
    <!-- REQUIRED JS SCRIPTS -->
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyDmVQe2fGH3kdKwNoP2mZJzoza2_J7WzKI&v=3&callback=initMap"></script>
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset ('/js/jquery-1.9.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('/js/bootstrap.min.js') }}"></script>
    <!--<script type="text/javascript" src="{{ asset ('/js/AnimatedCluster.js') }}"></script>-->
    <script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset ("/js/app.js") }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset ('/js/map_layout.js') }}"></script>

    <script src="{{ asset('/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.scrolling-tabs.min.js') }}"></script>
    <script src="{{ asset('/js/moment.min.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        setSidebarHeight();
        $('.main-sidebar .sidebar').mCustomScrollbar({
            theme:'minimal'
        });
      });

      $(window).resize(function(){
        setSidebarHeight();
      })

      function setSidebarHeight() {
        $('.main-sidebar .sidebar').css({
          height: $(window).innerHeight() - $('.main-sidebar .sidebar').offset().top + 'px'
        });
      }
    </script>
    @stack('scripts')
  </body>
</html>
