<?php
/**
 * Created by PhpStorm.
 * User: sadia
 * Date: 11/5/2015
 * Time: 11:42 PM
 */
// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});

// Home > Category
Breadcrumbs::register('category', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Category', route('category'));
});
// Home > Brand
Breadcrumbs::register('brand', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Brand', route('brand'));
});

// Home > AboutUs
Breadcrumbs::register('about_us', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About Us', route('about_us'));
});
// Home > buyerregistration
Breadcrumbs::register('buyerregistration', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Buyer Registration', route('buyerregistration'));
});
// Home > buyerinformation
Breadcrumbs::register('buyerinformation', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Buyer Information', route('buyerinformation'));
});
// Home > productconsumer
Breadcrumbs::register('productconsumer', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Product Description', route('productconsumer'));
});

// Home > product
Breadcrumbs::register('product', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Product', route('productconsumer'));
});

//Home > pledge
Breadcrumbs::register('oauth.pledge', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pledge', route('oauth.pledge', [$id]));
});

// Home > productsupplier
Breadcrumbs::register('productsupplier', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Product Supplier', route('productsupplier'));
});
// Home > profilesettingcertificate
Breadcrumbs::register('profilesettingcertificate', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Profile Setting Certificate', route('profilesettingcertificate'));
});
// Home > profilesettingaboutus
Breadcrumbs::register('profilesettingaboutus', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Profile Setting About Us', route('profilesettingaboutus'));
});

// Home > profilesetting
Breadcrumbs::register('profilesetting', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Profile Setting', route('profilesetting'));
});

// Home > payment
Breadcrumbs::register('payment', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Payment', route('payment'));
});
// Home > album
Breadcrumbs::register('album', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Album', route('albumtabbed'));
});

// Home > openchannel
Breadcrumbs::register('station.open-channel', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('OpenChannel', route('station-open-channel'));
});

// Home > Sales Report
Breadcrumbs::register('merchantsalesreport', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Merchant Sales Report', route('merchantsalesreport'));
});

// Home > Sales Report
Breadcrumbs::register('stationsalesreport', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Station Sales Report', route('stationsalesreport'));
});

// Home > Receipt
Breadcrumbs::register('statementreceipt', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Receipt', route('statementreceipt'));
});

// Home > Sales Report
Breadcrumbs::register('statementdo', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Delivery Order', route('statementdo'));
});

// Home > Sales Report
Breadcrumbs::register('statementoverall', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Statement', route('statementoverall'));
});

// Home > merchantdashboard
Breadcrumbs::register('merchant.dashboard', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Merchant Dashboard', route('merchantdashboard'));
});

Breadcrumbs::register('station.dashboard', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Station Dashboard', route('stationdashboard'));
});

Breadcrumbs::register('order-view-icon', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Order View Icon', route('order-view-icon'));
});

Breadcrumbs::register('invupdate', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Inventory Update', route('invupdate'));
});

Breadcrumbs::register('get-inventory-data', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Inventory Report', route('get-inventory-data'));
});

// Home > SMM
Breadcrumbs::register('SMM', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('SMM', route('SMM'));
});
// Home > oshopsmsone
Breadcrumbs::register('oshopsmsone', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('O-Shop SMS One', route('oshopsmsone'));
});
// Home > OShop OEM
Breadcrumbs::register('oshopoem', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('O-Shop OEM', route('oshopoem'));
});
// Home > oshoplist
Breadcrumbs::register('oshoplist', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    //$breadcrumbs->push('O-Shop', route('oshoplist'));
});
// Home > oshoplist > oshop one
Breadcrumbs::register('oshop.one', function($breadcrumbs, $url) {
    $ooshop = DB::table('oshop')->where('url',$url)->first();
    $oshop = \App\Models\MerchantOshop::where('oshop_id',$ooshop->id)->first();
    $Merchant = \App\Models\Merchant::where('id',$oshop->merchant_id)->first();
    $breadcrumbs->parent('oshoplist');

	$os = \App\Models\Oshop::where('id',$oshop->oshop_id)->first();
    $breadcrumbs->push($os->oshop_name, route('oshop.one', $os->id));
});
// Home > oshopcertificate
Breadcrumbs::register('oshopcertificate', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('O-Shop Certificate', route('oshopcertificate'));
});

// Home > oshopaboutus
Breadcrumbs::register('oshopaboutus', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('O-Shop About Us', route('oshopaboutus'));
});

// Home > product

Breadcrumbs::register('productdealer', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('product supplier', route('productdealer'));
});
Breadcrumbs::register('test', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('test', route('test'));
});
/*
Breadcrumbs::register('oshop.one', function($breadcrumbs, $id) {
    $Merchant = \App\Models\Merchant::where('id',$id)->first();
    $breadcrumbs->parent('oshoplist');
    $breadcrumbs->push($Merchant->oshop_name, route('oshop.one', $id));
}); 

*/



