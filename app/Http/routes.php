<?php
/*temporary login for writing login*/
use Illuminate\Support\Facades\Auth;

//---------------------------------

Event::listen('illuminate.query', function ($query) {
    //echo "<pre>";
    //print_r($query); echo "</pre>";
    Storage::append('q.log', $query);
});
//include_once("Routes/wastageRoutes.php");
include_once("Routes/InventorycostRoutes.php");
include_once("Routes/RefrigeratorRoutes.php");
include_once('Routes/SalesListRoutes.php');
include_once('Routes/TerminalRoutes.php');
include_once("Routes/TestRoutes.php");
include_once("Routes/PaymentRoutes.php");
include_once("Routes/MerchantRoutes.php");
include_once("Routes/MobileRoutes.php");
include_once("Routes/StationRoutes.php");
include_once("Routes/LogisticRoutes.php");
include_once("Routes/AppRoutes.php");
include_once("Routes/CProfileRoutes.php");
include_once("Routes/CampaignRoutes.php");
include_once("Routes/MerchantCaimanRoutes.php");
include_once("Routes/MLMCommissionsRoutes.php");
Route::group(['middleware'=>'gator'], function(){
	include_once("Routes/GatorRoutes.php");
});
include_once("Routes/OPOSsumRoutes.php");
include_once("Routes/RecipeRoutes.php");
include_once("Routes/VoucherRoute.php");
include_once("Routes/onz/LoginRoutes.php");
include_once("Routes/ONZRoutes/routes.php");
include_once("Routes/HumanCapRoutes.php");
include_once("Routes/WarehouseRoutes.php");
include_once("Routes/WalletRoutes.php");
include_once("Routes/PromotionRoutes.php");
include_once("Routes/BuyerRoutes.php");
include_once("Routes/SaleRoutes.php");

include_once("Routes/CustomerRoutes.php");
include_once("Routes/NStaffRoutes.php");
include_once("Routes/OpossumStaffRoutes.php");
include_once("Routes/WebProductMapperRoutes.php");

include_once("Routes/AgeingReportRoutes.php");
include_once("Routes/DOManagementRoutes.php");
include_once("Routes/StockLevelRoutes.php");
include_once("Routes/InventoryImpExpRoutes.php");

include_once("Routes/DebitNoteRoutes.php");
include_once("Routes/SalesItemsRoutes.php");
include_once("Routes/GroupBarcodeRoutes.php");

include_once("Routes/ProductQuantityRoutes.php");
include_once("Routes/ProductSalesRoutes.php");
include_once("Routes/StockOutRoutes.php");
include_once("Routes/CashSalesRoutes.php");
include_once("Routes/StaffSalesRoutes.php");

include_once("Routes/CreditProductSalesRoutes.php");
include_once("Routes/CreditStaffSalesRoutes.php");

include_once("Routes/StaffManagementRoutes.php");
include_once("Routes/CreditNoteRoutes.php");

include_once("Routes/JaguarRoutes.php");
include_once("Routes/ConsignmentRoutes.php");
include_once("Routes/QuotationRoutes.php");

include_once("Routes/LogisticShieldRoutes.php");
include_once("Routes/LogisticVerifyRoutes.php");
include_once("Routes/BarcodeAuditTrailRoutes.php");
include_once("Routes/RaWRoutes.php");

/*Mobile Routes are in RNRoutes*/
Route::group(['prefix'=>'rn/app'],function(){
    include_once ("RNRoutes/AuthRoutes.php");
    include_once("RNRoutes/LandingPageRoutes.php");
    include_once("RNRoutes/UserAuthRoutes.php");
    include_once("RNRoutes/ProductInfoRoutes.php");
    include_once("RNRoutes/ConglomerateRoutes.php");

    Route::group(["middleware"=>"jwt.auth"],function(){
        include_once("RNRoutes/ProductMapperRoutes.php");
        include_once("RNRoutes/HEProductMapperRoutes.php");
        include_once ("RNRoutes/ReportRoutes.php");
        include_once ("RNRoutes/SalesMemoRoutes.php");
        include_once ("RNRoutes/StaffPageRoutes.php");
        include_once ("RNRoutes/PlatyPOSRoutes.php");
    });
});

/*
Route::get('milton', function(){
	return view('caiman');
});
*/

/* Route::get('UserController/hello', 'UserController@index'); */

Route::get('DemoPrintCommandsController/printZPL', 'DemoPrintCommandsController@printZPL');
Route::get('DemoPrintCommands', 'DemoPrintCommandsController@index');
Route::get('DemoPrintCommandsController', 'DemoPrintCommandsController@printCommands');
Route::any('WebClientPrintController', 'WebClientPrintController@processRequest');

Route::get('test/view/shaban','GatorController@testview');


// Staff Routes
Route::get('stafflist','HumanCapController@staffList');
Route::get('staff/attendance','HumanCapController@staffAttendance');
Route::get('staff/commission','HumanCapController@staffCommission');
Route::get('staff/overtime','HumanCapController@staffOvertime');
//Route::get('staff/schedule','HumanCapController@staffSchedule');
Route::get('staff/schedule','HumanCapController@staffSchedule');
Route::get('staff/leave','HumanCapController@staffLeave');
Route::get('staff/payslip','HumanCapController@payslip');
Route::get('staff/summary','HumanCapController@summary');
Route::get('staff/parttimer','HumanCapController@parttimer');
Route::get('staff/staff_name','HumanCapController@staff_name');


Route::get('staff/test','HumanCapController@staffAttendance');

Route::get('manager/schedule','HumanCapController@manager_schedule');
Route::get('manager/weekly_routine','HumanCapController@weekly_routine');
Route::get('manager/manager_working','HumanCapController@manager_working');



Route::get('branch/subcat/{location_id}','ProductController@branchSubcat');
Route::get('branch/product/{location_id}/{subcat_id}','ProductController@branchProduct');


Route::get('tracking/report&stock', function(){
    return view('merchant.tracking_report');
});

Route::get('location', function(){
    return view('merchant.location');
});

