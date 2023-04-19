<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="{{ url('/') }}" class="logo">
    <span class="logo-mini"><img src="{{ asset("/img/logo.png") }}" style="width:40px;" alt="Logo"/></span>
    <span class="logo-lg">
    	<div class="logo-image">
	    	<div class="pull-left"><img src="{{ asset("/img/logo.png") }}" style="width:40px;" alt="Logo"/></div>
	    	<div class="logo-side"> 
		    	<p>GMIS</p>
		    	<h2>Dharan Municipality</h2>
	    	</div> 
    	</div>
    	
    </span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu top-dash">
      <ul class="nav navbar-nav">
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <i class="fa fa-user"></i>
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="{{ url('/logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out pull-right"></i>  
                Sign out
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>