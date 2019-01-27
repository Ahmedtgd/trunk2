<?php

/* OpenSupermall Custom Routes */
Route::get('admin/master/advertisement', array('as' => 'advertisementmaster', 'uses' => 'AdvertisementController@master'));
/* * * Delivery Order Product ** */
Route::get('admin/master/deliveryorder', array('as' => 'DeliveryOrder', 'uses' => 'AdminDeliveryOrderController@index'));
Route::get('admin/master/delivery_order_details/{id}', 'AdminDeliveryOrderController@show_po_details');
Route::get('admin/master/humancap', array('as' => 'humancapMaster', 'uses' => 'HumanCapController@master'));
Route::get('admin/master/humancap/approval/{id}', array('as' => 'humancapApproval', 'uses' => 'HumanCapController@approval'));
Route::get('admin/master/wishlist', array('as' => 'WhiseshMaster', 'uses' => 'AdminMasterMerchantController@wishlist'));
Route::get('admin/master/wishlist/{user_id}', array('as' => 'WhiseshMasterProduct', 'uses' => 'AdminMasterMerchantController@wishlist_product'));
Route::get('admin/master/network/{id}', array('as' => 'merchantNetwork', 'uses' => 'AdminMasterMerchantController@network'));
Route::get('admin/master/snetwork/{id}', array('as' => 'stationNetwork', 'uses' => 'AdminMasterMerchantController@snetwork'));
Route::get('admin/master/oshops/{id}', array('as' => 'merchantOshops', 'uses' => 'AdminMasterMerchantController@oshops'));
Route::get('admin/master/merchant/approval/{id}', array('as' => 'merchantApproval', 'uses' => 'AdminMasterMerchantController@approval'));
Route::get('admin/master/oshop/approval/{id}', array('as' => 'oshopApproval', 'uses' => 'OshopController@oshopapproval'));
Route::get('admin/master/oshop/product/transfer/{id}', array('as' => 'oshopProductTransfer', 'uses' => 'OshopController@oshopproducttransfer'));
Route::get('admin/master/oshop/transfer/{id}', array('as' => 'oshopTransfer', 'uses' => 'OshopController@oshoptransfer'));
Route::get('admin/master/oshop/transfer_history/{id}', array('as' => 'oshopTransferHistory', 'uses' => 'OshopController@oshop_transfer_history'));
Route::get('admin/master/oshop/product/transfer_history/{id}', array('as' => 'PoshopTransferHistory', 'uses' => 'OshopController@product_transfer_history'));
Route::get('admin/master/product/{id}', array('as' => 'ProductM', 'uses' => 'ProductController@listProducts'));
Route::post('product/transfer', array('as' => 'ProductTransfer', 'uses' => 'OshopController@product_transfer'));
Route::post('oshop/transfer', array('as' => 'osTransfer', 'uses' => 'OshopController@oshop_transfer'));
Route::post('admin/master/saveOshopRemarks', array('as' => 'saveOshopRemarks', 'uses' => 'OshopController@saveOshopRemarks'));
Route::get('admin/master/oshop_remarks/{id}', array('as' => 'OshopRemark', 'uses' => 'OshopController@oshop_remarks'));
Route::post('admin/master/approveOshop', array('as' => 'approveOshop', 'uses' => 'OshopController@approveOshop'));



//Route::get('admin/master/deliveryorder/{id}','AdminDeliveryOrderController@edit');
//Route::post('admin/master/orders','AdminDeliveryOrderController@store');
//Route::put('admin/master/orders/{id?}','AdminDeliveryOrderController@update');


