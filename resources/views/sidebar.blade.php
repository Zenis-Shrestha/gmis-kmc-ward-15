<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
     
            <li class="treeview">
                <a href="{{ action('HomeController@index') }}"><i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span></a>
            </li>
           
           
            <li class="treeview">
                <a href="{{ action('BuildingController@index') }}"><i class="fa fa-building-o" aria-hidden="true"></i><span>Buildings</span></a>
            </li>
          
            {{-- <li class="treeview">
                <a href="{{ action('BuildingBusinessController@index') }}"><i class="fa fa-briefcase" aria-hidden="true"></i><span>Buildings Business</span></a>
            </li> --}}
{{--         
            <li class="treeview">
                <a href="{{ action('BuildingRentController@index') }}"><i class="fa fa-sticky-note" aria-hidden="true"></i><span>Buildings Rent</span></a>
            </li> --}}
           
            {{-- <li class="treeview">
                <a href="#"><i class="fa fa-upload" aria-hidden="true"></i><span>Revenue</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  
                         <li  class="treeview"><a href="{{ action('TaxPaymentDashboardController@index') }}"><i class="fa fa-circle-o"></i><span>Dashboard </span></a></li>
                   
               
                          
                            <li  class="treeview"><a href=""><i class="fa fa-circle-o"></i><span> Data Import </span> <i class="fa fa-angle-left pull-right"></i></a>
                               
                                    <ul class="treeview-menu">
                                    
                                        <li  class="treeview"><a href="{{ action('TaxPaymentController@index') }}"><i class="fa fa-circle-o"></i>Building Tax</a></li>
                                    </ul>
                                
                            </li>   
                          
                </ul>
            </li> --}}
          
            {{-- <li class="treeview">
                <a href="{{ action('StreetController@index') }}"><i class="fa fa-road" aria-hidden="true"></i><span>Roads</span></a>
            </li>
            --}}
            <li class="treeview">
                <a href="{{ action('RoadController@index') }}"><i class="fa fa-road" aria-hidden="true"></i><span>Roads</span></a>

                <a href="{{ action('POIController@index') }}"><i class="fa fa-road" aria-hidden="true"></i><span>Point of Interest</span></a>
            </li>
            
            {{-- <li class="treeview">
                <a href="#"><i class="fa fa-bullseye" aria-hidden="true"></i><span>System Constants</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                 
                    <li><a href="{{ action('AddZoneController@index') }}"><i class="fa fa-circle-o"></i>Address Zones</a></li>
                  
                    <li><a href="{{ action('BuildingConstrController@index') }}"><i class="fa fa-circle-o"></i>Building Construction Types</a></li>
                   
                    <li><a href="{{ action('BuildingUseController@index') }}"><i class="fa fa-circle-o"></i>Building Uses</a></li>
                   
                    <li><a href="{{ action('DrnkWtrSrcController@index') }}"><i class="fa fa-circle-o"></i>Drinking Water Sources</a></li>
                  
                    <li><a href="{{ action('TaxStsCodeController@index') }}"><i class="fa fa-circle-o"></i>Tax Status Codes</a></li>
                  
                    <li><a href="{{ action('DrainageController@index') }}"><i class="fa fa-circle-o"></i>Drainages</a></li>
                   
                    <li><a href="{{ action('VerfYesNoController@index') }}"><i class="fa fa-circle-o"></i>Verification Status</a></li>
                    
                <li><a href="{{action('YesNoController@index')}}"><i class="fa fa-circle-o"></i>Yes No Status</a></li>
                   
                    {{-- <li><a href="{{ action('RoadHierarchyController@index') }}"><i class="fa fa-circle-o"></i>Road Hierarchies</a></li> --}}
                   
                    {{-- <li><a href="{{ action('RoadSurfaceController@index') }}"><i class="fa fa-circle-o"></i>Road Surfaces</a></li>
                 
                </ul>
            </li> --}} 
           
            <li class="treeview">
                <a href="#"><i class="fa fa-cog" aria-hidden="true"></i><span>Settings</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                   
                    <li><a href="{{ action('UserController@index') }}"><i class="fa fa-circle-o"></i>Users</a></li>
                   
                    <li><a href="{{ action('RoleController@index') }}"><i class="fa fa-circle-o"></i>Roles</a></li>
                   
                    <li><a href="{{ action('RolesPermissionsController@index') }}"><i class="fa fa-circle-o"></i>Permission</a></li>
                  
                </ul>
            </li>
           
            <li class="treeview">
                <a href="{{ action('MapsController@index') }}"><i class="fa fa-map-marker" aria-hidden="true"></i><span>View Map</span></a>
            </li>
            
        </ul>
    </section>
</aside>
