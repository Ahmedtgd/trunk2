<?php 

Route::post("/bundles/getbundles","PromoController@getBundles");
Route::post("/bundles/savebundles","PromoController@saveBundle");

Route::post("/bundles/getbundlelocation","PromoController@getBundleLocation");
Route::post("/bundles/savebundlelocation","PromoController@saveBundleLocation");
Route::post("/bundles/detetebundle","PromoController@deteteBundle");
Route::post("/bundles/getbundlelist","PromoController@getBundleList");

Route::post("/bundles/showbundleproducts","PromoController@showBundleProducts");


?>