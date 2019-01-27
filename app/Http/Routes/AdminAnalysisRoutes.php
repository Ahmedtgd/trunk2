<?php
/* OpenSupermall Custom Routes */
// Station Administration
Route::get('station/administration', ['as' => 'map', 'uses' => 'StationController@map']);
Route::get('/station/get-stations-admin-data-for-table',['as'=> 'get-stations-admin-data-for-table', 'uses'=>'StationController@getStationsAdminDataForTable']);

// Station Analysis
Route::get('admin/analysis/geographical', ['as' => 'station-show', 'uses' => 'StationController@show']);

// Sales Analysis
Route::get('admin/analysis/sales', ['as' => 'analysissales', 'uses' => 'SalesAnalysisController@index']);

// Analysis -Emeka
Route::get('/admin/analysis/mc',['as'=>'srmerchantAnalysis','uses'=>'SRAnalysisController@get_mcanalysis_view']);
Route::get('/admin/station/selection',['as'=>'stationselectionan','uses'=>'StationController@station_selection_admin']);
Route::get('/admin/station/selection/{id}',['as'=>'stationselectionget','uses'=>'StationController@station_selection_get']);
Route::get('/admin/station/selection/state/{id}',['as'=>'stationselectiongets','uses'=>'StationController@station_selection_get_state']);
Route::get('/admin/station/selection/city/{id}',['as'=>'stationselectiongetc','uses'=>'StationController@station_selection_get_city']);
Route::get('/admin/station/selection/merchant/{id}',['as'=>'stationselectiongetm','uses'=>'StationController@station_selection_get_merchant']);
Route::get('/admin/station/selection/product/{id}',['as'=>'stationselectiongetm','uses'=>'StationController@station_selection_get_product']);


?>
