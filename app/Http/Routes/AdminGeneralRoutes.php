<?php
/* OpenSupermall Custom Routes */
Route::post('/admin/general/advertisement/save_slider', array('as' => 'save_slider_landing', 'uses' => 'AdvertisementController@save_landing_slider'));
Route::post('/admin/general/advertisement/save_hyper', array('as' => 'save_hyper_ad', 'uses' => 'AdvertisementController@save_hyper'));
Route::get('admin/general/advertisement', array('as' => 'globaladvertisement', 'uses' => 'AdvertisementController@global_index'));
Route::get('admin/general/advertisement/main', array('as' => 'globalmainadvert', 'uses' => 'AdvertisementController@global_landing'));
Route::get('admin/general/advertisement/brand', array('as' => 'globalbrandadvert', 'uses' => 'AdvertisementController@global_brand'));
Route::get('admin/general/advertisement/smm', array('as' => 'globalsmmadvert', 'uses' => 'AdvertisementController@global_smm'));
Route::get('admin/general/advertisement/hyper', array('as' => 'globalhyperadvert', 'uses' => 'AdvertisementController@global_hyper'));
Route::get('admin/general/advertisement/landing_preview', array('as' => 'globallanding_preview', 'uses' => 'AdvertisementController@landing_preview'));

Route::get('admin/general/advertisement/{page}/slider', array('as' => 'globalslider', 'uses' => 'AdvertisementController@global_slider'));
/* for ajax request */
Route::get('/admin/general', array('as' => 'routeAdminGeneral', 'uses' => 'EmployeeController@index'));
Route::resource('/admin/general/employees', 'EmployeeController');

Route::get('/admin/general/listsalesstaff', array('as' => 'routeSalesStaff', 'uses' => 'SalesStaffController@index'));
Route::resource('/admin/general/salesstaff', 'SalesStaffController');


Route::get('/admin/general/listoccupation', array('as' => 'routeOccupation', 'uses' => 'OccupationController@index'));
Route::resource('/admin/general/occupations', 'OccupationController');

Route::get('/admin/general/listglobals', array('as' => 'routeGlobal', 'uses' => 'GlobalController@index'));
Route::resource('/admin/general/globals', 'GlobalController');
Route::post('/admin/general/globals/updatetoken', array('as' => 'globalupdatetoken', 'uses' => 'GlobalController@updatetoken'));
Route::post('/admin/general/globals/updatecurrency', array('as' => 'globalupdatecurrency', 'uses' => 'GlobalController@updatecurrency'));

Route::get("/admin/general/mcpreport", array('as' => 'mcReport', 'uses' => 'ReportsController@mcGeneralReport'));
Route::get("/admin/general/mppreport", array('as' => 'mpReport', 'uses' => 'ReportsController@mpGeneralReport'));
Route::get("/admin/general/pusherpreport", array('as' => 'pusherReport', 'uses' => 'ReportsController@pusherGeneralReport'));
Route::get('sales-by-country', ['as' => 'sales-by-country', 'uses' => 'ShippingController@getSalesByCountry']);
Route::get('sales-by-state', ['as' => 'sales-by-state', 'uses' => 'ShippingController@getSalesByState']);
Route::get('sales-by-merchant-consultant', ['as' => 'sales-by-merchant-consultant', 'uses' => 'ShippingController@getSalesByMerchantConsultant']);
Route::get('sales-by-merchant', ['as' => 'sales-by-merchant', 'uses' => 'ShippingController@getSalesByMerchantID']);
Route::get('sales-by-buyer', ['as' => 'sales-by-buyer', 'uses' => 'ShippingController@getSalesByBuyer']);
Route::get('sales-by-courier', ['as' => 'sales-by-courier', 'uses' => 'ShippingController@getSalesByCourier']);
Route::get('states-by-country', ['as' => 'states-by-country', 'uses' => 'ShippingController@getStatesByCountry']);


Route::post('admin/general/ad/upload', ['as' => 'image.store' , 'uses' => 'AdController@store']);
Route::get('admin/general/ad/exist/{adtarget_id}','AdController@adcontrolExists');
Route::get('admin/general/ad','AdController@index');