Route::get('admin/master/investment', array('as' => 'MasterInvestment', 'uses' => 'InvestmentController@master'));
Route::get('admin/master/oshop', array('as' => 'MasterOshop', 'uses' => 'OshopController@master'));
Route::get('admin/master/merchant', array('as' => 'MasterMerchant', 'uses' => 'AdminMasterMerchantController@index'));
Route::get('paginate/merchant', array('as' => 'MasterMerchantPag', 'uses' => 'AdminMasterMerchantController@paginate_merchant'));
Route::get('/admin/logistics/delivery', array('as' => 'DeliveryMaster', 'uses' => 'AdminMasterDeliveryController@showDelivery'));
Route::get('/admin/master/getmerchantproduct/{id}', array('as' => 'MerchantProd', 'uses' => 'AdminMasterMerchantController@getmerchantproduct'));
Route::get('/admin/master/merchant_remarks/{id}', array('as' => 'MasterBuyerRolesRemarks', 'uses' => 'AdminMasterMerchantController@merchant_remarks'));
Route::get('/admin/master/humancap_remarks/{id}', array('as' => 'MasterhumancapRemarks', 'uses' => 'HumanCapController@humancap_remarks'));
Route::get('/admin/master/merchant/remarks/{id}', array('as' => 'MasterBuyerRolesRemarksApp', 'uses' => 'AdminMasterMerchantController@merchant_remarks_approval'));
Route::get('/admin/master/merchant_approval/{id}', array('as' => 'merchant_approval', 'uses' => 'AdminMasterMerchantController@merchant_approval'));
Route::get('admin/master/getmerchantmngrs/{id}', array('as' => 'MasterMerchantMngrs', 'uses' => 'AdminMasterMerchantController@getmngrs'));
Route::post('admin/master/setmerchantmngrs/{id}', 'AdminMasterMerchantController@setmngrs');
Route::post('admin/master/approveMerchant', array('as' => 'approveMasterMerchant', 'uses' => 'AdminMasterMerchantController@approveMerchant'));
Route::post('admin/master/approveHumanCap', array('as' => 'approveHumanCap', 'uses' => 'HumanCapController@approveHumanCap'));
Route::post('admin/master/approveMerchantSection', array('as' => 'approveMerchantSection', 'uses' => 'AdminMasterMerchantController@approveMerchantSection'));
Route::post('admin/master/saveMerchantRemarks', array('as' => 'saveMerchantRemarks', 'uses' => 'AdminMasterMerchantController@saveMerchantRemarks'));
Route::post('admin/master/saveHumanCapRemarks', array('as' => 'saveHumanCapRemarks', 'uses' => 'HumanCapController@saveHumanCapRemarks'));
Route::post('admin/master/saveMerchantSecRemarks', array('as' => 'saveMerchantSecRemarks', 'uses' => 'AdminMasterMerchantController@saveMerchantSecRemarks'));
//Admin Station
Route::get('/admin/master/station', array('as' => 'Station', 'uses' => 'AdminStationController@index'));
Route::get('/admin/master/station/approval/{id}', array('as' => 'stationApproval', 'uses' => 'AdminStationController@approval'));
Route::get('/admin/master/station/details/{id}', array('as' => 'stationDetails', 'uses' => 'AdminStationController@details'));
Route::get('/admin/master/getstationproduct/{id}', array('as' => 'StationProd', 'uses' => 'AdminStationController@getstationproduct'));
Route::get('/admin/master/property', array('as' => 'Property', 'uses' => 'AdminPropertyController@index'));
Route::get('/admin/master/sproperty/{id}', array('as' => 'sProperty', 'uses' => 'AdminPropertyController@sproperty'));
Route::get('/admin/master/station_remarks/{id}', array('as' => 'MasterStationRolesRemarks', 'uses' => 'AdminStationController@station_remarks'));


Route::get('/admin/master/station_recruiter', [
	'as' => 'station_recruiter',
	'uses' => 'AdminStationController@get_station_recruiter'
]);
Route::get('/admin/master/station_recruiter/approval/{id}', [
	'as' => 'recruiterApproval',
	'uses' => 'AdminStationController@approval_sr'
]);
Route::post('/admin/master/approveStation', array('as' => 'approveStation', 'uses' => 'AdminStationController@approveStation'));
Route::post('admin/master/saveStationRemarks', array('as' => 'saveStationRemarks', 'uses' => 'AdminStationController@saveStationRemarks'));

