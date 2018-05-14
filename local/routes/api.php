<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'account','namespace' => 'Api\Auth'], function(){
    Route::post('login','AuthController@apiLogin');
    Route::post('register','AuthController@apiRegister');
    Route::post('auth/social', 'AuthController@apiSocialLogin');

    Route::get('details','AuthController@getAuthUserDetails')->middleware('auth:api');
    Route::get('profile','AuthController@profile')->middleware('auth:api');
    Route::put('profile','AuthController@updateProfile')->middleware('auth:api');
});

Route::group(['prefix' => '/support/tickets','namespace' => 'Api', 'middleware' => 'auth:api'], function() {
    Route::get('/', 'TicketController@index');
    Route::post('/', 'TicketController@store');
    Route::get('/{id}', 'TicketController@show')->where('id', '[0-9]+');
    Route::put('/{id}', 'TicketController@update')->where('id', '[0-9]+');
    Route::post('/{id}/messages', 'MessageController@store')->where('id', '[0-9]+');
});


/**
 * 
 * Routes for verfication of users phone numbers
 * 
 */

Route::group(['prefix' => 'verify'], function () {
    Route::post('/otp', 'Api\VerificationController@otp');
    Route::post('/confirm', 'Api\VerificationController@confirm');
    Route::post('/change', 'Api\VerificationController@change');
});

/*Routes for jobs*/

Route::group(['prefix' => 'jobs', 'namespace' => 'Api', 'middleware' => 'auth:api'], function(){
    Route::post('create','JobsController@create')->name('api.create.job');
    Route::post('schedule/{id}','JobsController@schedule')->name('api.schedule.job');
    Route::post('broadcast/{id}','JobsController@broadcast')->name('api.broadcast.job');
    Route::any('calculate-job-amount/{id}','JobsController@getJobAmount')->name('api.amount.job');

    // add balance to wallet
    Route::post('add-money','JobsController@addMoney')->name('api.add.money');
    // activate job, it will add 3 credit entries i) job fee ii) admin fee iii) vat fee
    Route::post('activate-job/{id}','JobsController@activateJob')->name('api.activate.job');
    Route::get('/my/applications/{id}', 'JobsController@myJobApplications')->name('api.my.job.applications');
    Route::post('apply/{id}','JobsController@applyJob')->name('api.apply.job');
    Route::post('mark/hired/{id}','JobsController@markHired')->name('api.mark.hired');
    
  
    
    Route::get('my','JobsController@myJobs')->name('api.my.jobs');
    Route::get('proposals','JobsController@myProposals')->name('api.my.proposals');

});

Route::group(['namespace' => 'Api', 'middleware' => 'auth:api'], function(){
    Route::get('/security-categories', 'JobsController@getSecurityCategories');
    Route::get('/business-categories', 'JobsController@getBusinessCategories');
    Route::get('/wallet-data', 'WalletController@getWalletData');
});

// Guest routes for jobs
Route::group(['namespace' => 'Api', 'middleware' => 'auth:api'], function(){
    Route::get('find-jobs','JobsController@findJobs')->name('api.find.jobs');
});
