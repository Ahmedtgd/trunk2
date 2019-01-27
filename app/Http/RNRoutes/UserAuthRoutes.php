<?php
Route::get("formfiller","rn\UserRegistrationController@form_filler");
Route::post('user/buyer/register', 'rn\HEProductMapperController@register');
Route::post('user/buyer/authenticate','rn\HEProductMapperController@authenticate');
Route::post("forgot_password","rn\HEProductMapperController@forgot_password");
?>
