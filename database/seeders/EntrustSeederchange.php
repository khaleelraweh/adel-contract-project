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
     *              01- user_groups 
     *              02- Users
     *              03- Attachuser_groups To  Users
     *              04- Create random customer and  AttachRole to customerRole
     * 
     * 
     * @return void
     */
    public function run()
    {

        //manage User Group
        $manageUserGroups = Permission::create(['name' => 'manage_user_groups', 'display_name' => ['ar'    =>  'دليل مجموعة المستخدمين',    'en'    =>  'Manage User Groups'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.index', 'icon' => 'fas fa-user-tie', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '5',]);
        $manageUserGroups->parent_show = $manageUserGroups->id;
        $manageUserGroups->save();
        $showUserGroups   =  Permission::create(['name' => 'show_user_groups', 'display_name'    =>  ['ar'   =>  'دليل مجموعة المستخدمين',   'en'    =>  'User Groups'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createUserGroups =  Permission::create(['name' => 'create_user_groups', 'display_name'    =>  ['ar'   =>  'إضافة مجموعة مستخدمين',   'en'    =>  'Add User Group'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.create', 'icon' => null, 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayUserGroups =  Permission::create(['name' => 'display_user_groups', 'display_name'    =>  ['ar'   =>  'عرض مجموعة مستخدمين',   'en'    =>  'Dsiplay User Group'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.show', 'icon' => null, 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateUserGroups  =  Permission::create(['name' => 'update_user_groups', 'display_name'    =>  ['ar'   =>  'تعديل مجموعة مستخدمين',   'en'    =>  'Edit User Group'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.edit', 'icon' => null, 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteUserGroups =  Permission::create(['name' => 'delete_user_groups', 'display_name'    =>  ['ar'   =>  'حذف مجموعة مستخدمين',   'en'    =>  'Delete User Group'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.destroy', 'icon' => null, 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
    }
}
