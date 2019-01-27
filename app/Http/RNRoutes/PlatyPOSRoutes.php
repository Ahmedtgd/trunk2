<?php

Route::group(["prefix"=>"platypos"],function(){
	Route::post("menu","rn\PlatyPOSController@menu");
	Route::post("tables","rn\PlatyPOSController@tables");
	Route::post("add/products","rn\PlatyPOSController@add_products");
	Route::post("customer/order","rn\PlatyPOSController@customer_order");
	Route::post("customer/order/deliver","rn\PlatyPOSController@customer_order_deliver");
	Route::get("kitchen/dishes","rn\PlatyPOSController@kitchen_dishes");
	Route::post("kitchen/cooking","rn\PlatyPOSController@kitchen_cooking");
	Route::post("kitchen/end/cooking","rn\PlatyPOSController@end_cooking");
	
});