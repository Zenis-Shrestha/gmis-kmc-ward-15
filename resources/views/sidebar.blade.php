<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="{{ action('HomeController@index') }}"><i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span></a>
            </li>
            @ability('super-admin', 'list-buildings')
            <li class="treeview">
                <a href="{{ action('BuildingController@index') }}"><i class="fa fa-building-o" aria-hidden="true"></i><span>Buildings</span></a>
            </li>
            @endability
            @ability('super-admin', 'list-buildings-business')
            <li class="treeview">
                <a href="{{ action('BuildingBusinessController@index') }}"><i class="fa fa-briefcase" aria-hidden="true"></i><span>Buildings Business</span></a>
            </li>
            @endability
            @ability('super-admin', 'list-buildings-rent')
            <li class="treeview">
                <a href="{{ action('BuildingRentController@index') }}"><i class="fa fa-sticky-note" aria-hidden="true"></i><span>Buildings Rent</span></a>
            </li>
            @endability

            @ability('super-admin', 'list-roads')
            <li class="treeview">
                <a href="#"><i class="fa fa-upload" aria-hidden="true"></i><span>Revenue</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                     @ability('super-admin', 'list-building-tax')
                   <li><a href="{{ action('TaxPaymentDashboardController@index') }}"><i class="fa fa-circle-o"></i><span>Dashboard </span></a></li>
                    @endability
               
                     @ability('super-admin', 'list-building-tax')
                    <li><a href=""><i class="fa fa-circle-o"></i><span> Data Import </span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                            @ability('super-admin', 'list-building-tax')
                        <li><a href="{{ action('TaxPaymentController@index') }}"><i class="fa fa-circle-o"></i>Building Tax</a></li>
                        @endability
                         @ability('super-admin', 'list-add-zones')
                          <li><a href="{{ action('AddZoneController@index') }}"><i class="fa fa-circle-o"></i>Business Tax</a></li>
                        @endability
                           @ability('super-admin', 'list-add-zones')
                          <li><a href="{{ action('AddZoneController@index') }}"><i class="fa fa-circle-o"></i>Rents Tax</a></li>
                            @endability
                            </ul>

                    
                    </li>   
                    @endability
                </ul>
            </li>
            @endability
            
            @ability('super-admin', 'list-streets')
            <li class="treeview">
                <a href="{{ action('StreetController@index') }}"><i class="fa fa-road" aria-hidden="true"></i><span>Streets</span></a>
            </li>
            @endability
            @ability('super-admin', 'list-roads')
            <li class="treeview">
                <a href="{{ action('RoadController@index') }}"><i class="fa fa-road" aria-hidden="true"></i><span>Roads</span></a>
            </li>
            @endability

            @ability('super-admin', 'list-add-zones,list-building-constructions,list-building-uses,list-water-srcs,list-tax-sts-codes,list-drainages,list-verf-yes-nos,list-yes-nos,list-road-hierarchies,list-road-surfaces')
            <li class="treeview">
                <a href="#"><i class="fa fa-bullseye" aria-hidden="true"></i><span>System Constants</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @ability('super-admin', 'list-add-zones')
                    <li><a href="{{ action('AddZoneController@index') }}"><i class="fa fa-circle-o"></i>Address Zones</a></li>
                    @endability
                    @ability('super-admin', 'list-building-constructions')
                    <li><a href="{{ action('BuildingConstrController@index') }}"><i class="fa fa-circle-o"></i>Building Construction Types</a></li>
                    @endability
                    @ability('super-admin', 'list-building-uses')
                    <li><a href="{{ action('BuildingUseController@index') }}"><i class="fa fa-circle-o"></i>Building Uses</a></li>
                    @endability
                    @ability('super-admin', 'list-water-srcs')
                    <li><a href="{{ action('DrnkWtrSrcController@index') }}"><i class="fa fa-circle-o"></i>Drinking Water Sources</a></li>
                    @endability
                    @ability('super-admin', 'list-tax-sts-codes')
                    <li><a href="{{ action('TaxStsCodeController@index') }}"><i class="fa fa-circle-o"></i>Tax Status Codes</a></li>
                    @endability
                    @ability('super-admin', 'list-drainages')
                    <li><a href="{{ action('DrainageController@index') }}"><i class="fa fa-circle-o"></i>Drainages</a></li>
                    @endability
                    @ability('super-admin', 'list-verf-yes-nos')
                    <li><a href="{{ action('VerfYesNoController@index') }}"><i class="fa fa-circle-o"></i>Verification Status</a></li>
                    @endability
                    @ability('super-admin', 'list-yes-nos')
                    <li><a href="{{ action('YesNoController@index') }}"><i class="fa fa-circle-o"></i>Yes No Status</a></li>
                    @endability
                    @ability('super-admin', 'list-road-hierarchies')
                    <li><a href="{{ action('RoadHierarchyController@index') }}"><i class="fa fa-circle-o"></i>Road Hierarchies</a></li>
                    @endability
                    @ability('super-admin', 'list-road-surfaces')
                    <li><a href="{{ action('RoadSurfaceController@index') }}"><i class="fa fa-circle-o"></i>Road Surfaces</a></li>
                    @endability
                </ul>
            </li>
            @endability
            @ability('super-admin', 'list-users,list-roles,assign-permissions')
            <li class="treeview">
                <a href="#"><i class="fa fa-cog" aria-hidden="true"></i><span>Settings</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @ability('super-admin', 'list-users')
                    <li><a href="{{ action('UserController@index') }}"><i class="fa fa-circle-o"></i>Users</a></li>
                    @endability
                    @ability('super-admin', 'list-roles')
                    <li><a href="{{ action('RoleController@index') }}"><i class="fa fa-circle-o"></i>Roles</a></li>
                    @endability
                    @ability('super-admin', 'assign-permissions')
                    <li><a href="{{ action('RolesPermissionsController@index') }}"><i class="fa fa-circle-o"></i>Permission</a></li>
                    @endability
                </ul>
            </li>
            @endability
            @ability('super-admin', 'view-map')
            <li class="treeview">
                <a href="{{ action('MapsController@index') }}"><i class="fa fa-map-marker" aria-hidden="true"></i><span>View Map</span></a>
            </li>
            @endability
        </ul>
    </section>
</aside>
