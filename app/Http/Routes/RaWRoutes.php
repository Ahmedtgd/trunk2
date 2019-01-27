<?php
/* OpenSupermall Custom Routes */
Route::get('raw/warranty_mgmt','RaWController@warranty_management');
Route::post('raw/show_warranty','RaWController@show_warranty');
Route::get('raw/service_repair_book/{id}','RaWController@service_repair_book');
Route::get('raw/show_chitno/{product_id}','RaWController@show_chitno');
?>

