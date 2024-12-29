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



        $manageSupervisors = Permission::create(['name' => 'manage_supervisors', 'display_name' => ['ar'    =>  'إدارة المشرفين',    'en'    =>  'Manage Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '5',]);
        $manageSupervisors->parent_show = $manageSupervisors->id;
        $manageSupervisors->save();
        $showSupervisors   =  Permission::create(['name' => 'show_supervisors', 'display_name'    =>  ['ar'   =>  'المشرفين',   'en'    =>  'Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createSupervisors =  Permission::create(['name' => 'create_supervisors', 'display_name'    =>  ['ar'   =>  'إضافة مشرف جديد',   'en'    =>  'Add Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.create', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displaySupervisors =  Permission::create(['name' => 'display_supervisors', 'display_name'    =>  ['ar'   =>  'عرض مشرف',   'en'    =>  'Dsiplay Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.show', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateSupervisors  =  Permission::create(['name' => 'update_supervisors', 'display_name'    =>  ['ar'   =>  'تعديل مشرف',   'en'    =>  'Edit Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.edit', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteSupervisors =  Permission::create(['name' => 'delete_supervisors', 'display_name'    =>  ['ar'   =>  'حذف مشرف',   'en'    =>  'Delete Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.destroy', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);


        //document Categories 
        $manageDocumentCategories = Permission::create(['name' => 'manage_document_categories', 'display_name' => ['ar' => 'إدارة الوثائق', 'en' => 'Manage Documents'], 'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.index', 'icon' => 'far fa-file-alt', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '10',]);
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
        $manageDocumentTemplates = Permission::create(['name' => 'manage_document_templates', 'display_name' => ['ar'    =>  ' إدارة نموذج الوثائق',   'en'    =>  '’Manage Document Templates'], 'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '20',]);
        $manageDocumentTemplates->parent_show = $manageDocumentTemplates->id;
        $manageDocumentTemplates->save();
        $showDocumentTemplates    =  Permission::create(['name' => 'show_document_templates', 'display_name'       =>    ['ar'   =>  'نموذج الوثائق',   'en'    =>  ' Document Templates'],   'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createDocumentTemplates  =  Permission::create(['name' => 'create_document_templates', 'display_name'     =>    ['ar'   =>  'إضافة نموذج وثيقة جديد',   'en'    =>  'Add Document Template'],    'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocumentTemplates =  Permission::create(['name' => 'display_document_templates', 'display_name'    =>    ['ar'   =>  ' عرض نموذج وثيقة',   'en'    =>  'Display Document Template'],    'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocumentTemplates  =  Permission::create(['name' => 'update_document_templates', 'display_name'     =>    ['ar'   =>  'تعديل نموذج وثيقة',   'en'    =>  'Edit Document Template'],    'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocumentTemplates  =  Permission::create(['name' => 'delete_document_templates', 'display_name'     =>    ['ar'   =>  'حذف نموذج وثيقة',   'en'    =>  'Delete Document Template'],    'route' => 'document_templates', 'module' => 'document_templates', 'as' => 'document_templates.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);


        //manage Document Templates
        $manageDocuments = Permission::create(['name' => 'manage_documents', 'display_name' => ['ar'    =>  ' إدارة الوثائق',   'en'    =>  '’Manage Documents'], 'route' => 'documents', 'module' => 'documents', 'as' => 'documents.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '25',]);
        $manageDocuments->parent_show = $manageDocuments->id;
        $manageDocuments->save();
        $showDocuments    =  Permission::create(['name' => 'show_documents', 'display_name'       =>    ['ar'   =>  ' الوثائق',   'en'    =>  ' Documents'],   'route' => 'documents', 'module' => 'documents', 'as' => 'documents.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createDocuments  =  Permission::create(['name' => 'create_documents', 'display_name'     =>    ['ar'   =>  'إضافة وثيقة',   'en'    =>  'Add Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocuments =  Permission::create(['name' => 'display_documents', 'display_name'    =>    ['ar'   =>  ' عرض وثيقة',   'en'    =>  'Display Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocuments  =  Permission::create(['name' => 'update_documents', 'display_name'     =>    ['ar'   =>  'تعديل وثيقة',   'en'    =>  'Edit Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocuments  =  Permission::create(['name' => 'delete_documents', 'display_name'     =>    ['ar'   =>  'حذف وثيقة',   'en'    =>  'Delete Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);



        //manage Document Archives
        $manageDocumentArchives = Permission::create(['name' => 'manage_document_archives', 'display_name' => ['ar'    =>  'إدارة الإرشيف',   'en'    =>  'Manage Archives'], 'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.index', 'icon' => 'fas fa-folder-minus', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '100',]);
        $manageDocumentArchives->parent_show = $manageDocumentArchives->id;
        $manageDocumentArchives->save();
        $showDocumentArchives    =  Permission::create(['name' => 'show_document_archives', 'display_name'       =>    ['ar'   =>  'إرشيف الوثائق',   'en'    =>  ' Document Archives'],   'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.index', 'icon' => 'fas fa-folder-minus', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createDocumentArchives  =  Permission::create(['name' => 'create_document_archives', 'display_name'     =>    ['ar'   =>  'إضافة إرشيف وثيقة جديد',   'en'    =>  'Add Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocumentArchives =  Permission::create(['name' => 'display_document_archives', 'display_name'    =>    ['ar'   =>  ' عرض إرشيف وثيقة',   'en'    =>  'Display Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocumentArchives  =  Permission::create(['name' => 'update_document_archives', 'display_name'     =>    ['ar'   =>  'تعديل إرشيف وثيقة',   'en'    =>  'Edit Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocumentArchives  =  Permission::create(['name' => 'delete_document_archives', 'display_name'     =>    ['ar'   =>  'حذف إرشيف وثيقة',   'en'    =>  'Delete Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);



        //Site Settings Holder 
        $manageSiteSettings = Permission::create(['name' => 'manage_site_settings', 'display_name' => ['ar' =>  'الاعدادات العامة', 'en'    =>  'General Settings'], 'route' => 'settings', 'module' => 'settings', 'as' => 'settings.index', 'icon' => 'fa fa-cog', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '105',]);
        $manageSiteSettings->parent_show = $manageSiteSettings->id;
        $manageSiteSettings->save();

        // Site Infos 
        $displaySiteInfos =  Permission::create(['name' => 'display_site_infos', 'display_name'     => ['ar'   =>  'إدارة  بيانات الموقع', 'en'  =>  'Manage Site Infos'], 'route' => 'settings.site_main_infos', 'module' => 'settings.site_main_infos', 'as' => 'settings.site_main_infos.show', 'icon' => 'fa fa-info-circle', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteInfos  =  Permission::create(['name' => 'update_site_infos', 'display_name'      => ['ar'    =>  'تعديل بيانات الموقع', 'en'    =>  'Edit Site Infos'], 'route' => 'settings.site_main_infos', 'module' => 'settings.site_main_infos', 'as' => 'settings.site_main_infos.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site Contacts  
        $displaySiteContacts =  Permission::create(['name' => 'display_site_contacts', 'display_name'   => ['ar'    =>  'إدارة  بيانات الإتصال ', 'en' =>  'Manage Site Contact '], 'route' => 'settings.site_contacts', 'module' => 'settings.site_contacts', 'as' => 'settings.site_contacts.show', 'icon' => 'fa fa-address-book', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteContacts  =  Permission::create(['name' => 'update_site_contacts', 'display_name'    => ['ar'    =>  'تعديل بيانات الإتصال ', 'en'   =>  'Edit Site Contact '], 'route' => 'settings.site_contacts', 'module' => 'settings.site_contacts', 'as' => 'settings.site_contacts.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site Socials
        $displaySiteSocails =  Permission::create(['name' => 'display_site_socials', 'display_name'     =>  ['ar'   =>  ' إدارة  حسابات التواصل  ',   'en'    =>  'Manage Site Socials'], 'route' => 'settings.site_socials', 'module' => 'settings.site_socials', 'as' => 'settings.site_socials.show', 'icon' => 'fas fa-rss', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteSocails  =  Permission::create(['name' => 'update_site_socials', 'display_name'      =>  ['ar'   =>  'تعديل حسابات التواصل ',   'en'    =>  'Edit Site Contact Infos'], 'route' => 'settings.site_socials', 'module' => 'settings.site_socials', 'as' => 'settings.site_socials.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site SEO
        $displaySiteMetas =  Permission::create(['name' => 'display_site_meta', 'display_name'     =>  ['ar'   =>  'إدارة  SEO',   'en'    =>  'Manage Site SEO'], 'route' => 'settings.site_meta', 'module' => 'settings.site_meta', 'as' => 'settings.site_meta.show', 'icon' => 'fa fa-tag', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteMetas  =  Permission::create(['name' => 'update_site_meta', 'display_name'      =>  ['ar'   =>  'تعديل SEO',   'en'    =>  'Edit Site SEO'], 'route' => 'settings.site_meta', 'module' => 'settings.site_meta', 'as' => 'settings.site_meta.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);
    }
}
