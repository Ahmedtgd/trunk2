<?php
Route::get('productledger/{rack_id}/{product_id}','WarehouseController@productRack_ledger');

Route::get('/sellerWarehouse/{user_id?}', ['as' => 'warehouse', 'uses'=>'WarehouseController@sellerWareHouse']);

Route::get('/sellerWarehouse/api', ['as' => 'warehouse', 'uses'=>'WarehouseController@sellerWareHouseApi']);

Route::get('/seller/member/segment/{uid}',['as' => 'companysegments', 'uses'=>'SellerHelpController@segmentsforradio']);

Route::post('/seller/store_racks', 'WarehouseController@store_racks')


?>
