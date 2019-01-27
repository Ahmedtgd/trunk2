<?php
/**
 * Created by rana.
 * User: mps
 * Date: 7/26/18
 * Time: 9:22 PM
 */




Route::group(['namespace' => 'onz', 'prefix' => 'onz'], function(){

    /**
     * API Routes For ONZ MPS
     */

    Route::post('signup', 'OnzLoginController@onzregistration');

    Route::post('get/cities', 'OnzSignupController@cgetCity');

    Route::post('/state', ['uses' => 'AjaxController@getState']);

    Route::get('logout','OnzLoginController@onz_logout')->name('onz_logout');
    Route::post('login','OnzLoginController@onz_login')->name('onz_login');
    Route::post('forgot_password','OnzLoginController@onz_forgot_password')->name('onz_forgot_password');
    Route::get('confirmation/approval/view','ConfirmApprovalController@view');
    Route::post("confirm/approval",'ConfirmApprovalController@confirm_approval');

});