Route::get('/admin/product/wholesale/{id}', array('as' => 'ProductWholesale', 'uses' => 'ProductController@getWholesale'));
Route::get('/admin/tproduct/wholesale/{id}', array('as' => 'ProductWholesalet', 'uses' => 'ProductController@getWholesalet'));
Route::get('/admin/product/specialsale/{id}', array('as' => 'ProductWholesales', 'uses' => 'ProductController@getSpecialsale'));
Route::get('/admin/tproduct/specialsale/{id}', array('as' => 'ProductWholesalest', 'uses' => 'ProductController@getSpecialsalet'));
Route::get('/admin/product/likes/{id}', array('as' => 'ProductLikes', 'uses' => 'ProductController@getLikes'));
Route::get('/admin/product/hyper/{id}', array('as' => 'ProductHyper', 'uses' => 'ProductController@getHyper'));
Route::get('/admin/product/spec/{id}', array('as' => 'ProductSpec', 'uses' => 'ProductController@getSpec'));
Route::post('/admin/product/update_availability/{id}', array('as' => 'UpdateAvailability', 'uses' => 'ProductController@update_availability'));
Route::post('/admin/product/update_brand/{id}', array('as' => 'UpdateBrand', 'uses' => 'ProductController@update_brand'));
Route::post('/admin/product/update_category/{id}', array('as' => 'UpdateCategory', 'uses' => 'ProductController@update_category'));
Route::post('/admin/product/update_subcategory/{id}', array('as' => 'UpdatesubCategory', 'uses' => 'ProductController@update_subcategory'));

Route::get('/admin/master/consultant', array('as' => 'MasterMerchantConsultant', 'uses' => 'MerchantConsultantController@consultant'));
Route::get('/admin/master/consultant/approval/{id}', array('as' => 'merchantCApproval', 'uses' => 'MerchantConsultantController@approval'));
Route::post('admin/master/approveSalesStaff', array('as' => 'approveMasterMerchantConsultant', 'uses' => 'MerchantConsultantController@approveSalesStaff'));
Route::post('admin/master/saveSalesStaffRemarks', array('as' => 'saveMerchantRemarks', 'uses' => 'MerchantConsultantController@saveSalesStaffRemarks'));
Route::get('/admin/master/sales_staff_remarks/{id}', array('as' => 'MasterBuyerRolesRemarks', 'uses' => 'MerchantConsultantController@sales_staff_remarks'));

Route::get('/admin/master/Merchant_professional', array('as' => 'MasterMerchantProfessional', 'uses' => 'MerchantProfessionalController@professional'));
Route::get('/admin/master/merchant_campaign', array('as' => 'MasterMerchantCampaign', 'uses' => 'AdminMasterMerchantController@campaign'));
Route::get('/admin/master/professional/approval/{id}', array('as' => 'merchantPApproval', 'uses' => 'MerchantProfessionalController@approval'));
Route::get('/admin/master/merchantProfessionalPopUp/{id}', array('as' => 'MasterMerchantProfessionalPopUp', 'uses' => 'MerchantProfessionalPopUpController@index'));

Route::get('/admin/master/campaign/approval/{id}', array('as' => 'campaignApproval', 'uses' => 'AdminMasterMerchantController@campaign_approval'));
Route::post('admin/master/saveCompanycampaignRemarks', array('as' => 'saveCompanycampaignRemarks', 'uses' => 'AdminMasterMerchantController@saveCompanycampaignRemarks'));
Route::post('admin/master/approveCompanycampaign', array('as' => 'approveCompanycampaign', 'uses' => 'AdminMasterMerchantController@approveCompanycampaign'));
Route::get('/admin/master/companycampaign_remarks/{id}', array('as' => 'COmpanyCampRemakrs', 'uses' => 'AdminMasterMerchantController@companycampaign_remarks'));

