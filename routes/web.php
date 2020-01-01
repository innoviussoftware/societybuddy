<?php

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
//     return view('societybuddy');
// })->name('index');

//http://18.190.94.153
Route::get('/', function () {
  if (Auth::check())
        {
             return redirect('admin/dashboard');
        } 
        else
        { 
          return view('auth.login');
        }
    
})->name('index');

Route::get('/logout', function () {
  if (Auth::check())
        {
             return redirect('admin/dashboard');
        } 
        else
        { 
          return view('auth.login');
        }
    
})->name('index');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacypolicy');

Route::get('/about', function () {
    return view('front.about');
})->name('about');

Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');

Auth::routes();

Route::post('/save-form', 'Admin\SocietyController@sendemail');

Route::post('/contact', 'Admin\MailController@sendfeedback');

Route::get('/home',function(){
   return redirect('admin/dashboard');
})->name('home');

Route::get('qrcode/{number}/{member}', function ($number,$member) {
  $c = $number.' '.$member; 
     return QrCode::size(300)->generate($c); 
 })->name('qrcode');

Route::name('admin.')->prefix('admin')->middleware(['auth'])->group(function () {
  Route::get('/', function(){
    return redirect('admin/dashboard');
  });
  Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');

  Route::get('/cities', 'Admin\CityController@index')->middleware(['role:admin|sub_admin'])->middleware(['role:admin|sub_admin'])->name('cities.index');
  Route::get('/cities/add', 'Admin\CityController@add')->middleware(['role:admin|sub_admin'])->name('cities.add');
  Route::post('/cities/store', 'Admin\CityController@store')->middleware(['role:admin|sub_admin'])->name('cities.store');
  Route::get('/cities/edit/{id}', 'Admin\CityController@edit')->middleware(['role:admin|sub_admin'])->name('cities.edit');
  Route::patch('/cities/update/{id}', 'Admin\CityController@update')->middleware(['role:admin|sub_admin'])->name('cities.update');
  Route::get('/cities/delete/{id}', 'Admin\CityController@delete')->middleware(['role:admin|sub_admin'])->name('cities.delete');
  Route::get('/cities/array/', 'Admin\CityController@cityArray')->middleware(['role:admin|sub_admin'])->name('cities.array');

  Route::get('/areas', 'Admin\AreaController@index')->middleware(['role:admin|sub_admin'])->name('areas.index');
  Route::get('/areas/add', 'Admin\AreaController@add')->middleware(['role:admin|sub_admin'])->name('areas.add');
  Route::post('/areas/store', 'Admin\AreaController@store')->middleware(['role:admin|sub_admin'])->name('areas.store');
  Route::get('/areas/edit/{id}', 'Admin\AreaController@edit')->middleware(['role:admin|sub_admin'])->name('areas.edit');
  Route::patch('/areas/update/{id}', 'Admin\AreaController@update')->middleware(['role:admin|sub_admin'])->name('areas.update');
  Route::get('/areas/delete/{id}', 'Admin\AreaController@delete')->middleware(['role:admin|sub_admin'])->name('areas.delete');
  Route::get('/areas/array/', 'Admin\AreaController@Array')->middleware(['role:admin|sub_admin'])->name('areas.array');
  Route::get('/areas/byCity/{city_id}', 'Admin\AreaController@areaByCity')->middleware(['role:admin|sub_admin'])->name('areas.bycity');

  Route::get('/guardes', 'Admin\GuardController@index')->middleware(['role:admin|sub_admin|society_admin'])->name('guardes.index');
  Route::get('/guardes/add', 'Admin\GuardController@add')->middleware(['role:admin|sub_admin|society_admin'])->name('guardes.add');
  Route::post('/guardes/store', 'Admin\GuardController@store')->middleware(['role:admin|sub_admin|society_admin'])->name('guardes.store');
  Route::get('/guardes/edit/{id}', 'Admin\GuardController@edit')->middleware(['role:admin|sub_admin|society_admin'])->name('guardes.edit');
  Route::patch('/guardes/update/{id}', 'Admin\GuardController@update')->middleware(['role:admin|sub_admin|society_admin'])->name('guardes.update');
  Route::get('/guardes/delete/{id}', 'Admin\GuardController@delete')->middleware(['role:admin|sub_admin|society_admin'])->name('guardes.delete');
  Route::get('/guardes/array/', 'Admin\GuardController@Array')->middleware(['role:admin|sub_admin|society_admin'])->name('guardes.array');

  Route::get('/societies', 'Admin\SocietyController@index')->middleware(['role:admin|sub_admin'])->name('societies.index');
  Route::get('/societies/add', 'Admin\SocietyController@add')->middleware(['role:admin|sub_admin'])->name('societies.add');
  Route::post('/societies/store', 'Admin\SocietyController@store')->middleware(['role:admin|sub_admin'])->name('societies.store');
  Route::get('/societies/edit/{id}', 'Admin\SocietyController@edit')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.edit');
  Route::get('/societies/edit/{id}/buildings', 'Admin\SocietyController@editBuildings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.editBuildings');
  Route::patch('/societies/update/{id}', 'Admin\SocietyController@update')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.update');
  Route::get('/societies/delete/{id}', 'Admin\SocietyController@delete')->middleware(['role:admin|sub_admin'])->name('societies.delete');
  Route::get('/societies/array/', 'Admin\SocietyController@Array')->middleware(['role:admin|sub_admin'])->name('societies.array');

  Route::get('/societies/{id}/buildings/add', 'Admin\SocietyController@addBuildings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.buildings.add');
  Route::post('/societies/{society_id}/buildings/store', 'Admin\SocietyController@storeBuildings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.buildings.store');
  Route::get('/societies/{society_id}/buildings/edit/{building_id}', 'Admin\SocietyController@editBuildings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.buildings.edit');
  Route::patch('/societies/{society_id}/buildings/update/{building_id}', 'Admin\SocietyController@updateBuildings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.buildings.update');
  Route::get('/societies/{society_id}/delete/buildings/{building_id}', 'Admin\SocietyController@deleteBuildings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.buildings.delete');
  Route::get('/societies/{society_id}/array/buildings', 'Admin\SocietyController@ArrayBuildings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayBuildings');

  Route::get('/societies/{society_id}/AdminUsers', 'Admin\SocietyController@indexAdminUsers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.adminusers.index');
  Route::get('/societies/{society_id}/array/adminusers', 'Admin\SocietyController@ArrayAdminUsers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayAdminusers');
  Route::get('/societies/{society_id}/adminusers/add', 'Admin\SocietyController@addAdminUsers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.adminusers.add');
  Route::post('/societies/{society_id}/adminusers/store', 'Admin\SocietyController@storeAdminUsers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.adminusers.store');
  Route::get('/societies/{society_id}/adminusers/edit/{user_id}', 'Admin\SocietyController@editAdminUsers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.adminusers.edit');
  Route::patch('/societies/{society_id}/adminusers/update/{user_id}', 'Admin\SocietyController@updateAdminUsers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.adminusers.update');
  Route::get('/societies/{society_id}/delete/adminusers/{user_id}', 'Admin\SocietyController@deleteAdminUsers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.adminusers.delete');
  Route::post('/societies/{society_id}/adminusers/store', 'Admin\SocietyController@storeAdminUsers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.adminusers.store');

  Route::get('/societies/{society_id}/members', 'Admin\SocietyController@indexMembers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.index');
  Route::get('/societies/{society_id}/array/members', 'Admin\SocietyController@ArrayMembers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayMembers');
  Route::get('/societies/{society_id}/members/add', 'Admin\SocietyController@addMembers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.add');
  Route::post('/societies/{society_id}/members/store', 'Admin\SocietyController@storeMembers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.store');
  Route::get('/societies/{society_id}/members/edit/{member_id}', 'Admin\SocietyController@editMembers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.edit');
  Route::patch('/societies/{society_id}/members/update/{member_id}', 'Admin\SocietyController@updateMembers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.update');
  Route::get('/societies/{society_id}/delete/members/{user_id}', 'Admin\SocietyController@deleteMembers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.delete');
  Route::get('/societies/flats/byBuilding/{building_id}', 'Admin\SocietyController@flatsByBuilding');

  Route::get('/societies/{society_id}/members/{member_id}/vehicles', 'Admin\SocietyController@indexMembersVehicles')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.vehicles.index');
  Route::get('/societies/{society_id}/members/{member_id}/vehicles/add', 'Admin\SocietyController@addMembersVehicles')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.vehicles.add');
  Route::get('/vehicles/array/{user_id}', 'Admin\SocietyController@ArrayMembersVehicles')->middleware(['role:admin|sub_admin|society_admin'])->name('arrayMembersVehicles');
  Route::post('/vehicles/{member_id}/store', 'Admin\SocietyController@storeMembersVehicles')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.vehicles.store');
  Route::get('/vehicles/{vehicle_id}/edit', 'Admin\SocietyController@editMembersVehicles')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.vehicles.edit');
  Route::patch('/vehicles/{vehicle_id}/update', 'Admin\SocietyController@updateMembersVehicles')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.vehicles.update');
  Route::get('/vehicles/{vehicle_id}/delete', 'Admin\SocietyController@deleteMembersVehicles')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.vehicles.delete');


  Route::get('/societies/{society_id}/members/{member_id}/familymember', 'Admin\SocietyController@indexMembersFamilymembers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.familymember.index');
  Route::get('/familymember/array/{user_id}', 'Admin\SocietyController@ArrayMembersFamilyMembers')->middleware(['role:admin|sub_admin|society_admin'])->name('arrayMembersFamily');

  Route::get('/member/import/{id}', 'Admin\GuardController@import')->name('guard.importadd');
  Route::post('/member/importdata', 'Admin\GuardController@importdata')->name('guard.importdata');


  Route::get('/societies/{society_id}/commitees', 'Admin\SocietyController@indexCommitees')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.commitees.index');
  Route::get('/societies/{society_id}/array/commitees', 'Admin\SocietyController@ArrayCommitees')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayCommitees');
  Route::get('/societies/{society_id}/commitees/edit/', 'Admin\SocietyController@editCommitees')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.commitees.edit');
  Route::patch('/societies/{society_id}/commitees/update/', 'Admin\SocietyController@updateCommitees')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.commitees.update');


  Route::get('/societies/{society_id}/notices', 'Admin\NoticeController@index')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.notices.index');
  Route::get('/societies/{society_id}/array/notices', 'Admin\NoticeController@Array')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayNotice');
  Route::get('/societies/{society_id}/notices/add', 'Admin\NoticeController@addNotices')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.notices.add');
  Route::post('/societies/{society_id}/notices/store', 'Admin\NoticeController@store')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.notices.store');
  Route::get('/societies/{society_id}/notices/edit/{notice_id}', 'Admin\NoticeController@edit')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.notices.edit');
  Route::patch('/societies/{society_id}/notices/update/{member_id}', 'Admin\NoticeController@update')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.notices.update');
  Route::get('/societies/{society_id}/delete/notices/{user_id}', 'Admin\NoticeController@delete')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.notices.delete');
  Route::get('/societies/{society_id}/notices/notify/{notice_id}', 'Admin\NoticeController@notify')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.notices.notify');



  Route::get('/societies/{society_id}/circulars', 'Admin\CircularController@index')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.circulars.index');
  Route::get('/societies/{society_id}/array/circulars', 'Admin\CircularController@Array')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayCircular');
  Route::get('/societies/{society_id}/circulars/add', 'Admin\CircularController@addCirculars')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.circulars.add');
  Route::post('/societies/{society_id}/circulars/store', 'Admin\CircularController@store')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.circulars.store');
  Route::get('/societies/{society_id}/circulars/edit/{notice_id}', 'Admin\CircularController@edit')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.circulars.edit');
  Route::patch('/societies/{society_id}/circulars/update/{member_id}', 'Admin\CircularController@update')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.circulars.update');
  Route::get('/societies/{society_id}/delete/circulars/{user_id}', 'Admin\CircularController@delete')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.circulars.delete');
  Route::get('/societies/{society_id}/circulars/notify/{notice_id}', 'Admin\CircularController@notify')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.circulars.notify');

  Route::get('/societies/{society_id}/events', 'Admin\EventController@index')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.events.index');
  Route::get('/societies/{society_id}/array/events', 'Admin\EventController@Array')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayEvents');
  Route::get('/societies/{society_id}/events/add', 'Admin\EventController@addEvents')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.events.add');
  Route::post('/societies/{society_id}/events/store', 'Admin\EventController@store')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.events.store');
  Route::get('/societies/{society_id}/events/edit/{notice_id}', 'Admin\EventController@edit')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.events.edit');
  Route::patch('/societies/{society_id}/events/update/{member_id}', 'Admin\EventController@update')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.events.update');
  Route::get('/societies/{society_id}/delete/events/{user_id}', 'Admin\EventController@delete')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.events.delete');
  Route::get('/societies/{society_id}/events/notify/{notice_id}', 'Admin\EventController@notify')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.events.notify');


  // Maintence Configrutation
  Route::get('/societies/{society_id}/maintence', 'Admin\MaintenceController@index')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.maintence.index');
  
  Route::get('/societies/{society_id}/array/maintence', 'Admin\MaintenceController@Array')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayMaintence');

  Route::get('/societies/{society_id}/maintence/add', 'Admin\MaintenceController@addEvents')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.maintence.add');

  Route::post('/societies/{society_id}/maintence/store', 'Admin\MaintenceController@store')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.maintence.store');

  Route::get('/societies/{society_id}/maintence/edit/{notice_id}', 'Admin\MaintenceController@edit')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.maintence.edit');

  Route::patch('/societies/{society_id}/maintence/update/{member_id}', 'Admin\MaintenceController@update')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.maintence.update');

  Route::get('/societies/{society_id}/delete/maintence/{user_id}', 'Admin\MaintenceController@delete')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.maintence.delete');

  // Maintence Payment Configrutation

  Route::get('/societies/{society_id}/maintencepayment', 'Admin\MaintenceController@maintencepayment')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.maintencepayment.index');

  Route::get('/societies/{society_id}/members', 'Admin\MaintenceController@buildingwisemember')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.members.index');  

  Route::get('/societies/members/byBuilding/{building_id}/{society_id}', 'Admin\MaintenceController@buildingwisemember')->name('societies.byBuilding');
  

  //Settings

  Route::get('/societies/{society_id}/settings', 'Admin\SocietyController@settingspage')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.settings.index');

  Route::post('/societies/{society_id}/settings/store', 'Admin\SocietyController@storesettings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.settings.store');
  
  Route::patch('/societies/{society_id}/settings/update/{member_id}', 'Admin\SocietyController@updatesettings')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.settings.update');


  ///Services Provider

  Route::get('/societies/{society_id}/serviceprovider', 'Admin\ServiceController@index')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.serviceprovider.index');

  Route::get('/societies/{society_id}/array/serviceprovider', 'Admin\ServiceController@ArrayServices')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayserviceprovider');

  Route::get('/societies/{society_id}/serviceprovider/add', 'Admin\ServiceController@addServiceProvider')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.serviceprovider.add');

  Route::post('/societies/{society_id}/serviceprovider/store', 'Admin\ServiceController@storeServicesProviders')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.serviceprovider.store');

  Route::get('/societies/{society_id}/serviceprovider/edit/{member_id}', 'Admin\ServiceController@editServices')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.serviceprovider.edit');

  Route::get('/societies/{society_id}/serviceprovider/view/{member_id}', 'Admin\ServiceController@viewServices')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.serviceprovider.view');

  Route::patch('/societies/{society_id}/serviceprovider/update/{member_id}', 'Admin\ServiceController@update')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.serviceprovider.update');

  Route::get('/societies/{society_id}/delete/serviceprovider/{user_id}', 'Admin\ServiceController@deleteServices')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.serviceprovider.delete');

  Route::get('/societies/{society_id}/status/serviceprovider/{user_id}/{status}', 'Admin\SocietyController@changestatus')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.serviceprovider.changestatus');


  ///Help Desk

  Route::get('/societies/{society_id}/helpdesk', 'Admin\SocietyController@indexhelpdesk')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk.index');

  Route::get('/societies/{society_id}/array/helpdesk', 'Admin\SocietyController@Arrayhelpdesk')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk');

  Route::get('/societies/{society_id}/helpdesk/add', 'Admin\SocietyController@addHelpdesk')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk.add');

  Route::post('/societies/{society_id}/helpdesk/store', 'Admin\SocietyController@storeHelpdesk')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk.store');

  Route::get('/societies/{society_id}/helpdesk/edit/{member_id}', 'Admin\SocietyController@editHelpdesk')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk.edit');

  Route::get('/societies/{society_id}/helpdesk/view/{member_id}', 'Admin\SocietyController@viewServices')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk.view');

  Route::patch('/societies/{society_id}/helpdesk/update/{member_id}', 'Admin\SocietyController@updateHelpdesk')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk.update');

  Route::get('/societies/{society_id}/delete/helpdesk/{user_id}', 'Admin\SocietyController@deleteHelpdesk')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk.delete');

  Route::get('/societies/{society_id}/status/helpdesk/{user_id}/{status}', 'Admin\SocietyController@changestatus')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpdesk.changestatus');

//Polls

  Route::get('/societies/{society_id}/polls', 'Admin\SocietyController@indexPolls')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.polls.index');

  Route::get('/societies/{society_id}/array/polls', 'Admin\SocietyController@Arraypolls')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.polls');

  Route::get('/societies/{society_id}/polls/add', 'Admin\SocietyController@addPolls')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.polls.add');

  Route::post('/societies/{society_id}/polls/store', 'Admin\SocietyController@storePolls')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.polls.store');

  Route::get('/societies/{society_id}/polls/edit/{member_id}', 'Admin\SocietyController@editPolls')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.polls.edit');

  Route::patch('/societies/{society_id}/polls/update/{member_id}', 'Admin\SocietyController@updatePolls')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.polls.update');

  Route::get('/societies/{society_id}/delete/polls/{user_id}', 'Admin\SocietyController@deletePolls')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.polls.delete');

  // Route::get('/societies/{society_id}/status/polls/{user_id}/{status}', 'Admin\SocietyController@changestatus')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.polls.changestatus');
///Reports

  //Domestic Helpers

  Route::get('/societies/{society_id}/helpers', 'Admin\SocietyController@indexdomestichelpers')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpers.index');

  Route::get('/societies/{society_id}/array/helpers', 'Admin\SocietyController@domestichelpersArray')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.helpers');


  //Current Visitor
  Route::get('/societies/{society_id}/reports', 'Admin\SocietyController@indexreports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.reports.index');

  //Visitor Reports
  Route::get('/societies/{society_id}/visitorreports', 'Admin\SocietyController@visitorReports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.visitorreports.index');

  //Tenant Reports
  Route::get('/societies/{society_id}/tenantreports', 'Admin\SocietyController@tenantReports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.tenantreports.index');

  //Tenant Reports Array
  Route::get('/societies/{society_id}/array/tenantreports', 'Admin\SocietyController@arrayTenantReports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.tenantreports');

  //Filter Reports
  Route::post('/societies/{society_id}/filterreports/store', 'Admin\SocietyController@filterReports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.filterreports.store');


  //Current Visitor Array
  Route::get('/societies/{society_id}/array/reports', 'Admin\SocietyController@arrayReports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.reports');

  //Visitor Reports Array
  Route::get('/societies/{society_id}/array/visitorreports', 'Admin\SocietyController@arrayVisitorReports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.visitorreports');

  //OutReportsEntry
  Route::get('/societies/{society_id}/delete/reports/{type}/{id}', 'Admin\SocietyController@outreports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.reports.out');

  Route::post('/societies/{society_id}/filterreports', 'Admin\SocietyController@indexreports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.filterReports.index');

   Route::get('/societies/{society_id}/array/filterreports', 'Admin\SocietyController@filterReports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.filterReports');

   //Referral Array
    Route::get('/referral', 'Admin\CityController@referralindex')->middleware(['role:admin|sub_admin'])->middleware(['role:admin|sub_admin'])->name('referral.index');

   Route::get('/referral/array/', 'Admin\CityController@referralArray')->middleware(['role:admin|sub_admin'])->name('referral.referralarray');

    Route::get('/view/{society_id}/notification/{id}', 'Admin\SocietyController@viewnotification')->name('member.viewnotification');

    Route::get('/view/notification/{id}', 'Admin\SocietyController@viewreferralnotification')->name('referral.viewnotification');
    //Domestic Helpers OutReportsEntry
    Route::get('/societies/{society_id}/delete/reports/{type}/{id}', 'Admin\SocietyController@domestichelperoutreports')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.reports.out');


//Amenties 
  Route::get('/societies/{society_id}/amenities', 'Admin\AmentiesController@indexAmenties')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.amenties.index');

  Route::get('/societies/{society_id}/array/amenities', 'Admin\AmentiesController@ArrayAmenties')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.arrayamenties');

  Route::get('/societies/{society_id}/amenities/add', 'Admin\AmentiesController@addAmenties')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.amenties.add');

  Route::post('/societies/{society_id}/amenities/store', 'Admin\AmentiesController@storeAmenties')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.amenties.store');

  Route::get('/societies/{society_id}/amenities/edit/{member_id}', 'Admin\AmentiesController@editAmenties')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.amenties.edit');

  Route::patch('/societies/{society_id}/amenities/update/{member_id}', 'Admin\AmentiesController@updateAmenties')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.amenties.update');

  Route::get('/societies/{society_id}/delete/amenities/{member_id}', 'Admin\AmentiesController@deleteAmenties')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.amenties.delete');

  Route::get('/societies/{society_id}/status/amenities/{user_id}/{status}', 'Admin\AmentiesController@changestatus')->middleware(['role:admin|sub_admin|society_admin'])->name('societies.amenties.changestatus');

});