Route::group(['middleware' => 'admin'], function() {
    include_once ("Routes/MerchantAccessRoutes.php");
    include_once("Routes/AdvertRoutes.php");
    include_once("Routes/AdminAnalysisRoutes.php");
    include_once("Routes/AdminCommissionRoutes.php");
    include_once("Routes/AdminCAPSRoutes.php");
    include_once("Routes/AdminGeneralRoutes.php");
    include_once("Routes/AdminMasterRoutes.php");
    include_once("Routes/AdminPaymentRoutes.php");
    include_once("Routes/AdminSMMRoutes.php");
    include_once("Routes/ScriptRoutes.php");
    include_once("Routes/CustomRoutes.php");
    include_once("Routes/CartRoutes.php");
    include_once("Routes/AdminLogisticRoutes.php");
    Route::get('admin/merchant/sbrand/{merchant_id}','BrandController@merchantsWithSameBrand');
    Route::get('admin/oshop/sbrand/{oshop_id}','BrandController@oshopsWithSameBrand');

    Route::post('admin/oshop/transfer','OshopController@transferOshop');
    Route::post('admin/product/transfer','ProductController@transfer_product');
    Route::get('/admin', ['as' => 'adminPanel', function () {
        return view('admin');
    }]);
    Route::get('/admin/analysis/smm', ['as' => 'masterSMManalysis', 'uses' => 'SMMController@smmasteranalysis']);
    Route::get('admin/admin_commission', array('as' => 'AdminCommission', 'uses' => 'AdminCommissionController@index'));
    Route::post('admin/edit_commission', 'AdminCommissionController@editCommission');
    Route::get('admin/master/discount', ['uses' => 'MerchantDashboardController@masterDiscount']);
    Route::get('/cd trcd truadmin/master/voucher', 'VoucherController@masterVoucher');
    Route::resource('/admin/master/autolink','AutoLinkController@index');
    Route::get('/admin/master/autolink/approval/{id}',['as' => 'autolinkApproval', 'uses' => 'AutoLinkController@approval']);
    Route::post('/admin/master/saveAutolinkRemarks', 'AutoLinkController@saveAutolinkRemarks');

    Route::get('/admin/master/autolink_remarks/{id}', array('as' => 'AutolinkRemarks', 'uses' => 'AutoLinkController@autolink_remarks'));
    Route::get('/admin/tblmgmt', ['as' => 'tblmgmt', function () {
        return view('admin/tblmgmt');
    }]);
    Route::get('/admin/heading', ['as' => 'heading', function () {
        return view('admin/generalHeading');
    }]);
    Route::get('admin/dashboard', ['as' => 'admin', 'uses' => 'AdminController@index']);

    /*get all categories*/
    Route::get('admin/category/get', 'AdminController@getCategories');
    Route::get('admin/category/getnum', 'AdminController@getCategoriesNum');

    /*get categories views*/
    Route::get('admin/tblmgmt/category', ['as' => 'categoryMgmt', 'uses' => 'AdminController@getCategoriesTable']);
    /*Start Route for  inventory analysis */

    Route::get('admin/analysis/inventory', ['as' => 'analysisinventory', 'uses' => 'AnalysisController@index']);
    Route::get('paginate/analysisinventory', array('as' => 'analysisinventorypag', 'uses' => 'AnalysisController@inventory_paginate'));
    Route::get('admin/analysis/inventory/{id}', ['as' => 'analysisinventoryproduct', 'uses' => 'AnalysisController@productinventory']);
    Route::get('admin/analysis/inventory_high/{id}', ['as' => 'analysisinventoryproducth', 'uses' => 'AnalysisController@productinventoryhigh']);
    Route::get('admin/analysis/inventory_low/{id}', ['as' => 'analysisinventoryproductl', 'uses' => 'AnalysisController@productinventorylow']);
    /*Start Route For Brand Table*/
    Route::get('admin/brand/get', 'BrandController@getBrand');
    Route::get('admin/tblmgmt/brand', ['as' => 'brandMgmt', 'uses' => 'BrandController@getBrandTable']);
    Route::post('admin/brand/add', 'BrandController@postNewBrand');
    Route::post('admin/brand/edit', 'BrandController@postEditBrand');
    Route::post('admin/brand/remove', 'BrandController@removeBrand');
    /*End Route For Brand Table*/

    /*Start Route For Newsletter Table*/
    Route::get('admin/newsletter/get', 'NewsletterController@getNewsletter');
    Route::get('admin/tblmgmt/newsletter', ['as' => 'newsletterMgmt', 'uses' => 'NewsletterController@getNewsletterTable']);
    Route::post('admin/newsletter/add', 'NewsletterController@postNewnewsletter');
    Route::post('admin/newsletter/edit', 'NewsletterController@postEditnewsletter');
    Route::post('admin/newsletter/remove', 'NewsletterController@removeNewsletter');
    /*End Route For Brand Table*/

    /*Start Route For Download Apps Table*/
    Route::get('admin/downloadapps/get', 'DownloadAppsController@getDownloadApps');
    Route::get('admin/tblmgmt/downloadapps', ['as' => 'downloadappsMgmt', 'uses' => 'DownloadAppsController@getDownloadAppsTable']);
    Route::post('admin/downloadapps/add', 'DownloadAppsController@postNewDownloadApps');
    Route::post('admin/downloadapps/edit', 'DownloadAppsController@postEditDownloadApps');
    Route::post('admin/downloadapps/remove', 'DownloadAppsController@removeDownloadApps');
    /*End Route For Brand Table*/

    /*Start Route For Directory Table*/
    Route::get('admin/directory/get', 'DirectoryController@getDirectory');
    Route::get('admin/tblmgmt/directory', ['as' => 'directoryMgmt', 'uses' => 'DirectoryController@getDirectoryTable']);
    Route::post('admin/directory/add', 'DirectoryController@postNewDirectory');
    Route::post('admin/directory/edit', 'DirectoryController@postEditDirectory');
    Route::post('admin/directory/remove', 'DirectoryController@removeDirectory');
    /*End Route For Brand Table*/

    /*Start Route For Buyer Help Table*/
    Route::get('admin/buyerhelp/get', 'BuyerHelpController@getBuyerHelp');
    Route::get('admin/tblmgmt/buyerhelp', ['as' => 'buyerhelpMgmt', 'uses' => 'BuyerHelpController@getBuyerHelpTable']);
    Route::post('admin/buyerhelp/add', 'BuyerHelpController@postNewBuyerHelp');
    Route::post('admin/buyerhelp/edit', 'BuyerHelpController@postEditBuyerHelp');
    Route::post('admin/buyerhelp/remove', 'BuyerHelpController@removeBuyerHelp');
    /*End Route For Brand Table*/

    /*Start Route For Seller Help Table*/
    Route::get('admin/sellerhelp/get', 'SellerHelpController@getSellerHelp');
    Route::get('admin/tblmgmt/sellerhelp', ['as' => 'sellerhelpMgmt', 'uses' => 'SellerHelpController@getSellerHelpTable']);
    Route::post('admin/sellerhelp/add', 'SellerHelpController@postNewSellerHelp');
    Route::post('admin/sellerhelp/edit', 'SellerHelpController@postEditSellerHelp');
    Route::post('admin/sellerhelp/remove', 'SellerHelpController@removeSellerHelp');
    /*End Route For Brand Table*/

    /*Start Route For Feedback Table*/
    Route::get('admin/feedback/get', 'FeedbackController@getFeedback');
    Route::get('admin/tblmgmt/feedback', ['as' => 'feedbackMgmt', 'uses' => 'FeedbackController@getFeedbackTable']);
    Route::post('admin/feedback/add', 'FeedbackController@postNewFeedback');
    Route::post('admin/feedback/edit', 'FeedbackController@postEditFeedback');
    Route::post('admin/feedback/remove', 'FeedbackController@removeFeedback');
    /*End Route For Brand Table*/

    // storing candidate's detail who applied for job
    Route::post('/JobStore', 'JobController@store');

    /*Start Route For Job Table*/
    Route::get('admin/job/get', 'JobController@getJob');
    Route::get('admin/tblmgmt/job', ['as' => 'jobMgmt', 'uses' => 'JobController@getJobTable']);
    Route::post('admin/job/add', 'JobController@postNewJob');
    Route::post('admin/job/edit', 'JobController@postEditJob');
    Route::post('admin/job/remove', 'JobController@removeJob');
    /*End Route For Brand Table*/
    /*Start Route For Contact Us Table*/
    Route::get('admin/contactus/get', 'ContactUsController@getContactUs');
    Route::get('admin/tblmgmt/contactus', ['as' => 'contactUsMgmt', 'uses' => 'ContactUsController@getContactUsTable']);
    Route::post('admin/contactus/add', 'ContactUsController@postNewContactUs');
    Route::post('admin/contactus/edit', 'ContactUsController@postEditContactUs');
    Route::post('admin/contactus/remove', 'ContactUsController@removeContactUs');
    /*End Route For Brand Table*/

    /*Start Route For Advertisement Table*/
    Route::get('admin/advertisement/get', 'AdvertisementController@getAdvertisement');
    Route::get('admin/tblmgmt/advertisement', ['as' => 'advertisementMgmt', 'uses' => 'AdvertisementController@getAdvertisementTable']);
    Route::post('admin/advertisement/add', 'AdvertisementController@postNewAdvertisement');
    Route::post('admin/advertisement/edit', 'AdvertisementController@postEditAdvertisement');
    Route::post('admin/advertisement/remove', 'AdvertisementController@removeAdvertisement');
    /*End Route For Brand Table*/


    /*Start Route For TermsAndCondition Policy Table*/
    Route::get('admin/termsandcondition/get', 'TermsAndConditionController@getTermsAndCondition');
    Route::get('admin/tblmgmt/termsandcondition', ['as' => 'termsandconditionMgmt', 'uses' => 'TermsAndConditionController@getTermsAndConditionTable']);
    Route::post('admin/termsandcondition/add', 'TermsAndConditionController@postNewTermsAndCondition');
    Route::post('admin/termsandcondition/edit', 'TermsAndConditionController@postEditTermsAndCondition');
    Route::post('admin/termsandcondition/remove', 'TermsAndConditionController@removeTermsAndCondition');
    /*End Route For Brand Table*/

    /*Start Route For Privacy Policy Table*/
    Route::get('admin/privacypolicy/get', 'PrivacyController@getPrivacyPolicy');
    Route::get('admin/tblmgmt/privacypolicy', ['as' => 'privacypolicyMgmt', 'uses' => 'PrivacyController@getPrivacyPolicyTable']);
    Route::post('admin/privacypolicy/add', 'PrivacyController@postNewPrivacyPolicy');
    Route::post('admin/privacypolicy/edit', 'PrivacyController@postEditPrivacyPolicy');
    Route::post('admin/privacypolicy/remove', 'PrivacyController@removePrivacyPolicy');
    /*End Route For Brand Table*/


    /*Start Route For Footer: Section A*/
    Route::get('admin/tblmgmt/footerSectionA',
        ['as' => 'footerSectionAMgmt', 'uses' => 'FooterSectionAController@index']);
    Route::post('admin/footerSectionA/save', 'FooterSectionAController@save');
    /*END Route For Footer: Section A*/


    /*Start Route For Footer: Section B*/
    Route::get('admin/tblmgmt/footerSectionB',
        ['as' => 'footerSectionBMgmt', 'uses' => 'FooterSectionBController@index']);

    /*END Route For Footer: Section B*/


    /*Roles*/
    Route::get('admin/roles/get', 'AdminController@getRoles');
    Route::get('admin/tblmgmt/roles', ['as' => 'rolesMgmt', 'uses' => 'AdminController@getRolesTable']);

    /*add new Roles */
    Route::post('admin/roles/add', 'AdminController@postNewRole');
    /*edit new Roles */
    Route::post('admin/roles/edit', 'AdminController@postEditRole');
    /*remove new Roles */
    Route::post('admin/roles/remove', 'AdminController@removeRole');

    Route::get('admin/tblmgmt/users', ['as' => 'user.all', 'uses' => 'AdminController@getUsers']);
    Route::post('admin/tblmgmt/users/single', ['as' => 'user.single', 'uses' => 'AdminController@getSingleUser']);
    Route::post('admin/tblmgmt/users/add', ['as' => 'user.add', 'uses' => 'AdminController@postNewUsers']);
    Route::post('admin/tblmgmt/users/edit', ['as' => 'user.edit', 'uses' => 'AdminController@postEditUser']);
    Route::post('admin/tblmgmt/users/remove', ['as' => 'user.remove', 'uses' => 'AdminController@removeUser']);

    /*Route::post('admin/tblmgmt/create-roles',[ 'as' => 'addNewRole', 'uses'=> 'AdminController@addNewRole']);
    Route::post('admin/tblmgmt/create-roles',[ 'as' => 'addNewRole', 'uses'=> 'AdminController@addNewRole']);
    Route::post('admin/tblmgmt/add-user-role',[ 'as' => 'addUserRole', 'uses'=> 'AdminController@addUserRole']);*/

    /*add new category or subcategory*/
    Route::post('admin/category/add', 'AdminController@postNewCategory');
    /*edit new category or subcategory*/
    Route::post('admin/category/edit', 'AdminController@postEditCategory');
    /*remove new category or subcategory*/
    Route::post('admin/category/remove', 'AdminController@removeCategory');
    Route::get('admin/payment/ipay88', ['as' => 'request_response', 'uses' => 'CartController@getRequestResponse']);
    Route::get('/admin/bankpayment', 'OcbcController@getBankPayment');
    Route::get('/admin/front', array('as' => 'adminFront', function () {
        return view("admin.adminFrontHome");
    }));
    Route::get('/admin/front/graph', array('as' => 'adminFrontGraph', 'uses' => 'ReportsController@monthlySales'));
    //Route::get('/admin/front/graph', array('as'=>'adminFrontGraph',function(){
    //    return view("admin.graphReport");
    //}));
    //Route::get('/admin/reports', ['as' => 'reportsHome', function () {
    //    return view('admin.CountrySales');
    //}]);
    Route::get('/admin/analysis/summary', array('as' => 'AnalysisSummary', 'uses' => 'ReportsController@get_all'));
    Route::get('/admin/front/sales', array('as' => 'countrySales', 'uses' => 'ReportsController@salesByCountry'));
    Route::get('/admin/front/activebuyer', array('as' => 'countryActiveBuyer', 'uses' => 'ReportsController@activeBuyer'));
    Route::get('/admin/front/merchant', array('as' => 'countryMerchant', 'uses' => 'ReportsController@merchantByCountry'));
    Route::get('/admin/front/mcrecruited', array('as' => 'countryMCRecruited', 'uses' => 'ReportsController@mcRecruited'));
    Route::get('/admin/front/buyerregistered', array('as' => 'countryBuyerRegistered', 'uses' => 'ReportsController@buyerRegistered'));
    Route::get('/admin/front/smmrecruited', array('as' => 'countrySMMRecruited', 'uses' => 'ReportsController@SMMRecruited'));
    Route::get('/admin/front/productregistered', array('as' => 'countryProductRegistered', 'uses' => 'ReportsController@productRegistered'));
    Route::post('/edit_employee_pcb', array('as' => 'edit_employee_pcb', 'uses' => 'EmployeeController@edit_employee_pcb'));
    Route::get('/admin/general', array('as' => 'routeAdminGeneral', 'uses' => 'EmployeeController@index'));
    Route::resource('/admin/general/employees', 'EmployeeController');

    Route::get('/admin/general/listsalesstaff', array('as' => 'routeSalesStaff', 'uses' => 'SalesStaffController@index'));
    Route::resource('/admin/general/salesstaff', 'SalesStaffController');


    Route::get('/admin/general/listoccupation', array('as' => 'routeOccupation', 'uses' => 'OccupationController@index'));
    Route::resource('/admin/general/occupations', 'OccupationController');

    Route::get('/admin/general/listglobals', array('as' => 'routeGlobal', 'uses' => 'GlobalController@index'));
    Route::resource('/admin/general/globals', 'GlobalController');

    Route::get("/admin/general/mcpreport", array('as' => 'mcReport', 'uses' => 'ReportsController@mcGeneralReport'));
    Route::get("/admin/general/mppreport", array('as' => 'mpReport', 'uses' => 'ReportsController@mpGeneralReport'));
    Route::get("/admin/general/pusherpreport", array('as' => 'pusherReport', 'uses' => 'ReportsController@pusherGeneralReport'));
    //data services
    Route::get('/admin/reports/getsale/{year}', 'ReportsController@getSales');
    //Route::get('/admin/reports/data/{identifier}', 'ReportsController@getReportData');

    //for testing
    Route::get('/admin/reports/test', 'ReportsController@yearlyMonthSale');
    //End OF Reports Routers


    /***********Amjad changes ************/
    /*Route::get('/admin/buyer', array('as' => 'BuyerMgmt', function () {
        return view('admin.BuyerMgmt');
    }));*/

    Route::get('/admin/buyer', array('as' => 'BuyerMgmt', 'uses' => 'AdminBuyerController@getBuyers'));

    // Route::get('admin/buyer','AdminBuyerController@getBuyers');
    // Route::get('admin/buyer/addbuyer', array('as' => 'addbuyer', 'uses' => 'AdminBuyerController@addBuyer'));
    Route::get('admin/buyersmm', array('as' => 'BuyerMgmt', 'uses' => 'AdminBuyerController@getBuyerSmm'));
    Route::get('admin/buyeropenwish', array('as' => 'BuyerMgmt', 'uses' => 'AdminBuyerController@getBuyerOwish'));
    Route::get('admin/buyerdealer', array('as' => 'BuyerMgmt', 'uses' => 'AdminBuyerController@getBuyerDealer'));

    /*TEST ROUTES*/


    /***********SMM changes ************/
    Route::get('admin/payment/smm', array('as' => 'paysmm', 'uses' => 'PaySMMController@smmpayment'));

    /************Shahrukh changes ****************/
    Route::get('admin/payment/financetracking', array('as' => 'finance','uses' => 'FinanceController@finance'));
    Route::get('admin/payment/paymentdetails', array('as' => 'paymentdetails','uses' => 'FinanceController@paymentdetails'));


    Route::post('admin/buyer/addbuyer', array('as' => 'addbuyer', 'uses' => 'AdminBuyerController@storeBuyer'));
    Route::get('admin/buyer/editbuyer/{id}', array('as' => 'editbuyerinfo', 'uses' => 'AdminBuyerController@editbuyer'));
    Route::post('admin/buyer/updatebuyer', array('as' => 'updatebuyer', 'uses' => 'AdminBuyerController@updatebuyer'));
    Route::post('admin/buyer/deletebuyer', array('as' => 'deletebuyerinfo', 'uses' => 'AdminBuyerController@deletebuyer'));

    //Admin Merchant
    Route::get('admin/merchant',array('as' =>'Merchant','uses'=>'AdminMerchantController@index'));
    Route::post('admin/approveMerchant',array('as' =>'approveMerchant','uses'=>'AdminMerchantController@approveMerchant'));
    Route::get('admin/master/load-orderDetails', ['as'=>'load:orderDetails','uses'=>'ShippingController@getOrderDetails']);
    Route::get('admin/master/load-merchantDetails', ['as'=>'load:merchantDetails','uses'=>'ShippingController@getmerchantDetails']);

    Route::get('admin/master/shipping/world', ['as' => 'shipping:world', 'uses' => 'ShippingController@getShippingMasterDetails']);
    Route::get('admin/master/shipping/country-state', ['as' => 'shipping:country', 'uses' => 'ShippingController@getShippingCountryDetails']);
    Route::get('admin/master/shipping/merchant', ['as' => 'shipping:merchant', 'uses' => 'ShippingController@getShippingMerchantDetails']);
    Route::get('admin/master/shipping/merchant-consultant', ['as' => 'shipping:merchant-consultant', 'uses' => 'ShippingController@getShippingMerchantConsultantDetails']);
    Route::get('admin/master/shipping/buyer', ['as' => 'shipping:buyer', 'uses' => 'ShippingController@getShippingBuyerDetails']);
    Route::get('admin/master/shipping/courier', ['as' => 'shipping:courier', 'uses' => 'ShippingController@getShippingCourierDetails']);
    //   Route::get('admin/master/delivery', ['as' => 'delivery', 'uses' => 'DeliveryController@getDeliveryMasterDetails']);
    Route::delete('admin/master/orders/{id?}','AdminDeliveryOrderController@destroy');
    Route::get('/admin/analysis/merchant_consultant', 'MerchantConsultantController@index');
    Route::get('/admin/analysis/merchant_consultant_area', 'MerchantConsultantController@showaarea');

    Route::get('admin/merchant/create','AdminController@merchant_Account_create');
    Route::post('admin/merchant/update','AdminController@update_merchant');
    Route::get('admin/merchant/edit/{mid}','AdminController@edit_merchant');
    Route::post('admin/merchant/delete','AdminController@destroy_merchant');

    /**** Seller Routes ***/

    Route::get('/seller/tproducts/{uid}', ['as' => 'adminsellertproducts', 'uses'=>'SellerHelpController@tproducts']);

    Route::get('/seller/terminal/cash/{uid}', ['as' => 'getTerminalCash', 'uses' => 'SellerHelpController@getTerminalCash']);

    Route::get('/seller/fairmode/{uid}', ['as' => 'adminsellerfair', 'uses'=>'SellerHelpController@fairmode']);
    Route::get('/sellerdashboard/{uid}', ['as' => 'adminsellerdashboard', 'uses'=>'SellerHelpController@dashboard']);
/*    Route::get('/sellermembers/{uid}', ['as' => 'adminsellermembers', 'uses'=>'SellerHelpController@members']);*/


    Route::get('/seller/creditorageing/{uid}', ['as' => 'adminsellercageing', 'uses'=>'SellerHelpController@cageinreport']);
    Route::get('/seller/sdocuments/{uid}', ['as' => 'adminsellerdocuments', 'uses'=>'SellerHelpController@sdocuments']);
    Route::get('/seller/debtor_balance/{id}/{user_id}', ['as' => 'adminsellercageingbalance', 'uses'=>'SellerHelpController@debtor_balance']);
    Route::get('/seller/creditor_balance/{id}/{user_id}', ['as' => 'adminsellerdageingbalance', 'uses'=>'SellerHelpController@creditor_balance']);
    Route::get('/seller/ageings/{uid}',['as' => 'ageingsselladm', 'uses'=>'SellerHelpController@sellageings']);


    Route::get('/merchant/openchannel/{uid}', ['as'=> 'adminmerchant-openchannel', 'uses'=> 'MerchantController@getOpenChannel']);
    Route::get('/merchant/salesreport/{uid}', ['as' => 'adminmerchantsalesreport', 'uses'=>'MerchantDashboardController@salesreport']);

    Route::get('/station/salesreport/{uid}', ['as' => 'adminstationsalesreport', 'uses'=>'StationController@salesreport']);
    Route::get('/seller/buyingorder/{uid}', ['as' => 'adminsellerborder', 'uses'=>'SellerHelpController@border']);
    Route::get('/seller/buyingreceipt/{uid}', ['as' => 'adminsellerbreceipt', 'uses'=>'SellerHelpController@breceipt']);
    Route::get('/seller/likes/{uid}', ['as' => 'adminsellerlikes', 'uses'=>'SellerHelpController@likes']);
    Route::get('/station/purchases/{uid}','StationController@purchases');
    Route::get('/merchant/hyper/{uid}', ['as' => 'adminmerchanthyper', 'uses'=>'SellerHelpController@merchanthyper']);
   /* Route::get('/merchant/inventory/{uid}', ['as' => 'adminmerchantinventory', 'uses'=>'SellerHelpController@merchantinventory']);*/
    Route::get('/merchant/discount/{uid}', ['as' => 'adminmerchantdiscount', 'uses'=>'SellerHelpController@merchantdiscount']);
    Route::get('/station/ochannel-supplier/{uid}', ['as'=> 'adminopen-channel', 'uses'=> 'StationController@getOpenChannel']);
    Route::get('/station/order-view/{uid}', ['as'=> 'adminorder-view-list', 'uses'=>'StationController@getOrderViewList']);
    Route::get('/station/order-view-term/{uid}', ['as'=> 'adminorder-view-list-term', 'uses'=>'StationController@getOrderViewListTerm']);
    Route::get('inventory/update/{uid}',array('as'=>'admininvupdate','uses'=>'InventoryController@redirect'));
    Route::get('inventory/update/add_product/{uid}',array('as'=>'admininventory-add','uses'=>'InventoryController@add_product'));
    Route::get('inventory/update/product_list/{uid}',array('as'=>'admininventory-list','uses'=>'InventoryController@list_product'));

    Route::get('/analytics/dashboard', ['as' => 'analdashboard', function () {
        return view('analytics/dashboard');
    }]);

    // ENDS
});