Route::get('/admin/master/buyer', array('as' => 'MasterBuyer', 'uses' => 'BuyerController@master_buyer'));
Route::get('/paginate/buyer', array('as' => 'MasterBuyerPag', 'uses' => 'BuyerController@buyer_pagination'));
Route::get('admin/master/buyer/approval/{id}', array('as' => 'buyerApproval', 'uses' => 'BuyerController@approval'));
Route::get('admin/master/buyer/others/{id}', array('as' => 'buyerOthers', 'uses' => 'BuyerController@others'));
Route::get('/admin/master/buyer_interest/{id}', array('as' => 'MasterBuyerInterest', 'uses' => 'BuyerController@buyer_interest'));
Route::get('/admin/master/buyer_address/{id}', array('as' => 'MasterBuyerAddress', 'uses' => 'BuyerController@buyer_address'));
Route::get('/admin/master/buyer_payment_method/{id}', array('as' => 'MasterBuyerPayment', 'uses' => 'BuyerController@buyer_payment_method'));
Route::get('/admin/master/buyer_roles/{id}', array('as' => 'MasterBuyerRoles', 'uses' => 'BuyerController@buyer_roles'));
Route::post('admin/master/buyer_edit/{id}/{role}/{tf}/{rec}', 'BuyerController@buyer_edit');
Route::get('/admin/master/buyer_likes/{id}', array('as' => 'BuyerLikes', 'uses' => 'BuyerController@getLikes'));
Route::get('/admin/master/buyer_ocredit/{id}', array('as' => 'BuyerOcredit', 'uses' => 'BuyerController@getOcredit'));

Route::post('admin/master/approveBuyer', array('as' => 'approveMasterBuyer', 'uses' => 'BuyerController@approveBuyer'));
Route::post('admin/master/saveBuyerRemarks', array('as' => 'saveBuyerRemarks', 'uses' => 'BuyerController@saveBuyerRemarks'));
Route::get('/admin/master/buyer_remarks/{id}', array('as' => 'MasterBuyerRolesRemarks', 'uses' => 'BuyerController@buyer_remarks'));

Route::get('admin/master/product', array('as' => 'Product', 'uses' => 'ProductController@listProducts'));
Route::get('admin/master/productterm', array('as' => 'ProductTerm', 'uses' => 'ProductController@listProductterm'));
Route::get('admin/master/productterm/{id}', array('as' => 'ProductTermId', 'uses' => 'ProductController@listProducttermid'));
Route::get('/admin/master/product/approval/{id}', array('as' => 'productApproval', 'uses' => 'ProductController@approval'));
Route::get('/admin/master/product/price/{id}', array('as' => 'productPrice', 'uses' => 'ProductController@price'));
Route::post('admin/master/approveProduct', array('as' => 'approveProduct', 'uses' => 'ProductController@approveProduct'));
Route::post('admin/master/approveProductSection', array('as' => 'approveProductSection', 'uses' => 'ProductController@approveProductSection'));
Route::post('admin/master/approveProductSectionB2b', array('as' => 'approveProductSectionN2b', 'uses' => 'ProductController@approveProductSectionB2b'));
Route::post('admin/master/saveProductRemarks', array('as' => 'saveProductRemarks', 'uses' => 'ProductController@saveProductRemarks'));
Route::post('admin/master/saveProductSecRemarks', array('as' => 'saveProductSecRemarks', 'uses' => 'ProductController@saveProductSecRemarks'));
Route::get('admin/master/product_approval/{id}', array('as' => 'product_approval', 'uses' => 'ProductController@product_approval'));
Route::get('admin/master/product_remarks/{id}', array('as' => 'ProductRemark', 'uses' => 'ProductController@product_remarks'));
Route::get('admin/master/product/remarks/{id}', array('as' => 'ProductRemarkApproval', 'uses' => 'ProductController@product_remarks_approval'));
/*Route::resource('admin/master/order', 'OrderController', [
	'names' =>
	[
		'index' => 'Order',
	]
]);*/

