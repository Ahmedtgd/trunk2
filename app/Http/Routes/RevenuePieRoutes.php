<?php
Route::get('revenue','RevenueReportController@index');
Route::get('overallRevenue','RevenueReportController@overallRevenuePie');
Route::get('overallRevenueJSON/{option?}','RevenueReportController@overallRevenuePieData');


Route::get('categoryRevenue','RevenueReportController@categoryRevenuePie');
Route::get('loadCategoryRevenue/{year}/{month}','RevenueReportController@loadCategoryRevenue');
Route::get('categoryRevenueJSON/{year}/{month}/{option?}','RevenueReportController@categoryRevenuePieData');

Route::get('subCategoryRevenue','RevenueReportController@subCategoryRevenuePie');
Route::get('loadSubCategoryRevenue/{year}/{month}/{categoryId}','RevenueReportController@loadSubCategoryRevenue');
Route::get('subCategoryRevenueJSON/{year}/{month}/{categoryId}/{option?}','RevenueReportController@subCategoryRevenuePieData');

Route::get('merchantRevenue','RevenueReportController@merchantRevenuePie');
Route::get('merchantRevenueJSON/{option?}','RevenueReportController@merchantRevenuePieData');

Route::get('productARevenue','RevenueReportController@productARevenuePie');
Route::get('productARevenueJSON/{option?}','RevenueReportController@productARevenuePieData');

Route::get('productBRevenue','RevenueReportController@productBRevenuePie');
Route::get('productBRevenueJSON/{option?}','RevenueReportController@productBRevenuePieData');

?>
