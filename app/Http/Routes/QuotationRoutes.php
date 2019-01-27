<?php
    Route::get('seller/quotation/{user_id?}','QuotationController@index');
    Route::post('seller/quotationconfirm','QuotationController@show');
?>