<?php
/* OpenSupermall Custom Routes */
Route::get('do/deliveryorder/{deliveryorderid}',array('as'=>'DeliveryOrder','uses'=>'DOController@deliveryorder'));
Route::get('inventory/update/add_product',array('as'=>'inventory-add','uses'=>'InventoryController@add_product'));
Route::get('inventory/update/product_list',array('as'=>'inventory-list','uses'=>'InventoryController@list_product'));
Route::post('inventory/addproduct',array('as'=>'inventoryadd','uses'=>'InventoryController@addproduct'));
Route::post('inventory/addoffer',array('as'=>'inventoryoffer','uses'=>'InventoryController@addoffer'));
Route::post('inventory/updateinv',array('as'=>'inventoryupdateinv','uses'=>'InventoryController@updateinv'));
?>
