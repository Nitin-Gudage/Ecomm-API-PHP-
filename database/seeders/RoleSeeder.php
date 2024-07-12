<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        
        Schema::disableForeignKeyConstraints();
        Permission::query()->truncate();
        Schema::enableForeignKeyConstraints();
        if (Role::count() == 0) {
            Role::insert([
                [
                    'name' => 'Admin',
                ]
 
 
            ]);
        }
 
        $permissions = array(
 
            array(
                "key" => "dashboards",
                "path" => "/dashboards/default",
                "title" => "sidenav.dashboard",
                "icon" => "DashboardOutlined",
                "breadcrumb" => false,
                "submenu" => array(
                    array(
                        "key" => "dashboards-default",
                        "path" => "/dashboards/default",
                        "title" => "Dashboard",
                        "icon" => "DashboardOutlined",
                        "breadcrumb" => false,
                        "submenu" => array(),
                    ),
                    array(
                        "key" => "dashboards-master",
                        "path" => "",
                        "title" => "Master",
                        "icon" => "OrderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" => array(
                            array(
                                "key" => "dashboards-brand",
                                "path" => "/dashboards/brand",
                                "title" => "Brand",
                                "icon" => "UnorderedListOutlined",
                                "breadcrumb" => false,
                                "submenu" => array("List Brand", "Add Brand", "Edit Brand", "Delete Brand"),
                            ),
                            array(
                                "key" => "dashboards-category",
                                "path" => "/dashboards/category",
                                "title" => "Category",
                                "icon" => "UnorderedListOutlined",
                                "breadcrumb" => false,
                                "submenu" => array("List Category", "Add Category", "Edit Category", "Delete Category"),
                            ),
                            array(
                                "key" => "dashboards-product",
                                "path" => "/dashboards/product",
                                "title" => "Product",
                                "icon" => "UnorderedListOutlined",
                                "breadcrumb" => false,
                                "submenu" => array("List Product", "Add Product", "Edit Product", "Delete Product"),
                            ),
                        ),
                    ),
                ),
            ),
 
            array(
                "key" => "dashboards-employee",
                "path" => "",
                "title" => "Employee Management",
                "icon" => "UserOutlined",
                "breadcrumb" => false,
                "submenu" => array(
                    array(
                        "key" => "dashboards-employee",
                        "path" => "/dashboards/employee",
                        "title" => " Employee",
                        "icon" => "UserOutlined",
                        "breadcrumb" => false,
                        "submenu" => array("List Employee", "Add Employee", "Edit Employee", "Delete Employee"),
                    ),
                    array(
                        "key" => "dashboards-permission",
                        "path" => "/dashboards/employee/permission",
                        "title" => " Permission",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" => array("List Permission", "Add Permission", "Edit Permission", "Delete Permission"),
                    ),
                    array(
                        "key" => "dashboards-role",
                        "path" => "/dashboards/employee/role",
                        "title" => "Role",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" => array("List Role", "Add Role", "Edit Role", "Delete Role"),
                    ),
                 
                  
                   
                   
                  
                   
                 
                ),
            ),
 
 
 
            array(
                "key" => "dashboards-order",
                "path" => "",
                "title" => "Orders ",
                "icon" => "OrderedListOutlined",
                "breadcrumb" => false,
                "submenu" => array(
                    array(
                        "key" => "dashboards-pending",
                        "path" => "/dashboards/order/Pending/indexr",
                        "title" => "New Order",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List New Order", "Add New Order", "Edit New Order", "Delete New Order"),
                    ),
                    array(
                        "key" => "dashboards-accepted",
                        "path" => "/dashboards/order/Accepted/index",
                        "title" => "Accepted Order",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Accepted Order", "Add Accepted Order", "Edit Accepted Order", "Delete Accepted Order"),
                    ),
                    array(
                        "key" => "dashboards-outofdelivery",
                        "path" => "/dashboards/order/Out-of-delivery/index",
                        "title" => "Out Of Delivered",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Out Of Delivered", "Add Out Of Delivered", "Edit Out Of Delivered", "Delete Out Of Delivered"),
                    ),
                    array(
                        "key" => "dashboards-deliveredorder",
                        "path" => "/dashboards/order/Delivere-order/index",
                        "title" => "Delivered Order",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Delivered Order", "Add Delivered Order", "Edit Delivered Order", "Delete Delivered Order"),
                    ),
                    array(
                        "key" => "dashboards-rejectorder",
                        "path" => "/dashboards/order/reject-order/index",
                        "title" => "Rejected Order",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Rejected Order", "Add Rejected Order", "Edit Rejected Order", "Delete Rejected Order"),
                    ),
                ),
            ),
            array(
                "key" => "dashboards-Customer.Support",
                "path" => "/dashboards/Customer-Support/index",
                "title" => "Customer Support",
                "icon" => "UserOutlined",
                "breadcrumb" => false,
                "submenu" => []
 
                     ),

            array(
                "key" => "dashboards-return",
                "path" => "",
                "title" => "Return",
                "icon" => "UserOutlined",
                "breadcrumb" => false,
                "submenu" => array(
 
                    array(
                        "key" => "dashboards-return.pending",
                        "path" => "/dashboards/Return-pending",
                        "title" => "Pending",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Pending", "Add Pending", "Edit Pending", "Delete Pending"),
                    ),
                    array(
                        "key" => "dashboards-returned",
                        "path" => "/dashboards/return/returned",
                        "title" => "Returned ",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Returned", "Add Returned", "Edit Returned", "Delete Returned"),
                    ),
                  
                ),
            ),
 
            array(
                "key" => "dashboards-faq",
                "path" => "",
                "title" => "FAQ",
                "icon" => "FileTextOutlined",
                "breadcrumb" => false,
                "submenu" => array(
                    array(
                        "key" => "dashboards-faq",
                        "path" => "/dashboards/faq",
                        "title" => " FAQ",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List FAQ", "Add FAQ", "Edit FAQ", "Delete FAQ"),
 
                    ),
                   
                    
                ),
            ),
 
            array(
                "key" => "dashboards-setting",
                "path" => "",
                "title" => "Setting",
                "icon" => "SettingOutlined",
                "breadcrumb" => false,
                "submenu" => array(
 
 
                    array(
                        "key" => "dashboards-settings",
                        "path" => "/dashboards/settings",
                        "title" => "Setting",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" => array("List Setting", "Add Setting", "Edit Setting", "Delete Setting"),
                    ),
                    array(
                        "key" => "dashboards-settings",
                        "path" => "/dashboards/settings/Site-setting/index",
                        "title" => "Site Setting",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Site Setting", "Add Site Setting", "Edit Site Setting", "Delete Site Setting"),
                    ),
                    array(
                        "key" => "dashboards-SMTP-Setting",
                        "path" => "/dashboards/settings/emailsetting",
                        "title" => "SMTP Setting",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List SMTP Setting", "Add SMTP Setting", "Edit SMTP Setting", "Delete SMTP Setting"),
                    ),
                    array(
                        "key" => "dashboards-Term&Condition",
                        "path" => "/dashboards/settings/term&condition",
                        "title" => "Term & Condition",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Term & Condition", "Add Term & Condition", "Edit Term & Condition", "Delete Term & Condition"),
                    ),
                    array(
                        "key" => "dashboards-Privacy&Policy",
                        "path" => "/dashboards/settings/privacy&policy",
                        "title" => "Privacy & Policy",
                        "icon" => "UnorderedListOutlined",
                        "breadcrumb" => false,
                        "submenu" =>  array("List Privacy & Policy", "Add Privacy & Policy", "Edit Privacy & Policy", "Delete Privacy & Policy"),
                    ),
                ),
            ),
          
 
           );
 
 
        foreach ($permissions as $permission) {
            $perObj = new Permission;
            $perObj->parent_id = $permission['parent_id'] ?? null;
            $perObj->title = $permission['title'] ?? "";
            $perObj->key = $permission['key'] ?? "";
            $perObj->path = $permission['path'] ?? "";
            $perObj->icon = $permission['icon'] ?? "";
            $perObj->breadcrumb = $permission['breadcrumb'] ?? "";
            $perObj->save();
            foreach ($permission['submenu'] ?? [] as $child) {
                $childObj = new Permission;
                $childObj->parent_id = $perObj->id;
                $childObj->title = $child['title'] ?? $child;
                $childObj->key = $child['key'] ?? "";
                $childObj->path = $child['path'] ?? "";
                $childObj->icon = $child['icon'] ?? "";
                $childObj->breadcrumb = $child['breadcrumb'] ?? "";
                $childObj->save();
                foreach ($child['submenu'] ?? [] as $subChild) {
                    $subChildObj = new Permission();
                    $subChildObj->parent_id = $childObj->id;
                    $subChildObj->title = $subChild['title'] ?? $subChild;
                    $subChildObj->save();
                }
            }
        }
    }
    
}
