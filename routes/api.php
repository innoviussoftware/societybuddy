<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('API/login', 'UserController@localeconv()gin');





Route::namespace('API')->group(function () {

    Route::post('verifyemail', 'GuardController@emailExists');

	Route::post('loginotp', 'UserController@login_opt');
	Route::post('register', 'UserController@register');
	Route::post('get/city', 'SocietyController@getcity');
    Route::post('get/area', 'SocietyController@getarea');
    Route::post('get/society', 'SocietyController@getsociety');
    Route::post('get/building', 'SocietyController@getbuilding');
    Route::post('get/flat', 'SocietyController@getflat');
    Route::post('get/flat2', 'SocietyController@getflat2');
    Route::get('professional', 'SocietyController@getprofessional');

    Route::post('guardlogin','GuardController@guardlogin');
    Route::post('guestentry','GuardController@addguestentry');
    Route::post('currentvisitor', 'GuardController@currentVisitorList');
    Route::post('allvisitor', 'GuardController@allvisitorList');
    Route::post('InOut', 'GuardController@InoutVisitor');
    Route::post('helpersInout', 'GuardController@domestichelpersinout');

    Route::post('logout', 'UserController@logout');
    Route::post('guard_logout', 'GuardController@guardLogout');
    Route::post('frequentvisitorlist', 'GuardController@preapporvedEntryList');
    Route::post('domestichelperslist', 'GuardController@DomesticHelpersList');

    Route::post('helperslist', 'UserController@domestichelpers');

    Route::post('helpersdetails', 'UserController@detailsofdomestichelpers');  

    Route::post('deleteguest','GuardController@deleteguestentry');  

    Route::post('gethelpdesk', 'SocietyController@gethelpdesk');   

    Route::post('notify_flag', 'GuardController@checknotificationflag');   

    Route::post('send_otp','CircularController@sendotpNewcode'); 

    Route::post('memberlist','GuardController@MemberList'); 

    Route::post('memberfamily', 'GuardController@getmemberfamilylist');

    Route::post('recentvisitor','GuardController@recentvisitorList');

    Route::post('sendref','SocietyController@send_reffreal');


});

Route::middleware('auth:api')->prefix('user')->namespace('API')->group(function () {
    
	Route::post('addnotice','NoticeController@addnotice');
    Route::post('editnotice','NoticeController@editNotice');
    Route::post('getnotice','NoticeController@getNotice');
    Route::post('deletenotice','NoticeController@deleteNotice');

    Route::post('addevent','EventController@addevent');
    Route::post('editevent','EventController@editEvent');
    Route::post('getevent','EventController@getEvent');
    Route::post('deleteevent','EventController@deleteEvent');

    Route::post('addcircular','CircularController@addcircular');
    Route::post('editcircular','CircularController@editCircular');
    Route::post('getcircular','CircularController@getCircular');
    Route::post('deletecircular','CircularController@deleteCircular');

    Route::post('acceptreject','GuardController@acceptorreject');

    Route::post('me', 'UserController@me');
    Route::post('addfamilymember', 'UserController@addfamilymember');
    Route::post('updatefamilymember/{family_member_id}', 'UserController@updatefamilymember');
    Route::get('getfamilymember', 'UserController@getFamilyMember');
    Route::post('deletefamilymember', 'UserController@DeleteFamilyMember');

    Route::post('guestlist', 'ActivityController@GuestList');
    Route::post('addFrequentEntry', 'GuardController@addFrequentEntry');
    Route::post('deletefrequent', 'GuardController@deletefrequententry');

    Route::post('frequentvisitorlist', 'GuardController@preapporvedEntryList');
    Route::post('updateprofile', 'UserController@updateProfile');
    Route::post('memberlist','UserController@MemberList');

    Route::get('vehicles/get', 'VehicleController@get');
    Route::post('vehicles/store', 'VehicleController@store');
    Route::post('vehicles/update/{vehicle_id}', 'VehicleController@update');
    Route::get('vehicles/delete/{vehicle_id}', 'VehicleController@delete');
    Route::post('vehicles/exists', 'VehicleController@exists');

    Route::get('invitelist', 'GuardController@getguestlist');
    Route::post('addsettings', 'GuardController@addsettings');
    Route::get('getsettings', 'GuardController@getSettings');

    Route::post('memberfamily', 'UserController@getmemberfamilylist');

    Route::post('addreview','UserController@addReview');
    Route::post('delreview','UserController@deletereview');
    Route::post('review','UserController@getreview');

    Route::get('notify_count','SocietyController@getnotificationcount');
    Route::post('updatenotify','SocietyController@updatenotificationcount');
    Route::post('deletenotify', 'SocietyController@notificationDelete');

    Route::post('myhelperslist', 'UserController@mydomestichelperslist');
    Route::post('notificationlist', 'UserController@NotificationList');

    Route::post('reminder', 'NoticeController@remainderNotification');

    Route::post('buildingmember', 'SocietyController@MemberList');    

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


