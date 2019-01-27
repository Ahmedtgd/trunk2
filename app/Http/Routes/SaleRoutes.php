<?php
Route::get('sale_report/sale_report_mgmt','SaleController@sale_management');
Route::group(array('prefix'=>'document'),function(){
	Route::group(["prefix"=>"salesreport"],function(){
		Route::get('view/{location_id}/{terminal_id}/{uid?}','DocumentSalesReportController@show_salesreport');
	});
});
?>
