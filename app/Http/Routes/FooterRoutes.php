<?php
/* OpenSupermall Custom Routes */
Route::get('admin/footer/aboutus',array('as' =>'AdminAboutUs','uses'=>'AdminFooterController@aboutus'));
Route::get('admin/footer/termsandcondition',array('as' =>'AdminTermsAndCondition','uses'=>'AdminFooterController@termsandcondition'));
Route::get('admin/footer/downloadapps',array('as' =>'AdminDownloadApps','uses'=>'AdminFooterController@downloadapps'));
Route::get("admin/footer/opensupport", array('as'=>'opensupport'));

Route::resource("aboutus", "AboutUsController");
Route::resource("termsandcondition", "TermsAndConditionAdminController");
Route::resource("downloadapps", "DownloadAppsAdminController");

?>
