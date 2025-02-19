<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        //create fake information  using faker factory lab 
        $faker = Factory::create();


        //------------- 01- Roles ------------//
        //adminRole
        $adminRole = new Role();
        $adminRole->name         = 'admin';
        $adminRole->display_name = 'User Administrator'; // optional
        $adminRole->description  = 'User is allowed to manage and edit other users'; // optional
        $adminRole->allowed_route = 'admin';
        $adminRole->save();

        //supervisorRole
        $supervisorRole = Role::create([
            'name' => 'supervisor',
            'display_name' => 'User Supervisor',
            'description' => 'Supervisor is allowed to manage and edit other users',
            'allowed_route' => 'admin',
        ]);


        //customerRole
        $customerRole = new Role();
        $customerRole->name         = 'customer';
        $customerRole->display_name = 'Project Customer'; // optional
        $customerRole->description  = 'Customer is the customer of a given project'; // optional
        $customerRole->allowed_route = null;
        $customerRole->save();


        //------------- 02- Users  ------------//
        // Create Admin
        $admin = new User();
        $admin->first_name = 'Admin';
        $admin->last_name = 'System';
        $admin->username = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->email_verified_at = now();
        $admin->mobile = '00967772036131';
        $admin->password = bcrypt('123123123');
        $admin->user_image = 'avator.svg';
        $admin->status = 1;
        $admin->remember_token = Str::random(10);
        $admin->save();

        // Create supervisor
        $supervisor = User::create([
            'first_name' => 'Supervisor',
            'last_name' => 'System',
            'username' => 'supervisor',
            'email' => 'supervisor@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036132',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        // Create customer
        $customer = User::create([
            'first_name' => 'Khaleel',
            'last_name' => 'Raweh',
            'username' => 'khaleel',
            'email' => 'khaleelvisa@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036133',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        //------------- 03- AttachRoles To  Users  ------------//
        $admin->attachRole($adminRole);
        $supervisor->attachRole($supervisorRole);
        $customer->attachRole($customerRole);


        //------------- 04-  Create random customer and  AttachRole to customerRole  ------------//
        for ($i = 1; $i <= 20; $i++) {
            //Create random customer
            $random_customer = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->email,
                'email_verified_at' => now(),
                'mobile' => '0096777' . $faker->numberBetween(1000000, 9999999),
                'password' => bcrypt('123123123'),
                'user_image' => 'avator.svg',
                'status' => 1,
                'remember_token' => Str::random(10),
            ]);

            //Add customerRole to RandomCusomer
            $random_customer->attachRole($customerRole);
        } //end for


        //------------- 05- Permission  ------------//
        //manage main dashboard page
        $manageMain = Permission::create(['name' => 'main', 'display_name' => ['ar' => 'الرئيسية', 'en'    => 'Main'], 'route' => 'index', 'module' => 'index', 'as' => 'index', 'icon' => 'fa fa-home', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '1']);
        $manageMain->parent_show = $manageMain->id;
        $manageMain->save();



        $manageSupervisors = Permission::create(['name' => 'manage_supervisors', 'display_name' => ['ar'    =>  'إدارة المستخدمين',    'en'    =>  'Manage Users'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '5',]);
        $manageSupervisors->parent_show = $manageSupervisors->id;
        $manageSupervisors->save();
        $showSupervisors   =  Permission::create(['name' => 'show_supervisors', 'display_name'    =>  ['ar'   =>  'دليل المستخدمين',   'en'    =>  'Users Guide'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createSupervisors =  Permission::create(['name' => 'create_supervisors', 'display_name'    =>  ['ar'   =>  'إضافة مستخدم جديد',   'en'    =>  'Add User'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.create', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displaySupervisors =  Permission::create(['name' => 'display_supervisors', 'display_name'    =>  ['ar'   =>  'عرض مستخدم',   'en'    =>  'Dsiplay User'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.show', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateSupervisors  =  Permission::create(['name' => 'update_supervisors', 'display_name'    =>  ['ar'   =>  'تعديل مستخدم',   'en'    =>  'Edit User'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.edit', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteSupervisors =  Permission::create(['name' => 'delete_supervisors', 'display_name'    =>  ['ar'   =>  'حذف مستخدم',   'en'    =>  'Delete User'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.destroy', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);

        //manage User Group
        $manageUserGroups = Permission::create(['name' => 'manage_user_groups', 'display_name' => ['ar'    =>  'دليل مجموعة المستخدمين',    'en'    =>  'Manage User Groups'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageSupervisors->id, 'parent_original' => '0', 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '5',]);
        $manageUserGroups->parent_show = $manageUserGroups->id;
        $manageUserGroups->save();
        $showUserGroups   =  Permission::create(['name' => 'show_user_groups', 'display_name'    =>  ['ar'   =>  'دليل مجموعة المستخدمين',   'en'    =>  'User Groups'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createUserGroups =  Permission::create(['name' => 'create_user_groups', 'display_name'    =>  ['ar'   =>  'إضافة مجموعة مستخدمين',   'en'    =>  'Add User Group'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.create', 'icon' => null, 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayUserGroups =  Permission::create(['name' => 'display_user_groups', 'display_name'    =>  ['ar'   =>  'عرض مجموعة مستخدمين',   'en'    =>  'Dsiplay User Group'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.show', 'icon' => null, 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateUserGroups  =  Permission::create(['name' => 'update_user_groups', 'display_name'    =>  ['ar'   =>  'تعديل مجموعة مستخدمين',   'en'    =>  'Edit User Group'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.edit', 'icon' => null, 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteUserGroups =  Permission::create(['name' => 'delete_user_groups', 'display_name'    =>  ['ar'   =>  'حذف مجموعة مستخدمين',   'en'    =>  'Delete User Group'], 'route' => 'user_groups', 'module' => 'user_groups', 'as' => 'user_groups.destroy', 'icon' => null, 'parent' => $manageUserGroups->id, 'parent_original' => $manageUserGroups->id, 'parent_show' => $manageUserGroups->id, 'sidebar_link' => '0', 'appear' => '0']);

        //document Categories 
        $manageDocumentCategories = Permission::create(['name' => 'manage_document_categories', 'display_name' => ['ar' => 'إدارة تصنيف الوثائق', 'en' => 'Manage Document Categories'], 'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.index', 'icon' => 'far fa-file-alt', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '10',]);
        $manageDocumentCategories->parent_show = $manageDocumentCategories->id;
        $manageDocumentCategories->save();
        $showDocuments    =  Permission::create(['name' => 'show_document_categories',  'display_name' => ['ar'     => 'إدارة تصنيف الوثائق ', 'en'  =>   'manage Document Categories'], 'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.index', 'icon' => 'far fa-file-alt', 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createDocuments  =  Permission::create(['name' => 'create_document_categories', 'display_name'  => ['ar'     => 'إضافة تصنيف وثيقة', 'en'  =>  'Add Document Category'], 'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.create', 'icon' => null, 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocuments =  Permission::create(['name' => 'display_document_categories', 'display_name'  => ['ar'     => 'عرض تصنيف وثيقة', 'en'  =>  'Display Document Category'], 'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.show', 'icon' => null, 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocuments  =  Permission::create(['name' => 'update_document_categories', 'display_name'  => ['ar'     => 'تعديل تصنيف وثيقة', 'en'  =>  'Edit Document Category'], 'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.edit', 'icon' => null, 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocuments  =  Permission::create(['name' => 'delete_document_categories', 'display_name'  => ['ar'     => 'حذف تصنيف وثيقة', 'en'  =>  'Delete Document Category'], 'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.destroy', 'icon' => null, 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);

        //document Types 
        $manageDocumentTypes = Permission::create(['name' => 'manage_document_types', 'display_name' => ['ar' => 'إدارة انواع الوثائق', 'en' => 'Manage Documents'], 'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.index', 'icon' => 'far fa-file-alt', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '15',]);
        $manageDocumentTypes->parent_show = $manageDocumentTypes->id;
        $manageDocumentTypes->save();
        $showDocuments    =  Permission::create(['name' => 'show_document_types',  'display_name' => ['ar'     => 'إدارة انواع الوثائق ', 'en'  =>   'manage Document Types'], 'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.index', 'icon' => 'far fa-file-alt', 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createDocuments  =  Permission::create(['name' => 'create_document_types', 'display_name'  => ['ar'     => 'إضافة نواع وثيقة', 'en'  =>  'Add Document Category'], 'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.create', 'icon' => null, 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocuments =  Permission::create(['name' => 'display_document_types', 'display_name'  => ['ar'     => 'عرض نواع وثيقة', 'en'  =>  'Display Document Category'], 'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.show', 'icon' => null, 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocuments  =  Permission::create(['name' => 'update_document_types', 'display_name'  => ['ar'     => 'تعديل نواع وثيقة', 'en'  =>  'Edit Document Category'], 'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.edit', 'icon' => null, 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocuments  =  Permission::create(['name' => 'delete_document_types', 'display_name'  => ['ar'     => 'حذف نواع وثيقة', 'en'  =>  'Delete Document Category'], 'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.destroy', 'icon' => null, 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);


        //manage Document Templates
        $manageDocumentTemplates = Permission::create(['name' => 'manage_document_templates', 'display_name' => ['ar'    =>  ' إدارة قالب الوثائق',   'en'    =>  '’Manage Document Templates'], 'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '20',]);
        $manageDocumentTemplates->parent_show = $manageDocumentTemplates->id;
        $manageDocumentTemplates->save();
        $showDocumentTemplates    =  Permission::create(['name' => 'show_document_templates', 'display_name'       =>    ['ar'   =>  'قالب الوثائق',   'en'    =>  ' Document Templates'],   'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createDocumentTemplates  =  Permission::create(['name' => 'create_document_templates', 'display_name'     =>    ['ar'   =>  'إضافة قالب وثيقة جديد',   'en'    =>  'Add Document Template'],    'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocumentTemplates =  Permission::create(['name' => 'display_document_templates', 'display_name'    =>    ['ar'   =>  ' عرض قالب وثيقة',   'en'    =>  'Display Document Template'],    'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocumentTemplates  =  Permission::create(['name' => 'update_document_templates', 'display_name'     =>    ['ar'   =>  'تعديل قالب وثيقة',   'en'    =>  'Edit Document Template'],    'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocumentTemplates  =  Permission::create(['name' => 'delete_document_templates', 'display_name'     =>    ['ar'   =>  'حذف قالب وثيقة',   'en'    =>  'Delete Document Template'],    'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);


        //manage Document 
        $manageDocuments = Permission::create(['name' => 'manage_documents', 'display_name' => ['ar'    =>  ' إدارة الوثائق',   'en'    =>  '’Manage Documents'], 'route' => 'documents', 'module' => 'documents', 'as' => 'documents.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '25',]);
        $manageDocuments->parent_show = $manageDocuments->id;
        $manageDocuments->save();
        $showDocuments    =  Permission::create(['name' => 'show_documents', 'display_name'       =>    ['ar'   =>  ' الوثائق',   'en'    =>  ' Documents'],   'route' => 'documents', 'module' => 'documents', 'as' => 'documents.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createDocuments  =  Permission::create(['name' => 'create_documents', 'display_name'     =>    ['ar'   =>  'إضافة وثيقة',   'en'    =>  'Add Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocuments =  Permission::create(['name' => 'display_documents', 'display_name'    =>    ['ar'   =>  ' عرض وثيقة',   'en'    =>  'Display Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocuments  =  Permission::create(['name' => 'update_documents', 'display_name'     =>    ['ar'   =>  'تعديل وثيقة',   'en'    =>  'Edit Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocuments  =  Permission::create(['name' => 'delete_documents', 'display_name'     =>    ['ar'   =>  'حذف وثيقة',   'en'    =>  'Delete Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);


        //manage Contract Templates
        $manageContractTemplates = Permission::create(['name' => 'manage_contract_templates', 'display_name' => ['ar'    =>  ' إدارة قالب العقود',   'en'    =>  '’Manage Contract Templates'], 'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '30',]);
        $manageContractTemplates->parent_show = $manageContractTemplates->id;
        $manageContractTemplates->save();
        $showContractTemplates    =  Permission::create(['name' => 'show_contract_templates', 'display_name'       =>    ['ar'   =>  'قالب العقود',   'en'    =>  ' Contract Templates'],   'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createContractTemplates  =  Permission::create(['name' => 'create_contract_templates', 'display_name'     =>    ['ar'   =>  'إضافة قالب عقد جديد',   'en'    =>  'Add Contract Template'],    'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayContractTemplates =  Permission::create(['name' => 'display_contract_templates', 'display_name'    =>    ['ar'   =>  ' عرض قالب عقد',   'en'    =>  'Display Contract Template'],    'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateContractTemplates  =  Permission::create(['name' => 'update_contract_templates', 'display_name'     =>    ['ar'   =>  'تعديل قالب عقد',   'en'    =>  'Edit Contract Template'],    'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteContractTemplates  =  Permission::create(['name' => 'delete_contract_templates', 'display_name'     =>    ['ar'   =>  'حذف قالب عقد',   'en'    =>  'Delete Contract Template'],    'route' => 'contract_templates', 'module' => 'contract_templates', 'as' => 'contract_templates.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);

        //manage Contracts
        $manageContracts = Permission::create(['name' => 'manage_contracts', 'display_name' => ['ar'    =>  ' إدارة العقود',   'en'    =>  '’Manage Contracts'], 'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '35',]);
        $manageContracts->parent_show = $manageContracts->id;
        $manageContracts->save();
        $showContracts    =  Permission::create(['name' => 'show_contracts', 'display_name'       =>    ['ar'   =>  ' العقود',   'en'    =>  ' Contracts'],   'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createContracts  =  Permission::create(['name' => 'create_contracts', 'display_name'     =>    ['ar'   =>  'إضافة عقد',   'en'    =>  'Add Contract'],    'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayContracts =  Permission::create(['name' => 'display_contracts', 'display_name'    =>    ['ar'   =>  ' عرض عقد',   'en'    =>  'Display Contract'],    'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateContracts  =  Permission::create(['name' => 'update_contracts', 'display_name'     =>    ['ar'   =>  'تعديل عقد',   'en'    =>  'Edit Contract'],    'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteContracts  =  Permission::create(['name' => 'delete_contracts', 'display_name'     =>    ['ar'   =>  'حذف عقد',   'en'    =>  'Delete Contract'],    'route' => 'contracts', 'module' => 'contracts', 'as' => 'contracts.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);


        //manage Document Archives
        $manageDocumentArchives = Permission::create(['name' => 'manage_document_archives', 'display_name' => ['ar'    =>  'إدارة الإرشيف',   'en'    =>  'Manage Archives'], 'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.index', 'icon' => 'fas fa-folder-minus', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '100',]);
        $manageDocumentArchives->parent_show = $manageDocumentArchives->id;
        $manageDocumentArchives->save();
        $showDocumentArchives    =  Permission::create(['name' => 'show_document_archives', 'display_name'       =>    ['ar'   =>  'إرشيف الوثائق',   'en'    =>  ' Document Archives'],   'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.index', 'icon' => 'fas fa-folder-minus', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createDocumentArchives  =  Permission::create(['name' => 'create_document_archives', 'display_name'     =>    ['ar'   =>  'إضافة إرشيف وثيقة جديد',   'en'    =>  'Add Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocumentArchives =  Permission::create(['name' => 'display_document_archives', 'display_name'    =>    ['ar'   =>  ' عرض إرشيف وثيقة',   'en'    =>  'Display Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocumentArchives  =  Permission::create(['name' => 'update_document_archives', 'display_name'     =>    ['ar'   =>  'تعديل إرشيف وثيقة',   'en'    =>  'Edit Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocumentArchives  =  Permission::create(['name' => 'delete_document_archives', 'display_name'     =>    ['ar'   =>  'حذف إرشيف وثيقة',   'en'    =>  'Delete Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
    }
}