// Home > howtosell
Breadcrumbs::register('howtosell', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('How To Sell', route('howtosell'));
});

// Home > howtobuy
Breadcrumbs::register('howtobuy', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('How To Buy', route('howtobuy'));
});

// Home > newsletter
Breadcrumbs::register('newsletter.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Newsletter', route('newsletter.index'));
});

// Home > downloads
Breadcrumbs::register('downloads.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Download Apps', route('downloads.index'));
});

// Home > advertise
Breadcrumbs::register('advertise.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Advertise With Us', route('advertise.index'));
});

// Home > terms_cond
Breadcrumbs::register('terms_cond.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Terms and Condition', route('terms_cond.index'));
});

// Home > privacy
Breadcrumbs::register('privacy.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Privacy Policy', route('privacy.index'));
});

// Home > job
Breadcrumbs::register('job.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Job Portal', route('job.index'));
});

// Home > contactus
Breadcrumbs::register('contactus.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contact Us', route('contactus.index'));
});

// Home > buyerhelp
Breadcrumbs::register('buyerhelp.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Help the Buyer', route('buyerhelp.index'));
});

// Home > sellerhelp
Breadcrumbs::register('sellerhelp.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Help the Seller', route('sellerhelp.index'));
});

// Home > feedback
Breadcrumbs::register('feedback.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Feedback', route('feedback.index'));
});

// Home > directory
Breadcrumbs::register('directory.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Directory', route('directory.index'));
});
 
// Home > Floor
Breadcrumbs::register('floor', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Floor', route('floor'));
});
Breadcrumbs::register('floor/{id}', function($breadcrumbs,$id)
{
    $breadcrumbs->parent('floor');
    $breadcrumbs->push(ucfirst(\App\Models\Category::where('floor',$id)->first()->description), route('floor'));
});

 

// Home > create_new_voucher
Breadcrumbs::register('create_new_voucher', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Create New Voucher', route('create_new_voucher'));
});

// Home > create_new_product
Breadcrumbs::register('create_new_product', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Create New Product', route('create_new_product'));
});
// Home > create_new_user
Breadcrumbs::register('create-new-user', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Create New User', route('create-w-user'));
});
// Home > sub-cat-details/{id}/{sid}
Breadcrumbs::register('sub-cat-details/{id}/{sid}', function($breadcrumbs,$cat,$subcat)
{
    $subcat_des = \App\Models\SubCatLevel1::where('id',$subcat)->where('category_id',$cat)->first();
    $cat_des = \App\Models\Category::where('id',$cat)->first();
    $breadcrumbs->parent('category');
    $breadcrumbs->push($cat_des->description.'/'.$subcat_des->description, route('sub-cat-details/{id}/{sid}'));
});
// Home > sub-cat-details/{id}/{sid}
Breadcrumbs::register('brand-details/{id}', function($breadcrumbs,$brand_id)
{
    $brand_name = \App\Models\Brand::where('id',$brand_id)->first();
    $breadcrumbs->parent('brand');
    $breadcrumbs->push($brand_name->name, route('brand-details/{id}'));
});
//search
Breadcrumbs::register('search', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Search', route('search'));
});
Breadcrumbs::register('create-station', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Create Station', route('create-station'));
});
Breadcrumbs::register('create-merchant', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Create Merchant', route('create-merchant'));
});
Breadcrumbs::register('edit-merchant', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Edit Merchant', route('edit-merchant'));
});
Breadcrumbs::register('edit-station', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Edit Station', route('edit-station'));
});
// O-Warehouse
Breadcrumbs::register('owarehouse', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('O-Warehouse', route('owarehouse'));
});

// Home > O-Warehouse
Breadcrumbs::register('owarehouselist', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Hyper', route('owarehouselist'));
});

//Home > Cart
Breadcrumbs::register('cart', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cart', route('cart'));
});


//Home > request-response
Breadcrumbs::register('request_response', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Request-Response', route('request_response'));
});

//Home > postOrder
Breadcrumbs::register('postOrder', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('PostOrder', route('postOrder'));
});

/*
 * Admin Table management Breadcrumbs
 */

Breadcrumbs::register('tableManagement', function($breadcrumbs){
    $breadcrumbs->push('Home', route('home'));
    $breadcrumbs->push('Admin', route('adminPanel'));
});

Breadcrumbs::register('categoryMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Category', route('categoryMgmt'));
});

Breadcrumbs::register('users', function ($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Users', route('user.all'));
});

Breadcrumbs::register('rolesMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Roles', route('rolesMgmt'));
});

