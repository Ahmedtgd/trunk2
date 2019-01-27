<?php

Route::get('payment/receipt','FPXController@show_receipt');
// View Based
Route::get('indirect','CartController@store');
Route::post('fpx/indirect','FPXController@handle_ac_indirect');
Route::post('fpx/direct','FPXController@handle_ac_direct');
Route::get('fpx/direct',function(){
	echo "This url only accepts POST requests.";
});
Route::get('fpx/indirect',function(){
	echo "This url only accepts POST requests.";
});
Route::post('fpx/checksum','FPXController@checksum_over_ajax');

// Host to Host
Route::get('direct','CartController@direct');

?>