// Route::get('/voucher','VoucherController@voucherList');
// Route::get('/digital_voucher','VoucherController@digitalVoucher');

// // Special Case of Admin being out
// Route::post('/savePaperVoucher', 'VoucherController@SavePaperVoucher');
// Route::post('/searchVoucher', 'VoucherController@searchVoucher');
// Route::get('/searchVoucher', 'VoucherController@searchVoucher');

// Route::post('/voucherRedeem', 'VoucherController@voucherRedeem');
// Route::get('/voucherRedeem', 'VoucherController@voucherRedeem');
//Route::get('/savePaperVoucher', 'VoucherController@SavePaperVoucher');
Route::post('/admin/master/approveAutolink', 'AutoLinkController@approveAutolink');
Route::post('/admin/master/approveAutolinkb', 'AutoLinkController@approveAutolinkb');
Route::get('/admin/merchant/order_process/{id}', array('as' => 'MasterProcessOrder', 'uses' => 'MerchantDashboardController@merchant_order_process'));
Route::post('/admin/station/order_process/{id}', array('as' => 'StationProcessOrder', 'uses' => 'MerchantDashboardController@merchant_order_process'));
/*Oshop master Routes for merchant By johanVick*/


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('analysis/station_recruiter', function() {
        return View::make('admin.Analysis.stationrecuiter');
    });
    Route::get('analysis/station_recruiter_area',  function (){
        return View::make('admin.Analysis.stationrecuiterarea');
    });
    Route::get('analysis/merchant_professional', function() {
        return View::make('admin.Analysis.Merchant_Professional');
    });
    Route::get('analysis/merchant_professional_area',  function (){
        return View::make('admin.Analysis.Merchant_Professionalarea');
    });
});

// Buyer Routes
Route::group(['middleware'=>'buyer'],function(){

});



// Merchant Routes
Route::group(['middleware'=>'merchant'],function(){



    Route::post("qrbccontent","ProductController@qrbccontent");
    Route::get('smmarmy_exposer/{user_id}','SellerHelpController@smmarmy_exposer');
    Route::get('/seller/getwastformreportbymonthyear','SellerHelpController@getwastformreportbymonthyear');

    /*
	 * Album routes
	 */
    Route::get('/sellermembers/{uid?}', ['as' => 'sellermembers', 'uses'=>'SellerHelpController@members']);


    /* Warehouse Cost Routes : starts */
    Route::get('/sellerWarehouse/{user_id?}', ['as' => 'warehouse', 'uses'=>'WarehouseController@sellerWareHouse']);

    Route::get('/sellerWarehouse/api', ['as' => 'warehouse', 'uses'=>'WarehouseController@sellerWareHouseApi']);

    /* Warehouse Routes : End */

    /*Route::get('/album/{id?}', ['as' => 'albumtabbed', 'uses' => 'AlbumController@index']);*/
    Route::get('/album/detail/{id}', ['as' => 'productdetail', 'uses' => 'ProductController@productdetail']);
    Route::get('/product/export_public',['as' => 'export_public', 'uses' => 'ProductController@export_public']);
    Route::get('/product/import_public',['as' => 'import_public', 'uses' => 'ProductController@import_public']);
    Route::post('/product/import_file_post',['as' => 'import_file_post', 'uses' => 'ProductController@import_file_post']);
    Route::post('/product/import_file_process',['as' => 'import_file_process', 'uses' => 'ProductController@import_file_process']);
    Route::get('/album-tabbed', function(){
        return view('album_tabbed');
    });
    Route::get('/dashboard/', ['as' => 'sellerdashboard', 'uses'=>'SellerHelpController@dashboard']);


    /*Route::get('/album/{param}', ['as' => 'album', 'uses' => 'AlbumController@index']);*/
    Route::get('/edit_merchant/{mid?}', ['as' => 'edit-merchant', 'uses' => 'UserController@getEditMerchant']);
    Route::post('/edit_merchant', ['as' => 'edit-merchant', 'uses' => 'UserController@postEditMerchant']);
    Route::get('/merchant/dashboard', ['as' => 'merchantdashboard', 'uses'=>'MerchantDashboardController@index']);

    Route::get('/merchant/salesreport', ['as' => 'merchantsalesreport', 'uses'=>'MerchantDashboardController@salesreport']);

    Route::get('/merchant/hyper', ['as' => 'merchanthyper', 'uses'=>'SellerHelpController@merchanthyper']);

    Route::post('/product/sku/{id}',['as' => 'postproductsku', 'uses'=>'ProductController@sku']);
    Route::get('/merchant/discount', ['as' => 'merchantdiscount', 'uses'=>'SellerHelpController@merchantdiscount']);
    Route::get('/merchant/min_order/{id}', ['as' => 'merchantminorder', 'uses'=>'SellerHelpController@merchantminorder']);
    Route::post('/merchant/min_order/{id}', ['as' => 'postmerchantminorder', 'uses'=>'SellerHelpController@updatemerchantminorder']);
    Route::post('/merchant/token', ['as' => 'postmerchanttoken', 'uses'=>'SellerHelpController@merchanttoken']);
    Route::post('/merchant/token/subscribe', ['as' => 'postmerchanttokensubscribe', 'uses'=>'SellerHelpController@merchantsubscribe']);
    Route::get('order/product/{id}','MerchantDashboardController@get_porder');
    Route::post('merchant/help', ['uses' => 'MerchantDashboardController@postAddOW']);
    Route::post('merchant/addNewDiscount', ['uses' => 'MerchantDashboardController@addNewDiscount']);
    Route::post('merchant/payment_details/', ['uses' => 'MerchantDashboardController@merchant_payment_details']);
    Route::get('merchant/get_discounts', ['uses' => 'MerchantDashboardController@getAllDiscounts']);
    Route::get('merchant/get_discounts/{id}', ['uses' => 'MerchantDashboardController@getMerchantDiscounts']);
    Route::get('merchant/get_left_discounts/{id}', ['uses' => 'MerchantDashboardController@getLeftDiscounts']);
    Route::get('merchant/get_disc_discounts/{id}', ['uses' => 'MerchantDashboardController@getIssuedDiscounts']);
    Route::get('merchant/get_discount/{id}', ['uses' => 'MerchantDashboardController@getDiscount']);
    Route::get('merchant/get_buyer_discounts/{discount_id}', ['uses' => 'MerchantDashboardController@get_buyer_discounts']);

    /* Inventory Cost Routes : starts */

    /* Inventory Cost Routes : ends */


});

// Station Routes
Route::group(['middleware'=>'station'],function(){
    Route::get('/station/dashboard', ['as' => 'stationdashboard', 'uses' => 'StationController@getDashboard']);
    Route::get('/station/salesreport', ['as' => 'stationsalesreport', 'uses'=>'StationController@salesreport']);
    Route::get('/station/station_payment_details/{user_id}', ['as' => 'stationsalesreportdet', 'uses'=>'StationController@station_details']);
    Route::get('/station/get-staion-data',['as'=>'get-station-data','uses'=>'StationController@getStationData']);
    Route::get('/station/getproductdetail/{id}',['uses'=>'StationController@getProductDetail']);
    Route::post('/productadd',['uses'=>'StationController@productadd']);
    Route::get('/station/order-view', ['as'=> 'order-view-list', 'uses'=>'StationController@getOrderViewList']);
    Route::get('/station/order-view-term', ['as'=> 'order-view-list-term', 'uses'=>'StationController@getOrderViewListTerm']);
    Route::get('/station/order-view-icon', ['as'=> 'order-view-icon', 'uses'=> 'StationController@getOrderViewIcon']);
    Route::get('/station/ochannel-supplier', ['as'=> 'open-channel', 'uses'=> 'StationController@getOpenChannel']);
    Route::get('/station/ochannel-supplier/statement/{id}','StationController@ochannel_merchant_statement');
    Route::get('/station/ochannel-station', ['as'=> 'station-open-channel', 'uses'=> 'StationController@getStationOpenChannel']);
    Route::get('/merchant/openchannel', ['as'=> 'merchant-openchannel', 'uses'=> 'MerchantController@getOpenChannel']);
    Route::get('/station/ochannel-station/statement/{id}','StationController@ochannel_station_statement');
    Route::get('/station/getProductIcon/{id}',['uses'=>'StationController@getProductIcon']);
    Route::get('/edit_station', ['as' => 'edit-station', 'uses' => 'UserController@getEditStation']);
    Route::post('/edit_station', ['as' => 'edit-station', 'uses' => 'UserController@postEditStation']);
    Route::post('/station/get-areas-by-country', ['as'=> 'get-areas-by-country', 'uses'=>'StationController@getAreasByCountry']);
    Route::post('/station/get-map-data', ['as'=> 'get-map-data', 'uses'=>'StationController@getMapData']);
    Route::post('/station/get-map-data-merchant', ['as'=> 'get-map-data-merchant', 'uses'=>'StationController@getMapDataMerchant']);
    Route::post('/station/get-map-data-both', ['as'=> 'get-map-data-both', 'uses'=>'StationController@getMapDataBoth']);
    Route::get('/station/get-stations-data-for-table',['as'=> 'get-stations-data-for-table', 'uses'=>'StationController@getStationsDataForTable']);
    Route::get('/station/get-merchants-data-for-table',['as'=> 'get-merchants-data-for-table', 'uses'=>'StationController@getMerchantsDataForTable']);
    Route::get('/station/get-both-data-for-table',['as'=> 'get-both-data-for-table', 'uses'=>'StationController@getBothDataForTable']);
    Route::get('/station/get-both-data-for-table',['as'=> 'get-both-data-for-table', 'uses'=>'StationController@getBothDataForTable']);
    Route::get('/station/get-order-data', ['as'=> 'get-order-data', 'uses'=>'StationController@getSorderData']);
    Route::post('/station/order-view/update-quantity/{id}', ['as'=> 'get-order-data', 'uses'=>'StationController@updateOrderProductQuantity']);
    Route::get('/station/inventory-report', ['as'=> 'get-inventory-data', 'uses'=>'StationController@getInventoryData']);
    Route::post('/station/orderqty', ['as'=> 'station.OrderQty', 'uses'=>'StationController@postOrderQty']);
    Route::post('station/addtocart', ['as'=> 'station.addToCart', 'uses'=>'StationController@postAddtocart']);
    Route::post('station/help', ['uses' => 'StationController@owAddtocart']);
    Route::get('/dashboard', ['as' => 'sellerdashboard', 'uses'=>'SellerHelpController@dashboard']);
});

// Station Routes
Route::group(['middleware'=>'logged'],function(){
    Route::get('/paginate/buyerorder/{uid}', ['as' => 'buyerpaginate', 'uses'=>'BuyerController@buyer_orders_pagination']);
    Route::get('salesmemo/{orderid}', array('as' => 'Salesmemo', 'uses' =>'DOController@salesmemo'));
    Route::post('salesmemo/status/{status}/{id}', array('as' => 'Salesmemostatus', 'uses' =>'DOController@salesmemostatus'));
    Route::get('receipt/{orderid}', array('as' => 'Receipt', 'uses' =>'DOController@receipt'));
    Route::get('invoice/{orderid}', array('as' => 'Invoice', 'uses' =>'DOController@invoice'));


    /***********Statement Controller Routes*********************/
    Route::get('statement/overall-statement/{id?}',[ 'as' => 'statementoverall','uses'=>'StatementController@sov']);
    Route::get('statement/loverall-statement/{id}',[ 'as' => 'statementloverall','uses'=>'StatementController@lsov']);
    Route::get('statement/overall-statement','StatementController@sov');
    Route::get('statement/delivery-order/{id?}',[ 'as' => 'statementdo','uses'=>'StatementController@dor']);
    Route::get('statement/delivery-order','StatementController@dor');
    Route::get('statement/receipt/{id?}', [ 'as' => 'statementreceipt','uses'=>'StatementController@rec']);
    Route::get('statement/receipt','StatementController@rec');
    Route::post('statement/add_adjustment','StatementController@add_adjustment');
    Route::post('statement/merchantdetail','StatementController@merchantdetail');
    Route::post('statement/detail','StatementController@detail');
    Route::post('statement/buyerdetail','StatementController@buyerdetail');
    Route::post('statement/merchantdetailrc','StatementController@merchantdetailrc');
    Route::post('statement/merchantdetailgst','StatementController@merchantdetailgst');
    Route::post('statement/recdetail','StatementController@recdetail');
    Route::post('statement/dodetail','StatementController@dodetail');
    Route::post('invoicestatement/merchantdetail','StatementController@merchantinvoicedetail');
    Route::post('invoicepurchase/merchantdetail','StatementController@merchantpurchasedetail');
    Route::post('invoicestatement/stationdetail','StatementController@stationdetailinvoicedetail');
    Route::post('invoicepurchase/stationdetail','StatementController@stationpurchasedetail');
    /*Tracking Report Route*/
    Route::get('stockreport/{id}/{uid?}', array('as' => 'Stockreport', 'uses' =>'DOController@stockreport'));
    Route::post('statement/trackingreport','StatementController@trackingreport');
    Route::get('statement/trackingop','StatementController@trackingop');
    Route::post('statement/salesmemo','StatementController@salesmemo');



});

// Logistics Routes
Route::group(['middleware'=>'logistics'],function(){
    Route::get('/logistic_dashboard/{uid?}', ['as' => 'logistic_dashboard', 'uses'=>'LogisticsController@showDashboard']);
    Route::get('/paginate/lsalesorder/{lid}', ['as' => 'logsalesorder', 'uses'=>'LogisticsController@orders_pagination']);
});


include_once("Routes/B2BRoutes.php");
include_once("Routes/RetailRoutes.php");
include_once("Routes/CoreRoutes.php");
include_once("Routes/FooterRoutes.php");