Breadcrumbs::register('brandMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Brands', route('brandMgmt'));
});
Breadcrumbs::register('newsletterMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Newsletters', route('newsletterMgmt'));
});
Breadcrumbs::register('downloadappsMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('DownloadApps', route('downloadappsMgmt'));
});
Breadcrumbs::register('directoryMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Directory', route('directoryMgmt'));
});
Breadcrumbs::register('buyerhelpMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('BuyerHelp', route('buyerhelpMgmt'));
});
Breadcrumbs::register('sellerhelpMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('SellerHelp', route('sellerhelpMgmt'));
});
Breadcrumbs::register('feedbackMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('FeedbackHelp', route('feedbackMgmt'));
});
Breadcrumbs::register('jobMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('jobHelp', route('jobMgmt'));
});
Breadcrumbs::register('contactUsMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('contactUsHelp', route('contactUsMgmt'));
});
Breadcrumbs::register('footerSectionAMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Footer: Section A', route('footerSectionAMgmt'));
});
Breadcrumbs::register('footerSectionBMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Footer: Section B', route('footerSectionBMgmt'));
});
Breadcrumbs::register('advertisementMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('advertisementHelp', route('advertisementMgmt'));
});
Breadcrumbs::register('termsnconditionMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('termsncondition', route('termsnconditionMgmt'));
});
Breadcrumbs::register('privacypolicyMgmt', function($breadcrumbs)
{
    $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('privacypolicy', route('privacypolicyMgmt'));
});
//Added By Imran For Admin Front
Breadcrumbs::register('adminFront', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Admin', route('admin'));
    $breadcrumbs->push('Front', route('adminFront'));
});
Breadcrumbs::register('adminFrontG', function ($breadcrumbs) {
    $breadcrumbs->parent('adminFront');
    $breadcrumbs->push('Graphs', route('adminFrontGraph'));
});
Breadcrumbs::register('CountrySales', function ($breadcrumbs) {
    $breadcrumbs->parent('adminFront');
    $breadcrumbs->push('Sale By Country', route('countrySales'));
});
Breadcrumbs::register('ActiveBuyer', function ($breadcrumbs) {
    $breadcrumbs->parent('adminFront');
    $breadcrumbs->push('Active Buyers', route('countryActiveBuyer'));
});
Breadcrumbs::register('MCRecruited', function ($breadcrumbs) {
    $breadcrumbs->parent('adminFront');
    $breadcrumbs->push('MC Recruited', route('countryMCRecruited'));
});
Breadcrumbs::register('SMMRecruited', function ($breadcrumbs) {
    $breadcrumbs->parent('adminFront');
    $breadcrumbs->push('SMM Recruited', route('countrySMMRecruited'));
});
Breadcrumbs::register('ProductRegistered', function ($breadcrumbs) {
    $breadcrumbs->parent('adminFront');
    $breadcrumbs->push('Product Registered', route('countryProductRegistered'));
});
Breadcrumbs::register('BuyerRegistered', function ($breadcrumbs) {
    $breadcrumbs->parent('adminFront');
    $breadcrumbs->push('Buyer Registered', route('countryBuyerRegistered'));
});
Breadcrumbs::register('Merchant', function ($breadcrumbs) {
    $breadcrumbs->parent('adminFront');
    $breadcrumbs->push('Merchants', route('countryMerchant'));
});

Breadcrumbs::register('routeAdminGeneral', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Admin', route('admin'));
    $breadcrumbs->push('General', route('routeAdminGeneral'));
});

Breadcrumbs::register('Employees', function ($breadcrumbs) {
    $breadcrumbs->parent('routeAdminGeneral');
    $breadcrumbs->push('Employees', route('routeEmployee'));
});

Breadcrumbs::register('SalesStaff', function ($breadcrumbs) {
    $breadcrumbs->parent('routeAdminGeneral');
    $breadcrumbs->push('Sales Staff', route('routeSalesStaff'));
});

Breadcrumbs::register('Occupations', function ($breadcrumbs) {
    $breadcrumbs->parent('routeAdminGeneral');
    $breadcrumbs->push('Occupation', route('routeOccupation'));
});

Breadcrumbs::register('Globals', function ($breadcrumbs) {
    $breadcrumbs->parent('routeAdminGeneral');
    $breadcrumbs->push('Globals', route('routeGlobal'));
});

Breadcrumbs::register('mcReport', function ($breadcrumbs) {
    $breadcrumbs->parent('routeAdminGeneral');
    $breadcrumbs->push('MC Report', route('mcReport'));
});

Breadcrumbs::register('mpReport', function ($breadcrumbs) {
    $breadcrumbs->parent('routeAdminGeneral');
    $breadcrumbs->push('MP Report', route('mpReport'));
});

Breadcrumbs::register('pusherReport', function ($breadcrumbs) {
    $breadcrumbs->parent('routeAdminGeneral');
    $breadcrumbs->push('Pusher Report', route('pusherReport'));
});

Breadcrumbs::register('BuyerMgmt', function ($breadcrumbs) {
        $breadcrumbs->parent('tableManagement');
    $breadcrumbs->push('Buyer Management', route('BuyerMgmt'));
});
