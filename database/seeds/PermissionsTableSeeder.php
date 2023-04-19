<?php

use App\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $permissions = array(
//            array('name' => 'list-users', 'display_name' => 'List Users'),
//            array('name' => 'view-user', 'display_name' => 'View User'),
//            array('name' => 'add-user', 'display_name' => 'Add User'),
//            array('name' => 'edit-user', 'display_name' => 'Edit User'),
//            array('name' => 'delete-user', 'display_name' => 'Delete User'),
//
//            array('name' => 'list-roles', 'display_name' => 'List Roles'),
//            array('name' => 'view-role', 'display_name' => 'View Role'),
//            array('name' => 'add-role', 'display_name' => 'Add Role'),
//            array('name' => 'edit-role', 'display_name' => 'Edit Role'),
//            array('name' => 'delete-role', 'display_name' => 'Delete Role'),
//
//            array('name' => 'assign-permissions', 'display_name' => 'Assign Permissions'),
//
//            array('name' => 'import-excel', 'display_name' => 'Import from Excel'),
//
//            array('name' => 'view-map', 'display_name' => 'View Map'),
//
//            array('name' => 'list-buildings', 'display_name' => 'List Buildings'),
//            array('name' => 'view-building', 'display_name' => 'View Building'),
//            array('name' => 'add-building', 'display_name' => 'Add Building'),
//            array('name' => 'edit-building', 'display_name' => 'Edit Building'),
//            array('name' => 'delete-building', 'display_name' => 'Delete Building'),
//            array('name' => 'export-buildings-excel', 'display_name' => 'Export Buildings to Excel'),
//            array('name' => 'export-buildings-shape', 'display_name' => 'Export Buildings to Shape'),
//            array('name' => 'export-buildings-kml', 'display_name' => 'Export Buildings to KML'),
//            
//            array('name' => 'list-streets', 'display_name' => 'List Streets'),
//            array('name' => 'view-street', 'display_name' => 'View Street'),
//            array('name' => 'add-street', 'display_name' => 'Add Street'),
//            array('name' => 'edit-street', 'display_name' => 'Edit Street'),
//            array('name' => 'delete-street', 'display_name' => 'Delete Street'),
//            array('name' => 'export-streets-excel', 'display_name' => 'Export Streets to Excel'),
//            array('name' => 'export-streets-shape', 'display_name' => 'Export Streets to Shape'),
//            array('name' => 'export-streets-kml', 'display_name' => 'Export Streets to KML'),
//            
//            array('name' => 'list-add-zones', 'display_name' => 'List Address Zones'),
//            array('name' => 'view-add-zone', 'display_name' => 'View Address Zone'),
//            array('name' => 'add-add-zone', 'display_name' => 'Add Address Zone'),
//            array('name' => 'edit-add-zone', 'display_name' => 'Edit Address Zone'),
//            array('name' => 'delete-add-zone', 'display_name' => 'Delete Address Zone'),
//            
//            array('name' => 'list-building-constructions', 'display_name' => 'List Building Construction Types'),
//            array('name' => 'view-building-construction', 'display_name' => 'View Building Construction Type'),
//            array('name' => 'add-building-construction', 'display_name' => 'Add Building Construction Type'),
//            array('name' => 'edit-building-construction', 'display_name' => 'Edit Building Construction Type'),
//            array('name' => 'delete-building-construction', 'display_name' => 'Delete Building Construction Type'),
//            
//            array('name' => 'list-building-uses', 'display_name' => 'List Building Uses'),
//            array('name' => 'view-building-use', 'display_name' => 'View Building Use'),
//            array('name' => 'add-building-use', 'display_name' => 'Add Building Use'),
//            array('name' => 'edit-building-use', 'display_name' => 'Edit Building Use'),
//            array('name' => 'delete-building-use', 'display_name' => 'Delete Building Use'),
//            
//            array('name' => 'list-water-srcs', 'display_name' => 'List Drinking Water Sources'),
//            array('name' => 'view-water-src', 'display_name' => 'View Drinking Water Source'),
//            array('name' => 'add-water-src', 'display_name' => 'Add Drinking Water Source'),
//            array('name' => 'edit-water-src', 'display_name' => 'Edit Drinking Water Source'),
//            array('name' => 'delete-water-src', 'display_name' => 'Delete Drinking Water Source'),
//            
//            array('name' => 'list-tax-sts-codes', 'display_name' => 'List Tax Status Codes'),
//            array('name' => 'view-tax-sts-code', 'display_name' => 'View Tax Status Code'),
//            array('name' => 'add-tax-sts-code', 'display_name' => 'Add Tax Status Code'),
//            array('name' => 'edit-tax-sts-code', 'display_name' => 'Edit Tax Status Code'),
//            array('name' => 'delete-tax-sts-code', 'display_name' => 'Delete Tax Status Code'),
//            
//            array('name' => 'list-drainages', 'display_name' => 'List Drainages'),
//            array('name' => 'view-drainage', 'display_name' => 'View Drainage'),
//            array('name' => 'add-drainage', 'display_name' => 'Add Drainage'),
//            array('name' => 'edit-drainage', 'display_name' => 'Edit Drainage'),
//            array('name' => 'delete-drainage', 'display_name' => 'Delete Drainage'),
//            
//            array('name' => 'list-verf-yes-nos', 'display_name' => 'List Verification Status'),
//            array('name' => 'view-verf-yes-no', 'display_name' => 'View Verification Status'),
//            array('name' => 'add-verf-yes-no', 'display_name' => 'Add Verification Status'),
//            array('name' => 'edit-verf-yes-no', 'display_name' => 'Edit Verification Status'),
//            array('name' => 'delete-verf-yes-no', 'display_name' => 'Delete Verification Status'),
//            
//            array('name' => 'list-yes-nos', 'display_name' => 'List Yes No Status'),
//            array('name' => 'view-yes-no', 'display_name' => 'View Yes No Status'),
//            array('name' => 'add-yes-no', 'display_name' => 'Add Yes No Status'),
//            array('name' => 'edit-yes-no', 'display_name' => 'Edit Yes No Status'),
//            array('name' => 'delete-yes-no', 'display_name' => 'Delete Yes No Status'),
//            
//            array('name' => 'list-road-hierarchies', 'display_name' => 'List Road Hierarchies'),
//            array('name' => 'view-road-hierarchy', 'display_name' => 'View Road Hierarchy'),
//            array('name' => 'add-road-hierarchy', 'display_name' => 'Add Road Hierarchy'),
//            array('name' => 'edit-road-hierarchy', 'display_name' => 'Edit Road Hierarchy'),
//            array('name' => 'delete-road-hierarchy', 'display_name' => 'Delete Road Hierarchy'),
//            
//            array('name' => 'list-road-surfaces', 'display_name' => 'List Road Surfaces'),
//            array('name' => 'view-road-surface', 'display_name' => 'View Road Surface'),
//            array('name' => 'add-road-surface', 'display_name' => 'Add Road Surface'),
//            array('name' => 'edit-road-surface', 'display_name' => 'Edit Road Surface'),
//            array('name' => 'delete-road-surface', 'display_name' => 'Delete Road Surface'),
//
//            array('name' => 'list-roads', 'display_name' => 'List Roads'),
//            array('name' => 'view-road', 'display_name' => 'View Road'),
//            array('name' => 'add-road', 'display_name' => 'Add Road'),
//            array('name' => 'edit-road', 'display_name' => 'Edit Road'),
//            array('name' => 'delete-road', 'display_name' => 'Delete Road'),
//            array('name' => 'export-roads-excel', 'display_name' => 'Export Roads to Excel'),
//            array('name' => 'export-roads-shape', 'display_name' => 'Export Roads to Shape'),
//            array('name' => 'export-roads-kml', 'display_name' => 'Export Roads to KML'),
            
//            array('name' => 'list-buildings-business', 'display_name' => 'List Building Business'),
//            array('name' => 'view-building-business', 'display_name' => 'View Building Business'),
//            array('name' => 'add-building-business', 'display_name' => 'Add Building Business'),
//            array('name' => 'edit-building-business', 'display_name' => 'Edit Building Business'),
//            array('name' => 'delete-building-business', 'display_name' => 'Delete Building Business'),
//            
//            array('name' => 'list-buildings-rent', 'display_name' => 'List Building Rent'),
//            array('name' => 'view-building-rent', 'display_name' => 'View Building Rent'),
//            array('name' => 'add-building-rent', 'display_name' => 'Add Building Rent'),
//            array('name' => 'edit-building-rent', 'display_name' => 'Edit Building Rent'),
//            array('name' => 'delete-building-rent', 'display_name' => 'Delete Building Rent'),
            
//            array('name' => 'export-buildings-rent-shape', 'display_name' => 'Export Building Rent Shape'),
//            array('name' => 'export-buildings-rent-kml', 'display_name' => 'Export Building Rent KML'),
//            array('name' => 'export-buildings-business-shape', 'display_name' => 'Export Building Business Shape'),
//            array('name' => 'export-buildings-business-kml', 'display_name' => 'Export Building Business KML'),
//            
            
            
            array('name' => 'export-buildings-business-excel', 'display_name' => 'Export Building Business Excel'),
            array('name' => 'export-buildings-rent-excel', 'display_name' => 'Export Building Rent Excel'),
            
            
        );

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
            ]);
        }

        Model::reguard();
    }
}