Route::get('admin/master/order' ,array('as' => 'Order', 'uses' => 'OrderController@index'));
Route::get('paginate/order' ,array('as' => 'PagOrder', 'uses' => 'OrderController@order_pagination'));

Route::get('admin/master/term', array('as' => 'OrderTerm', 'uses' => 'OrderController@term'));
//  Paul on 1 May 2017 to enable MRT for Buyer & Merchant as well
//Route::get('admin/master/orderapp/{id}', array('as' => 'appordermaster', 'uses' => 'OrderController@approval'));
Route::post('admin/master/order/manual/{id}', array('as' => 'manualorder', 'uses' => 'OrderController@manual'));
Route::get('admin/order/{id}', array('as' => 'DeliveryOrder', 'uses' => 'OrderController@getDeliveryOrder'));
Route::get('/admin/master/employee', array('as' => 'routeEmployee', 'uses' => 'EmployeeController@index'));
Route::get('/admin/master/employee/approval/{id}', array('as' => 'employeeApproval', 'uses' => 'EmployeeController@approval'));
Route::post('/admin/master/employee_position/{id}/{pos}', array('as' => 'MasterEmployeeRoles', 'uses' => 'EmployeeController@employee_position'));
Route::get('/admin/master/employee_roles/{id}', array('as' => 'MasterEmployeeRoles', 'uses' => 'EmployeeController@employee_roles'));
Route::get('/admin/master/employee_payment/{id}', array('as' => 'MasterEmployeePayment', 'uses' => 'EmployeeController@employee_payment'));
Route::post('/admin/master/employee_payment/{id}', array('as' => 'MasterEmployeeRoles', 'uses' => 'EmployeeController@employee_payment_save'));
Route::get('/admin/master/employee_pcb/{id}', array('as' => 'MasterEmployeePcb', 'uses' => 'EmployeeController@employee_pcb'));
Route::get('/admin/master/employee_remarks/{id}', array('as' => 'MasterEmployeeRolesRemarks', 'uses' => 'AdminMasterMerchantController@employee_remarks'));
Route::get('/admin/master/employee/{employee}/attachment', array('as' => 'routeEmployeeAttachment', 'uses' => 'EmployeeController@showattachment'));
Route::post('admin/master/approveEmployee', array('as' => 'approveMasterEmployee', 'uses' => 'EmployeeController@approveEmployee'));
Route::post('admin/master/saveEmployeeRemarks', array('as' => 'saveEmployeeRemarks', 'uses' => 'EmployeeController@saveEmployeeRemarks'));
Route::get('admin/master/employee_document/{id}', array('as' => 'EmployeeDocument', 'uses' => 'EmployeeController@EmployeeDocument'));
Route::post('/admin/master/employee_update_document', array('as' => 'EmployeeUpdateDocument', 'uses' => 'EmployeeController@EmployeeUpdateDocument'));

// Added by Syed Salman Ali (salman.falcon@gmail.com)
Route::get('admin/master/cre', [ 'as' => 'cre', 'uses' => 'AdminCreController@index']);
Route::get('admin/master/cre/approval/{id}', [ 'as' => 'creApproval', 'uses' => 'AdminCreController@approval']);


//mass_autolink
//moved to AdminGeneralRoutes.php


// openchannel admin
Route::get('admin/master/openchannel', array('as' => 'openchannel', 'uses' => 'ChannelController@channeladmin'));
Route::get('admin/master/sochannelall/{id}', array('as' => 'sochannelAll', 'uses' => 'ChannelController@sochannelall'));
Route::get('admin/master/sochannelactive/{id}', array('as' => 'sochannelActive', 'uses' => 'ChannelController@sochannelactive'));
Route::get('admin/master/sochannelpasive/{id}', array('as' => 'sochannelPasive', 'uses' => 'ChannelController@sochannelpasive'));
Route::get('admin/master/ochannelall/{id}', array('as' => 'ochannelAll', 'uses' => 'ChannelController@ochannelall'));
Route::get('admin/master/ochannelactive/{id}', array('as' => 'ochannelActive', 'uses' => 'ChannelController@ochannelactive'));
Route::get('admin/master/ochannelpasive/{id}', array('as' => 'ochannelPasive', 'uses' => 'ChannelController@ochannelpasive'));
Route::get('/admin/master/getstationchannel/{id}', array('as' => 'openchannelstation', 'uses' => 'ChannelController@getstation'));


