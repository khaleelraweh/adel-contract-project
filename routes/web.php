<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\AdvsController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\AlbumsController;
use App\Http\Controllers\Backend\EventsController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\PartnerController;
use App\Http\Controllers\AdvertisorSliderController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\MainMenuController;
use App\Http\Controllers\Backend\PlaylistsController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Backend\MainSliderController;
use App\Http\Controllers\Backend\StatisticsController;
use App\Http\Controllers\Backend\SupervisorController;
use App\Http\Controllers\Backend\TopicsMenuController;
use App\Http\Controllers\Backend\TracksMenuController;
use App\Http\Controllers\Backend\CollegeMenuController;
use App\Http\Controllers\Backend\CompanyMenuController;
use App\Http\Controllers\Backend\SupportMenuController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\Backend\ContactUsMenuController;
use App\Http\Controllers\Backend\DocumentTypesController;
use App\Http\Controllers\Backend\CommonQuestionController;
use App\Http\Controllers\Backend\PageCategoriesController;
use App\Http\Controllers\Backend\SpecializationController;
use App\Http\Controllers\Backend\PresidentSpeechController;
use App\Http\Controllers\Backend\DocumentArchivesController;
use App\Http\Controllers\Backend\ImportantLinkMenuController;
use App\Http\Controllers\Backend\DocumentCategoriesController;
use App\Http\Controllers\Backend\AcademicProgramMenuController;
use App\Http\Controllers\Backend\CommonQuestionVideoController;
use App\Http\Controllers\Backend\ContractTemplateController;
use App\Http\Controllers\Backend\DocumentsController;
use App\Http\Controllers\Backend\DocumentTemplatesController;
use App\Http\Controllers\Backend\PoliciesPrivacyMenuController;

Auth::routes(['verify' => true]);
// لايقاف الديباجر نضيف هذا الكود
app('debugbar')->disable();

//Frontend 
Route::get('/',         [BackendController::class, 'index'])->name('admin.index');
Route::get('/index',    [BackendController::class, 'index'])->name('admin.index');


Route::get('/change-language/{locale}',     [LocaleController::class, 'switch'])->name('change.language');

