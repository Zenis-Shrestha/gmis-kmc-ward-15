<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GMIS</title>
	<link type="image/vnd.microsoft.icon" rel="shortcut icon" href="favicon.ico" />
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	 <div class="brand"><img src="{{ asset('img/logo.png') }}"> Dharan Municipality</div>
     <div class="address-bar">GIS-based Municipal Information System (GMIS)</div>
<div class="container-fluid loogin">
	@yield('content')
</div>
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        <strong>Developed by:</strong> <a href="http://www.innovativesolution.com.np">Innovative Solution Pvt. Ltd.</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright © 2017 <a href="#">GMIS</a>.</strong> All rights reserved.
</footer>

</body>
</html>
