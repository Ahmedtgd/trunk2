<?php
// Route::post("report/info",'rn\ReportController@report_info');
// Route::post("report/new",'rn\ReportController@report_new');
// Route::post("report/update",'rn\ReportController@report_update');
// Route::post("report/delete",'rn\ReportController@report_delete');
Route::post("report/autost",'rn\ReportController@auto_create_st_report_warehouse');
Route::post("report/autowastage",'rn\ReportController@auto_create_wastage_report');
Route::post("report",'rn\ReportController@report');
Route::post("report/list",'rn\ReportController@report_list');
Route::post("report/qr/info",'rn\ReportController@qr_dropdown_info');
Route::get("report/time/summary/{company_id}/{location_id?}","rn\ReportController@years_month");
Route::get("rack/list/{warehouse_id}/{ttype?}","rn\ReportController@rack_list");
?>