// Password Reset
Route::post('/admin/master/buyer-password-reset', 'BuyerController@resetBuyerPassword');

// Hyper

Route::get('admin/master/hyper','AdminHyperController@index');

// Openwish routes ported from routes file
/*Start Route for  OpenWish*/
 Route::get('/admin/master/openwish', array('as' => 'routeOpenWish', 'uses' => 'OpenWishController@index'));
 Route::resource('/admin/master/general/openwish', 'OpenWishController');
 // Route::get('/admin/owp/{number}', 'OpenWishController@owpledge');
 Route::get('/admin/master/openwish/owpledge/{number}' , 'OpenWishController@owpledge');
 /*End Route for OpenWish  */
 Route::get('/admin/master/smm', ['as' => 'masterSMM', 'uses' => 'SMMController@smmastereport']);
 Route::get('/admin/master/smm/approval/{id}', ['as' => 'smmApproval', 'uses' => 'SMMController@smmastereportapp']);

 Route::get('/admin/master/opencredit', array('as' => 'openCredit', 'uses' => 'OpenCreditController@index'));

 Route::get('admin/master/discount', ['uses' => 'MerchantDashboardController@masterDiscount']);


Route::get('owish/trans/{openwish_id}','OpenWishController@trans_openwish');
 // Outlet Ajax route . param : station id
 // Update: No more ajax

Route::get('admin/master/station/outlet/{station_id}','AdminStationController@get_outlet');
Route::get('admin/master/station/oqueue/{station_id}','AdminStationController@get_oqueue');
Route::get('admin/master/station/detail/{station_id}','AdminStationController@get_sr');
Route::get('admin/master/smm/all','SMMController@smm_all');
Route::get('admin/master/smm/slct','SMMController@smm_slct');

// Route for CRE images . returns a view with image gallery.
Route::get('admin/master/cre/reasons/{cre_id}/images','AdminCreController@show_cre_images');

Route::get('admin/master/cre/review/{oid}','AdminCreController@getReview');
//Route::post('admin/master/cre/review','AdminCreController@doReview');
Route::post('admin/master/cre/review','AdminCreController@doReview');
// SMM per user_id
Route::get('admin/master/smm/info/{user_id}/{smmout_id?}','SMMController@getSMM');
Route::get('admin/master/smm/info/clicked/{user_id}/{smmout_id}','SMMController@getClicked');
// Route::get('admin/master/cre/resource/{image_path}/image','')

// Delivery

 Route::get('admin/master/delivery','AdminMasterDeliveryController@showDelivery');
 Route::get('paginate/delivery','AdminMasterDeliveryController@get_deliverys');
 
 /*** TOKEN by Auggy**/
 Route::get('admin/master/token','TokenController@master');
 Route::post('admin/free_tokens','TokenController@free_tokens');
 Route::post('admin/available_tokens','TokenController@available_tokens');
 Route::post('admin/set_tokens','TokenController@set_tokens');
 Route::post('admin/available_facilities','TokenController@available_facilities');
 Route::post('admin/offer_tokens','TokenController@offer_tokens');
 Route::get('paginate/token','TokenController@master_pagination');
 Route::get('/admin/token/facilities/{id}', array('as' => 'TokenFacilties', 'uses' => 'TokenController@getFacilities'));
 Route::post('/admin/token/facilities/edit_subscription', array('as' => 'TokenSubscription', 'uses' => 'TokenController@edit_subscription'));
 Route::post('/admin/token/facilities/edit_admin', array('as' => 'TokenAdmin', 'uses' => 'TokenController@edit_admin'));
 Route::get('/admin/token/transaction/{id}', array('as' => 'getTokenTransaction', 'uses' => 'TokenController@getTokenTransaction'));
 Route::get('/admin/token/alltransactions/', array('as' => 'getTokenTransactions', 'uses' => 'TokenController@getTokenAllTransactions'));
 Route::get('/admin/token/log/{id}', array('as' => 'getTokenLog', 'uses' => 'TokenController@getTokenLog'));
 Route::get('/admin/master/apr_remarks/{id}', array('as' => 'apr_remarks', 'uses' => 'AdminMasterMerchantController@apr_remarks'));