Route::post('admin/general/set/ad','AdController@set_ads');
Route::post('admin/general/set/target','AdController@set_targets');

Route::get('admin/general/advert',['as'=>'advert','uses'=>'AdvertController@index']);
// Route::get('admin/general/set/landing','LandingProductController@index');
Route::post('admin/general/slider_image','AdvertController@sliderImage');
Route::post('admin/general/advertsmall_image','AdvertController@advertSmallImage');
Route::post('admin/general/advertsmall_bimage','AdvertController@advertSmallbImage');
Route::post('admin/general/oshop_image','AdvertController@advertOshopImage');
Route::get('admin/general/right_image_slider','AdvertController@rightImageSlider');
Route::get('admin/general/right_bimage_slider','AdvertController@rightbImageSlider');
Route::get('admin/general/oshop_slider','AdvertController@oshopSlider');
Route::get('admin/general/left_image_slider','AdvertController@leftImageSlider');
// Route::post('admin/general/left_image_slider/delete','AdvertController@deleteLeftImageSlider');
// Route::post('admin/general/right_top_image/delete','AdvertController@deleteTopImage');
// Route::post('admin/general/right_bottom_image/delete','AdvertController@deleteBottomImage');
// Route::post('admin/general/oshop_image/delete','AdvertController@deleteOshopImage');

Route::post('admin/general/slider/delete','AdvertController@deleteSliderImage');
Route::post('admin/general/hide_advert/{target}','AdvertController@hideAdvertImage');
Route::post('admin/general/upload_public','AdvertController@uploadPublicImage');
/** Added by Eemeka - 17th 11, 2016 **/

//payment gateway - CRUD
Route::get('/admin/general/payment-gateway',['as'=>'generalIndexPaymentGateway', 'uses'=>'PaymentGatewayController@get_index']);
Route::post('/admin/general/payment-gateway',['as'=>'generalStorePaymentGateway', 'uses'=>'PaymentGatewayController@post_store']);
Route::post('/admin/general/payment-gateway/update/{id}',['as'=>'generalUpdatePaymentGateway', 'uses'=>'PaymentGatewayController@post_update']);
Route::get('/admin/general/payment-gateway/delete/{id}',['as'=>'generalDeletePaymentGateway', 'uses'=>'PaymentGatewayController@get_delete']);

//giro_reader
Route::get('/admin/general/giro-reader',['as'=>'giroReader', 'uses'=>'GiroReaderController@get_reader']);
Route::post('/admin/general/giro-reader/upload',['as'=>'uploadGiroReader', 'uses'=>'GiroReaderController@post_upload']);
Route::post('/admin/general/giro-reader/uploaded',['as'=>'uploadGiroReaderded', 'uses'=>'GiroReaderController@post_uploaded']);
Route::get('/admin/general/giro-reader/detail/{id}',['as'=>'giroReaderDetail', 'uses'=>'GiroReaderController@get_detail']);
Route::get('/admin/general/giro-reader/{file}',['as'=>'giroReaderDetail', 'uses'=>'GiroReaderController@get_upload']);

//mass_autolink
Route::get('admin/general/mass_autolink', ['as' => 'Mass_autolink', 'uses' => 'MslinkingController@index']);
Route::get('admin/general/mass_autolink/{uid}/{mid}', ['as' => 'PMass_autolink', 'uses' => 'MslinkingController@products']);
Route::post('admin/general/mass_autolink', ['as' => 'PostMass_autolink', 'uses' => 'MslinkingController@autolink']);
Route::post('admin/general/mass_autolink/product', ['as' => 'PostMass_autolink_product', 'uses' => 'MslinkingController@enable_product']);
Route::post('admin/general/mass_autolink/filter', ['as' => 'PostMass_autolinkFilter', 'uses' => 'MslinkingController@filter']);


