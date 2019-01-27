<?php 

Route::post("/bundles/getbundles","PromoController@getBundles");
Route::post("/bundles/savebundles","PromoController@saveBundle");

Route::post("/bundles/getbundlelocation","PromoController@getBundleLocation");
Route::post("/bundles/savebundlelocation","PromoController@saveBundleLocation");

?>