Route::get('paginate/product/{id?}','ProductController@get_products');
Route::post('subcats/by/pid','ProductController@subcats_by_pid');


//Test Route

Route::get('pm','ProductController@pm'); 

//CRM
Route::get('admin/member/staff' ,array('as' => 'adminmemberlist', 'uses' => 'CRMController@members'));
Route::get('admin/member/lasttemplate' ,array('as' => 'adminlastemplate', 'uses' => 'CRMController@lasttemplate'));
Route::get('admin/member/campaign' ,array('as' => 'adminmembercampaign', 'uses' => 'CRMController@campaign'));
Route::get('admin/member/campaign/{id}' ,array('as' => 'adminmembercampaign', 'uses' => 'CRMController@campaigncustomers'));
Route::post('/admin/member/add_employee/{type?}',['as' => 'addemployeeadminos', 'uses'=>'CRMController@add_employee']);   
Route::post('/admin/member/send_emails',['as' => 'sendemailsosmall', 'uses'=>'CRMController@send_emails']);
Route::post('/admin/member/send_emails_c',['as' => 'sendemailsosmallc', 'uses'=>'CRMController@send_emails_c']);
Route::get('/admin/member/segments',['as' => 'osmallsegments', 'uses'=>'CRMController@segments']);
Route::get('/admin/member/campaings/{id}',['as' => 'osmallcampaignsc', 'uses'=>'CRMController@c_campaigns']);
Route::post('/admin/member/save_campaign',['as' => 'save_campaignosmall', 'uses'=>'CRMController@save_campaign']);
Route::post('/admin/member/send_campaign',['as' => 'send_campaignosmall', 'uses'=>'CRMController@send_campaign']);
Route::post('/admin/campaign/delete',['as' => 'deletcampaignosmall', 'uses'=>'CRMController@deletecampaign']);
Route::post('/admin/member/delete',['as' => 'deletememberosmall', 'uses'=>'CRMController@deletemember']);
Route::post('/admin/member/add_role',['as' => 'addroleselleros', 'uses'=>'CRMController@add_role']);
Route::get('/admin/member/roles/{user_id}',['as' => 'sellermemberroleos', 'uses'=>'CRMController@adminmemberrole']);
Route::get('/admin/member/rolescust/{user_id}',['as' => 'sellermemberroleos', 'uses'=>'CRMController@adminmemberrolecust']);
Route::post('/admin/member/add_recruiter',['as' => 'add_recruiteros', 'uses'=>'CRMController@add_recruiter']);
Route::post('/admin/member/roles/{user_id}',['as' => 'postsellermemberroleos', 'uses'=>'CRMController@changememberrole']);
Route::post('/admin/member/rolescust/{user_id}',['as' => 'postsellermemberroleos', 'uses'=>'CRMController@changememberrole']);
Route::get('admin/member/status/{id}',['as' => 'employeeOsmall', 'uses'=>'CRMController@member_status']);
Route::get('admin/member_remarks/{id}',['as' => 'employeeOsmallRem', 'uses'=>'CRMController@member_remarks']);
Route::post('admin/approveMember','CRMController@approveMember');
Route::post('admin/saveMemberRemarks','CRMController@saveMemberRemarks');
Route::get('opencredit/{buyer_id}','OpenCreditController@get_opencredit_buyer');

?>
