<?php
Route::group(["prefix"=>"caiman"],function(){
	Route::post("cacctno","MerchantCaimanController@cacctno");
	Route::post("cacctno/list/location","MerchantCaimanController@cacct_by_location");
	Route::post("cacctno/list/company","MerchantCaimanController@cacct_by_location");
	Route::post("cacctno/assign/location","MerchantCaimanController@assign_location");
});
?>