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

        //manage Contract Templates
        $manageContractTemplates = Permission::create(['name' => 'manage_contract_templates', 'display_name' => ['ar'    =>  ' إدارة نموذج العقود',   'en'    =>  '’Manage Contract Templates'], 'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '20',]);
        $manageContractTemplates->parent_show = $manageContractTemplates->id;
        $manageContractTemplates->save();
        $showContractTemplates    =  Permission::create(['name' => 'show_contract_templates', 'display_name'       =>    ['ar'   =>  'نموذج العقود',   'en'    =>  ' Contract Templates'],   'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createContractTemplates  =  Permission::create(['name' => 'create_contract_templates', 'display_name'     =>    ['ar'   =>  'إضافة نموذج عقد جديد',   'en'    =>  'Add Contract Template'],    'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayContractTemplates =  Permission::create(['name' => 'display_contract_templates', 'display_name'    =>    ['ar'   =>  ' عرض نموذج عقد',   'en'    =>  'Display Contract Template'],    'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateContractTemplates  =  Permission::create(['name' => 'update_contract_templates', 'display_name'     =>    ['ar'   =>  'تعديل نموذج عقد',   'en'    =>  'Edit Contract Template'],    'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteContractTemplates  =  Permission::create(['name' => 'delete_contract_templates', 'display_name'     =>    ['ar'   =>  'حذف نموذج عقد',   'en'    =>  'Delete Contract Template'],    'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
    }
}
