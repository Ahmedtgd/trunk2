<?php
// This file will have any route which uses the email controller

Route::get('c/verify/{token}/{email_to_be_verified}/{purpose}/{user_role}/confirm','EmailController@do_confirmEmail');
Route::get('c/verify/{token}/{email_to_be_updated}/{purpose}/{user_id}/update','EmailController@do_updateEmail');
Route::get('c/verify/{token}/{email}/{purpose}/{user_id}/password/reset','EmailController@do_passwordReset');

?>