include_once("Routes/PopupRoutes.php");
include_once("Routes/RevenuePieRoutes.php");
include_once("Routes/EmailControllerRoutes.php");

/*-------------------------------------------------------------------------*/
Route::get('/', ['as' => 'home', 'uses' => 'Landing@index']);
Route::get('/show_register', ['as' => 'show_register', 'uses' => 'Landing@show_register']);
//Route::get('/', function(){
//
//    $plucked = \App\Models\StatusState::all()->pluck('description', 'name');
//
//    return json_encode($plucked);
//});

//Route::get('create-w-user', ['as' => 'home', 'uses' => 'Landing@index']);
// Route::get('/buyerregistration',['as' => 'buyerregistration', function () {
//     return view('buyerregistration');
// }]);
// Route::get('/buyerregistration', array('as' => 'buyerregistration', 'uses' => 'BuyerController@showpage'));
// Route::post('/buyerregistration', ['as' => 'buyerregistration', 'uses' => 'BuyerController@storeBuyerDetails']);
// Copied from Gitlab History
//     Route::get('/buyerreg', array('as' => 'buyerreg', 'uses' => 'BuyerController@showPagenewReg'));
// Route::post('/buyerreg', ['as' => 'buyerreg', 'uses' => 'BuyerController@storeBuyernewDetails']);
// Copy Ends
Route::get('/create_new_buyer', array('as' => 'buyerreg', 'uses' => 'BuyerController@showPagenewReg'));
Route::get('/create_new_buyer_mob', array('as' => 'buyerreg', 'uses' => 'BuyerController@showPagenewRegmob'));
Route::post('/create_new_buyer', ['as' => 'buyerreg', 'uses' => 'BuyerController@storeBuyernewDetails']);
Route::post('/create_new_buyer_mob', ['as' => 'mobbuyerreg', 'uses' => 'BuyerController@storeBuyernewDetails']);
Route::get('/validate_email/{email}', ['as' => 'validateemail', 'uses' => 'BuyerController@validate_email']);
Route::get('/validate_url/{url}/{oid}', ['as' => 'validateurl', 'uses' => 'AjaxController@validate_url']);
Route::get('/validate_url2/{url}', ['as' => 'validateurl', 'uses' => 'AjaxController@validate_url2']);

// Route::get('owarehouse/{id}',  ['as' => 'owarehouse',function () {
//     return view('owarehouse');
// }]);

Route::get('owarehouse/{id}', array('as' => 'owarehouse', 'uses' => 'OwarehouseController@owarehouse'));
Route::post('owarehouse/store', array('as' => 'owarehouseStore', 'uses' => 'OwarehouseController@storeOwarehouse'));
// Route::post('hyper/cart','OwarehouseController@hyperCart');

/* J&C TopUp */
Route::post('/test_topup_request1', ["middleware" =>"cors", "as" => "test.request1", "uses" => "TestJcController@request1"]);
Route::post('/test_topup_request2', ["as" => "test.request2", "uses" => "TestJcController@request2"]);
Route::post('/tpresponse', ["middleware" => "cors", "as" => "jctopup.tpresponse", "uses" => "TestJcController@tpresponse"]);

Route::get('/`_topup_request1', 'TestJcController@test');


Route::get('/SMM', ['as' => 'SMM', 'uses' => 'SMMController@smediaMarketer']);


Route::get('/SMM/facebook', ['as' => 'facebook', 'uses' => 'SMMController@facebook']);
Route::post('smm/update/product','SMMController@update_product_smm');
//Route::get('/SMM/facebok',function(){echo "dfg";});
Route::get('/SMM/callback', ['as' => 'callback', 'uses' => 'SMMController@callback']);

Route::get('productconsumer/{id}/{openwish_id?}', array(
    'as' => 'productconsumer',
    'uses' => 'ProductController@productconsumer'));
Route::post('products/product_upadte/{id}', ['as' => 'product_update', 'uses' => 'AlbumController@product_update']);
Route::post('products/add_comment', ['as' => 'add_comment', 'uses' => 'ProductController@add_comment']);
Route::post('products/delete', ['as' => 'product_delete', 'uses' => 'ProductController@product_delete']);
Route::post('/action_form_data', ['as' => 'action_form_data', 'uses'=>'ProductController@action_form_data']);
Route::post('/status_form_data', ['as' => 'status_form_data', 'uses'=>'ProductController@status_form_data']);
// b2b product :: wahid
Route::get('productb2b/{id}/{openwish_id?}', array(
    'as' => 'productb2b',
    'uses' => 'ProductController@productconsumer'));
Route::get('productconsumerdisc/{product_id}/{discount_id}','ProductController@productconsumerdiscount');
/**
 * Start Profile setting section Routes and it's views.
 *
 */
Route::get('/defaboutus/{id}', ['as' => 'profilesettingaboutus','uses' => 'ProfileSettingController@profilesettingaboutus']);

Route::get('/defcertificate/{id}', ['as' => 'profilesettingcertificate','uses' => 'ProfileSettingController@profilesettingcertificate']);

Route::get('/def', ['as' => 'profilesetting', 'uses' => 'ProfileSettingController@index']);
Route::post('UpdateDefs', ['as' => 'updateTheme', 'uses' => 'ProfileSettingController@updateSettings']);

/**
 * Profile Setting Post Ajax
 */
Route::post('/def/save-products', ['as' => 'profilesetting.selectedProducts', 'uses' => 'ProfileSettingController@saveSelectedProducts']);
Route::post('/SMM/save-products', ['as' => 'SMM.selectedProducts', 'uses' => 'SMMController@saveSMM']);

/*--add profile products --*/
Route::post('saved_profile_product', ['as' => 'saved_product', 'uses' => 'ProfileSettingController@SavedProduct']);
Route::post('delete_profile_product', ['as' => 'saved_product', 'uses' => 'ProfileSettingController@deleteProduct']);
/**--End Profile setting routes--*/

Route::post('/payment', ['as' => 'payment', 'uses' => 'CartController@getPayment']);
Route::get('/payment/get_stations', ['as' => 'paymentstations', 'uses' => 'MakePaymentController@get_stations']);
Route::post('/postOrder', ['as' => 'postOrder', 'uses' => 'MakePaymentController@postOrder']);
/**
 * Admin Commmission Routes :: wahid
 */

Route::GET('station/logistics_station', 'StationController@logistics_station');

/*
 * Album routes
 */
/*Route::get('/album/{id?}', ['as' => 'albumtabbed', 'uses' => 'AlbumController@index']);*/
Route::get('/album/detail/{id}', ['as' => 'productdetail', 'uses' => 'ProductController@productdetail']);
Route::get('/album-tabbed', function(){
    return view('album_tabbed');
});
/*Route::get('/album/{param}', ['as' => 'album', 'uses' => 'AlbumController@index']);*/
Route::get('/getmerchantproducts', ['as' => 'getmerchantproducts', 'uses' => 'ProductController@getmerchantproducts']);
Route::get('/getmerchantnotproducts', ['as' => 'getmerchantnotproducts', 'uses' => 'ProductController@getmerchantnotproducts']);
Route::get('/getmerchanttproducts', ['as' => 'getmerchanttproducts', 'uses' => 'ProductController@getmerchanttproducts']);
Route::post('/product/cashback', ['as' => 'prouctcashback', 'uses' => 'ProductController@prouctcashback']);
Route::post('/product/pcashback', ['as' => 'prouctpcashback', 'uses' => 'ProductController@prouctpcashback']);
Route::post('/product_oshop', ['as' => 'productoshop', 'uses' => 'ProductController@product_oshop']);
Route::get('/getmerchantproducts', ['as' => 'getmerchantproducts', 'uses' => 'ProductController@getmerchantproducts']);
Route::post('/product_retailprice', ['as' => 'productretailprice', 'uses' => 'ProductController@product_retailprice']);
Route::post('/product_discountedprice', ['as' => 'productdiscountedprice', 'uses' => 'ProductController@product_discountedprice']);
Route::post('/product_warehouse_qty', ['as' => 'product_warehouse_qty', 'uses' => 'ProductController@product_warehouse_qty']);
Route::post('/tproduct_warehouse_qty', ['as' => 'tproduct_warehouse_qty', 'uses' => 'ProductController@tproduct_warehouse_qty']);
Route::post('/product_qty', ['as' => 'product_qty', 'uses' => 'ProductController@product_qty']);
Route::post('/tproduct_qty', ['as' => 'tproduct_qty', 'uses' => 'ProductController@tproduct_qty']);
Route::post('/tproduct_name', ['as' => 'tproduct_name', 'uses' => 'ProductController@tproduct_name']);

Route::get('/wholesale/{id}', array('as' => 'wholesale', 'uses' => 'AlbumController@getWholesaleInfo'));
Route::get('/hyperterms/{id}', array('as' => 'hyperterms', 'uses' => 'OwarehouseController@hyperterms'));
Route::get('/hyperbyid/{id}', array('as' => 'hyperbyid', 'uses' => 'OwarehouseController@hyperbyid'));
Route::get('/hyper/{id}', array('as' => 'hyper', 'uses' => 'AlbumController@getHyperInfo'));
Route::get('/specialprice/{id}/{userid}', array('as' => 'specialPrice', 'uses' => 'AlbumController@getProductDealerInfo'));
Route::get('/specification/{id}', array('as' => 'specification', 'uses' => 'AlbumController@getSpecificationInfo'));
Route::get('/deliveryprice/{id}', array('as' => 'deliveryprice', 'uses' => 'AlbumController@getDeliveryPrice'));
Route::get('/deliverycoverage/{id}', array('as' => 'deliverycoverage', 'uses' => 'AlbumController@getDeliveryCoverage'));
/*POST*/
Route::post('/editfunit', array('as' => 'editFUnit', 'uses' => 'AlbumController@updateFUnit'));
Route::post('/editunit', array('as' => 'editUnit', 'uses' => 'AlbumController@updateUnit'));
Route::post('/editprice', array('as' => 'editPrice', 'uses' => 'AlbumController@updatePrice'));
Route::post('/editsvalue', array('as' => 'editSValue', 'uses' => 'AlbumController@updateSvalue'));
Route::post('/editdeliveryprice', array('as' => 'editdeliveryprice', 'uses' => 'AlbumController@updateDeliveryprice'));
Route::post('/editdeliverycoverage', array('as' => 'editdeliverycoverage', 'uses' => 'AlbumController@updateDeliverycoverage'));
Route::post('/addrowprice', array('as' => 'addrowprice', 'uses' => 'AlbumController@addRow'));
Route::post('/addhyperprice', array('as' => 'addhyperprice', 'uses' => 'AlbumController@addhyperprice'));
Route::post('/removehyperprice', array('as' => 'removehyperprice', 'uses' => 'AlbumController@removehyperprice'));
Route::post('/updatehyperprice', array('as' => 'updatehyperprice', 'uses' => 'AlbumController@updatehyperprice'));
Route::post('/deletespecialprice', array('as' => 'deletespecialprice', 'uses' => 'AlbumController@deleteProductDealer'));
Route::post('/deletewholesaleprice', array('as' => 'deletewholesaleprice', 'uses' => 'AlbumController@deleteWholesale'));

/*update */
Route::post('/update_current_signboard/{id}/{userid}/{enabled}', 'AlbumController@update_current_signboard');
Route::post('/update_current_signboard_oshop/{id}/{oshop_id}/{userid}', 'AlbumController@update_current_signboard_oshop');
Route::post('/update-signboard', 'AlbumController@signboard');
Route::post('/update-bunting', 'AlbumController@bunting');
Route::post('/update-vbanner', 'AlbumController@vbannerLink');
Route::post('/vbanner_image', 'AlbumController@vbannerImage');
/* delete */
Route::post('/delete-bunting', 'AlbumController@deletebunting');
Route::post('/delete-signboard', 'AlbumController@deletesignboard');
Route::post('/delete-banner', 'AlbumController@deletebanner');
/*
 * End Album routes
 */


Route::get('/mdb.static', ['as' => 'mdb.static', function () {
    return view('merchantdashboard');
}]);

/*
Route::get('/merchant/dashboard', ['as' => 'merchantdashboard',
    'uses' => 'MerchantController@getDashboard']);
*/
Route::get('/logistic_dashboard/{uid?}', ['as' => 'logistic_dashboard', 'uses'=>'LogisticsController@showDashboard']);

/*Route::get('/seller/documents',['as' => 'documentssell', 'uses'=>'SellerHelpController@selldocuments']);*/
Route::get('/seller/ageings',['as' => 'ageingssell', 'uses'=>'SellerHelpController@sellageings']);

Route::get('/seller/member/campaign/{uid?}', ['as' => 'sellermemberscampaign', 'uses'=>'SellerHelpController@campaign']);
Route::post('/seller/campaign/delete',['as' => 'deletcampaigno', 'uses'=>'SellerHelpController@deletecampaign']);
Route::get('seller/member/campaigncustomers/{id}/{uid?}' ,array('as' => 'sellermembercampaign', 'uses' => 'SellerHelpController@campaigncustomers'));
Route::get('seller/member/lasttemplate/{uid}' ,array('as' => 'sellerlastemplate', 'uses' => 'SellerHelpController@lasttemplate'));

