<?php
/* OpenSupermall Custom Routes */

// merchant payment routes :: wahid
Route::get('/admin/payment/consolidator', ['as' => 'consolidatorPayment', 'uses' => 'UserPaymentController@get_consolidator']);
Route::get('/paymentorders/{user_id}', ['as' => 'paymentorders', 'uses' => 'UserPaymentController@paymentorders']);
Route::post('/paymentfile', ['as' => 'paymentfile', 'uses' => 'UserPaymentController@paymentfile']);
Route::post('/paymentfiledownload', ['as' => 'paymentfiledownload', 'uses' => 'UserPaymentController@paymentfiledownload']);
Route::post('/paymentconfirm', ['as' => 'paymentconfirm', 'uses' => 'UserPaymentController@paymentconfirm']);
Route::post('/paymentdelete', ['as' => 'paymentdelete', 'uses' => 'UserPaymentController@paymentdelete']);
Route::get('/admin/payment/merchant', ['as' => 'merchantPayment', 'uses' => 'UserPaymentController@get_merchant_view']);
Route::get('/admin/payment/logistic', ['as' => 'logisticPayment', 'uses' => 'UserPaymentController@get_logistic_view']);
Route::get('/admin/payment/merchant_single/{id}', 'UserPaymentController@get_merchant_single');
Route::get('/admin/payment/logistic_single/{id}', 'UserPaymentController@get_logistic_single');
Route::get('/admin/payment/station_single/{id}', 'UserPaymentController@get_station_single');
Route::get('/admin/payment/merchant/order/{id}','UserPaymentController@get_order_view');
Route::get('/admin/payment/merchant/product/{id}','UserPaymentController@get_product_view');
Route::post('/paymerchant','UserPaymentController@post_pay_merchant');
Route::post('/paylogistic','UserPaymentController@post_pay_logistic');
Route::post('/payorder','UserPaymentController@post_pay_order');

// smm payment routes :: wahid
Route::get('/admin/payment/smm', ['as' => 'smmPayment', 'uses' => 'UserPaymentController@get_smm_view']);
Route::get('/admin/payment/smm/smmdetail/{id}','UserPaymentController@get_smm_details_view');
Route::post('/paysmm','UserPaymentController@post_pay_smm');

// employee payment routes :: wahid
Route::get('/admin/payment/employee', ['as' => 'employeePayment', 'uses' => 'UserPaymentController@get_employee_view']);
Route::get('/admin/payment/employee/details/{id}', ['as' => 'employeepaydetails', 'uses' => 'UserPaymentController@get_employee_view_details']);
Route::post('/payemployee','UserPaymentController@post_pay_employee');

//payment logistics routes :: nirmesh
Route::get('/payment/logistics', ['as' => 'logisticsPayment', 'uses' => 'UserPaymentController@get_payment_logistics']);

// mp payment routes :: emeka
Route::get('/admin/payment/mp', ['as' => 'mpPayment', 'uses' => 'MPPaymentController@get_mp_view']);
Route::get('/admin/payment/mp/details/{id}', ['as' => 'mpPaymentDetails', 'uses' => 'MPPaymentController@get_mpdetail_view']);
Route::get('/admin/payment/mpa/{id}',['as'=>'mpPaymentAnalysis','uses'=>'MPPaymentController@get_mpanalysis_view']);
Route::post('/admin/payment/mp/consolidate',['as'=>'postMPPaymentConsolidate', 'uses' => 'MPPaymentController@post_consolidation']);

//Route::post('/admin/payment/mp/consolidate','UserPaymentController@post_pay_pc');


//mc post consolidation :: emeka
Route::get('/admin/payment/mc', ['as' => 'mcPayment', 'uses' => 'UserPaymentController@get_mc_view']);
Route::get('/admin/payment/mc/details/{id}', ['as' => 'mcpaydetails', 'uses' => 'UserPaymentController@get_mcdetail_view']);
Route::get('/admin/payment/mca/{id}',['as'=>'srmerchantConsultantAnalysis','uses'=>'SRPaymentController@get_mcanalysis_view']);
Route::post('/admin/payment/mc/consolidate',['as'=>'postconsolidatemc', 'uses'=>'UserPaymentController@post_consolidation']);


// ~Zurez
// Station Recruiter - Emeka
Route::get('/admin/payment/sr',['as'=>'srPayment','uses'=>'SRPaymentController@get_sr_view']);
Route::get('/admin/payment/sr/details/{sr_id}',['as'=>'srPaymentDetails','uses'=>'SRPaymentController@get_srdetails_view']);
Route::get('/admin/payment/sra/{sr_id}',['as'=>'srPaymentAnalysis','uses'=>'SRPaymentController@get_sranalysis_view']);
Route::post('/admin/payment/sr/consolidate',['as'=>'srPaymentConsolidate', 'uses' => 'SRPaymentController@post_consolidation']);

//payment receivable ipay88
Route::get('/admin/payment/receivables',['as'=>'paymentReceivableGateway', 'uses'=>'PaymentReceivableController@get_ipay']);
Route::get('/admin/payment/receivables/detail/{week_number}',['as'=>'paymentReceivableGatewayDetail', 'uses'=>'PaymentReceivableController@get_ipay_detail']);
Route::post('/admin/payment/receivables/remark',['as'=>'paymentReceivableGatewayRemark', 'uses'=>'PaymentReceivableController@post_ipay_remark']);
Route::post('/admin/payment/receivables/partial',['as'=>'paymentReceivableGatewayPartial', 'uses'=>'PaymentReceivableController@post_ipay_partial']);

/*
Payment to Station Routes.
@author: Zurez

Route::group(["prefix"=>"admin/payment"],function(){
	Route::get('station',['as'=>'stationPayment','uses'=>'PaymentToStationController@get_station_payment_view']);
});
*/ 

?>
