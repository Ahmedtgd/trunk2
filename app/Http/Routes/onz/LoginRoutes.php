<?php
Route::post("onzloginapi","onz\OnzLoginController@login_api")->name('onzloginapi');
Route::get("onzloginpage/{uname?}/{pass?}","onz\OnzLoginController@onzloginpage")->name('onzloginpage');

?>