Route::post('/seller/member/save_campaign',['as' => 'save_campaign', 'uses'=>'SellerHelpController@save_campaign']);
Route::get('/seller/member/segments/{uid}',['as' => 'companysegments', 'uses'=>'SellerHelpController@segments']);
Route::get('/seller/debtorageing/{uid?}/{station_id?}', ['as' => 'sellercageing', 'uses'=>'SellerHelpController@dageinreport']);
Route::get('/seller/creditorageing/{uid?}', ['as' => 'sellerdageing', 'uses'=>'SellerHelpController@cageinreport']);
Route::get('/seller/sdocuments/{uid?}', ['as' => 'sdocuments', 'uses'=>'SellerHelpController@sdocuments']);
Route::get('/seller/debtor_balance/{id}/{user_id}/{sellid?}', ['as' => 'sellercageingbalance', 'uses'=>'SellerHelpController@debtor_balance']);
Route::post('/seller/balance/payment', ['as' => 'postbalancepayment', 'uses'=>'SellerHelpController@balance_payment']);
Route::post('/seller/balance/deletepayment', ['as' => 'postbalancedeletepayment', 'uses'=>'SellerHelpController@balance_delpayment']);
Route::post('/seller/member/send_campaign',['as' => 'send_campaign', 'uses'=>'SellerHelpController@send_campaign']);
Route::post('/seller/member/admin/send_campaign',['as' => 'send_campaign', 'uses'=>'SellerHelpController@send_campaign_admin']);
Route::post('/deletetp', ['as' => 'deletetp', 'uses'=>'ProductController@deletetp']);
Route::post('/addtp', ['as' => 'addtp', 'uses'=>'ProductController@addtp']);
Route::post('/location_company', ['as' => 'location_company', 'uses'=>'SellerHelpController@location_company']);
Route::post('/location_branch', ['as' => 'location_branch', 'uses'=>'SellerHelpController@location_branch']);
Route::post('/acctno_no', ['as' => 'acctno_no', 'uses'=>'SellerHelpController@acctno_no']);
Route::post('/location_loc', ['as' => 'location_company', 'uses'=>'SellerHelpController@location_loc']);
Route::post('/addlocation', ['as' => 'addlocation', 'uses'=>'SellerHelpController@addlocation']);
Route::post('/addwarehouse', ['as' => 'addwarehouse', 'uses'=>'SellerHelpController@addwarehouse']);
Route::post('/addacctno', ['as' => 'addacctno', 'uses'=>'SellerHelpController@addacctno']);
Route::post('/deletelocation', ['as' => 'deletelocation', 'uses'=>'SellerHelpController@deletelocation']);
Route::post('/deleteacc', ['as' => 'deleteacc', 'uses'=>'SellerHelpController@deleteacc']);
Route::post('/savelocationaddress', ['as' => 'savelocationaddress', 'uses'=>'SellerHelpController@savelocationaddress']);
Route::get('/getlocations', ['as' => 'getlocations', 'uses' => 'SellerHelpController@getlocation']);
Route::get('/getacctno', ['as' => 'getacctno', 'uses' => 'SellerHelpController@getacctno']);
Route::get('/locationaddress', ['as' => 'locationaddress', 'uses' => 'SellerHelpController@locationaddress']);
Route::get('/seller/creditor_balance/{id}/{user_id}', ['as' => 'sellerdageingbalance', 'uses'=>'SellerHelpController@creditor_balance']);
Route::get('/seller/ageing/{oid}/{uid}/{sellid?}', ['as' => 'selageing', 'uses'=>'SellerHelpController@ageingstatus']);
Route::get('/seller/balance/{oid}/{uid}/{sellid?}', ['as' => 'selageingbalance', 'uses'=>'SellerHelpController@ageingbalance']);
Route::get('/seller/tproducts/{mid?}', ['as' => 'sellertproducts', 'uses'=>'SellerHelpController@tproducts']);
Route::get('/seller/consignment/{merchant_id?}', ['as' => 'sellerconsignment', 'uses'=>'SellerHelpController@consignment']);
Route::get('/seller/consignmentvalue/{uid?}', ['as' => 'sellertconsignment', 'uses'=>'SellerHelpController@consignmentgetvalue']);

Route::get('/seller/fairmode/{mid?}', ['as' => 'sellerfair', 'uses'=>'SellerHelpController@fairmode']);

Route::get('/seller/fairmode/accno/{lid}', ['as' => 'locationacc', 'uses'=>'SellerHelpController@locationacc']);
Route::get('/merchant/dashboard', ['as' => 'merchantdashboard', 'uses'=>'MerchantDashboardController@index']);
Route::get('/merchant/salesreport', ['as' => 'merchantsalesreport', 'uses'=>'MerchantDashboardController@salesreport']);
Route::get('/seller/buyingorder', ['as' => 'sellerborder', 'uses'=>'SellerHelpController@border']);
Route::get('/seller/buyingreceipt', ['as' => 'sellerbreceipt', 'uses'=>'SellerHelpController@breceipt']);
Route::get('/seller/likes', ['as' => 'sellerlikes', 'uses'=>'SellerHelpController@likes']);
Route::get('/seller/ageings',['as' => 'selelrageings', 'uses'=>'SellerHelpController@sellageings']);
Route::get('/merchant/hyper', ['as' => 'merchanthyper', 'uses'=>'SellerHelpController@merchanthyper']);

Route::get('/merchant/discount', ['as' => 'merchantdiscount', 'uses'=>'SellerHelpController@merchantdiscount']);
Route::get('/merchant/min_order/{id}', ['as' => 'merchantminorder', 'uses'=>'SellerHelpController@merchantminorder']);
Route::post('/merchant/min_order/{id}', ['as' => 'postmerchantminorder', 'uses'=>'SellerHelpController@updatemerchantminorder']);
Route::post('/merchant/token', ['as' => 'postmerchanttoken', 'uses'=>'SellerHelpController@merchanttoken']);
Route::post('/merchant/token/subscribe', ['as' => 'postmerchanttokensubscribe', 'uses'=>'SellerHelpController@merchantsubscribe']);
Route::get('order/product/{id}','MerchantDashboardController@get_porder');
Route::post('merchant/help', ['uses' => 'MerchantDashboardController@postAddOW']);
Route::post('merchant/addNewDiscount', ['uses' => 'MerchantDashboardController@addNewDiscount']);
Route::post('merchant/payment_details/', ['uses' => 'MerchantDashboardController@merchant_payment_details']);
Route::get('merchant/get_discounts', ['uses' => 'MerchantDashboardController@getAllDiscounts']);
Route::get('merchant/get_discounts/{id}', ['uses' => 'MerchantDashboardController@getMerchantDiscounts']);
Route::get('merchant/get_left_discounts/{id}', ['uses' => 'MerchantDashboardController@getLeftDiscounts']);
Route::get('merchant/get_disc_discounts/{id}', ['uses' => 'MerchantDashboardController@getIssuedDiscounts']);
Route::get('merchant/get_discount/{id}', ['uses' => 'MerchantDashboardController@getDiscount']);
Route::get('merchant/get_buyer_discounts/{discount_id}', ['uses' => 'MerchantDashboardController@get_buyer_discounts']);

/*
Route::controller('merchant', 'MerchantController', [
    'getDashboard' => 'merchant.dashboard',
]);
*/

Route::get('/create_new_product/{id}/{subcat}', ['as' => 'create_new_product', 'uses' => 'ProductController@index']);
Route::post('/create_new_product', ['as' => 'create_new_product', 'uses' => 'ProductController@store']);
Route::post('albumpost', ['as' => 'albumpost', 'uses' => 'ProductController@storep']);
Route::post('/albumpostedit', ['as' => 'albumpostedit', 'uses' => 'ProductController@storepedit']);

Route::post('/store_retail/{uid?}', ['as' => 'store_retail', 'uses' => 'ProductController@store_retail']);
Route::post('/store_retailedit/{uid?}', ['as' => 'store_retailedit', 'uses' => 'ProductController@store_retailedit']);

Route::post('/store_b2b', ['as' => 'store_b2b', 'uses' => 'ProductController@store_b2b']);

Route::post('/store_hyper', ['as' => 'store_hyper', 'uses' => 'ProductController@store_hyper']);
Route::post('/store_tb2b', ['as' => 'store_tb2b', 'uses' => 'ProductController@store_tb2b']);
Route::post('/store_sp', ['as' => 'store_sp', 'uses' => 'ProductController@store_sp']);
Route::post('/store_stp', ['as' => 'store_stp', 'uses' => 'ProductController@store_stp']);
Route::post('/albumpost_b2b', ['as' => 'albumpost_b2b', 'uses' => 'ProductController@storeb2b']);
Route::get('/scan_oshop_template', ['as' => 'scan_oshop_template', 'uses' => 'AlbumController@scanOshopTemplate']);


/*User Routes*/
/*
*created by khakan
*/
//ajax controllers
Route::get('/getstationsbytype/{type}', 'AjaxController@getstationsbytype');
Route::post('/subcategory', 'AjaxController@subcat');
Route::post('/subcategory/{mid}', 'AjaxController@subcat_bymerchant');
Route::post('/brandproducts', 'AjaxController@broducts');
Route::post('/brandproducts/{mid}', 'AjaxController@broducts_bymerchant');
Route::post('/sbrandproducts/{mid}', 'AjaxController@broducts_bystation');
Route::post('/subcategorys/{sid}', 'AjaxController@subcat_bystation');
Route::post('/subcatproducts', 'AjaxController@subcatproducts');
Route::post('/subcategoryp', 'AjaxController@subcatp');
Route::post('/subcategoryp2', 'AjaxController@subcatp2');
Route::post('/subcategoryp3', 'AjaxController@subcatp3');
Route::post('/checktemplate', 'AjaxController@checktemplate');
Route::get('/newdealer', 'AjaxController@allUser');
Route::post('/state', [ 'as' => 'state', 'uses' => 'AjaxController@getState']);
Route::post('/city', 'AjaxController@getCity');
Route::post('/countries', 'AjaxController@getCountries');
Route::post('/merchantproducts', 'AjaxController@getMerchantProducts');
Route::post('/area', 'AjaxController@getArea');
Route::post('/CategoryAndBrand', 'AjaxController@CategoryAndBrand');
Route::post('/update-pro', 'AjaxController@updatePro');
Route::post('/delete-pro', 'AjaxController@deletePro');
//new route for album
Route::post('/showsubDetails', 'AjaxController@showsubDetails');

/*
 * login area
 */
Route::post('/LoginUser', 'AjaxController@Login');
Route::post('/RegisterUser', 'AjaxController@Register');
/*
 * end login area
 */

Route::post('buyer/openwishProduct', ['uses' => 'BuyerController@openwishProduct']);

//Mobile Optimization Routes
Route::get('/buyer/dashboard', ['as' => 'buyerinformation', 'uses' => 'BuyerController@buyerInformation']);
Route::post("/buyer/companylocation","BuyerController@companylocation");
Route::get('/buyer/mobdiscount/{id}', ['as' => 'buyermobdiscount', 'uses' => 'BuyerController@mobdiscount']);
Route::get('/buyer/mobhyper/{id}', ['as' => 'buyermobhyper', 'uses' => 'BuyerController@mobhyper']);
Route::get('/buyer/mobautolink/{id}', ['as' => 'buyermobautolink', 'uses' => 'BuyerController@mobautolink']);
Route::get('/buyer/mobdocuments/{id}', ['as' => 'buyermobdocuments', 'uses' => 'BuyerController@mobdocuments']);
Route::get('/buyer/moblikes/{id}', ['as' => 'buyermoblikes', 'uses' => 'BuyerController@moblikes']);
Route::get('/buyer/mobstaff/{id}', ['as' => 'buyermobstaff', 'uses' => 'BuyerController@mobstaff']);
Route::get('/buyer/mobinformation/{id}', ['as' => 'buyermobinformation', 'uses' => 'BuyerController@mobinformation']);


Route::get('/seller', ['as' => 'sellerinfo', 'uses' => 'MerchantController@sellerinfo']);
Route::get('buyer/edit', 'BuyerController@editbuyerinfo');
Route::get('buyer/mobedit', 'BuyerController@editmobbuyerinfo');
Route::post('buyer/edit', 'BuyerController@save_edit');
Route::post('buyer/mobedit', 'BuyerController@save_mobedit');
Route::get('/create_new_merchant', ['as' => 'create-merchant', 'uses' => 'UserController@createMerchant']);
Route::get('/create_new_humancap', ['as' => 'create_new_humancap', 'uses' => 'UserController@createHumancap']);
Route::get('/create_new_fairmode', ['as' => 'create_new_fairmode', 'uses' => 'UserController@createFairMode']);
Route::get('/edit_merchant/{mid?}', ['as' => 'edit-merchant', 'uses' => 'UserController@getEditMerchant']);
Route::post('/edit_merchant', ['as' => 'edit-merchant', 'uses' => 'UserController@postEditMerchant']);
Route::get('create_new_user', ['as' => 'create-new-user', 'uses' => 'UserController@create']);
Route::post('/create_new_user', ['as' => 'create-new-user-p', 'uses' => 'UserController@store']);
Route::post('/create_new_user_wizard', ['as' => 'create-new-user-wizard', 'uses' => 'UserController@storewizard']);
Route::post('/create_new_user_log', ['as' => 'create-new-user-plog', 'uses' => 'UserController@storelog']);
Route::post('/disagree_new_user_log', ['as' => 'dis-new-user-plog', 'uses' => 'UserController@storedislog']);
Route::post('/create_new_humancap', ['as' => 'create-new-user-hc', 'uses' => 'UserController@store']);

/*route information for station*/
Route::get('/create_new_station/{type?}', ['as' => 'create-station', 'uses' => 'UserController@createStation']);
Route::post('/create_new_station', ['as' => 'create-new-user-s', 'uses' => 'UserController@store']);
Route::get('/station/dashboard', ['as' => 'stationdashboard', 'uses' => 'StationController@getDashboard']);
Route::get('/station/salesreport', ['as' => 'stationsalesreport', 'uses'=>'StationController@salesreport']);
Route::get('/station/station_payment_details/{user_id}', ['as' => 'stationsalesreportdet', 'uses'=>'StationController@station_details']);

Route::get('/station/get-staion-data',['as'=>'get-station-data','uses'=>'StationController@getStationData']);
Route::get('/station/getproductdetail/{id}',['uses'=>'StationController@getProductDetail']);
Route::post('/productadd',['uses'=>'StationController@productadd']);
Route::get('/station/order-view', ['as'=> 'order-view-list', 'uses'=>'StationController@getOrderViewList']);
Route::get('/station/order-view-term', ['as'=> 'order-view-list-term', 'uses'=>'StationController@getOrderViewListTerm']);
Route::get('/station/order-view-icon', ['as'=> 'order-view-icon', 'uses'=> 'StationController@getOrderViewIcon']);
Route::get('/station/ochannel-supplier', ['as'=> 'open-channel', 'uses'=> 'StationController@getOpenChannel']);
Route::get('/station/ochannel-supplier/statement/{id}','StationController@ochannel_merchant_statement');
Route::get('/station/ochannel-station', ['as'=> 'station-open-channel', 'uses'=> 'StationController@getStationOpenChannel']);
Route::get('/merchant/openchannel', ['as'=> 'merchant-openchannel', 'uses'=> 'MerchantController@getOpenChannel']);
Route::get('/station/ochannel-station/statement/{id}','StationController@ochannel_station_statement');
Route::get('/station/getProductIcon/{id}',['uses'=>'StationController@getProductIcon']);


Route::get('/edit_station', ['as' => 'edit-station', 'uses' => 'UserController@getEditStation']);
Route::post('/edit_station', ['as' => 'edit-station', 'uses' => 'UserController@postEditStation']);

Route::post('/station/get-areas-by-country', ['as'=> 'get-areas-by-country', 'uses'=>'StationController@getAreasByCountry']);
Route::post('/station/get-map-data', ['as'=> 'get-map-data', 'uses'=>'StationController@getMapData']);
Route::post('/station/get-map-data-merchant', ['as'=> 'get-map-data-merchant', 'uses'=>'StationController@getMapDataMerchant']);
Route::post('/station/get-map-data-both', ['as'=> 'get-map-data-both', 'uses'=>'StationController@getMapDataBoth']);
Route::get('/station/get-stations-data-for-table',['as'=> 'get-stations-data-for-table', 'uses'=>'StationController@getStationsDataForTable']);
Route::get('/station/get-merchants-data-for-table',['as'=> 'get-merchants-data-for-table', 'uses'=>'StationController@getMerchantsDataForTable']);
Route::get('/station/get-both-data-for-table',['as'=> 'get-both-data-for-table', 'uses'=>'StationController@getBothDataForTable']);
Route::get('/station/get-both-data-for-table',['as'=> 'get-both-data-for-table', 'uses'=>'StationController@getBothDataForTable']);
Route::get('/station/get-order-data', ['as'=> 'get-order-data', 'uses'=>'StationController@getSorderData']);
Route::post('/station/order-view/update-quantity/{id}', ['as'=> 'get-order-data', 'uses'=>'StationController@updateOrderProductQuantity']);

