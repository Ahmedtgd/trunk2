<?php
	
	// Buyer Warehouse feature in Buyer Dashboard
	Route::get('buyer/warehouse/{user_id?}','BuyerWarehouseController@get_buyer_warehouse_data');

	Route::get('buyer/roles/{location_id}','BuyerController@get_roles');

	Route::get('/seller/warehouse/get_description', 'BuyerWarehouseController@get_description')

?>