//Route::get('admin/general/allmerchant', ['as' => 'allmerchant_autolink', 'uses' => 'MslinkingController@allmerchant']);
//Route::post('/admin/general/mslinkig-autolink', ['as' => 'mslinkig-autolink', 'uses' => 'MslinkingController@postmslinking']);
//Route::get('/admin/general/catmerchant/{id}', ['as' => 'mslinkig-catmerchant', 'uses' => 'MslinkingController@catmerchant']);
//Route::get('/admin/general/subcatmerchant/{id}', ['as' => 'mslinkig-subcatmerchant', 'uses' => 'MslinkingController@subcatmerchant']);
//Route::get('/admin/general/idmerchant/{id}', ['as' => 'mslinkig-idmerchant', 'uses' => 'MslinkingController@idmerchant']);
//

//station types - CRUD
Route::get('/admin/general/station-type',['as'=>'generalIndexStationType', 'uses'=>'StationTypeController@get_index']);
Route::post('/admin/general/station-type',['as'=>'generalStoreStationType', 'uses'=>'StationTypeController@post_store']);
Route::post('/admin/general/station-type/update/{id}',['as'=>'generalUpdateStationType', 'uses'=>'StationTypeController@post_update']);
Route::get('/admin/general/station-type/delete/{id}',['as'=>'generalDeleteStationType', 'uses'=>'StationTypeController@get_delete']);

Route::get('/admin/general/opensupport',['as'=>'generalIndexOpenSupport', 'uses'=>'AdminOpenSupportController@getIndex']);
Route::post('/admin/general/opensupport',['as'=>'generalStoreOpenSupport', 'uses'=>'AdminOpenSupportController@postStore']);
Route::post('/admin/general/opensupport/update/{id}',['as'=>'generalUpdateOpenSupport', 'uses'=>'AdminOpenSupportController@postUpdate']);
Route::get('/admin/general/opensupport/delete/{id}',['as'=>'generalDeleteOpenSupport', 'uses'=>'AdminOpenSupportController@getDelete']);

Route::get('/admin/general/opensupport/category',['as'=>'generalIndexOpenSupportCategory', 'uses'=>'AdminOpenSupportCategoryController@getIndex']);
Route::post('/admin/general/opensupport/category',['as'=>'generalStoreOpenSupportCategory', 'uses'=>'AdminOpenSupportCategoryController@postStore']);
Route::post('/admin/general/opensupport/category/update/{id}',['as'=>'generalUpdateOpenSupportCategory', 'uses'=>'AdminOpenSupportCategoryController@postUpdate']);
Route::get('/admin/general/opensupport/category/delete/{id}',['as'=>'generalDeleteOpenSupportCategory', 'uses'=>'AdminOpenSupportCategoryController@getDelete']);

Route::get('/admin/general/opensupport/{category}/sub-category',['as'=>'generalIndexOpenSupportSubCategory', 'uses'=>'AdminOpenSupportSubCategoryController@getIndex']);
Route::post('/admin/general/opensupport/sub-category',['as'=>'generalStoreOpenSupportSubCategory', 'uses'=>'AdminOpenSupportSubCategoryController@postStore']);
Route::post('/admin/general/opensupport/sub-category/update/{id}',['as'=>'generalUpdateOpenSupportSubCategory', 'uses'=>'AdminOpenSupportSubCategoryController@postUpdate']);
Route::get('/admin/general/opensupport/{category}/sub-category/delete/{id}',['as'=>'generalDeleteOpenSupportSubCategory', 'uses'=>'AdminOpenSupportSubCategoryController@getDelete']);
//Route::get('/admin/general/opensupport/{category}/sub-category',['as'=>'generalGetByIdOpenSupportSubCategory', 'uses'=>'AdminOpenSupportSubCategoryController@getById']);

Route::get('/admin/general/advert/category/{category}',['as'=>'generalAdvertCategory', 'uses'=>'AdvertController@cateogoryAdvert']);
Route::post('admin/general/category_image','AdvertController@categoryImage');
Route::get('admin/general/category_image_list/{category}','AdvertController@categoryImageList');
Route::get('/admin/general/advert/subcategory/{category}',['as'=>'generalAdvertSubCategory', 'uses'=>'AdvertController@subcateogoryAdvert']);
Route::post('/admin/general/sub_category_image','AdvertController@subcategoryImage');
Route::get('/admin/general/get_sub_category/{category}','AdvertController@subCategoryList');
?>