/*************created By Amjad*******************/
Route::get('/station/inventory-report', ['as'=> 'get-inventory-data', 'uses'=>'StationController@getInventoryData']);
Route::post('/station/orderqty', ['as'=> 'station.OrderQty', 'uses'=>'StationController@postOrderQty']);
Route::post('station/addtocart', ['as'=> 'station.addToCart', 'uses'=>'StationController@postAddtocart']);
Route::post('station/help', ['uses' => 'StationController@owAddtocart']);



/*start voucher routes  */

/*
Route::get('/create_new_voucher', ['as' => 'create_newThanks Bro! :)_voucher', function () {
    return view('create_new_voucher');
}]);
*/

//post routes
// Route::post('/voucher/voucher-timeslots/{id}', array('as' => 'voucher-timeslots', 'uses' => 'VoucherController@getVoucherTimeSlots'));
// Route::post('/voucher/update/{id}', array('as' => 'voucher-update', 'uses' => 'VoucherController@update'));
// Route::get('/voucher/buyer_voucher', 'VoucherController@getBuyerVoucher');

// Route::get('/get_voucher/{id}', 'VoucherController@get_vouchers');

/* end voucher routes */


/* Start of OShop routes */

//Route::get('oshoplist', 'MerchantController@index');
Route::get('oshoplist', ['as' => 'oshoplist', 'uses' => 'OshopController@index']);
Route::post('customTheme', ['as' => 'customTheme', 'uses' => 'MerchantController@userCustomThems']);


Route::get('addCustomTheme', ['as' => 'addCustomTheme', 'uses' => 'ProfileSettingController@addCustomTheme']);

Route::get('dealer/{id}', array(
    'as' => 'dealer',
    'uses' => 'DealerController@index'));

/* This is the route where Merchants use */
Route::get('/o/{url}', array(
    'as' => 'oshop.one',
    //'uses' => 'MerchantController@oshopone'
    'uses' => 'OshopController@oShopOne'
));

Route::post('oshop/all_query', ['as' => 'all_query', 'uses' => 'OshopController@all_query']);
Route::post('oshop/category_query', ['as' => 'category_query', 'uses' => 'OshopController@category_query']);
Route::post('oshop/sub_category_query', ['as' => 'sub_category_query', 'uses' => 'OshopController@sub_category_query']);
Route::post('/oshop/color_query', ['as' => 'color_query', 'uses' => 'OshopController@color_query']);
Route::post('/oshop/brand_query', ['as' => 'brand_query', 'uses' => 'OshopController@brand_query']);
Route::post('/oshop/subcatlevel2_query', ['as' => 'subcatlevel2_query', 'uses' => 'OshopController@subcatlevel2_query']);
Route::post('/oshop/subcatlevel3_query', ['as' => 'subcatlevel3_query', 'uses' => 'OshopController@subcatlevel3_query']);
Route::post('/floor/filter', ['as' => 'floor_filter', 'uses' => 'FloorController@filter']);

// Zurez-Autolink
Route::get('oshopreq/{id}/autolink', 'AutoLinkController@validate_request');
Route::post('autolink/accept', 'AutoLinkController@accept');
Route::post('autolink/delete', 'AutoLinkController@delete');
Route::get('autolink/{id}/unlink', 'AutoLinkController@unlink');

Route::get('merchant/{user_id}/autolink','AutoLinkController@merchant');
Route::post('/request_autolink', 'AutoLinkController@request_autolink');
Route::post('/cancel_autolink', 'AutoLinkController@cancel_autolinko');


Route::post('/autolink/cancel','AutoLinkController@cancel_autolink');



// Ends
Route::get('oshopaboutus/{id}', array(
    'as' => 'oshopaboutus',
    //'uses' => 'MerchantController@aboutus'
    'uses' => 'OshopController@aboutUs'
));

/*
Route::get('oshopcertificate', 'CertificateController@index');
*/

Route::get('oshopcertificate/{id}', array(
    'as' => 'oshopcertificate',
    //'uses' => 'MerchantController@aboutus'
    'uses' => 'CertificateController@index'
));

/*
Route::get('/oshopsmsone', ['as' => 'oshopsmsone', function () {
    return view('OShopMsOne');
}]);
*/
Route::get('oshopoem/{id}', ['as' => 'oshopoem', function () {
    return view('oshopoem');
}]);
Route::get('test', ['as' => 'test', function () {
    return view('test');
}]);

/*
Route::get('/oshoplist', ['as' => 'oshoplist', function () {
    return view('shops');
}]);

Route::get('/oshopcertificate', ['as' => 'oshopcertificate', function () {
    return view('OShopCertificate');
}]);

Route::get('/oshopaboutus',['as' => 'oshopaboutus',  function () {
    return view('OShopAboutUs');
}]);
 */

/* End of OShop routes */


// Footer: Section A Displaying Content
Route::get('/howtobuy', ['as' => 'howtobuy', 'uses' => 'FooterViewController@howToBuy']);
Route::get('/howtosell', ['as' => 'howtosell', 'uses' => 'FooterViewController@howToSell']);

// End of Footer: Section A Displaying Content








Route::get('/buildings', ['as' => 'buildings', function () {
    return view('buildings');
}]);


// here i started


// done this --chonchol
Route::get('userflow', ['as' => 'userflow',
    'uses' => 'UserflowController@index']);
Route::POST('user_flow', 'UserflowController@get_counts');

Route::get('/refresh', ['as' => 'refresh',
    'uses' => 'RefreshController@index']);




Route::get('floor', ['as' => 'floor', 'uses' => 'FloorController@index']);
Route::get('floor/{id}', ['as' => 'floor/{id}', 'uses' => 'FloorController@show']);
Route::get('hyperdeals', ['as' => 'hyperdeals', 'uses' => 'HyperdealsController@index']);

Route::get('category', ['as' => 'category', 'uses' => 'CategoryController@index']);
Route::get('brand', ['as' => 'brand', 'uses' => 'BrandController@index']);


Route::get('sub-cat-details/{id}/{sid}', ['as' => 'sub-cat-details/{id}/{sid}', 'uses' => 'CategoryController@show']);
Route::get('/category_sort', ['as' => 'category_sort', 'uses' => 'CategoryController@category_sort']);

Route::get('brand-details/{id}', ['as' => 'brand-details/{id}', 'uses' => 'BrandController@showBrandDetails']);
// Route::get('brand-details/{id}',function(){
//     return
// })

Route::get('/brand_sort', ['as' => 'brand_sort', 'uses' => 'BrandController@brand_sort']);


/*End Route for inventory analysis */

Route::post('sales/getWorldWideSalesData/{filter}', ['as' => 'worldsalesdatatotal', 'uses' => 'SalesAnalysisController@getWorldDataTotal']);
Route::post('sales/getWorldWideSalesData', ['as' => 'worldsalesdata', 'uses' => 'SalesAnalysisController@getWorldData']);
Route::post('sales/getcountrySalesData', ['as' => 'countrysalesdata', 'uses' => 'SalesAnalysisController@getCountryData']);
Route::post('sales/getstateSalesData', ['as' => 'statesalesdata', 'uses' => 'SalesAnalysisController@getStateData']);
Route::post('sales/getmerchantSalesData/{filter}', ['as' => 'merchantsalesdatatotal', 'uses' => 'SalesAnalysisController@getMerchantDataTotal']);
Route::post('sales/getmerchantSalesData', ['as' => 'merchantsalesdata', 'uses' => 'SalesAnalysisController@getMerchantData']);
Route::post('sales/getmerchantConsultantSalesData', ['as' => 'merchantconsultantsalesdata', 'uses' => 'SalesAnalysisController@getMerchantConsultantData']);
Route::post('sales/getstationSalesData', ['as' => 'stationsalesdata', 'uses' => 'SalesAnalysisController@getStationData']);
Route::post('sales/getstationSalesData/{filter}', ['as' => 'stationsalesdatatotal', 'uses' => 'SalesAnalysisController@getStationDataTotal']);
/*End Route for graph sales data */

Route::get('/state/list/{id}', ['uses' => 'CountryController@stateList']);
Route::get('/city/list/{id}', ['uses' => 'CountryController@cityList']);
Route::get('/area/list/{id}', ['uses' => 'CountryController@areaList']);
/*List of sales */


/*search functionality*/
Route::get('search', ['as' => 'searchPage', 'uses' => 'TNTSearchController@searchPage']);
Route::post('search', ['as' => 'search', 'uses' => 'TNTSearchController@search']);
Route::post('autolink/search',['as'=>'asearch','uses'=>'SearchController@autolink']);
/*Resource routes*/
Route::resource("downloads", "DownloadAppsController");
Route::resource("newsletter", "NewsletterController");
Route::resource("advertise", "AdvertisementController");
Route::resource("directory", "DirectoryController");
Route::resource("buyerhelp", "HelpBuyerController");
Route::resource("sellerhelp", "HelpSellerController");
Route::resource("feedback", "FeedbackController");
Route::resource("contactus", "ContactUsController");
Route::resource("job", "JobController");
Route::resource("privacy", "PrivacyController");
Route::resource("terms_cond", "TermsAndCondition");

/**
 * OpenWish Routes
 */
Route::get('add_to_wish_list_new', 'UserController@add_to_wish_list');
Route::get('product_like', 'UserController@product_like');

Route::post('delete_like', 'UserController@delete_like');
Route::post('add_wishlist', 'UserController@add_wishlist');
Route::post('mywishlist', 'UserController@mywishlist');
Route::get('auth/facebook/login/{source?}', [
    'as' => 'oauth.login',
    'uses' => 'AuthController@redirectToProvider'
]);

// Route::get('auth/facebook/login', 'AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'AuthController@handleProviderCallback');

Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('pledge/{openwish_id}', [
    'as' => 'oauth.pledge',
    'uses' => 'UserController@openwishPledge'
]);

Route::post('pledge/{openwish_id}', [
    'as' => 'oauth.postPledge',
    'uses' => 'UserController@postOpenwishPledge'
]);


/** Owarehouse list **/
Route::get('owarehouselist', ['as' => 'owarehouselist', 'uses' => 'OwarehouseController@index']);

// Route::get('owarehouse/{id}',
// ['as' => 'owarehouse', 'uses' => 'OwarehouseController@owarehouse_list']
//     );


/*
 * Cart Routes
*/
Route::get('cart', ['as' => 'cart', 'uses' => 'CartController@index']);
Route::get('cart/{openwish_id}', ['as' => 'cart.openwish', 'uses' => 'CartController@index']);
Route::post('cart/addtocart', ['as' => 'postAddToCart', 'uses' => 'CartController@postAddtocart']);
Route::post('/add_invoices', ['as' => 'postAddInvoice', 'uses' => 'StationController@postAddInvoice']);
Route::post('/add_invoice_po', ['as' => 'postAddInvoicePo', 'uses' => 'StationController@postAddInvoicePo']);
Route::post('/delete_invoice_po', ['as' => 'postDeleteInvoicePo', 'uses' => 'StationController@postDeleteInvoicePo']);
Route::post('/add_tproducts', ['as' => 'postAddtpr', 'uses' => 'SellerHelpController@postAddtpr']);
Route::get('purchase_o/{id}', ['as' => 'purchase_order_individual', 'uses' => 'SellerHelpController@purchase_order_individual']);
Route::get('purchase_order', ['as' => 'purchase_order', 'uses' => 'SellerHelpController@purchase_order']);
Route::get('purchase_order/{id}', ['as' => 'purchase_order_complete', 'uses' => 'SellerHelpController@purchase_order_complete']);
Route::get('tproduct/wholesale/{id}/{merchant_id}/{user_id}', ['as' => 'twholesale', 'uses' => 'SellerHelpController@twholesale']);
Route::get('tproduct/special/{id}/{merchant_id}/{user_id}', ['as' => 'tspecial', 'uses' => 'SellerHelpController@tspecial']);
Route::get('product/get_delprice','AlbumController@get_delprice');
Route::post('product/get_delpricebyid', ['as' => 'get_delpricebyid', 'uses' => 'DeliveryController@get_delpricebyid']);
Route::post('cart/muladdtocart', 'CartController@postMultipleAddTocart');
Route::get('cart/remove/{id}', 'CartController@getRemoveitem');

Route::post('/storeResponse', 'CartController@storeResponse');
Route::post('/saveAddress', 'CartController@saveAddress');
Route::post('/getState', 'CartController@getState');
Route::post('/getCity', 'CartController@getCity');
Route::post('/saveUser', 'CartController@saveUser');
Route::post('/cartSum', 'CartController@cartSum');
Route::post('/cart/new/address','OnboardingController@new_default_address');
Route::get('cart/new/address','OnboardingController@address_modal');
Route::get('cart/total/items','CartController@totalItems');
/**
 * Ocbc Routes :: Wahid
 */

Route::post('/paystaff', 'OcbcController@index');
Route::get('/parsefile', 'OcbcController@parseReturnFile');
Route::get('exception/read', ['as' => 'custom_exception', function(){
    return view('custom_exception');
}]);


Route::get('cart/smmin/{product_id}/{smmout_id}', ['as' => 'cart.smmout', 'uses' => 'UserController@smmInMarketer']);

/**
 * Ajax Call request
 */
Route::get('smedia/marketer', 'UserController@smediaMarketer');

/**
 * SMM routes
 */
//Ajax Call
Route::post('/save/smmout', 'UserController@smmout');


Route::get('/clear', function () {
//    Session::forget('album_id');
////    Session::forget('profile_id');
//    Session::forget('p_section_id');
//    Session::forget('p_section_name');
//    Session::forget('p_section_data');
//      session()->flush();

    return \Illuminate\Support\Facades\Session::all();

});


// Route for Tokens.
// Route::get('/test','TokenController@index');
// Generate a login URL
Route::get('/fb/login', array('as' => 'fbtoken', 'uses' => 'TokenController@connect'));

// Endpoint that is redirected to after an authentication attempt
Route::get('/fb/callback', 'TokenController@callback');
Route::get('/fb/token/test', array('as' => 'testfbtoken', 'uses' => 'TokenController@testfbtoken'));

//Start Of Admin Dashboard Reports Routers
Route::post('/album/product/detail',array('uses'=>'AlbumController@productDetail'));
// New Routes
Route::get('/edit_mastermerchant', ['as' => 'edit-master-merchant', 'uses' => 'UserController@getMasterEditMerchant']);

