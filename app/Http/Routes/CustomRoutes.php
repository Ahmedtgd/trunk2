<?php
/* OpenSupermall Custom Routes */

/******************* Admin CAPS **********/
// Disabled by Zurez
// Route::post('/store_retail_custom', ['as' => 'store_retail_custom', 'uses' => 'CustomController@store_retail_custom']);
Route::post('/jc/save_jc', ['as' => 'save_jc', 'uses' => 'JCController@jcstore']);
?>