//Backend
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //guest to website 
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [BackendController::class, 'login'])->name('login');
        Route::get('/register', [BackendController::class, 'register'])->name('register');
        Route::get('/lock-screen', [BackendController::class, 'lock_screen'])->name('lock-screen');
        Route::get('/recover-password', [BackendController::class, 'recover_password'])->name('recover-password');
    });

    //uthenticate to website 
    Route::group(['middleware' => ['auth', 'roles', 'role:admin|supervisor']], function () {
        Route::get('/', [BackendController::class, 'index'])->name('index2');
        Route::get('/index', [BackendController::class, 'index'])->name('index');


        Route::post('supervisors/remove-image', [SupervisorController::class, 'remove_image'])->name('supervisors.remove_image');
        Route::post('supervisors/update-supervisor-status', [SupervisorController::class, 'updateSupervisorStatus'])->name('supervisors.update_supervisor_status');
        Route::resource('supervisors', SupervisorController::class);

        Route::post('support_menus/update-support-menu-status', [SupportMenuController::class, 'updateSupportMenuStatus'])->name('support_menus.update_support_menu_status');
        Route::resource('support_menus', SupportMenuController::class);


        // ==============   Document Categories Tab   ==============  //
        Route::post('document-categories/update-document-category-status', [DocumentCategoriesController::class, 'updateDocumentCategoryStatus'])->name('document_categories.update_document_category_status');
        Route::resource('document_categories', DocumentCategoriesController::class);

        // ==============   Document types Tab   ==============  //
        Route::post('document-types/update-document-type-status', [DocumentTypesController::class, 'updateDocumentTypeStatus'])->name('document_types.update_document_type_status');
        Route::resource('document_types', DocumentTypesController::class);

        // ==============   Document template Tab   ==============  //
        Route::post('document-templates/update-document-template-status', [DocumentTemplatesController::class, 'updateDocumentTemplateStatus'])->name('document_templates.update_document_template_status');
        Route::resource('document_templates', DocumentTemplatesController::class);


        // ==============   Document  Tab   ==============  //
        Route::post('documents/update-document-status', [DocumentsController::class, 'updateDocumentStatus'])->name('documents.update_document_status');
        Route::get('document/print/{id}', [DocumentsController::class, 'print'])->name('documents.print');
        Route::get('document/pdf/{id}', [DocumentsController::class, 'pdf'])->name('documents.pdf');
        Route::resource('documents', DocumentsController::class);


        // ==============   contract template Tab   ==============  //
        Route::post('contract-templates/update-contract-template-status', [ContractTemplateController::class, 'updateContractTemplateStatus'])->name('contract_templates.update_contract_template_status');
        Route::resource('contract_templates', ContractTemplateController::class);











        // ==============   Document Archive Tab   ==============  //
        Route::post('document_archives/update-document-archive-status', [DocumentArchivesController::class, 'updateDocumentArchiveStatus'])->name('document_archives.update_document_archive_status');
        Route::resource('document_archives', DocumentArchivesController::class);







        // ==============   Site Setting  Tab   ==============  //
        Route::get('site_setting/site_infos', [SiteSettingsController::class, 'show_main_informations'])->name('settings.site_main_infos.show');
        Route::post('site_setting/update_site_info/{id?}', [SiteSettingsController::class, 'update_main_informations'])->name('settings.site_main_infos.update');
        Route::post('site_setting/site_infos/remove-image', [SiteSettingsController::class, 'remove_image'])->name('site_infos.remove_image');
        //to remove album 
        Route::post('site_setting/site_infos/remove-site_settings_albums', [SiteSettingsController::class, 'remove_site_settings_albums'])->name('site_infos.remove_site_settings_albums');
        //for logos 
        Route::post('site_setting/site_infos/remove-site-logo-large-light', [SiteSettingsController::class, 'remove_site_logo_large_light'])->name('site_infos.remove_site_logo_large_light');
        Route::post('site_setting/site_infos/remove_site_logo_small_light', [SiteSettingsController::class, 'remove_site_logo_small_light'])->name('site_infos.remove_site_logo_small_light');
        //---------------
        Route::post('site_setting/site_infos/remove_site_logo_large_dark', [SiteSettingsController::class, 'remove_site_logo_large_dark'])->name('site_infos.remove_site_logo_large_dark');
        Route::post('site_setting/site_infos/remove_site_logo_small_dark', [SiteSettingsController::class, 'remove_site_logo_small_dark'])->name('site_infos.remove_site_logo_small_dark');

        Route::get('site_setting/site_contacts', [SiteSettingsController::class, 'show_contact_informations'])->name('settings.site_contacts.show');
        Route::post('site_setting/update_site_contact/{id?}', [SiteSettingsController::class, 'update_contact_informations'])->name('settings.site_contacts.update');

        Route::get('site_setting/site_socials', [SiteSettingsController::class, 'show_socail_informations'])->name('settings.site_socials.show');
        Route::post('site_setting/update_site_social/{id?}', [SiteSettingsController::class, 'update_social_informations'])->name('settings.site_socials.update');

        Route::get('site_setting/site_metas', [SiteSettingsController::class, 'show_meta_informations'])->name('settings.site_meta.show');
        Route::post('site_setting/update_site_meta/{id?}', [SiteSettingsController::class, 'update_meta_informations'])->name('settings.site_meta.update');

        // ==============   Admin Acount Tab   ==============  //
        Route::get('account_settings', [BackendController::class, 'account_settings'])->name('account_settings');
        Route::post('admin/remove-image', [BackendController::class, 'remove_image'])->name('remove_image');
        Route::patch('account_settings', [BackendController::class, 'update_account_settings'])->name('update_account_settings');


        // ==============   Theme Icon To Style Website Ready ==============  //
        Route::post('/cookie/create/update', [BackendController::class, 'create_update_theme'])->name('create_update_theme');
    });
});
