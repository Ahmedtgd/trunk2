<?php
	Route::group(array('prefix'=>'test'),function(){
		Route::post('cc','TestController@test_cc_payment');
		Route::post('fpx/be','FPXController@test_post_be');
	});
?>
