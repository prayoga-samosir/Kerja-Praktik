<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Master\RegionController;
use App\Http\Controllers\Master\PoolingController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\News\CountryController;
use App\Http\Controllers\News\AgeController;
use App\Http\Controllers\News\ProvinceController;
use App\Http\Controllers\News\BloodController;
use App\Http\Controllers\News\EthnicController;
use App\Http\Controllers\News\FamilyController;
use App\Http\Controllers\News\ChurchController;
use App\Http\Controllers\News\EventController;
use App\Http\Controllers\News\MemberController;
use App\Http\Controllers\Report\MemberController as MemberReport;
use App\Http\Controllers\Report\AttendanceController as AttendanceReport;
use App\Http\Controllers\Report\VisitationController as VisitationReport;
use App\Http\Controllers\Report\DevotionalController as DevotionalReport;
use App\Http\Controllers\Report\EventController as EventReport;
use App\Http\Controllers\News\EducationController;
use App\Http\Controllers\News\HobbyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SysGroupController;
use App\Http\Controllers\MemberPrintController;
use App\Http\Controllers\MySettingController;
use App\Http\Controllers\News\GuestController;

// use DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//  dd(DB::select("SELECT * FROM chc_member"));
// });



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/coba', function () {
    return view('coba');
});

Route::get('/clear-cache', function () {
    // Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Berhasil";
});

Route::view('/', 'welcome');

Route::get('/mydevotional', 'WelcomeController@devotionalfooter');
Route::get('/mydevotional/datedisplay', 'WelcomeController@datedisplay');
Route::get('/guestdevotional/{id}', 'WelcomeController@devotional');
// Route::get('/', 'WelcomeController@index');
Route::get('/mycard', 'WelcomeController@mycard');
Auth::routes();


Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/login/user', 'Auth\LoginController@showUserLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('/register/user', 'Auth\RegisterController@showUserRegisterForm');

Route::get('/passwordforgot', 'Auth\LoginController@forget');
Route::post('/passwordforgot', 'Auth\ForgotPasswordController@forget');
Route::get('/passwordreset', 'Auth\ResetPasswordController@getForm');
Route::post('/passwordreset', 'Auth\ResetPasswordController@resetPassword');
Route::get('/resetresult', 'Auth\ResetPasswordController@result');

Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('logout_error', 'Auth\LoginController@logout');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::post('/login/admin', 'Auth\LoginController@adminLogin')->name('login.admin');
Route::post('/login/user', 'Auth\LoginController@userLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/user', 'Auth\RegisterController@createUser');