/***********Delivery Order ************/
Route::get('deliveryorder/{orderid}', array('as' => 'deliverorder', 'uses' => 'DOController@deliveryorder'));
Route::get('merchantinvoice/{orderid}', array('as' => 'deliverinvoice', 'uses' => 'DOController@deliveryinvoice'));
Route::get('purchaseorder/{orderid}', array('as' => 'purchaseorder', 'uses' => 'DOController@purchaseorder'));
Route::post('deliveryorder/process', array('as' => 'deliverorderprocess', 'uses' => 'DOController@deliveryorderprocess'));
Route::post('deliveryinvoice/process', array('as' => 'deliveryinvoiceprocess', 'uses' => 'DOController@deliveryinvoiceprocess'));
Route::get('receipt/{orderid}', array('as' => 'Receipt', 'uses' =>'DOController@receipt'));
Route::get('invoice/{orderid}', array('as' => 'Invoice', 'uses' =>'DOController@invoice'));




Route::get('get-world-shipping', ['as' => 'get-world-shipping', 'uses' => 'ShippingController@getShippingWorldData']);

/*********** Delivery ************/


Route::get('get_delivery', ['as' => 'get_delivery', 'uses' => 'DeliveryController@getDeliveryData']);


/***********Statement Controller Routes*********************/
Route::get('statement/overall-statement/{id?}',[ 'as' => 'statementoverall','uses'=>'StatementController@sov']);
Route::get('statement/overall-statement','StatementController@sov');
Route::get('statement/delivery-order/{id?}',[ 'as' => 'statementdo','uses'=>'StatementController@dor']);
Route::get('statement/delivery-order','StatementController@dor');
Route::get('statement/receipt/{id?}', [ 'as' => 'statementreceipt','uses'=>'StatementController@rec']);
Route::get('statement/receipt','StatementController@rec');
Route::post('statement/merchantdetail','StatementController@merchantdetail');
Route::post('statement/detail','StatementController@detail');
Route::post('statement/buyerdetail','StatementController@buyerdetail');
Route::post('salesmemo/buyerdetail/{user_id}','StatementController@salesmemodetail');
Route::post('salesmemo/buyerdetailweb/{user_id}','StatementController@salesmemodetailweb');
Route::post('statement/recdetail','StatementController@recdetail');
Route::post('statement/dodetail','StatementController@dodetail');
Route::post('invoicestatement/merchantdetail','StatementController@merchantinvoicedetail');
Route::post('invoicestatement/stationdetail','StatementController@stationdetailinvoicedetail');

// MERCHANT STATEMENT route
Route::get('m/{month}/{year}/{mid?}/{type?}','StatementController@showMerchantStatement');
Route::get('pdf/m/{month}/{year}/{mid?}/{type?}','StatementController@downloadMSPDF');

/**
 * User Payment Module Routes : Wahid
 */

Route::get('/user_payment', 'UserPaymentController@index');


// Inventory-Update
Route::get('inventory/update',array('as'=>'invupdate','uses'=>'InventoryController@redirect'));

Route::get('inventory/update/{subcat_id}','InventoryController@nextpage');
Route::get('inventory/update/{subcat_id}/info','InventoryController@sbajax');
// Route::get('inventory/{station_id}/update','InventoryController@index');
Route::get('inventory/product/{id}',array('as'=>'inpr','uses'=>'InventoryController@prajax'));
Route::post('inventory/page', array('as'=>'inventory_page','uses'=>'InventoryController@page'));
Route::get('inventory/product/{station_id}/{id}/add','InventoryController@prajaxadd');
Route::get('inventory/product/{station_id}/{id}/del','InventoryController@prajaxdel');
Route::get('inventory/product/{station_id}/{id}/neutral','InventoryController@prajaxneutral');
Route::get('/gc','AlbumController@groupCategories');

Route::get('/jsonusers', array('as' => 'jsonusers', 'uses' => 'UserController@getJsonUsers'));
Route::get('/jsonusersnom', array('as' => 'jsonusersnom', 'uses' => 'UserController@getJsonUsersidnom'));
Route::get('/jsonusersnomrec', array('as' => 'jsonusersnomrec', 'uses' => 'UserController@getJsonUsersidnomrec'));
Route::get('/jsonusersid','UserController@getJsonUsersid');
Route::get('/jsonusersid/{id}','UserController@getJsonUsersidpp');
Route::get('/jsonbuyersid','UserController@getJsonBuyerid');
Route::get('/jsonmerchantid/{id}','UserController@getJsonMerchantid');

Route::get('/payslipdf',array('as' => 'payslipdf', 'uses' => 'BuyerController@payslipdf'));

Route::post('product/update/selected_product','ProductController@update_product_selected');

Route::post('/ff', array('as' => 'routeFetchFields', 'uses' => 'AlbumController@fetchField'));
Route::post('/fft', array('as' => 'routeFetchFieldsT', 'uses' => 'SellerHelpController@fetchFieldt'));
Route::post('/fs', array(
    'as' => 'routeFetchFieldsForSpecialPrice',
    'uses' => 'AlbumController@fetchFieldsForSpecialPrice'
));
Route::post('/fst', array(
    'as' => 'routeFetchFieldsForSpecialPricet',
    'uses' => 'SellerHelpController@fetchFieldsForSpecialPricet'
));

Route::post('/fsn', array(
    'as' => 'routeFetchFieldsForSpecialPricen',
    'uses' => 'AlbumController@fetchFieldsForSpecialPricen'
));

Route::post('/dpd', array(
    'as' => 'routedeletepdealer',
    'uses' => 'AlbumController@deletepdealer'
));

Route::get('/gdp', array(
    'as' => 'routegetdealers',
    'uses' => 'AlbumController@routegetdealers'
));

Route::get('/gdpt', array(
    'as' => 'routegetdealerst',
    'uses' => 'SellerHelpController@routegetdealerst'
));

Route::get('/pd/sprices/{did}/{pid}', array(
    'as' => 'pdsprices',
    'uses' => 'AlbumController@pdsprices'
));

Route::get('/pd/stprices/{did}/{pid}/{merchant_id}', array(
    'as' => 'pdtsprices',
    'uses' => 'SellerHelpController@pdstprices'
));


Route::post('/sendmp', array('as' => 'sendmp', 'uses' => 'UserController@sendmp'));
Route::post('/deleteaccount', array('as' => 'deleteaccount', 'uses' => 'UserController@deleteaccount'));


Route::post('/summernote/upload',function(){
    if ($_FILES['file']['name']) {
        if (!$_FILES['file']['error']) {
            $name = md5(rand(100, 200));
            $ext = explode('.', $_FILES['file']['name']);
            $filename = $name . '.' . $ext[1];
            //change this directory
            $destination = public_path('/images/footer/'. $filename) ;
            $location = $_FILES["file"]["tmp_name"];
            move_uploaded_file($location, $destination);
            echo asset('/images/footer/'.$filename);
        }
        else {
            echo  $message =
                'Ooops!  Your upload triggered the following error: '.
                $_FILES['file']['error'];
        }
    }
});

//-------------Start--Create New Voucher------------------//
Route::get('/create_new_voucher',
    [   'as' => 'createNewVoucher',
        'uses' => 'CreateVoucherController@index'
    ]);
Route::post('create_new_voucher',
    [   'as' => 'create_new_voucher.post',
        'uses' => 'CreateVoucherController@store'
    ]);
Route::get('selectCategoryWiseSubCategory/{categoryId}',
    [   'as' => 'selectCategoryWiseSubCategory',
        'uses' => 'CreateVoucherController@SubCategory'
    ]);
Route::get('CreateVoucherDetails/{pdtId}',
    [   'as' => 'CreateVoucherDetails',
        'uses' => 'CreateVoucherController@detailsVoucher'
    ]);
Route::get('buy-voucher/{id}',
    [   'as' => 'buy-voucher',
        'uses' => 'VoucherController@buy_voucher'
    ]);
Route::post('create_new_voucher_v2',
    [   'as' => 'create_new_voucher_v2.post',
        'uses' => 'CreateVoucherController@storev2'
    ]);
Route::post('create_new_voucher_v1',
    [   'as' => 'create_new_voucher_v1.post',
        'uses' => 'CreateVoucherController@storev1'
    ]);
//-------------End--Create New Voucher------------------//


Route::post('/ocreditSourceDetail', array('as' => 'ocreditSourceDetail', 'uses' => 'OpenCreditController@getSourceDetail'));
Route::post('/ocreditSourceIdDetail', array('as' => 'ocreditSourceIdDetail', 'uses' => 'OpenCreditController@get_source_id_detail'));
Route::post('/claim', array('as' => 'claim', 'uses' => 'OpenCreditController@saveClaim'));


// Url Shortener
Route::get('u/{pointer}','UrlShortenerController@handler');
//  TEST ROUTES [TO BE REMOVED IN PRODUCTION]

Route::get('/payment-gateway','PaymentSimulation@index');


// Test Routes ENDS
Route::post('/changeadmin','UserController@changeadmin');
Route::post('/changepassword','UserController@changepassword');
Route::post('/investment','InvestmentController@investment');
Route::post('/alsostation','UserController@alsostation');
Route::post('/alsomerchant','UserController@alsomerchant');
Route::post('/sendpassword','UserController@sendpassword');

Route::post('/save/in/session/',array('as'=>'ssave','uses'=>'AjaxController@saveinSession'));

Route::post('/forgot_password','AjaxController@forgot_password');
Route::get('/check/login','AjaxController@check');
Route::post('/autolink/cancel/{id}','AutoLinkController@cancel_autolink');
Route::post('/autolink/delete_autolink/{id}','AutoLinkController@delete_autolink');

Route::get('/verify/{id}','AjaxController@verify');
Route::get('/verifymerchant/{id}',['as' => 'cartmerchant', 'uses' => 'CartController@cartmerchant']);
Route::get('/verifystation/{id}',['as' => 'cartstation', 'uses' => 'CartController@cartstation']);
Route::get('/redirectstation/{id}',['as' => 'redirectstation', 'uses' => 'AjaxController@redirectstation']);
Route::get('/change_password/{id}','AjaxController@change_password');
Route::post('reset/password',array('as'=>'pwdreset','uses'=>'PasswordController@resetPassword'));

Route::get('opensupport',['as' => 'openSupportIndex','uses' => 'OpenSupportController@index']);
Route::get('weaccept',['as' => 'weaccept','uses' => 'OpenSupportController@weaccept']);
Route::post('opensupport',['as' => 'openSupport.post','uses' => 'OpenSupportController@save']);

// Ajax route
Route::get('check/smm/merchant/status','AjaxController@check_smm');
Route::get('check/session/limit/{key}/{limit}','AjaxController@check_session');
Route::get('helper/message/{id}','AjaxController@get_message');


//---- Start Merchant Analysis--------------------//





//----End Merchant Mnalysis--------------------//

// Buyer Cancel Order
Route::get('cancelorder/{order_id}','BuyerController@buyer_cancel_order');
Route::get('complainorder/{order_id}','BuyerController@buyer_complain_order');
/*Merchant cancels the order*/
Route::get('merchant/cancelorder/{order_id}','CREController@merchant_cancel_order');
// Buyer Returns a product
// Route::get('return/product/{orderid}/{product_id}'.'BuyerController@buyer_return_product');
Route::get('return/init/modal/{order_id}','BuyerController@init_return_modal');
Route::post('return/product','BuyerController@buyer_does_return');

// Merchant aprrove/reject cancellation
Route::post('merchant/confirms/cre','CREController@merchant_confirms_cre');
// Route::post('merchant/reject/cre','CREController@merchant_rejects_cre');

// Onboarding
Route::get('onboarding/required','OnboardingController@is_onboarding_required');
Route::get('onboarding/init','OnboardingController@init_onboarding');
Route::post('onboarding/save','OnboardingController@onboard');

Route::get('onboard/army','OnboardingController@smm_army');

// T&C modal
Route::get('tc/modal/{role}','TermsAndCondition@show_TC_modal'); //role==mer or sta || buyer is default.

// Ajax based logout
Route::get('logout/user','AjaxController@logout');
Route::get('logout/opossum','AjaxController@opossum_logout');

// Pay by Ocredit

Route::get('pay/{ref_no}/by/ocredit/{ocredit_part}/aid/{address_id}','MakePaymentController@pay_by_ocredit');

// Ajax Route Landing
Route::get('landing/header/hyper','AjaxController@header_hyper');
Route::get('landing/header/category','AjaxController@header_category');
Route::get('landing/header/category_mobile','AjaxController@header_category_mobile');
Route::get('landing/header/smm','AjaxController@header_smm');

// SMM new route

Route::get('smm/{cat_id}',array('as'=>'smm','uses'=>'SMMController@smm_by_cat'));

// View CRE images

Route::get('cre/images/{cre_id}','CREController@show_cre_images');


Route::get('inventory/all/{merchantid}/{stationid}', ['as' => 'inventoryAll', 'uses' => 'InventoryController@inventory_all']);
Route::get('inventory/low/{merchantid}/{stationid}', ['as' => 'inventoryLow', 'uses' => 'InventoryController@inventory_low']);
Route::get('inventory/high/{merchantid}/{stationid}', ['as' => 'inventoryHigh', 'uses' => 'InventoryController@inventory_high']);

// OpenWish Reshare route

Route::get('owish/reshare','OpenWishController@reshareOWish');
// Buyer Complaint Routes
Route::get('buyer/complaint/{porder_id}','BuyerComplaintController@loadComplaintModal');
Route::post('buyer/complaint/register','BuyerComplaintController@registerComplaint');

Route::get('buyer/feedback/{porder_id}','BuyerFeedbackController@loadFeedbackModal');
Route::post('buyer/feedback/register','BuyerFeedbackController@registerFeedback');

// Show PDF

Route::get('receipt/{porder_id}/pdf','DOController@pdfRC');
Route::get('download/{type}/pdf/{id}','DOController@downloadPDF');
Route::get('print/{type}/{id}','DOController@print_do');

Route::post('buyer/pay/rfee','CREController@payrfee');
Route::post('/uploadsummernoteimg','AjaxController@uploadsummernoteimg');
Route::get('cre/status/{oid}','CREController@getStatus');
Route::get('smm/trans/{smmout_id}','SMMController@getSMMInfo');

// Openwish Route
Route::get('openwish/buyer/info/{openwish_id}','OpenWishController@showBuyerOWPledgeDetails');
Route::get('pdo/{table}','TestController@getPDO');
Route::get('stuff/{arg?}','TestController@stuff');
Route::post('test/nv/webhook','TestController@nv_webhook');
// Route::get('test/{table}/{id}','TestController@table');

Route::get('mail/{email}','TestController@testMail');
//Staff
Route::get('buyer/staff/function/{mode}','BuyerController@getStaffMode');
Route::get('buyer/staff/mobile/function/{mode}','BuyerController@getStaffModemobile');

// Get delivery price for a cart element

