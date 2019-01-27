<?php
Route::group(["prefix"=>"merchant/inventory"],function(){

	 Route::get('exports','InventoryImpExpController@index');
	 Route::get('exports/download','InventoryImpExpController@exports');

});
