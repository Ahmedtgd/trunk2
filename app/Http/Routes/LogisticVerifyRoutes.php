<?php
/* OpenSupermall Custom Routes */

Route::post('/serial_no_check','LogisticVerifySerialController@check');
Route::post('/warranty_check','LogisticVerifyWarrantyController@check');
?>
