<?php
	/* Credit Product Sales Routes */

Route::get('/merchant/credit-product-sales/{uid?}','CreditProductSalesController@creditProductSales');
Route::get('/merchant/credit/skulist','CreditProductSalesController@skulist');
