<?php

Route::group(["prefix"=>"web/product/"],function(){
	Route::post("barcode/create","WebProductMapperController@create_blank_barcode");
	Route::post("barcode/update","WebProductMapperController@update_barcode");
	Route::post("barcode/delete","WebProductMapperController@delete_barcode");
});

?>
