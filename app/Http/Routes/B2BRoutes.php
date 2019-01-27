<?php

// B2B Routes :: wahid
Route::get('/b2b/{id}', array('as' => 'b2b', 'uses' => 'B2BController@showProduct'));

?>
