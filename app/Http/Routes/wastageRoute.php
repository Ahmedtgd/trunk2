<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Route::group(['middleware'=>'logged'],function(){
 Route::get('/seller/getwastformreportbymonthyear','SellerHelpController@getwastformreportbymonthyear');
 Route::get('wastageform/{report_id}', array('as' => 'Wastageform', 'uses' =>'WastageController@wastageform'));
});
?>
