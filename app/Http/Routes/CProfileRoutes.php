<?php
Route::get('/about_us',
	['as' => 'about_us', 'uses' => 'cprofile_controller@aboutUs']);
Route::get('/content',
	['as' => 'content', 'uses' => 'cprofile_controller@content']);
Route::get('/people',
	['as' => 'people', 'uses' => 'cprofile_controller@people']);
Route::get('/innovation',
	['as' => 'innovation', 'uses' => 'cprofile_controller@innovation']);
Route::get('/risk',
	['as' => 'risk', 'uses' => 'cprofile_controller@risk']);
Route::get('/target',
	['as' => 'target', 'uses' => 'cprofile_controller@target']);
Route::get('/jaguar',
	['as' => 'jaguar', 'uses' => 'cprofile_controller@jaguar']);
Route::get('/flyingfox',
	['as' => 'flyingfox', 'uses' => 'cprofile_controller@flyingfox']);
?>
