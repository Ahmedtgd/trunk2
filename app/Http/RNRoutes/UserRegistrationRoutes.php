<?php
Route::get("formfiller","rn\UserRegistrationController@form_filler");
Route::post('user/buyer/register', 'rn\HEProductMapperController@register');
?>
