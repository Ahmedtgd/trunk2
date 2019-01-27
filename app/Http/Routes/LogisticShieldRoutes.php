<?php
Route::post('/albumpostedit', ['as' => 'albumpostedit', 'uses' => 'ProductController@storepedit']);
Route::post('/store_retail/{uid?}', ['as' => 'store_retail', 'uses' => 'LogisticShieldController@store_retail']);
Route::post('/store_retailedit/{uid?}', ['as' => 'store_retailedit', 'uses' => 'LogisticShieldController@store_retailedit']);
Route::post('/store_b2b', ['as' => 'store_b2b', 'uses' => 'LogisticShieldController@store_b2b']);
?>
