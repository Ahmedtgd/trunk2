<?php
/* OpenSupermall Custom Routes */

/******************* Admin CAPS **********/
Route::post('/api/login', ['as' => 'login_api', 'uses' => 'APIController@login_api']);
Route::post('/api/qr', ['as' => 'qr_api', 'uses' => 'APIController@qr_api']);
Route::get('/api/loginget', ['as' => 'login_apiget', 'uses' => 'APIController@login_api']);
/*************APi routes******************/
Route::group(['prefix'=>'api/v1','middleware'=>['cors']],function(){
    Route::post('register','AuthenticateController@register');
    Route::post('login','AuthenticateController@authenticate');
    Route::group(['middleware'=>['jwt.auth']],function(){
        Route::get('user','AuthenticateController@getAuthenticatedUser');
    }); 
});
/*************Dated : 18-07-2017**********/
Route::group(['prefix'=>'mobile/api/v1','middleware'=>['cors']],function(){
    Route::get('home','MobileController@index');
});
/*************End*************************/
?>