Route::get('cart/product/delivery/{id}','CartController@getproductDelivery');
Route::get('cart/merchant/delivery/{id}','CartController@getmerchantDelivery');
Route::get('mail/{email}','TestController@testMail');

Route::post('/seller/member/add_employee/{type?}',['as' => 'addemployeeseller', 'uses'=>'SellerHelpController@add_employee']);
Route::post('/seller/member/send_emails/{type?}',['as' => 'sendemailsseller', 'uses'=>'SellerHelpController@send_emails']);
Route::post('/seller/member/send_emails_c',['as' => 'sendemailsseller_c', 'uses'=>'SellerHelpController@send_emails_c']);
Route::post('/seller/member/add_role',['as' => 'addroleseller', 'uses'=>'SellerHelpController@add_role']);
Route::get('/seller/member/roles/{user_id}',['as' => 'sellermemberrole', 'uses'=>'SellerHelpController@sellermemberrole']);
Route::get('/seller/osmallmember/segment/{user_id}',['as' => 'osmallsellermembersegment', 'uses'=>'SellerHelpController@osmallsellermembersegment']);
Route::get('/seller/member/segment/{user_id}/{owner_id}',['as' => 'sellermembersegment', 'uses'=>'SellerHelpController@sellermembersegment']);
Route::get('/buyer/crm/customers/{user_id}',['as' => 'memberscrm', 'uses'=>'BuyerController@memberscrm']);
Route::post('/buyer/crm/customers/add',['as' => 'memberscrmadd', 'uses'=>'BuyerController@memberscrmadd']);
Route::post('/seller/member/roles/{user_id}',['as' => 'postsellermemberrole', 'uses'=>'SellerHelpController@changememberrole']);
Route::post('/seller/member/locations/{user_id}',['as' => 'postsellermemberlocation', 'uses'=>'SellerHelpController@changememberlocation']);
Route::post('/seller/osmallmember/segment/{user_id}',['as' => 'postosmallsellermembersegment', 'uses'=>'SellerHelpController@changeosmallmembersegment']);
Route::post('/seller/member/segment/{user_id}/{owner_id}',['as' => 'postsellermembersegment', 'uses'=>'SellerHelpController@changemembersegment']);
Route::post('/seller/member/delete',['as' => 'deletemember', 'uses'=>'SellerHelpController@deletemember']);
Route::get('stationterm', 'SellerHelpController@stationterm');
Route::get('/seller/osmallcampaign/template/{id}',['as' => 'osmallcampaigntemplate', 'uses'=>'SellerHelpController@getosmallcampaigntemplate']);
Route::get('/seller/companycampaign/template/{id}',['as' => 'companycampaigntemplate', 'uses'=>'SellerHelpController@getcompanycampaigntemplate']);
Route::get('/seller/companycampaign/frecuency/{id}',['as' => 'companycampaignfrecuency', 'uses'=>'SellerHelpController@getcompanycampaignfrecuency']);
Route::post('/seller/osmallcampaign/template/{id}',['as' => 'postosmallcampaigntemplate', 'uses'=>'SellerHelpController@osmallcampaigntemplate']);
Route::post('/seller/companycampaign/template/{id}',['as' => 'postcompanycampaigntemplate', 'uses'=>'SellerHelpController@companycampaigntemplate']);
Route::post('/seller/osmallcampaign/name/{id}',['as' => 'postosmallcampaignname', 'uses'=>'SellerHelpController@osmallcampaignname']);
Route::post('/seller/companycampaign/name/{id}',['as' => 'postcompanycampaignname', 'uses'=>'SellerHelpController@companycampaignname']);
Route::post('/seller/member/name/{id}',['as' => 'postmembername', 'uses'=>'SellerHelpController@membername']);
Route::post('/seller/osmallmember/name/{id}',['as' => 'postosmallmembername', 'uses'=>'SellerHelpController@osmallmembername']);
Route::post('/seller/osmallmember/mobile/{id}',['as' => 'postosmallmembername', 'uses'=>'SellerHelpController@osmallmembermobile']);
Route::post('/seller/osmallsegment/name/{id}',['as' => 'postosmallsegmentname', 'uses'=>'SellerHelpController@osmallsegmentname']);
Route::post('/seller/companysegment/name/{id}',['as' => 'postcompanysegmentname', 'uses'=>'SellerHelpController@companysegmentname']);
Route::post('/seller/osmallsegment/delete',['as' => 'postosmallsegmentdelete', 'uses'=>'SellerHelpController@osmallsegmentdelete']);
Route::post('/seller/companysegment/delete',['as' => 'postcompanysegmentdelete', 'uses'=>'SellerHelpController@companysegmentdelete']);
Route::post('/seller/osmallsegment/add',['as' => 'postosmallsegmentadd', 'uses'=>'SellerHelpController@osmallsegmentadd']);
Route::post('/seller/companysegment/add',['as' => 'postcompanysegmentadd', 'uses'=>'SellerHelpController@companysegmentadd']);
Route::post('/seller/osmallcampaign/add',['as' => 'postosmallcampaign', 'uses'=>'SellerHelpController@osmallcampaign']);
Route::post('/seller/companycampaign/add',['as' => 'postcompanycampaigncampaign', 'uses'=>'SellerHelpController@companycampaign']);
Route::post('/terms/create',['as' => 'createterms', 'uses'=>'SellerHelpController@createterms']);
Route::get('/station/purchases/{uid?}','StationController@purchases');
Route::get('/seller/member/campaings/{id}/{owner_id}',['as' => 'campaignsc', 'uses'=>'SellerHelpController@c_campaigns']);



Route::get('/getcurrentcurrency',['as' => 'getcurrentcurrency', 'uses'=>'AjaxController@getcurrentcurrency']);

/*  Paul on 1st May 2017 at 11 50 pm    */
//Route::get('admin/master/orderapp/{id}', array('as' => 'appordermaster', 'uses' => 'OrderController@approval'));
Route::get('/orderapp/{id}', array('as' => 'appordermaster', 'uses' => 'OrderController@approval'));
Route::get('email/{email}','EmailController@testEmail');
Route::get('fairmode/{merchant}/{recruiter}','BuyerController@fairmode');
Route::get('stocktake/{merchant}/{recruiter}/{location}','BuyerController@stocktake');
Route::get('salesmemo/{merchant}/{recruiter}/{location}','BuyerController@salesmemo');
Route::get('stocktake/productinfo/{id}','BuyerController@stocktakeinfo');
Route::get('salesmemo/productinfo/{id}','BuyerController@salesmemoinfo');
Route::post('salesmemo/createsalesmemo','BuyerController@createsalesmemo');
/*  Ends Here  */

/** Following are routes used to develop and test the NinjaVan API **/
// NV Authentication 2.0 API
Route::get('/script/nv1', ['as' => 'nv1', 'uses' => 'ScriptController@nv1']);
Route::get('/script/jnv1', ['as' => 'jnv1', 'uses' => 'ScriptController@jnv1']);

// NV Sub-Shipper 1.0 API
Route::get('/script/nv2', ['as' => 'nv2', 'uses' => 'ScriptController@nv2']);
Route::get('/script/jnv2', ['as' => 'jnv2', 'uses' => 'ScriptController@jnv2']);

// NV Orders 3.0 API
Route::get('/script/nv3', ['as' => 'nv3', 'uses' => 'ScriptController@nv3']);
Route::get('/script/jnv3', ['as' => 'jnv3', 'uses' => 'ScriptController@jnv3']);
Route::get('/script/nv3ms',['as'=>'nv3ms','uses' => 'ScriptController@nv3ms']);

// NV Orders 4.0 API
Route::get('/script/nv43',['as'=>'nv43','uses'=>'ScriptController@nv43']);
Route::get('/script/jnv43',['as'=>'jnv43','uses'=>'ScriptController@jnv43']);
Route::get('/script/jnv4r',['as'=>'jnv4r','uses'=>'ScriptController@jnv4r']);
Route::get('/script/nv44',['as'=>'nv44','uses'=>'ScriptController@nv44']);
Route::get('/script/jnv44',['as'=>'jnv44','uses'=>'ScriptController@jnv44']);
Route::get('/script/nv45',['as'=>'nv45','uses'=>'ScriptController@nv45']);
Route::get('/script/jnv45',['as'=>'jnv45','uses'=>'ScriptController@jnv45']);


// NV Orders 3.0 Search API
Route::get('/script/nv4', ['as' => 'nv4', 'uses' => 'ScriptController@nv4']);
Route::get('/script/jnv4', ['as' => 'jnv4', 'uses' => 'ScriptController@jnv4']);

// NV Orders 2.0 Cancellation API
Route::get('/script/nv5', ['as' => 'nv5', 'uses' => 'ScriptController@nv5']);
Route::get('/script/jnv5', ['as' => 'jnv5', 'uses' => 'ScriptController@jnv5']);

// NV Orders 2.0 Tracking API
Route::get('/script/nv6', ['as' => 'nv6', 'uses' => 'ScriptController@nv6']);
Route::get('/script/jnv6', ['as' => 'jnv6', 'uses' => 'ScriptController@jnv6']);

// NV WebHooks 1.1 API
Route::post('/nv/ppickup',
    ['as'=>'ppickup', 'uses'=>'ScriptController@wh_pending_pickup']);

Route::post('/nv/parcelsize',
    ['as'=>'parcelsize', 'uses'=>'ScriptController@wh_parcel_size']);

Route::post('/nv/parcelweight',
    ['as'=>'parcelweight', 'uses'=>'ScriptController@wh_parcel_weight']);

Route::post('/nv/spickup',
    ['as'=>'spickup', 'uses'=>'ScriptController@wh_successful_pickup']);

Route::post('/nv/sdelivery',
    ['as'=>'sdelivery', 'uses'=>'ScriptController@wh_successful_delivery']);

Route::post('/nv/fpickup',
    ['as'=>'fpickup', 'uses'=>'ScriptController@wh_pickup_fail']);

Route::post('/nv/presched',
    ['as'=>'presched', 'uses'=>'ScriptController@wh_pending_reschedule']);

Route::post('/nv/rts',
    ['as'=>'rts', 'uses'=>'ScriptController@wh_return_to_sender']);
/*Used in calculating B2C prices*/
Route::post('product/price','ProductController@get_price');
Route::post('product/price/b2b','ProductController@get_price_b2b');
Route::get('citilink',function(){echo "string";});

Route::get('openwish/log/{openwish_id}','OpenWishController@openwish_log');

/*FOR Mobile OrderProduct details for a porder_id*/
Route::get('mobile/formatted/op/{porder_id}','OrderController@get_op_details_mobile');
Route::get('mobile/productdetails/{id}','ProductController@get_product_details');

Route::get('productmapping/{selluser}/{pid}' ,array('as' => 'productmapping', 'uses' => 'ProductController@productmapping'));
Route::get('producttracking/{pid}/{user_id?}' ,array('as' => 'producttracking', 'uses' => 'ProductController@producttracking'));
Route::get('productlocations/{pid}/{user_id?}' ,array('as' => 'productlocations', 'uses' => 'ProductController@productlocations'));

Route::get('seller/returnGoodsTable','CreditNoteController@returnGoods');
Route::get('seller/returnStatusTable','CreditNoteController@returnStatus');
Route::get('seller/returnMerchantAprovalTable','CreditNoteController@returnMerchantAproval');

Route::get('seller/returnordertproduct','CreditNoteController@returnordertproduct');
Route::post('seller/returnquantity','CreditNoteController@returnquantity')->name('returnquantity');
Route::get('seller/updatereturnproductstatus/{return_good_id}/{statusforupdate}','CreditNoteController@updatereturnproductstatus');



/*Route::get('seller/opossum','OpossumController@index')->name('opossum');
Route::get('seller/opossumproduct/{id}','OpossumController@productdetail');
Route::get('seller/addopossumproductsession/{id}','OpossumController@addinsession');
Route::get('seller/removefromsession/{id}','OpossumController@destroyfromsession');
Route::post('seller/checkoutopossum','OpossumController@save')->name('checkoutopossum');*/



// Delivery order routes __

Route::get('seller/deliveryorder/{user_id?}','DoManagementController@index')->name('deliveryorder');
Route::post('seller/issue/do','DoManagementController@issueDo')->name('issue.do');
Route::post('seller/tr/do','DoManagementController@trDo')->name('tr.do');
Route::post('seller/discard/do','DoManagementController@discardDo')->name('discard.do');
Route::post('seller/import/file','DoManagementController@importDo')->name('import.do');
Route::post('seller/export/file','DoManagementController@exportDo')->name('export.do');
Route::get('seller/canceltr/{id}','DoManagementController@canceltr')->name('canceltr');
Route::get('importedstatus/{id}','DoManagementController@importedstatus')->name('importedstatus');
// Do docoment
Route::post('deliveryorder/document','StatementController@doissued');

//Route::post('creditnote/stationdetail','StatementController@creditnote');

Route::get('creditnotedocument/{id}','CreditNoteController@creditnotedocument')->name('creditnotedocument');
Route::get('returnofgoodsdocument/{id}','CreditNoteController@returnofgoodsdocument')->name('returnofgoodsdocument');

Route::post('returnofgoods/stationdetail','StatementController@returnofgoods');


Route::post("merchant/qrsetting","QrsettingController@index")->name('qrsetting');
Route::get('fairlocation/savedil/{id}','DilFairLocationController@index');
Route::get('locationcode/save/{code}/{id}','DilFairLocationController@savecode');




Route::get('productbarmapping/{selluser}/{pid}' ,array('as' => 'productmapping', 'uses' => 'ProductController@productbarmapping'));


Route::get("/coolimages", function() {
    return response()->download('/var/tmp/images.tar.gz');
});


Route::get('fortest/','TestController@mytest');
Route::get('/newpasswords','TestController@updatePasswords');

Route::get('/myroute','SellerHelpController@getTerminalCash');
// Route::get('/seller/getvoucherlist/{id}','VoucherController@getvoucherlist');
// Route::get('/seller/getvoucherledgerlist/{id}','VoucherController@getvoucherledgerlist');

// Refrigerator and Storage routes

 Route::get('/seller/documents/{uid}',['as' => 'documentsselladm', 'uses'=>'SellerHelpController@selldocuments']);

Route::get('/album/{id?}/{uid?}', ['as' => 'albumtabbed', 'uses'=>'AlbumController@index']);


Route::post('image/save','UtilityController@image_save');
Route::get('/merchant/inventory/{uid?}', ['as' => 'merchantinventory', 'uses'=>'SellerHelpController@merchantinventory']);


/* Routes to save/update remarks and image in Product Ledger, SISO Report */
Route::post('producttracking/saveremarks' ,'ProductController@saveRemarks');
Route::post('producttracking/saveimage' ,'ProductController@saveImage');
Route::post('stockreportremark/savestockremark','DOController@savestockremark');

Route::get('script/moduleaccess','ScriptController@module_access');