Route::view('/home', 'home')->middleware('auth');
Route::view('/cek', 'home')->middleware(['cek' => 'cek:1']);
Route::group(['middleware' => 'auth:admin'], function () {
    Route::view('/cetak_card1', 'card1');
    // Route::view('/cetak_profile', 'CardController@index');
    Route::get('memberprint/{id}', [MemberPrintController::class, 'index']);
    Route::get('filter_statistik', 'Master\RegionController@filter')->middleware(['cek' => 'cek:all']);

    Route::get('/index', 'HomeController@index')->middleware(['cek' => 'cek:all']);
    Route::get('/highchart', 'HighchartController@highchart1');
    Route::get('/highchart', 'HighchartController@highchart1');
    Route::get('/highchart2', 'HighchartController@highchart2');

    // Route::view('/highchart', 'highchart');
    Route::view('/privacy', 'privacy');
    Route::view('/contact', 'contact');
    Route::view('/video', 'video');
    Route::get('generate-pdf', 'PDFController@index')->middleware(['cek' => 'cek:all']);
    Route::post('save-qr', 'PDFController@simpan')->middleware(['cek' => 'cek:all']);
    Route::post('scan-qr', 'PDFController@scanqr')->middleware(['cek' => 'cek:all']);
    // profile
    // Route::get('/sample', 'SampleController@index')->middleware(['cek' => 'cek:all']);
    Route::view('/sample', 'sample/index')->middleware(['cek' => 'cek:all']);
    Route::view('/myhelp', 'faqs')->middleware(['cek' => 'cek:all']);
    // Route::get('mysetting', [MySettingController::class, 'index']);
    // Route::post('/update-settings', 'MySettingController@updateSettings')->name('update.settings');
    Route::get('/mysetting', 'MySettingController@index')->middleware(['cek' => 'cek:all']);
    Route::post('/mysetting', 'MySettingController@update')->middleware(['cek' => 'cek:all']);

    // Route::post('mysetting', 'MySettingController@settingstore')->middleware(['cek' => 'cek:all']);
    Route::view('/member', 'member')->middleware(['cek' => 'cek:all']);

    // MYMEMBER
    Route::get('/mymember', 'MyMemberController@index')->middleware(['cek' => 'cek:all']);
    Route::get('/mymember/search', 'MyMemberController@search')->middleware(['cek' => 'cek:all']);

    // MEMBER
    Route::get('/member', 'MemberController@index')->middleware(['cek' => 'cek:11201']);
    Route::get('/member/search', 'MemberController@search')->middleware(['cek' => 'cek:11201']);
    Route::get('/member/searchabjad', 'MemberController@searchabjad')->middleware(['cek' => 'cek:11201']);
    Route::post('/member/add', 'MemberController@memberadd')->middleware(['cek' => 'cek:11201']);

    // GUEST
    Route::get('/guest', 'GuestController@index')->middleware(['cek' => 'cek:11202']);
    Route::get('/guest/search', 'GuestController@search')->middleware(['cek' => 'cek:11202']);
    Route::get('/guest/searchabjad', 'GuestController@searchabjad')->middleware(['cek' => 'cek:11202']);
    Route::post('/guest/add', 'GuestController@guestadd')->middleware(['cek' => 'cek:11202']);
    Route::get('/profile-guest/{id}', 'GuestController@guest')->middleware(['cek' => 'cek:all']);
    Route::post('/profile-guest/{id}', 'GuestController@gueststore')->middleware(['cek' => 'cek:all']);
    Route::get('/edit-guest/{id}', 'GuestController@guestview')->middleware(['cek' => 'cek:all']);

    // reservation
    Route::view('seatreservation', 'reservation/seatreservation')->middleware(['cek' => 'cek:all']);
    Route::post('save-seat', 'SeatController@simpan')->middleware(['cek' => 'cek:all']);
    Route::post('get-seat', 'SeatController@ambil')->middleware(['cek' => 'cek:all']);



    // PROFILE
    Route::get('/myprofile', 'MyProfileController@index')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/change_picture', 'MyProfileController@change_picture')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/change_picture', 'MyProfileController@picturestore')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/self_desc', 'MyProfileController@self_desc')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/self_desc', 'MyProfileController@selfstore')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/self_desc/delete', 'MyProfileController@selfdelete')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/member', 'MyProfileController@member')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/member', 'MyProfileController@memberstore')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/member/delete/{id}', 'MyProfileController@memberdelete')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/address', 'MyProfileController@address')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/address', 'MyProfileController@storeaddress')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/contact', 'MyProfileController@contact')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/contact', 'MyProfileController@storecontact')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/socialmedia', 'MyProfileController@storesocialmedia')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/family', 'MyProfileController@family')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/family', 'MyProfileController@storefamily')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/setting', 'MyProfileController@setting')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/setting', 'MyProfileController@storesetting')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/socialmedia', 'MyProfileController@socialmedia')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/info', 'MyProfileController@info')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/info', 'MyProfileController@infostore')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/info/delete', 'MyProfileController@infodelete')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/commission/{id}', 'MyProfileController@commission')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/commission', 'MyProfileController@storecommission')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/commission/delete', 'MyProfileController@commissiondelete')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/occupation/{id}', 'MyProfileController@occupation')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/occupation', 'MyProfileController@occupationstore')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/occupation/delete', 'MyProfileController@occupationdelete')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/ministry/{id}', 'MyProfileController@ministry')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/ministry', 'MyProfileController@ministrystore')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/ministry/delete', 'MyProfileController@ministrydelete')->middleware(['cek' => 'cek:all']);



    Route::get('/myprofile/expertise/{id}', 'MyProfileController@expertise')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/expertise', 'MyProfileController@expertisestore')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/expertise/delete/{id}', 'MyProfileController@expertisedelete')->middleware(['cek' => 'cek:all']);

    Route::get('/myprofile/education/{id}', 'MyProfileController@education_detail')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/education/add', 'MyProfileController@educationadd')->middleware(['cek' => 'cek:all']);
    Route::post('myprofile/education/store', 'MyProfileController@educationstore')->name('education.store')->middleware(['cek' => 'cek:all']);

    // Tambah data
    Route::post('/myprofile/occupation/add', 'MyProfileController@occupationadd')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/expertise/add', 'MyProfileController@expertiseadd')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/commission/add', 'MyProfileController@commissionadd')->middleware(['cek' => 'cek:all']);
    Route::post('/myprofile/ministry/add', 'MyProfileController@ministryadd')->middleware(['cek' => 'cek:all']);

    // Hapus data
    Route::get('/myprofile/education/delete/{id}', 'MyProfileController@educationdelete')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/ministry/delete/{id}', 'MyProfileController@ministrydelete')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/expertise/delete/{id}', 'MyProfileController@expertisedelete')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/commission/delete/{id}', 'MyProfileController@commissiondelete')->middleware(['cek' => 'cek:all']);
    Route::get('/myprofile/occupation/delete/{id}', 'MyProfileController@occupationdelete')->middleware(['cek' => 'cek:all']);


    // profile

    Route::get('/profile/{id}', 'ProfileController@index')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/self_desc/{id}', 'ProfileController@self_desc')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/self_desc', 'ProfileController@selfstore')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/self_desc/delete/{id}', 'ProfileController@selfdelete')->middleware(['cek' => 'cek:all']);
    // Route::view('/cetak_profile/{id}', 'ProfileController@card');
    Route::get('/profile/member/{id}', 'ProfileController@member')->middleware(['cek' => 'cek:all']);
    // Route::get('/profile/guest/{id}', 'ProfileController@guest')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/member', 'ProfileController@memberstore')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/member/delete/{id}', 'ProfileController@memberdelete')->middleware(['cek' => 'cek:all']);

    Route::get('/profile/address/{id}', 'ProfileController@address')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/address', 'ProfileController@storeaddress')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/contact/{id}', 'ProfileController@contact')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/contact', 'ProfileController@storecontact')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/socialmedia', 'ProfileController@storesocialmedia')->middleware(['cek' => 'cek:all']);

    Route::get('/profile/family/{id}', 'ProfileController@family')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/family', 'ProfileController@storefamily')->middleware(['cek' => 'cek:all']);

    Route::get('/profile/setting/{id}', 'ProfileController@setting')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/setting', 'ProfileController@storesetting')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/socialmedia/{id}', 'ProfileController@socialmedia')->middleware(['cek' => 'cek:all']);

    Route::get('/profile/info/{id}', 'ProfileController@info')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/info', 'ProfileController@infostore')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/info/delete/{id}', 'ProfileController@infodelete')->middleware(['cek' => 'cek:all']);

    Route::get('/profile/commission/{id}/{get_id}', 'ProfileController@commission')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/commission', 'ProfileController@storecommission')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/commission/delete/{id}/{get_id}', 'ProfileController@commissiondelete')->middleware(['cek' => 'cek:all']);

    Route::get('/profile/occupation/{id}/{get_id}', 'ProfileController@occupation')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/occupation', 'ProfileController@occupationstore')->middleware(['cek' => 'cek:all']);
    Route::post('/profile1/occupation/add', 'ProfileController@occupationadd')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/occupation/delete/{id}/{get_id}', 'ProfileController@occupationdelete')->middleware(['cek' => 'cek:all']);

    Route::get('/profile/ministry/{id}/{get_id}', 'ProfileController@ministry')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/ministry/', 'ProfileController@ministrystore')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/ministry/delete/{id}', 'ProfileController@ministrydelete')->middleware(['cek' => 'cek:all']);
    Route::post('/profile1/ministry/add', 'ProfileController@ministryadd')->middleware(['cek' => 'cek:all']);



    Route::get('/profile/expertise/{id}/{get_id}', 'ProfileController@expertise')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/expertise', 'ProfileController@expertisestore')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/expertise/delete/{id}', 'ProfileController@expertisedelete')->middleware(['cek' => 'cek:all']);
    Route::post('/profile1/expertise/add/', [ProfileController::class, 'expertiseadd'])->name('profile.expertise.add')->middleware(['cek' => 'cek:all']);

    Route::get('/profile/education/{id}/{get_id}', 'ProfileController@education_detail')->middleware(['cek' => 'cek:all']);
    Route::post('/profile/education/add', 'ProfileController@educationadd')->middleware(['cek' => 'cek:all']);
    Route::post('profile/education/store', 'ProfileController@educationstore')->name('profile.education.store')->middleware(['cek' => 'cek:all']);

    // Tambah data


    Route::post('/profile/commission/add', 'ProfileController@commissionadd')->middleware(['cek' => 'cek:all']);

    // Hapus data
    Route::get('/profile/education/delete/{id}/{get_id}', 'ProfileController@educationdelete')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/ministry/delete/{id}/{get_id}', 'ProfileController@ministrydelete')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/expertise/delete/{id}/{get_id}', 'ProfileController@expertisedelete')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/commission/delete/{id}/{get_id}', 'ProfileController@commissiondelete')->middleware(['cek' => 'cek:all']);
    Route::get('/profile/occupation/delete/{id}/{get_id}', 'ProfileController@occupationdelete')->middleware(['cek' => 'cek:all']);


    // mymemberprofile
    // PROFILE
    Route::get('/mymemberprofile/{id}', 'MyMemberProfileController@index')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/self_desc', 'MyMemberProfileController@self_desc')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/self_desc', 'MyMemberProfileController@selfstore')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/self_desc/delete', 'MyMemberProfileController@selfdelete')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/member', 'MyMemberProfileController@member')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/member', 'MyMemberProfileController@memberstore')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/member/delete/{id}', 'MyMemberProfileController@memberdelete')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/address', 'MyMemberProfileController@address')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/address', 'MyMemberProfileController@storeaddress')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/contact', 'MyMemberProfileController@contact')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/contact', 'MyMemberProfileController@storecontact')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/socialmedia', 'MyMemberProfileController@storesocialmedia')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/family', 'MyMemberProfileController@family')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/family', 'MyMemberProfileController@storefamily')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/setting', 'MyMemberProfileController@setting')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/setting', 'MyMemberProfileController@storesetting')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/socialmedia', 'MyMemberProfileController@socialmedia')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/info', 'MyMemberProfileController@info')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/info', 'MyMemberProfileController@infostore')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/info/delete', 'MyMemberProfileController@infodelete')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/commission/{id}', 'MyMemberProfileController@commission')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/commission', 'MyMemberProfileController@storecommission')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/commission/delete', 'MyMemberProfileController@commissiondelete')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/occupation/{id}', 'MyMemberProfileController@occupation')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/occupation', 'MyMemberProfileController@occupationstore')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/occupation/delete', 'MyMemberProfileController@occupationdelete')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/ministry/{id}', 'MyMemberProfileController@ministry')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/ministry', 'MyMemberProfileController@ministrystore')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/ministry/delete', 'MyMemberProfileController@ministrydelete')->middleware(['cek' => 'cek:all']);



    Route::get('/mymemberprofile/expertise/{id}', 'MyMemberProfileController@expertise')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/expertise', 'MyMemberProfileController@expertisestore')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/expertise/delete/{id}', 'MyMemberProfileController@expertisedelete')->middleware(['cek' => 'cek:all']);

    Route::get('/mymemberprofile/education/{id}', 'MyMemberProfileController@education_detail')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/education/add', 'MyMemberProfileController@educationadd')->middleware(['cek' => 'cek:all']);
    Route::post('/education/store', 'MyMemberProfileController@educationstore')->name('education.store')->middleware(['cek' => 'cek:all']);

    // Tambah data
    Route::post('/mymemberprofile/occupation/add', 'MyMemberProfileController@occupationadd')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/expertise/add', 'MyMemberProfileController@expertiseadd')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/commission/add', 'MyMemberProfileController@commissionadd')->middleware(['cek' => 'cek:all']);
    Route::post('/mymemberprofile/ministry/add', 'MyMemberProfileController@ministryadd')->middleware(['cek' => 'cek:all']);

    // Hapus data
    Route::get('/mymemberprofile/education/delete/{id}', 'MyMemberProfileController@educationdelete')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/ministry/delete/{id}', 'MyMemberProfileController@ministrydelete')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/expertise/delete/{id}', 'MyMemberProfileController@expertisedelete')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/commission/delete/{id}', 'MyMemberProfileController@commissiondelete')->middleware(['cek' => 'cek:all']);
    Route::get('/mymemberprofile/occupation/delete/{id}', 'MyMemberProfileController@occupationdelete')->middleware(['cek' => 'cek:all']);





    // MASTER DATA
    Route::get('/region', 'Master\RegionController@index')->middleware(['cek' => 'cek:11101']);
    Route::get('/region/data', 'Master\RegionController@getData')->middleware(['cek' => 'cek:11101']);
    Route::get('region/delete/{id}', 'Master\RegionController@destroy')->middleware(['cek' => 'cek:11101']);
    Route::get('/region/edit/{id}', 'Master\RegionController@edit')->middleware(['cek' => 'cek:11101']);
    Route::get('/region/detail/{id}', 'Master\RegionController@detail')->middleware(['cek' => 'cek:11101']);
    Route::get('/news/detail/{id}', 'News\NewsController@detail')->middleware(['cek' => 'cek:11101']);
    Route::post('/region/store', 'Master\RegionController@store')->name('region.store')->middleware(['cek' => 'cek:11101']);
    Route::post('/region/update', 'Master\RegionController@update')->name('region.update')->middleware(['cek' => 'cek:11101']);
    Route::get('region/search', 'Master\RegionController@search')->middleware(['cek' => 'cek:11101']);

    // sector
    Route::get('sector/delete/{id}', 'Master\SectorController@destroy')->middleware(['cek' => 'cek:11101']);
    Route::get('sector/search', 'Master\SectorController@search')->middleware(['cek' => 'cek:11101']);
    Route::get('/sector/edit/{id}', 'Master\SectorController@edit')->middleware(['cek' => 'cek:11101']);
    Route::get('/sector/detail/{id}', 'Master\SectorController@detail')->middleware(['cek' => 'cek:11101']);
    Route::get('/news/detail/{id}', 'News\NewsController@detail')->middleware(['cek' => 'cek:11101']);
    Route::post('/sector/store', 'Master\SectorController@store')->name('sector.store')->middleware(['cek' => 'cek:11101']);
    Route::post('/sector/update', 'Master\SectorController@update')->name('sector.update')->middleware(['cek' => 'cek:11101']);

    // pooling
    Route::post('/pooling/store', 'Master\PoolingController@store')->name('pooling.store')->middleware(['cek' => 'cek:11101']);
    Route::get('pooling/search', 'Master\PoolingController@search')->middleware(['cek' => 'cek:11101']);
    Route::get('/pooling/edit/{id}', 'Master\PoolingController@edit')->middleware(['cek' => 'cek:11101']);
    Route::get('/pooling/detail/{id}', 'Master\PoolingController@detail')->middleware(['cek' => 'cek:11101']);
    Route::post('/pooling/update', 'Master\PoolingController@update')->name('pooling.update')->middleware(['cek' => 'cek:11101']);
    Route::get('pooling/delete/{id}', 'Master\PoolingController@destroy')->middleware(['cek' => 'cek:11101']);

    // compass
    Route::get('compass/search', 'Master\CompassController@search')->middleware(['cek' => 'cek:11101']);
    Route::get('/compass/detail/{id}', 'Master\CompassController@detail')->middleware(['cek' => 'cek:11101']);



    // country
    Route::get('/country', 'Master\CountryController@index')->middleware(['cek' => 'cek:11102']);
    Route::get('country/search', 'Master\CountryController@search')->middleware(['cek' => 'cek:11102']);
    Route::get('/country/detail/{id}', 'Master\CountryController@detail')->middleware(['cek' => 'cek:11102']);

    Route::get('province/search', 'Master\ProvinceController@search')->middleware(['cek' => 'cek:11102']);
    Route::get('/province/detail/{id}', 'Master\ProvinceController@detail')->middleware(['cek' => 'cek:11102']);
    Route::get('/province/edit/{id}', 'Master\ProvinceController@edit')->middleware(['cek' => 'cek:11102']);
    Route::post('/province/store', 'Master\ProvinceController@store')->name('province.store')->middleware(['cek' => 'cek:11102']);
    Route::post('/province/update', 'Master\ProvinceController@update')->name('province.update')->middleware(['cek' => 'cek:11102']);
    Route::get('province/delete/{id}', 'Master\ProvinceController@destroy')->middleware(['cek' => 'cek:11102']);

    Route::post('/city/store', 'Master\CityController@store')->name('city.store')->middleware(['cek' => 'cek:11102']);
    Route::get('city/search', 'Master\CityController@search')->middleware(['cek' => 'cek:11102']);
    Route::get('/city/edit/{id}', 'Master\CityController@edit')->middleware(['cek' => 'cek:11102']);
    Route::get('/city/detail/{id}', 'Master\CityController@detail')->middleware(['cek' => 'cek:11102']);
    Route::post('/city/update', 'Master\CityController@update')->name('city.update')->middleware(['cek' => 'cek:11102']);
    Route::get('city/delete/{id}', 'Master\CityController@destroy')->middleware(['cek' => 'cek:11102']);


    Route::get('/education', 'Master\EducationController@index')->middleware(['cek' => 'cek:11103']);
    Route::get('education/search', 'Master\EducationController@search')->middleware(['cek' => 'cek:11103']);
    Route::get('/education/detail/{id}', 'Master\EducationController@detail')->middleware(['cek' => 'cek:11103']);

    Route::post('/occupation/store', 'Master\OccupationController@store')->name('occupation.store')->middleware(['cek' => 'cek:11103']);
    Route::get('occupation/search', 'Master\OccupationController@search')->middleware(['cek' => 'cek:11103']);
    Route::get('/occupation/edit/{id}', 'Master\OccupationController@edit')->middleware(['cek' => 'cek:11103']);
    Route::get('/occupation/detail/{id}', 'Master\OccupationController@detail')->middleware(['cek' => 'cek:11103']);
    Route::post('/occupation/update', 'Master\OccupationController@update')->name('occupation.update')->middleware(['cek' => 'cek:11103']);
    Route::get('occupation/delete/{id}', 'Master\OccupationController@destroy')->middleware(['cek' => 'cek:11103']);

    Route::post('/hobby/store', 'Master\HobbyController@store')->name('hobby.store')->middleware(['cek' => 'cek:11103']);
    Route::get('hobby/search', 'Master\HobbyController@search')->middleware(['cek' => 'cek:11103']);
    Route::get('/hobby/edit/{id}', 'Master\HobbyController@edit')->middleware(['cek' => 'cek:11103']);
    Route::get('/hobby/detail/{id}', 'Master\HobbyController@detail')->middleware(['cek' => 'cek:11103']);
    Route::post('/hobby/update', 'Master\HobbyController@update')->name('hobby.update')->middleware(['cek' => 'cek:11103']);
    Route::get('hobby/delete/{id}', 'Master\HobbyController@destroy')->middleware(['cek' => 'cek:11103']);


    // ethnic

    Route::get('/age', 'Master\AgeController@index')->middleware(['cek' => 'cek:11104']);
    Route::get('age/search', 'Master\AgeController@search')->middleware(['cek' => 'cek:11104']);
    Route::get('/age/detail/{id}', 'Master\AgeController@detail')->middleware(['cek' => 'cek:11104']);

    Route::get('/blood', 'Master\BloodController@index')->middleware(['cek' => 'cek:11104']);
    Route::get('blood/search', 'Master\BloodController@search')->middleware(['cek' => 'cek:11104']);
    Route::get('/blood/detail/{id}', 'Master\BloodController@detail')->middleware(['cek' => 'cek:11104']);

    Route::post('/ethnic/store', 'Master\EthnicController@store')->name('ethnic.store')->middleware(['cek' => 'cek:11104']);
    Route::get('ethnic/search', 'Master\EthnicController@search')->middleware(['cek' => 'cek:11104']);
    Route::get('/ethnic/edit/{id}', 'Master\EthnicController@edit')->middleware(['cek' => 'cek:11104']);
    Route::get('/ethnic/detail/{id}', 'Master\EthnicController@detail')->middleware(['cek' => 'cek:11104']);
    Route::post('/ethnic/update', 'Master\EthnicController@update')->name('ethnic.update')->middleware(['cek' => 'cek:11104']);
    Route::get('ethnic/delete/{id}', 'Master\EthnicController@destroy')->middleware(['cek' => 'cek:11104']);

    Route::get('/family', 'Master\FamilyController@index')->middleware(['cek' => 'cek:11105']);
    Route::get('family/search', 'Master\FamilyController@search')->middleware(['cek' => 'cek:11105']);
    Route::get('/family/detail/{id}', 'Master\FamilyController@detail')->middleware(['cek' => 'cek:11105']);

    Route::get('/marriage', 'Master\MarriageController@index')->middleware(['cek' => 'cek:11105']);
    Route::get('marriage/search', 'Master\MarriageController@search')->middleware(['cek' => 'cek:11105']);
    Route::get('/marriage/detail/{id}', 'Master\MarriageController@detail')->middleware(['cek' => 'cek:11105']);
    Route::get('/marriage/edit/{id}', 'Master\MarriageController@edit')->middleware(['cek' => 'cek:11105']);
    Route::post('/marriage/store', 'Master\MarriageController@store')->name('marriage.store')->middleware(['cek' => 'cek:11105']);
    Route::post('/marriage/update', 'Master\MarriageController@update')->name('marriage.update')->middleware(['cek' => 'cek:11105']);

    Route::get('/statusmember', 'Master\MemberController@index')->middleware(['cek' => 'cek:11106']);
    Route::post('/statusmember/store', 'Master\MemberController@store')->name('member.store')->middleware(['cek' => 'cek:11106']);
    Route::get('statusmember/search', 'Master\MemberController@search')->middleware(['cek' => 'cek:11106']);
    Route::get('/statusmember/edit/{id}', 'Master\MemberController@edit')->middleware(['cek' => 'cek:11106']);
    Route::get('/statusmember/detail/{id}', 'Master\MemberController@detail')->middleware(['cek' => 'cek:11106']);
    Route::post('/statusmember/update', 'Master\MemberController@update')->name('member.update')->middleware(['cek' => 'cek:11106']);
    Route::get('statusmember/delete/{id}', 'Master\MemberController@destroy')->middleware(['cek' => 'cek:11106']);

    Route::get('mutation/search', 'Master\MutationController@search')->middleware(['cek' => 'cek:11106']);
    Route::get('/mutation/detail/{id}', 'Master\MutationController@detail')->middleware(['cek' => 'cek:11106']);
    Route::get('/mutation/edit/{id}', 'Master\MutationController@edit')->middleware(['cek' => 'cek:11106']);
    Route::post('/mutation/store', 'Master\MutationController@store')->name('mutation.store')->middleware(['cek' => 'cek:11106']);
    Route::post('/mutation/update', 'Master\MutationController@update')->name('mutation.update')->middleware(['cek' => 'cek:11106']);
    Route::get('mutation/delete/{id}', 'Master\MutationController@destroy')->middleware(['cek' => 'cek:11106']);

    Route::get('/ministry', 'Master\MinistryController@index')->middleware(['cek' => 'cek:11107']);
    Route::post('/ministry/store', 'Master\MinistryController@store')->name('ministry.store')->middleware(['cek' => 'cek:11107']);
    Route::get('ministry/search', 'Master\MinistryController@search')->middleware(['cek' => 'cek:11107']);
    Route::get('/ministry/edit/{id}', 'Master\MinistryController@edit')->middleware(['cek' => 'cek:11107']);
    Route::get('/ministry/detail/{id}', 'Master\MinistryController@detail')->middleware(['cek' => 'cek:11107']);
    Route::post('/ministry/update', 'Master\MinistryController@update')->name('ministry.update')->middleware(['cek' => 'cek:11107']);
    Route::get('ministry/delete/{id}', 'Master\MinistryController@destroy')->middleware(['cek' => 'cek:11107']);

    Route::get('commission/search', 'Master\CommissionController@search')->middleware(['cek' => 'cek:11107']);
    Route::get('/commission/detail/{id}', 'Master\CommissionController@detail')->middleware(['cek' => 'cek:11107']);
    Route::get('/commission/edit/{id}', 'Master\CommissionController@edit')->middleware(['cek' => 'cek:11107']);
    Route::post('/commission/store', 'Master\CommissionController@store')->name('commission.store')->middleware(['cek' => 'cek:11107']);
    Route::post('/commission/update', 'Master\CommissionController@update')->name('commission.update')->middleware(['cek' => 'cek:11107']);
    Route::get('commission/delete/{id}', 'Master\CommissionController@destroy')->middleware(['cek' => 'cek:11107']);

    Route::get('/event', 'Master\EventController@index')->middleware(['cek' => 'cek:11108']);
    Route::get('eventregular/search', 'Master\EventController@searchregular')->middleware(['cek' => 'cek:11108']);
    Route::get('eventnonregular/search', 'Master\EventController@searchnonregular')->middleware(['cek' => 'cek:11108']);


    Route::get('/eventregular/detail/{id}', 'Master\EventController@detailRegular')->middleware(['cek' => 'cek:11108']);
    Route::get('/eventnonregular/detail/{id}', 'Master\EventController@detailNonRegular')->middleware(['cek' => 'cek:11108']);
    Route::get('/eventregular/edit/{id}', 'Master\EventController@editRegular')->middleware(['cek' => 'cek:11108']);
    Route::get('/eventnonregular/edit/{id}', 'Master\EventController@editNonRegular')->middleware(['cek' => 'cek:11108']);

    Route::get('/event/edit/{id}', 'Master\EventController@edit')->middleware(['cek' => 'cek:11108']);
    Route::post('/eventregular/store', 'Master\EventController@storeReg')->name('eventregular.store')->middleware(['cek' => 'cek:11108']);
    Route::post('/eventregular/update', 'Master\EventController@updateReg')->name('eventregular.update')->middleware(['cek' => 'cek:11108']);
    Route::post('/eventnonregular/store', 'Master\EventController@storeNonReg')->name('eventnonregular.store')->middleware(['cek' => 'cek:11108']);
    Route::post('/eventnonregular/update', 'Master\EventController@updateNonReg')->name('eventnonregular.update')->middleware(['cek' => 'cek:11108']);
    Route::get('eventregular/delete/{id}', 'Master\EventController@destroyReg')->middleware(['cek' => 'cek:11108']);
    Route::get('eventnonregular/delete/{id}', 'Master\EventController@destroyNonReg')->middleware(['cek' => 'cek:11108']);

    Route::get('visit', 'Master\VisitController@index')->middleware(['cek' => 'cek:11109']);

    Route::get('visstatus/search', 'Master\VisitController@searchStatus')->middleware(['cek' => 'cek:11109']);
    Route::get('/visstatus/detail/{id}', 'Master\VisitController@detailStatus')->middleware(['cek' => 'cek:11109']);

    Route::get('visprivacy/search', 'Master\VisitController@searchPrivacy')->middleware(['cek' => 'cek:11109']);
    Route::get('/visprivacy/detail/{id}', 'Master\VisitController@detailPrivacy')->middleware(['cek' => 'cek:11109']);

    Route::get('vispriority/search', 'Master\VisitController@searchPriority')->middleware(['cek' => 'cek:11109']);
    Route::get('/vispriority/detail/{id}', 'Master\VisitController@detailPriority')->middleware(['cek' => 'cek:11109']);

    Route::get('visreason/search', 'Master\VisitController@searchReason')->middleware(['cek' => 'cek:11109']);
    Route::get('/visreason/detail/{id}', 'Master\VisitController@detailReason')->middleware(['cek' => 'cek:11109']);

    Route::get('/church', 'Master\ChurchController@index')->middleware(['cek' => 'cek:11110']);
    Route::get('church/search', 'Master\ChurchController@search')->middleware(['cek' => 'cek:11110']);
    Route::get('/church/detail/{id}', 'Master\ChurchController@detail')->middleware(['cek' => 'cek:11110']);
    Route::get('/church/edit/{id}', 'Master\ChurchController@edit')->middleware(['cek' => 'cek:11110']);
    Route::post('/church/store', 'Master\ChurchController@store')->name('church.store')->middleware(['cek' => 'cek:11110']);
    Route::post('/church/update', 'Master\ChurchController@update')->name('church.update')->middleware(['cek' => 'cek:11110']);
    Route::get('church/delete/{id}', 'Master\ChurchController@destroy')->middleware(['cek' => 'cek:11110']);

    Route::post('/verse/store', 'Master\VerseController@store')->name('verse.store')->middleware(['cek' => 'cek:11110']);
    Route::get('verse/search', 'Master\VerseController@search')->middleware(['cek' => 'cek:11110']);
    Route::get('/verse/edit/{id}', 'Master\VerseController@edit')->middleware(['cek' => 'cek:11110']);
    Route::get('/verse/detail/{id}', 'Master\VerseController@detail')->middleware(['cek' => 'cek:11110']);
    Route::post('/verse/update', 'Master\VerseController@update')->name('verse.update')->middleware(['cek' => 'cek:11110']);
    Route::get('verse/delete/{id}', 'Master\VerseController@destroy')->middleware(['cek' => 'cek:11110']);

    // location
    Route::get('/location', 'Master\LocationController@index')->middleware(['cek' => 'cek:11111']);
    Route::get('location/search', 'Master\LocationController@search')->middleware(['cek' => 'cek:11111']);
    Route::get('/location/detail/{id}', 'Master\LocationController@detail')->middleware(['cek' => 'cek:11111']);

    Route::view('qrgenerator', 'qrcode.qrgenerator')->middleware(['cek' => 'cek:11112']);
    Route::view('myqrscan', 'qrcode.qrscanner')->middleware(['cek' => 'cek:11112']);

    Route::get('/devotional', 'Schedules\DevotionalController@index')->middleware(['cek' => 'cek:11113']);
    Route::get('/devotional/add', 'Schedules\DevotionalController@add')->middleware(['cek' => 'cek:11113']);
    Route::get('/devotional/data', 'Schedules\DevotionalController@getData')->middleware(['cek' => 'cek:11113']);
    Route::get('devotional/delete/{id}', 'Schedules\DevotionalController@destroy')->middleware(['cek' => 'cek:11113']);
    Route::get('/devotional/edit/{id}', 'Schedules\DevotionalController@edit')->middleware(['cek' => 'cek:11113']);
    Route::get('/devotional/detail/{id}', 'Schedules\DevotionalController@detail')->middleware(['cek' => 'cek:11113']);
    Route::post('/devotional/store', 'Schedules\DevotionalController@store')->name('devotional.store')->middleware(['cek' => 'cek:11113']);
    Route::post('/devotional/update', 'Schedules\DevotionalController@update')->name('devotional.update')->middleware(['cek' => 'cek:11113']);
    Route::get('devotional/search', 'Schedules\DevotionalController@search')->middleware(['cek' => 'cek:11113']);
    Route::get('devotional/filterdate', 'DevotionalController@filterdate')->middleware(['cek' => 'cek:11113']);





    Route::get('/article/detail/{id}', 'Schedules\ArticleController@detail')->middleware(['cek' => 'cek:all']);
    Route::get('article/search', 'Schedules\ArticleController@search')->middleware(['cek' => 'cek:all']);

    // events
    Route::get('/events', 'Schedules\EventsController@index')->middleware(['cek' => 'cek:11303']);
    Route::get('/events/add', 'Schedules\EventsController@add')->middleware(['cek' => 'cek:11303']);
    Route::get('/events/data', 'Schedules\EventsController@getData')->middleware(['cek' => 'cek:11303']);
    Route::get('events/delete/{id}', 'Schedules\EventsController@destroy')->middleware(['cek' => 'cek:11303']);
    Route::get('/events/edit/{id}', 'Schedules\EventsController@edit')->middleware(['cek' => 'cek:11303']);
    Route::get('/events/detail/{id}', 'Schedules\EventsController@detail')->middleware(['cek' => 'cek:11303']);
    Route::post('/events/store', 'Schedules\EventsController@store')->name('events.store')->middleware(['cek' => 'cek:11303']);
    Route::post('/events/update', 'Schedules\EventsController@update')->name('events.update')->middleware(['cek' => 'cek:11303']);
    Route::get('events/search', 'Schedules\EventsController@search')->middleware(['cek' => 'cek:11303']);

    Route::post('eventnonregular/store', 'Schedules\EventNonRegularController@store')->middleware(['cek' => 'cek:11108']);

    Route::get('schedule/news/detail/{id}', 'Schedules\NewsController@detail')->middleware(['cek' => 'cek:11303']);
    Route::get('schedule/news/search', 'Schedules\NewsController@search')->middleware(['cek' => 'cek:11303']);


    // calender
    Route::get('/calender', 'Schedules\CalenderController@index')->middleware(['cek' => 'cek:11307']);
    Route::get('/calender/add', 'Schedules\CalenderController@add')->middleware(['cek' => 'cek:11307']);
    Route::get('/calender/detail/{id}', 'Schedules\CalenderController@detail')->middleware(['cek' => 'cek:11307']);
    Route::get('/calender/data', 'Schedules\CalenderController@getData')->middleware(['cek' => 'cek:11307']);


    // visitation 

    // My Visitation
    Route::get('myvisitation', 'MyVisitationController@index')->middleware(['cek' => 'cek:11602']);
    Route::get('myvisitation/add', 'MyVisitationController@add')->middleware(['cek' => 'cek:11602']);
    Route::get('myvisitation/data', 'MyVisitationController@getData')->middleware(['cek' => 'cek:11602']);
    Route::get('myvisitation/delete/{id}', 'MyVisitationController@destroy')->middleware(['cek' => 'cek:11602']);
    Route::get('myvisitation/edit/{id}', 'MyVisitationController@edit')->middleware(['cek' => 'cek:11602']);
    Route::get('myvisitation/detail/{id}', 'MyVisitationController@detail')->middleware(['cek' => 'cek:11602']);
    Route::post('myvisitation/store', 'MyVisitationController@store')->name('myvisitation.store')->middleware(['cek' => 'cek:11602']);
    Route::post('myvisitation/update', 'MyVisitationController@update')->name('myvisitation.update')->middleware(['cek' => 'cek:11602']);
    Route::get('myvisitation/search', 'MyVisitationController@search')->middleware(['cek' => 'cek:11602']);

    // vis requsest
    Route::get('visit/request', 'Schedules\Visit\RequestController@index')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/request/add', 'Schedules\Visit\RequestController@add')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/request/data', 'Schedules\Visit\RequestController@getData')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/request/delete/{id}', 'Schedules\Visit\RequestController@destroy')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/request/edit/{id}', 'Schedules\Visit\RequestController@edit')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/request/detail/{id}', 'Schedules\Visit\RequestController@detail')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/request/store', 'Schedules\Visit\RequestController@store')->name('visit.request.store')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/request/followup', 'Schedules\Visit\RequestController@followup')->name('visit.request.followup')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/request/update', 'Schedules\Visit\RequestController@update')->name('visit.request.update')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/request/search', 'Schedules\Visit\RequestController@search')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/request/myprofile/change_picture/{id}', 'Schedules\Visit\RequestController@change_picture')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/request/myprofile/change_picture', 'Schedules\Visit\RequestController@picturestore')->middleware(['cek' => 'cek:11301']);

    // myvis summary
    Route::get('visit/mysummary', 'Schedules\Visit\MySummaryController@index')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/mysummary/add', 'Schedules\Visit\MySummaryController@add')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/mysummary/data', 'Schedules\Visit\MySummaryController@getData')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/mysummary/delete/{id}', 'Schedules\Visit\MySummaryController@destroy')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/mysummary/edit/{id}', 'Schedules\Visit\MySummaryController@edit')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/mysummary/detail/{id}', 'Schedules\Visit\MySummaryController@detail')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/mysummary/store', 'Schedules\Visit\MySummaryController@store')->name('visit.mysummary.store')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/mysummary/update', 'Schedules\Visit\MySummaryController@update')->name('visit.mysummary.update')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/mysummary/search', 'Schedules\Visit\MySummaryController@search')->middleware(['cek' => 'cek:11301']);

    // vis schedule
    Route::get('visit/schedule', 'Schedules\Visit\ScheduleController@index')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/schedule/add', 'Schedules\Visit\ScheduleController@add')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/schedule/data', 'Schedules\Visit\ScheduleController@getData')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/schedule/delete/{id}', 'Schedules\Visit\ScheduleController@destroy')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/schedule/edit/{id}', 'Schedules\Visit\ScheduleController@edit')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/schedule/detail/{id}', 'Schedules\Visit\ScheduleController@detail')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/schedule/followup', 'Schedules\Visit\ScheduleController@followup')->name('visit.schedule.followup')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/schedule/store', 'Schedules\Visit\ScheduleController@store')->name('visit.schedule.store')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/schedule/update', 'Schedules\Visit\ScheduleController@update')->name('visit.schedule.update')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/schedule/search', 'Schedules\Visit\ScheduleController@search')->middleware(['cek' => 'cek:11301']);

    // vis summary
    Route::get('visit/summary', 'Schedules\Visit\SummaryController@index')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/summary/add', 'Schedules\Visit\SummaryController@add')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/summary/data', 'Schedules\Visit\SummaryController@getData')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/summary/delete/{id}', 'Schedules\Visit\SummaryController@destroy')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/summary/edit/{id}', 'Schedules\Visit\SummaryController@edit')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/summary/detail/{id}', 'Schedules\Visit\SummaryController@detail')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/summary/store', 'Schedules\Visit\SummaryController@store')->name('visit.summary.store')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/summary/update', 'Schedules\Visit\SummaryController@update')->name('visit.summary.update')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/summary/search', 'Schedules\Visit\SummaryController@search')->middleware(['cek' => 'cek:11301']);

    // visit Final Report
    Route::get('visit/finalreport', 'Schedules\Visit\FinalReportController@index')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/finalreport/add', 'Schedules\Visit\FinalReportController@add')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/finalreport/data', 'Schedules\Visit\FinalReportController@getData')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/finalreport/delete/{id}', 'Schedules\Visit\FinalReportController@destroy')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/finalreport/edit/{id}', 'Schedules\Visit\FinalReportController@edit')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/finalreport/detail/{id}', 'Schedules\Visit\FinalReportController@detail')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/finalreport/store', 'Schedules\Visit\FinalReportController@store')->name('visit.finalreport.store')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/finalreport/update', 'Schedules\Visit\FinalReportController@update')->name('visit.finalreport.update')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/finalreport/search', 'Schedules\Visit\FinalReportController@search')->middleware(['cek' => 'cek:11301']);

    // visit Final Report
    Route::get('visit/cancel', 'Schedules\Visit\CancelController@index')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/cancel/data', 'Schedules\Visit\CancelController@getData')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/cancel/delete/{id}', 'Schedules\Visit\CancelController@destroy')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/cancel/edit/{id}', 'Schedules\Visit\CancelController@edit')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/cancel/detail/{id}', 'Schedules\Visit\CancelController@detail')->middleware(['cek' => 'cek:11301']);
    Route::post('visit/cancel/update', 'Schedules\Visit\CancelController@update')->name('visit.cancel.update')->middleware(['cek' => 'cek:11301']);
    Route::get('visit/cancel/search', 'Schedules\Visit\CancelController@search')->middleware(['cek' => 'cek:11301']);

    // schedule personnels
    Route::get('schedule/personnels', 'Schedules\PersonnelsController@index')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/add', 'Schedules\PersonnelsController@add')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/search', 'Schedules\PersonnelsController@search')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/user_list', 'Schedules\PersonnelsController@user_list')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/job_list', 'Schedules\PersonnelsController@job_list')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/personnel_modal', 'Schedules\PersonnelsController@personnel_modal')->middleware(['cek' => 'cek:11306']);
    Route::post('schedule/personnel/store', 'Schedules\PersonnelsController@store')->name('schedule.personnels.store')->middleware(['cek' => 'cek:11306']);


    Route::get('schedule/personnels/eventreg/add', 'Schedules\PersonnelEventRegularController@add')->middleware(['cek' => 'cek:11306']);
    Route::post('schedule/personnel/eventreg/store', 'Schedules\PersonnelEventRegularController@store')->name('schedule.personnels.eventreg.store')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/eventreg/search', 'Schedules\PersonnelEventRegularController@search')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/eventreg/edit/{id}', 'Schedules\PersonnelEventRegularController@edit')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/eventnonreg/add', 'Schedules\PersonnelEventNonRegularController@add')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/eventnonreg/search', 'Schedules\PersonnelEventNonRegularController@search')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/personnels/eventnonreg/edit/{id}', 'Schedules\PersonnelEventNonRegularController@edit')->middleware(['cek' => 'cek:11306']);
    Route::post('schedule/personnel/eventnonreg/store', 'Schedules\PersonnelEventNonRegularController@store')->name('schedule.personnels.eventnonreg.store')->middleware(['cek' => 'cek:11306']);
    Route::get('schedule/eventreg/search', 'Schedules\EventRegularController@search')->middleware(['cek' => 'cek:11306']);


    // REPORT
    // Route::controller(MemberReport::class)->group(function () {
    //     Route::get('/report/member', 'index');
    // });
    Route::get('/report/member', [MemberReport::class, 'index']);
    Route::get('/report/attendance', [AttendanceReport::class, 'index']);
    Route::get('/report/visitation', [VisitationReport::class, 'index']);
    Route::get('/report/devotional', [DevotionalReport::class, 'index']);
    Route::get('/report/event', [EventReport::class, 'index']);


    // CONFIG

    // SYSGROUP
    Route::get('config/sysgroup', 'Config\SysGroupController@index')->middleware(['cek' => 'cek:11102']);
    Route::get('config/sysgroup/search', 'Config\SysGroupController@search')->middleware(['cek' => 'cek:11102']);
    Route::get('config/sysgroup/detail/{id}', 'Config\SysGroupController@detail')->middleware(['cek' => 'cek:11102']);

    // SYSGROUP
    Route::get('config/sysusergroup', 'Config\SysUserGroupController@index')->middleware(['cek' => 'cek:11102']);
    Route::get('config/sysusergroup/search', 'Config\SysUserGroupController@search')->middleware(['cek' => 'cek:11102']);
    Route::get('config/sysusergroup/detail/{id}', 'Config\SysUserGroupController@detail')->middleware(['cek' => 'cek:11102']);

    // SYSGROUP
    Route::get('config/sysmenu', 'Config\SysMenuController@index')->middleware(['cek' => 'cek:11102']);
    Route::get('config/sysmenu/search', 'Config\SysMenuController@search')->middleware(['cek' => 'cek:11102']);
    Route::get('config/sysmenu/detail/{id}', 'Config\SysMenuController@detail')->middleware(['cek' => 'cek:11102']);
});

Route::view('/user', 'home');
