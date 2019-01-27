<?php

Route::post("product/he","rn\HEProductMapperController@he_product");
Route::post('product/map/{id}', 'rn\HEProductMapperController@map_product');
Route::post('product/unmap', 'rn\HEProductMapperController@unmap_product');
Route::post('product/unsent', 'rn\HEProductMapperController@unsent');
Route::post('product/unsent/count', 'rn\HEProductMapperController@count_unsent');
Route::post('salesmemo/date', 'rn\HEProductMapperController@get_salesmemo_date');
Route::post('report/date', 'rn\HEProductMapperController@get_report_date');
Route::post('product/mapped', 'rn\HEProductMapperController@mapped_product');
Route::post('product/search/unmapped', 'rn\HEProductMapperController@search_unmapped_product');
Route::post('product/search/mapped', 'rn\HEProductMapperController@search_mapped_product');
Route::post('product/get/barcode', 'rn\HEProductMapperController@get_barcode');
?>
