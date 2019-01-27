<?php
//MLM Commissions form display
Route::get('/mlmCommissions', 'MlmCommissionsController@index');

//save route
Route::post('/mlmCommissions/save', ['uses' => 'MlmCommissionsController@save']);
Route::post('/mlmCommissions/ajax/save', ['uses' => 'MlmCommissionsController@save']);

//ajax save route
// Route::get('/mlmCommissions/ajax/save/{field}/{value?}/{mlmcommid?}', 'MlmCommissionsController@save');



?>
