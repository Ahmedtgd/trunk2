<?php
/* OpenSupermall Custom Routes */

/******************* Admin CAPS **********/
Route::get('/admin/caps/auditpayment',array('as' =>'AuditPayment','uses'=>'CapsController@auditpayment' ));
Route::get('/paymentordersaudit/{user_id}', ['as' => 'paymentordersaudit', 'uses' => 'CapsController@paymentordersaudit']);
?>
