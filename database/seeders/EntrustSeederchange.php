<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelstatistics;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Dictionary : 
     *              01- user_permissions 
     *              02- Users
     *              03- Attachuser_permissions To  Users
     *              04- Create random customer and  AttachRole to customerRole
     * 
     * 
     * @return void
     */
    public function run()
    {

        //manage User Permission
        $manageUserPermissions = Permission::create(['name' => 'manage_user_Permissions', 'display_name' => ['ar'    =>  'صلاحيات المستهدمين',    'en'    =>  'Manage User Permissions'], 'route' => 'user_permissions', 'module' => 'user_permissions', 'as' => 'user_permissions.index', 'icon' => 'fas fa-user-tie', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '5',]);
        $manageUserPermissions->parent_show = $manageUserPermissions->id;
        $manageUserPermissions->save();
        $showUserPermisssions   =  Permission::create(['name' => 'show_user_Permissions', 'display_name'    =>  ['ar'   =>  'صلاحيات المستخدمين',   'en'    =>  'User Permissions'], 'route' => 'user_permissions', 'module' => 'user_permissions', 'as' => 'user_permissions.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageUserPermissions->id, 'parent_original' => $manageUserPermissions->id, 'parent_show' => $manageUserPermissions->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createUserPermisssions =  Permission::create(['name' => 'create_user_Permissions', 'display_name'    =>  ['ar'   =>  'إضافة صلاحية مستخدم',   'en'    =>  'Add User Permission'], 'route' => 'user_permissions', 'module' => 'user_permissions', 'as' => 'user_permissions.create', 'icon' => null, 'parent' => $manageUserPermissions->id, 'parent_original' => $manageUserPermissions->id, 'parent_show' => $manageUserPermissions->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayUserPermisssions =  Permission::create(['name' => 'display_user_Permissions', 'display_name'    =>  ['ar'   =>  'عرض صلاحية مستخدم',   'en'    =>  'Dsiplay User Permission'], 'route' => 'user_permissions', 'module' => 'user_permissions', 'as' => 'user_permissions.show', 'icon' => null, 'parent' => $manageUserPermissions->id, 'parent_original' => $manageUserPermissions->id, 'parent_show' => $manageUserPermissions->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateUserPermisssions  =  Permission::create(['name' => 'update_user_Permissions', 'display_name'    =>  ['ar'   =>  'تعديل صلاحية مستخدم',   'en'    =>  'Edit User Permission'], 'route' => 'user_permissions', 'module' => 'user_permissions', 'as' => 'user_permissions.edit', 'icon' => null, 'parent' => $manageUserPermissions->id, 'parent_original' => $manageUserPermissions->id, 'parent_show' => $manageUserPermissions->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteUserPermisssions =  Permission::create(['name' => 'delete_user_Permissions', 'display_name'    =>  ['ar'   =>  'حذف صلاحية مستخدم',   'en'    =>  'Delete User Permission'], 'route' => 'user_permissions', 'module' => 'user_permissions', 'as' => 'user_permissions.destroy', 'icon' => null, 'parent' => $manageUserPermissions->id, 'parent_original' => $manageUserPermissions->id, 'parent_show' => $manageUserPermissions->id, 'sidebar_link' => '0', 'appear' => '0']);
    }
}
