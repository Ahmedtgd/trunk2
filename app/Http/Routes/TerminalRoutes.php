<?php
Route::group(['middleware'=>'merchant'],function() {
 
 Route::get('/open-terminal/get-sub-cateogires','TerminalController@getSubCategories');
 Route::get('/open-terminal/save-terminal-data','TerminalController@saveTerminalData');   
 Route::get('/open-terminal/save-terminal-user-data','TerminalController@saveTerminalUserData');   
 Route::get('/open-terminal/get-terminal-user-data','TerminalController@getTerminalUserData');   
 // Route::get('/open-terminal/add-without-values/{location}','TerminalController@addWithoutValues');
 Route::post('/open-terminal/add-without-values','TerminalController@addWithoutValues');
 Route::get('/open-terminal/update-values','TerminalController@updateValue');
 Route::get('/open-terminal/assign-user-term','TerminalController@assignUser');
 Route::post('/open-terminal/delete','TerminalController@deleteValue');
 Route::get('/open-terminal/{location_id}/{uid?}','TerminalController@viewTerminal');
 Route::get('/product-defination-page/{uid?}','TerminalController@viewProductDefination');
 
Route::get('/cashmgmt/{uid?}', ['as' => 'getTerminalList', 'uses' => 'SellerHelpController@getTerminalCash']);
 
 Route::get('/cashmgmt/{terminal_id}/{uid?}', ['as' => 'getCML', 'uses' => 'SellerHelpController@getCML']);

Route::group(['prefix'=>'terminal'],function(){
	Route::post("update","TerminalController@update_terminal");
	Route::post("mass/update","TerminalController@update_all_terminal");
});
 
 
});
Route::get('/naturalEod', function () {
    $exitCode = Artisan::call('eod:natural', []);
});

 