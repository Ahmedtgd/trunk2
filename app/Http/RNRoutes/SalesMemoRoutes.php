<?php
Route::post("salesmemo",'rn\SalesMemoController@salesmemo');
Route::post("salesmemo/list",'rn\SalesMemoController@salesmemo_list');
Route::get("salesmemo/time/summary/{company_id}","rn\SalesMemoController@years_month");

Route::post("cacct","rn\SalesMemoController@cacct");
Route::post("cacct/list","rn\SalesMemoController@cacct_list");
?>
