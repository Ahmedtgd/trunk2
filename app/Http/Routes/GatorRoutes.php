<?php
Route::get('seller/gator/invrefund/{id}','ReturnInvoiceController@inv_refund');
Route::get('seller/gator/invreturn/{id}','ReturnInvoiceController@inv_return');
Route::get('seller/gator/notes/{id}','GatorInvoiceController@inv_notes');
Route::post('seller/gator/sub_dar_return','ReturnInvoiceController@sub_dar');
Route::post('seller/gator/reject_return','ReturnInvoiceController@reject_return');
Route::get('seller/gator/credit_note/{id}/{cid}','ReturnInvoiceController@credit_note');
Route::get('seller/gator/return_prod_modal/{id}','ReturnInvoiceController@return_prod_modal');
Route::get('seller/gator/seller_mini_gator/{id}','ReturnInvoiceController@show_mini_seller_gator');
Route::get('seller/gator/{user_id?}','GatorController@index')->name('gator');
Route::get('/seller/gatorbuyer/modal/{user_id?}','GatorController@gatorBuyer');
Route::post('/gator/deleteRow','GatorController@deleteRecord');
Route::post('/gator/SoConvertInvoice','GatorController@SoConvertInvoice');
Route::get('/seller/gator/saleorder/{user_id}','GatorController@displaySaleOrder');
Route::get('/seller/invoice/{id}', 'GatorInvoiceController@displayInvoice');
Route::get('seller/gatorbuyer/tierprice/{id}', 'GatorController@tierPrice');
Route::get('seller/gatorbuyer/print_page/{id}', 'GatorController@printPage');
Route::get('seller/gator/price_list/{id}', 'GatorController@price_list');
Route::post('seller/gator/price_check','GatorController@price_check');
Route::post('seller/gator/qty_check','GatorController@qty_check');
Route::post('/seller/gator/set_status','GatorController@set_status');
Route::post('/seller/gator/return_prod','ReturnInvoiceController@return_prod');
/*
Route::get('seller/gatorproduct/{id}','GatorController@productdetail');
Route::get('seller/addgatorproductsession/{id}','GatorController@addinsession');
Route::get('seller/removefromsession/{id}','GatorController@destroyfromsession');
*/
Route::post('seller/checkoutgator','GatorController@save')->name('checkoutgator');
Route::post('seller/gatorconfirm','GatorController@show');
Route::post('seller/gatornewbuyer','GatorController@savebuyer');
Route::post('/gator/salesorder','StatementController@salesorderdocument');
Route::get('/DO/displaysalesorderdocument/{id}/{nid?}/{heading?}','GatorController@displaysalesorderdocument')->name('displaysalesorderdocument');

Route::get('/DO/displaydeliveryorderdocument/{id}/{nid?}/{heading?}','GatorController@displaydeliveryorderdocument')->name('displaydeliveryorderdocument');

Route::get('/seller/deletegatorbuyer/{id}','GatorController@deletegatorbuyer');
Route::get('/seller/unlinkgatorbuyer/{id}{user_id?}','GatorController@unlinkgatorbuyer');
Route::get('/seller/emerchantdetail/{id}','GatorController@emerchantdetail');
Route::post('/seller/invoice', 'GatorInvoiceController@invoice');
Route::post('/seller/deleteInvoiceRecord','GatorInvoiceController@deleteInvoiceRecord');
Route::post('/seller/checkCreaditLimit', 'GatorInvoiceController@checkCreaditLimit');

?>
