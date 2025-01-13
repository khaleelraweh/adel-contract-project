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
     *              01- Roles 
     *              02- Users
     *              03- AttachRoles To  Users
     *              04- Create random customer and  AttachRole to customerRole
     * 
     * 
     * @return void
     */
    public function run()
    {

        //manage Contracts
        $manageContracts = Permission::create(['name' => 'manage_contracts', 'display_name' => ['ar'    =>  ' إدارة العقود',   'en'    =>  '’Manage Contracts'], 'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '25',]);
        $manageContracts->parent_show = $manageContracts->id;
        $manageContracts->save();
        $showContracts    =  Permission::create(['name' => 'show_contracts', 'display_name'       =>    ['ar'   =>  ' العقود',   'en'    =>  ' Contracts'],   'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createContracts  =  Permission::create(['name' => 'create_contracts', 'display_name'     =>    ['ar'   =>  'إضافة عقد',   'en'    =>  'Add Contract'],    'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayContracts =  Permission::create(['name' => 'display_contracts', 'display_name'    =>    ['ar'   =>  ' عرض عقد',   'en'    =>  'Display Contract'],    'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateContracts  =  Permission::create(['name' => 'update_contracts', 'display_name'     =>    ['ar'   =>  'تعديل عقد',   'en'    =>  'Edit Contract'],    'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteContracts  =  Permission::create(['name' => 'delete_contracts', 'display_name'     =>    ['ar'   =>  'حذف عقد',   'en'    =>  'Delete Contract'],    'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
    }
}
