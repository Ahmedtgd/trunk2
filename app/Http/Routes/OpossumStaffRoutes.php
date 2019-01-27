<?php
Route::get('oposstafflist/{terminal_id}','OpossumStaffController@oposStaffList');
Route::get('oposstaffproduct/{terminal_id}/{member_id}','OpossumStaffController@oposStaffProduct');
Route::get('oposperformance/{member_id}','OpossumStaffController@performance');
Route::get('oposperformance/{member_id}/download','OpossumStaffController@performance_download');

Route::post('oposstaffcomm','OpossumStaffController@save_commission');
?>
