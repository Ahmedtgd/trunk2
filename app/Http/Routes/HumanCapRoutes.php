<?php
// Staff Routes
Route::get('stafflist','HumanCapController@staffList');
Route::get('staff/attendance/{id}','HumanCapController@staffAttendance');
Route::post('staff/attendance/record','HumanCapController@staffAttendanceRecord');
Route::get('staff/commission/{id}','HumanCapController@staffCommission');
Route::get('staff/overtime/{id}','HumanCapController@staffOvertime');
Route::get('staff/schedule/{id}','HumanCapController@staffSchedule');
Route::post('staff/schedule/{id}','HumanCapController@staffScheduleTime');
Route::get('staff/schedule','HumanCapController@staffSchedule');
Route::get('staff/leave/{id}','HumanCapController@staffLeave');
Route::post('staff/leave','HumanCapController@staffLeaveStore');
Route::get('staff/payslip','HumanCapController@payslip');
Route::get('staff/summary','HumanCapController@summary');
Route::get('staff/parttimer/{id}','HumanCapController@parttimer');
Route::get('staff/staff_name/{id}/{mode?}','HumanCapController@staff_name');
Route::post('staff/product_comm','HumanCapController@store_prod_comm');
Route::post('staff/delete_product_comm','HumanCapController@delete_prod_comm');
Route::post('staff/branch_comm','HumanCapController@store_percent_comm');
Route::post('staff/delete_branch_comm','HumanCapController@delete_branch_comm');


Route::post('staff/over_time','HumanCapController@store_over_time');
Route::post('staff/part_time','HumanCapController@store_part_time');

Route::get('staff/test','HumanCapController@staffAttendance');

Route::get('manager/schedule','HumanCapController@manager_schedule');
Route::post('manager/update_shift','HumanCapController@manager_update_shift');
Route::post('manager/store_shift','HumanCapController@manager_store_shift');
Route::post('manager/daily_schedule','HumanCapController@manager_daily_schedule');
Route::post('manager/mgr_schedule','HumanCapController@manager_schedule_store');
Route::get('manager/schedule/{id}','HumanCapController@manager_schedule_month');
Route::get('manager/weekly_routine','HumanCapController@weekly_routine');
Route::get('manager/manager_working','HumanCapController@manager_working');

Route::post('staff/getcommprods','ProductController@get_commission_products');

//ahsan
Route::get('/cproduct','MerchantDashboardController@productcomms');
?>
