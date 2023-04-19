<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $pageTitle }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link type="image/vnd.microsoft.icon" rel="shortcut icon" href="favicon.ico" />
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/css/bootstrap.min.css ") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset("/css/font-awesome.min.css ") }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/css/AdminLTE.min.css ")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset("/datatables/dataTables.bootstrap.css ")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/css/skins/_all-skins.min.css ")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/autocomplete/jquery-ui.min.css ")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/chosen.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/select2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/css/style.css ")}}" rel="stylesheet" type="text/css" /> @stack('style')
    <link
href="http://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.1.min.css"
rel="stylesheet" type="text/css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue sidebar-fixed sidebar-mini">
    <div class="wrapper">
        <!-- Header -->
        @include('header')
        <!-- Sidebar -->
        @include('sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
            {{ $pageTitle }}
            <small></small>
          </h1>
                <!-- You can dynamically generate breadcrumbs here -->
                <!--
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
          </ol>-->
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @include('flash::message') @yield('content') @include('footer')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Footer -->
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED JS SCRIPTS -->
    <!-- jQuery 2.1.4 -->
    <script src="{{ asset("/js/jQuery-2.1.4.min.js ") }}"></script>
    <script src="{{ asset("/autocomplete/jquery-ui.min.js ") }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset("/js/bootstrap.min.js ") }}" type="text/javascript"></script>
    <script src="{{ asset("/datatables/jquery.dataTables.min.js ") }}" type="text/javascript"></script>
    <script src="{{ asset("/datatables/dataTables.bootstrap.min.js ") }}" type="text/javascript"></script>
    <script src="{{ asset("/datatables/extensions/tool/dataTables.tableTools.min.js ") }}" type="text/javascript"></script>
    <script src="{{ asset('/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('/js/Chart.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("/js/app.js ") }}" type="text/javascript"></script>
    <script src="{{ asset('/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <script
src="http://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.1.min.js"
type="text/javascript"></script>
    @stack('scripts')
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->
</body>

</html>
