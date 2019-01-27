<?php

Route::get('companies','rn\StaffPageController@get_companies');
Route::get('fairlocations/{company_id}','rn\StaffPageController@get_fairlocations');
Route::get('inventory','rn\StaffPageController@get_inventory');
Route::get('summary/{company_id}','rn\StaffPageController@get_summary');
?>
