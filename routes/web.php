<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use App\Models\Community;
use App\Http\Controllers\DataController;



$activeSite =\DB::table('site_configurations')->where('status',1)->first();

$appName = 'Databroker';
$appSlogan = 'The marketplace for data';
if($activeSite) {
	if(!empty($activeSite->app_name)){
		$appName = $activeSite->app_name;
	}
	if(!empty($activeSite->app_name)){
		$appSlogan = $activeSite->app_slogan;
	}
}

define('APPLICATION_NAME', $appName);
define('APPLICATION_SLOGAN', $appSlogan);


Route::get('/styleguide', function () {
    return view('styleguide');
});
Route::get('/createWalletForAllUsers', 'Controller@createWalletForAllUsers')->name('createWalletForAllUsers');

Route::group(['middleware' => ['ReturnAfterAuthentication']], function(){
	Route::group(['middleware' => ['auth', 'is_user_active']], function(){
		Route::get('/profile', 'ProfileController@index')->name('account.profile');
		Route::get('/profile/download', 'ProfileController@downloadFiles')->name('account.profile.download');
		Route::get('/myaccount', 'ProfileController@myaccount')->name('account.myaccount');

		Route::get('/profile/company', 'ProfileController@company')->name('account.company');
		

		Route::post('/profile/company', 'ProfileController@update_company')->name('account.company.update');
		Route::post('/profile', 'ProfileController@update')->name('account.profile.update');	
		Route::get('/profile/purchases', 'ProfileController@purchases')->name('account.purchases');	
		Route::get('/profile/purchases/{pid}', 'ProfileController@purchases_detail')->where('pid', '[0-9]+')->name('account.purchases_detail');	
		Route::get('/wallet', 'ProfileController@wallet')->name('account.wallet');	
		Route::get('/profile/sales', 'ProfileController@sales')->name('account.sales');	
		Route::get('/profile/sales/{sid}', 'ProfileController@sales_detail')->where('sid', '[0-9]+')->name('account.sales_detail');	
		Route::get('/profile/sales/redeem/{sid}/{from?}', 'ProfileController@sales_redeem')->where('sid', '[0-9]+')->name('account.sales_redeem');	
		Route::post('/user/delete', 'ProfileController@delete')->name('account.delete');	
		Route::post('/invite', 'ProfileController@invite_user')->name('account.invite_user');

		//auto redeem sales 		
		Route::get('/auto_redeed_deals', 'HomeController@auto_redeed_deals')->name('account.auto_redeed_deals');
		// add buyer feedback to sale		
		Route::post('/update-sale-feedback', 'ProfileController@updateSaleFeedBack')->name('account.update_sale_feedback');
		
		//share free acces for testing 
		Route::post('/invite_user_for_free_access', 'ProfileController@invite_user_for_free_access')->name('account.invite_user_for_free_access');		
		Route::get('/access_free_data/{token}', 'DataController@access_free_data')->name('profile.access_free_data');
		Route::post('/data/get/free_access_review/{id}/{pid}', 'DataController@take_access_free_data')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('account.take_access_free_data');
		Route::get('/data/get/free_access_success/{purIdx}', 'DataController@get_free_access_success')->where('purIdx', '[0-9]+')->name('data.get_free_access_success');

		
		//private share routes 
		Route::get('/profile/myprivatedatanetwork', 'ProfileController@my_private_data_network')->name('my_private_data_network');
		Route::post('/profile/add_org', 'ProfileController@add_sharing_organisation')->name('add_org');
		Route::post('/profile/edit_org', 'ProfileController@update_sharing_organisation')->name('edit_org');
		Route::post('/profile/delete_org', 'ProfileController@delete_sharing_organisation')->name('delete_org');
		Route::post('/profile/add_org_user', 'ProfileController@add_user_to_organisation')->name('add_org_user');
		Route::post('/profile/edit_org_user', 'ProfileController@edit_user_to_organisation')->name('edit_org_user');
		Route::post('/profile/delete_org_user', 'ProfileController@delete_org_user')->name('delete_org_user');
		Route::post('/profile/resend_org_user_invite', 'ProfileController@resend_org_user_invite')->name('resend_org_user_invite');
		Route::get('/profile/get_organizations', 'ProfileController@get_organizations')->name('get_organizations');
		
		Route::get('/profile/my_data_providers', 'ProfileController@get_my_data_providers')->name('my_data_providers');
		Route::post('/profile/invite_users_to_data_product', 'ProfileController@invite_users_to_data_product')->name('invite_users_to_data_product');
		//comment to enable verification link
		Route::get('/data/offers/overview', 'DataController@offers_overview')->name('data_offers_overview')->middleware('verified');			
		Route::get('/data/offers/{id}', 'DataController@offer_detail')->where('id', '[0-9]+')->name('data_offer_detail');
		Route::get('/data/offers/{id}/confirmation', 'DataController@offer_publish_confirm')->where('id', '[0-9]+')->name('data_offer_publish_confirm');
		Route::get('/data/offers/{id}/edit', 'DataController@offer_edit')->where('id', '[0-9]+')->name('data_offer_edit');
		Route::post('/data/offers/{id}/update', 'DataController@update_offer')->where('id', '[0-9]+')->name('data.update_offer');
		Route::get('/data/offers/{id}/confirm-update', 'DataController@offer_update_confirm')->where('id', '[0-9]+')->name('data_offer_update_confirm');
		
		Route::post('/data/offers/get_data_products', 'DataController@get_data_products')->name('get_data_products');
		Route::post('/data/offers/share_data_proucts', 'DataController@share_data_proucts')->name('share_data_proucts');
		
		Route::get('/data/offers/{id}/product/add', 'DataController@offer_add_product')->where('id', '[0-9]+')->name('data_offer_add_product');
		Route::get('/data/offers/{id}/product/{pid}/edit', 'DataController@offer_edit_product')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data_offer_edit_product');
		Route::post('/data/product/add', 'DataController@offer_submit_product')->name('data_offer_submit_product');
		Route::get('/data/offers/{id}/product/{pid}/confirmation', 'DataController@offer_product_publish_confirm')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data_offer_product_publish_confirm');
		Route::get('/data/offers/{id}/product/{pid}/confirm-update', 'DataController@offer_product_update_confirm')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data_offer_product_update_confirm');
		Route::get('/data/offers/{id}/confirmation', 'DataController@offer_publish_confirm')->where('id', '[0-9]+')->name('data_offer_publish_confirm');
		Route::get('/data/offers/{id}/confirm-update', 'DataController@offer_update_confirm')->where('id', '[0-9]+')->name('data_offer_update_confirm');
		Route::get('/data/bid/{id}/{pid}/{ppmid?}', 'DataController@bid')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data.bid');
		Route::post('/data/bid/{id}/{pid}', 'DataController@send_bid')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data.send_bid');
		Route::get('/data/bid/update/{bid}', 'DataController@edit_bid')->where('bid', '[0-9]+')->name('data.edit_bid');
		Route::post('/data/bid/update/{bid}', 'DataController@update_bid')->where('bid', '[0-9]+')->name('data.update_bid');
		Route::get('/data/bid/success/{id}/{pid}', 'DataController@send_bid_success')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data.send_bid_success');
		Route::get('/data/bid/respond/{bid}', 'DataController@bid_respond')->where('bid', '[0-9]+')->where('pid', '[0-9]+')->name('data.bid_respond');
		Route::post('/data/bid/respond/{bid}', 'DataController@send_bid_response')->where('bid', '[0-9]+')->where('pid', '[0-9]+')->name('data.bid_send_response');
		Route::get('/data/buy/{id}/{pid}/{expiredate?}/{ppmid?}', 'DataController@buy_data')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data.buy_data');		
		Route::post('/data/buy/{id}/{pid}', 'DataController@pay_data')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data.pay_data');
		Route::get('/data/buy/success/{purIdx}', 'DataController@pay_success')->where('purIdx', '[0-9]+')->name('data.pay_success');
		Route::post('/data/product/map_data_with_dxc', 'DataController@map_data_with_dxc')->name('map_data_with_dxc');

		Route::get('/data/get/review/{id}/{pid}/{expiredate?}/{ppmid?}', 'DataController@get_data')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data.get_data');
		Route::post('/data/get/review/{id}/{pid}', 'DataController@take_data')->where('id', '[0-9]+')->where('pid', '[0-9]+')->name('data.take_data');
		Route::get('/data/get/success/{purIdx}', 'DataController@get_success')->where('purIdx', '[0-9]+')->name('data.get_success');

		Route::get('/data/stream/configure/{purIdx}', 'DataController@configure_stream')->where('purIdx', '[0-9]+')->name('data.configure_stream');
		Route::post('/data/stream/save', 'DataController@save_stream')->name('data.save_stream');
		Route::get('/data/stream/save/success', 'DataController@save_stream_success')->name('data.save_stream_success');
		
		Route::post('/data/add', 'DataController@add_offer')->name('data.add_offer');
		Route::post('/data/update-status', 'DataController@data_update_status')->name('data.update_status');
		Route::post('/data/share_offer', 'DataController@share_offer')->name('data.share_offer');			
		Route::post('/data/remove_access_to_offer', 'DataController@remove_access_to_offer')->name('data.remove_access_to_offer');
		Route::post('/data/delete', 'DataController@delete_offer')->name('data.delete_offer');
		Route::post('/data/duplicate-offer', 'DataController@duplicate_offer')->name('data.duplicate_offer');


		Route::get('/buyer/bids', 'ProfileController@buyer_bids')->name('profile.buyer_bids');
		Route::get('/seller/bids', 'ProfileController@seller_bids')->name('profile.seller_bids');

		Route::get('/dxc', 'DXCController@index')->name('dxc.data_exchange_controller');
		Route::get('/dxc/updateApiKey/{address}', 'DXCController@update_apiKey')->name('dxc.update_apiKey');
		Route::post('/dxc/updateDxcStatus', 'DXCController@update_dxc_status')->name('dxc.update_dxc_status');
	});

	Route::get('/', 'HomeController@index')->name('home');
	
	Route::get('/wyre', 'HomeController@wyrePayment')->name('account.wyre');	
	Route::post('/wyrepayment', 'HomeController@wyreMakePayment')->name('account.wyre.makepayment');

	Route::get('/generateslugurl', 'HomeController@generateSlugURL');

	//Transak Payment routes
	Route::get('/transak-popup', 'PaymentController@transakPayment')->name('account.transak-popup');	
	Route::get('/transak', 'PaymentController@index')->name('account.transak');
	Route::get('/transak-success', 'PaymentController@transakSuccess')->name('account.transak.success');

	Route::post('/offer/filter', 'DataController@filter_offer')->name('data.filter_offer');	

	Route::get('/offer/{slug}', 'DataController@Offerdetail')->name('Offerdetail');
	Route::get('/offers/{companyName}/{param}', 'DataController@details')->name('data_details');
	Route::get('/offers_by_id/{id}', 'DataController@details_by_id')->where('id', '[0-9]+')->name('offer_detail_by_id');
	Route::post('/offers/{companyName}/{param}', 'DataController@details')->name('data_details');
	Route::get('/offersdetails/{offerIdx}', 'DataController@offerDetailsById')->name('offersdetails');
	Route::get('/{community}/theme/{theme}', 'DataController@offer_theme_filter')->name('data.offer_theme_filter');
	Route::get('/offers/{companyName}', 'DataController@company_offers')->name('data.company_offers');
	Route::get('/{community}/region/{regionName}', 'DataController@offer_region_filter')->name('data.offer_region_filter');
	Route::get('/getAllThemes', 'DataController@get_all_themes')->name('data.get_all_themes');

	Route::get('/data/send_message/{id}', 'DataController@send_message')->name('data.send_message');	
	Route::post('/data/send_message', 'DataController@post_send_message')->name('data.post_send_message');
	Route::get('/data/send_message_success/{id}', 'DataController@send_message_success')->name('data.send_message_success');	
	
	Route::get('/data/publish', 'DataController@offer_publish')->name('data_offer_publish');
	Route::get('/data/start', 'DataController@offer_start')->name('data_offer_start');
	Route::get('/data/second', 'DataController@offer_second')->name('data_offer_second');
	Route::get('/data/provider', 'DataController@offer_provider')->name('data_offer_provider');

	Route::post('/data/provider', 'DataController@save_offer_provider')->name('save_data_offer_provider');

	Route::get('/data/offers', 'DataController@offers')->name('data_offers');		//should rename as publish	
	Route::get('/data/checkOfferExpiration', 'DataController@alet_users_on_offer_expiration')->name('alet_users_on_offer_expiration');		//alert users on offer expiration	

	Route::get('/about', 'AboutController@index')->name('about.about');  
	Route::get('/terms_conditions', 'AboutController@terms_conditions')->name('about.terms_conditions');   
	Route::get('/privacy_policy', 'AboutController@privacy_policy')->name('about.privacy_policy');   
	Route::get('/cookie_policy', 'AboutController@cookie_policy')->name('about.cookie_policy');    
	Route::get('/contact', 'AboutController@contact')->name('contact'); 
	Route::post('/contact', 'AboutController@send')->name('contact.send');       
	Route::get('/contact_pass', 'AboutController@contact_pass')->name('contact_pass');

	

	Route::get('/contact-commercial-team', 'ProfileController@contact_commercial_team')->name('contact_commercial_team'); 
	Route::post('/contact-commercial-team', 'ProfileController@contact_commercial_send')->name('contact.contact_commercial_send');  


	Route::get('/about/matchmaking', 'AboutController@matchmaking')->name('about.matchmaking'); 
	Route::get('about/matchmeup', 'AboutController@matchmeup')->name('matchmeup'); 
	
	Route::get('/about/media-center', 'AboutController@media_center')->name('about.media_center'); 
	Route::get('/about/partners', 'AboutController@partners')->name('about.partners');    
	Route::get('/about/use-cases', 'AboutController@usecase')->name('about.usecase'); 
	Route::get('/about/updates', 'AboutController@news')->name('about.news');
	Route::post('/about/updates/updates_loadmore', 'AboutController@updates_loadmore')->name('about.updates_loadmore');
	Route::post('/about/updates/filter_updates', 'AboutController@filter_updates')->name('about.filter_updates');
	
	Route::post('/about/usecases/usecases_loadmore', 'AboutController@usecases_loadmore')->name('about.usecases_loadmore');
	Route::post('/about/usecases/filter_usecases', 'AboutController@filter_usecases')->name('about.filter_usecases');
	
	
	
	Route::get('/help', 'HelpController@index')->name('help.overview');    	
	Route::get('/help/buying-data', 'HelpController@buying_data')->name('help.buying_data'); 
	Route::get('/help/buying-data/topic/{title}', 'HelpController@buying_data_topic')->name('help.buying_data_topic');
	Route::get('/help/selling-data', 'HelpController@selling_data')->name('help.selling_data');  
	Route::get('/help/selling-data/topic/{title}', 'HelpController@selling_data_topic')->name('help.selling_data_topic');
	Route::get('/help/guarantee', 'HelpController@guarantee')->name('help.guarantee'); 
	Route::get('/help/file_complaint', 'HelpController@file_complaint')->name('help.file_complaint');
	Route::get('/help/file_complaint/send', 'HelpController@send_file_complaint')->name('help.send_file_complaint');
	Route::post('/help/file_complaint/send', 'HelpController@post_send_file_complaint')->name('help.post_send_file_complaint');
	Route::get('/help/feedback', 'HelpController@feedback')->name('help.feedback');

	Route::get('/verify-email-reminder', 'HomeController@verify_email_reminder')->name('verify_email_reminder'); 
	
	Route::get('/documentation/dxc', 'AboutController@dxc_documentation')->name('help.dxc_documentation');   
	
	Route::get('/oldprodctpricemappindg', 'HelpController@oldProductPricePeriodMapping')->name('hele.mapoldproductprice');

	Route::get('/download/data-toolkit', 'AboutController@download')->name('download.data-toolkit');
	Route::get('/about/usecase/{title}', 'AboutController@usecase_detail')->name('about.usecase_detail');
	Route::get('/about/updates/{title}', 'AboutController@news_detail')->name('about.news_detail');

	//content pages routes
	Route::get('/oldprodctpricemappindg', 'HelpController@oldProductPricePeriodMapping')->name('hele.mapoldproductprice');
	//content pages routes
	Route::get('/content/smart-cities', 'AboutController@smart_cities')->name('content.smart_cities');
	Route::get('/content/iot-platforms', 'AboutController@iot_platforms')->name('content.iot_platforms');
	Route::get('/content/white-paper', 'AboutController@smart_white_paper')->name('content.white_paper');
	Route::get('/content/smart-cities-survey-report', 'AboutController@smart_cities_survey_report')->name('content.smart_cities_survey_report');
	Route::get('/content/value-of-data', 'AboutController@value_of_data')->name('content.value_of_data');
	Route::get('/content/contact', 'AboutController@content_contacts')->name('content.content_contacts');
	Route::get('/content/satellite-data-for-agriculture', 'AboutController@satelliteDataForAgriculture')->name('content.satellite_data_for_agriculture');
	//content pages routes

	Route::group(['middleware' => ['guest_auth']], function(){
		Route::get('/admin/login', "AdminController@login")->name('admin.login');
		Route::post('/admin/login', "AdminController@check_login")->name('admin.check_login');
	});

	Route::group(['middleware' => ['admin_auth']], function(){
		Route::get('/admin/logout', "AdminController@logout")->name('admin.logout');
		//admin route usecase	

		Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
		Route::get('/admin/howtouse', 'AdminController@howtouse')->name('admin.howtouse');
		Route::get('/admin/usecases/{id}', 'AdminController@usecases')->where('id', '[0-9]+')->name('admin.usecases');
		Route::get('/admin/usecases/add_new/{id}', 'AdminController@usecases_add_new')->where('id', '[0-9]+')->name('admin.usecases.add_new');
		Route::post('/admin/usecases/update', 'AdminController@usecases_update')->name('admin.usecases.update');
		Route::post('/admin/usecases/publish', 'AdminController@usecases_publish')->name('admin.usecases_publish');
		Route::post('/admin/usecases/upload_attach/{articleIdx}', 'AdminController@usecases_upload_attach')->name('admin.usecases_upload_attach');
		Route::get('/admin/usecases/edit/{id}/{redirectfrom?}', 'AdminController@usecases_edit')->where('id', '[0-9]+')->name('admin.usecases_edit');
		Route::post('/admin/usecases/delete/{id}', 'AdminController@usecases_delete')->where('id', '[0-9]+')->name('admin.usecases_delete');
		Route::post('/admin/usecases/summernote/upload_attach', 'AdminController@usecases_summernote_upload')->name('admin.usecases.summernote_upload');

		Route::post('/admin/image-upload', 'AdminController@imageUpload')->name('admin.imageUpload');
		Route::get('/admin/image-browse', 'AdminController@browseImages')->name('admin.browseImages');
		//admin route media
		Route::get('/admin/media_library/{mode}', 'AdminController@media_library')->name('admin.media_library');
		Route::get('/admin/media/add_new/{mode}', 'AdminController@add_media')->name('admin.add_media');
		Route::get('/admin/media/edit/{mid}/{mode}', 'AdminController@edit_media')->where('mid', '[0-9]+')->name('admin.edit_media');
		Route::post('/admin/media/delete/{mid}', 'AdminController@delete_media')->where('mid', '[0-9]+')->name('admin.delete_media');
		Route::post('/admin/media/update', 'AdminController@media_update')->name('admin.media_update');
		Route::post('/admin/media/upload_attach/{id}', 'AdminController@media_upload_attach')->name('admin.media_upload_attach');

		//admin route updates
		Route::get('/admin/updates', 'AdminController@updates')->name('admin.updates');
		Route::get('/admin/updates/add_new', 'AdminController@updates_add_new')->name('admin.updates_add_new');
		Route::post('/admin/updates/update', 'AdminController@updates_update')->name('admin.updates_update');
		Route::post('/admin/updates/publish', 'AdminController@updates_publish')->name('admin.updates_publish');
		Route::get('/admin/updates/edit/{id}', 'AdminController@updates_edit')->where('id', '[0-9]+')->name('admin.updates_edit');
		Route::post('/admin/updates/delete/{id}', 'AdminController@updates_delete')->where('id', '[0-9]+')->name('admin.updates_delete');
		Route::post('/admin/updates/summernote/upload_attach', 'AdminController@updates_summernote_upload')->name('admin.updates.summernote_upload');

		Route::get('/admin',  "AdminController@index")->name('admin.index');
		Route::get('/admin/home', 'AdminController@home')->name('admin.home');
		Route::get('/admin/home_featured_data', 'AdminController@home_featured_data')->name('admin.home_featured_data');
		Route::post('/admin/home_featured_data/upload_attach/{id}', 'AdminController@home_featured_data_upload_attach');
		Route::post('/admin/home_featured_data/upload_logo/{id}', 'AdminController@home_featured_data_upload_logo');
		Route::get('/admin/home_featured_data/edit', 'AdminController@home_featured_data_edit')->name('admin.home_featured_data_edit');
		Route::post('/admin/home_featured_data/update', 'AdminController@home_featured_data_update')->name('admin.home_featured_data_update');
		Route::post('/admin/home_featured_data/publish', 'AdminController@home_featured_data_publish')->name('admin.home_featured_data_publish');
		Route::get('/admin/home_trending', 'AdminController@home_trending')->name('admin.home_trending');
		Route::post('/admin/home_trending/upload_attach/{id}', 'AdminController@home_trending_upload_attach')->name('admin.home_trending_upload_attach');
		Route::get('/admin/home_trending/edit/{id}', 'AdminController@home_trending_edit')->where('id', '[0-9]+')->name('admin.home_trending_edit');
		Route::post('/admin/home_trending/publish', 'AdminController@home_trending_publish')->name('admin.home_trending_publish');
		Route::get('/admin/home_trending/add_new', 'AdminController@home_trending_edit')->name('admin.home_trending_add_new');
		Route::post('/admin/home_trending/update', 'AdminController@home_trending_update')->name('admin.home_trending_update');
		Route::get('/admin/home_marketplace', 'AdminController@home_marketplace')->name('admin.home_marketplace');
		Route::get('/admin/home_marketplace/add_new', 'AdminController@home_marketplace_edit')->name('admin.home_marketplace_add_new');
		Route::post('/admin/home_marketplace/update', 'AdminController@home_marketplace_update')->name('admin.home_marketplace_update');
		Route::get('/admin/home_marketplace/edit/{id}', 'AdminController@home_marketplace_edit')->where('id', '[0-9]+')->name('admin.home_marketplace_edit');
		Route::post('/admin/home_marketplace/upload_attach/{id}', 'AdminController@home_marketplace_upload_attach')->name('admin.home_marketplace_upload_attach');
		Route::post('/admin/home_marketplace/upload_logo/{id}', 'AdminController@home_marketplace_upload_logo')->name('admin.home_marketplace_upload_logo');
		Route::post('/admin/home_marketplace/publish', 'AdminController@home_marketplace_publish')->name('admin.home_marketplace_publish');
		Route::get('/admin/home_teampicks', 'AdminController@home_teampicks')->name('admin.home_teampicks');
		Route::get('/admin/home_teampicks/edit/{id}', 'AdminController@home_teampicks_edit')->where('id', '[0-9]+')->name('admin.home_teampicks_edit');
		Route::post('/admin/home_teampicks/update', 'AdminController@home_teampicks_update')->name('admin.home_teampicks_update');
		Route::get('/admin/home_teampicks/add_new', 'AdminController@home_teampicks_edit')->name('admin.home_teampicks_add_new');
		Route::post('/admin/home_teampicks/upload_logo/{id}', 'AdminController@home_teampicks_upload_logo')->name('admin.home_teampicks_upload_logo');
		Route::post('/admin/home_teampicks/upload_attach/{id}', 'AdminController@home_teampicks_upload_attach')->name('admin.home_teampicks_upload_attach');
		Route::post('/admin/home_teampicks/publish', 'AdminController@home_teampicks_publish')->name('admin.home_teampicks_publish');
		Route::get('/admin/home_featured_provider', 'AdminController@home_featured_provider')->name('admin.home_featured_provider');
		Route::get('/admin/home-top-use-cases', 'AdminController@homeTopUseCases')->name('admin.top_use_cases');
		Route::post('/admin/usecases/promote', 'AdminController@promoteArticle')->name('admin.promote_article');
		Route::get('/admin/home_featured_provider/add_new', 'AdminController@home_featured_provider_edit')->name('admin.home_featured_provider_add_new');
		Route::get('/admin/home_featured_provider/edit/{id}', 'AdminController@home_featured_provider_edit')->where('id', '[0-9]+')->name('admin.home_featured_provider_edit');
		Route::post('/admin/home_featured_provider/delete/{id}', 'AdminController@home_featured_provider_delete')->where('id', '[0-9]+')->name('admin.home_featured_provider_delete');
		Route::post('/admin/home_featured_provider/update', 'AdminController@home_featured_provider_update')->name('admin.home_featured_provider_update');
		Route::post('/admin/home_featured_provider/publish', 'AdminController@home_featured_provider_publish')->name('admin.home_featured_provider_publish');

		Route::get('/admin/preview/home/{url}/{model}', 'AdminController@preview_home')->name('admin.preview_home');
		Route::get('/admin/preview_check/{url}/{model}/{check}', 'AdminController@preview_check')->name('admin.preview_check');

		Route::get('/admin/help/buying_data', 'AdminController@help_buying_data')->name('admin.help.buying_data');
		Route::post('/admin/help/buying_data/update', 'AdminController@update_help_buying_data')->name('admin.help.update_buying_data');
		Route::get('/admin/help/buying_data/faqs', 'AdminController@help_buying_faqs')->name('admin.help.buying_data_faqs');
		Route::get('/admin/help/buying_data/faq/add_new', 'AdminController@edit_help_buying_faq')->name('admin.help.add_buying_faq');	
		Route::get('/admin/help/buying_data/faq/edit/{fid}', 'AdminController@edit_help_buying_faq')->where('fid', '[0-9]+')->name('admin.help.edit_buying_faq');
		Route::post('/admin/help/buying_data/faq/update', 'AdminController@update_help_buying_faq')->name('admin.help.update_buying_faq');	
		Route::get('/admin/help/buying_data/faq/delete/{fid}', 'AdminController@delete_help_buying_faq')->name('admin.help.delete_buying_faq');	
		Route::get('/admin/help/buying_data/topics', 'AdminController@help_buying_data_topics')->name('admin.help.buying_data_topics');
		Route::get('/admin/help/buying_data/topic/add_new', 'AdminController@edit_help_buying_data_topic')->name('admin.help.add_buying_data_topic');
		Route::get('/admin/help/buying_data/topic/edit/{tid}', 'AdminController@edit_help_buying_data_topic')->where('tid', '[0-9]+')->name('admin.help.edit_buying_data_topic');
		Route::get('/admin/help/buying_data/topic/delete/{tid}', 'AdminController@delete_help_buying_data_topic')->where('tid', '[0-9]+')->name('admin.help.delete_buying_data_topic');
		Route::post('/admin/help/buying_data/topic/update', 'AdminController@update_help_buying_data_topic')->name('admin.help.update_buying_data_topic');
		Route::post('/admin/help/buying_data/topic/publish', 'AdminController@publish_help_buying_data_topic')->name('admin.help.publish_buying_data_topic');

		Route::get('/admin/help/selling_data', 'AdminController@help_selling_data')->name('admin.help.selling_data');
		Route::post('/admin/help/selling_data/update', 'AdminController@update_help_selling_data')->name('admin.help.update_selling_data');
		Route::get('/admin/help/selling_data/faqs', 'AdminController@help_selling_faqs')->name('admin.help.selling_data_faqs');
		Route::get('/admin/help/selling_data/faq/add_new', 'AdminController@edit_help_selling_faq')->name('admin.help.add_selling_faq');	
		Route::get('/admin/help/selling_data/faq/edit/{fid}', 'AdminController@edit_help_selling_faq')->where('fid', '[0-9]+')->name('admin.help.edit_selling_faq');
		Route::post('/admin/help/selling_data/faq/update', 'AdminController@update_help_selling_faq')->name('admin.help.update_selling_faq');	
		Route::get('/admin/help/selling_data/faq/delete/{fid}', 'AdminController@delete_help_selling_faq')->name('admin.help.delete_selling_faq');	
		Route::get('/admin/help/selling_data/topics', 'AdminController@help_selling_data_topics')->name('admin.help.selling_data_topics');
		Route::get('/admin/help/selling_data/topic/add_new', 'AdminController@edit_help_selling_data_topic')->name('admin.help.add_selling_data_topic');
		Route::get('/admin/help/selling_data/topic/edit/{tid}', 'AdminController@edit_help_selling_data_topic')->where('tid', '[0-9]+')->name('admin.help.edit_selling_data_topic');
		Route::get('/admin/help/selling_data/topic/delete/{tid}', 'AdminController@delete_help_selling_data_topic')->where('tid', '[0-9]+')->name('admin.help.delete_selling_data_topic');
		Route::post('/admin/help/selling_data/topic/update', 'AdminController@update_help_selling_data_topic')->name('admin.help.update_selling_data_topic');
		Route::post('/admin/help/selling_data/topic/publish', 'AdminController@publish_help_selling_data_topic')->name('admin.help.publish_selling_data_topic');

		Route::get('/admin/help/faqs', 'AdminController@help_faqs')->name('admin.help.faqs');		
		Route::get('/admin/help/faqs/add_new', 'AdminController@edit_help_faq')->name('admin.help.add_faq');	
		Route::get('/admin/help/faqs/edit/{fid}', 'AdminController@edit_help_faq')->where('fid', '[0-9]+')->name('admin.help.edit_faq');
		Route::get('/admin/help/faqs/update', 'AdminController@update_help_faq')->name('admin.help.update_faq');	
		Route::post('/admin/help/faqs/delete/{fid}', 'AdminController@delete_help_faq')->name('admin.help.delete_faq');	


		Route::get('/admin/help/guarantees', 'AdminController@help_guarantees')->name('admin.help.guarantee');
		Route::get('/admin/help/guarantees/add_new', 'AdminController@edit_help_guarantee')->name('admin.help.add_guarantee');
		Route::get('/admin/help/guarantees/edit/{tid}', 'AdminController@edit_help_guarantee')->where('tid', '[0-9]+')->name('admin.help.edit_guarantee');
		Route::get('/admin/help/guarantees/delete/{tid}', 'AdminController@delete_help_guarantee')->where('tid', '[0-9]+')->name('admin.help.delete_guarantee');
		Route::post('/admin/help/guarantees/update', 'AdminController@update_help_guarantee')->where('tid', '[0-9]+')->name('admin.help.update_guarantee');

		Route::get('/admin/help/complaints', 'AdminController@help_complaints')->name('admin.help.complaint');
		Route::get('/admin/help/complaints/add_new', 'AdminController@edit_help_complaint')->name('admin.help.add_complaint');
		Route::get('/admin/help/complaints/edit/{tid}', 'AdminController@edit_help_complaint')->where('tid', '[0-9]+')->name('admin.help.edit_complaint');
		Route::get('/admin/help/complaints/delete/{tid}', 'AdminController@delete_help_complaint')->where('tid', '[0-9]+')->name('admin.help.delete_complaint');
		Route::post('/admin/help/complaints/update', 'AdminController@update_help_complaint')->where('tid', '[0-9]+')->name('admin.help.update_complaint');

		Route::get('/admin/help/feedbacks', 'AdminController@help_feedbacks')->name('admin.help.feedback');	
		Route::get('/admin/help/feedbacks/add_new', 'AdminController@edit_help_feedback')->name('admin.help.add_feedback');
		Route::get('/admin/help/feedbacks/edit/{tid}', 'AdminController@edit_help_feedback')->where('tid', '[0-9]+')->name('admin.help.edit_feedback');
		Route::get('/admin/help/feedbacks/delete/{tid}', 'AdminController@delete_help_feedback')->where('tid', '[0-9]+')->name('admin.help.delete_feedback');
		Route::post('/admin/help/feedbacks/update', 'AdminController@update_help_feedback')->where('tid', '[0-9]+')->name('admin.help.update_feedback');	
		//compress Images
		Route::get('/admin/compress_images', 'AdminController@compress_images')->name('admin.compress_images');

		Route::get('/admin/users', 'AdminController@users')->name('admin.users');
		Route::get('/admin/company_users/{adminUserIdx}', 'AdminController@company_users')->where('adminUserIdx', '[0-9]+')->name('admin.company_users');
		Route::get('/admin/users/edit/{userIdx}', 'AdminController@edit_user')->name('admin.edit_user');
		Route::post('/admin/users/update', 'AdminController@update_user')->name('admin.update_user');
		Route::get('/admin/users/delete/{userIdx}', 'AdminController@delete_user')->name('admin.delete_user');
		Route::get('/admin/users/export', 'AdminController@exportUser')->name('admin.users.export');
		Route::post('/admin/users/publish', 'AdminController@userPublish')->name('admin.users.publish');

		//admin route offers
		Route::get('/admin/offers', 'AdminController@getOffers')->name('admin.offers');
		Route::get('/admin/offers/edit/{mid}', 'AdminController@editOffer')->where('mid', '[0-9]+')->name('admin.edit.offers');
		Route::post('/admin/offers/delete/{mid}', 'AdminController@deleteOffer')->where('mid', '[0-9]+')->name('admin.delete.offer');
		Route::post('/admin/offer/update', 'AdminController@offerUpdate')->name('admin.offer.update');
		Route::post('/admin/offers/publish', 'AdminController@Offerpublish')->name('admin.offer_publish');
		Route::get('/admin/offers/export', 'AdminController@exportOffers')->name('admin.offers.export');
		Route::get('/admin/offers/{companyName}/{param}', 'AdminController@details')->name('admin_data_details');

		//admin route products
		Route::get('/admin/products', 'AdminController@getProducts')->name('admin.products');
		Route::get('/admin/products/edit/{pid}', 'AdminController@editProduct')->where('pid', '[0-9]+')->name('admin.edit.products');
		Route::post('/admin/products/update', 'AdminController@productUpdate')->name('admin.products.update');
		Route::get('/admin/products/view/{pid}', 'AdminController@productdetails')->name('admin.products.view');
		Route::post('/admin/products/delete/{pid}', 'AdminController@deleteProduct')->where('mid', '[0-9]+')->name('admin.products.offer');

		//admin route contents
		Route::get('/admin/contents', 'AdminController@getContents')->name('admin.contents');
		Route::get('/admin/contents/add', 'AdminController@addContents')->name('admin.add.contents');
		Route::post('/admin/contents/insert', 'AdminController@contentInsert')->name('admin.contents.insert');
		Route::get('/admin/contents/edit/{cid}', 'AdminController@editContents')->where('pid', '[0-9]+')->name('admin.edit.contents');
		Route::post('/admin/contents/update', 'AdminController@contentUpdate')->name('admin.contents.update');		

		// admin communities

		Route::get('/admin/communities', 'CommunityController@list')->name('admin.communities');
		Route::get('/admin/communities/add', 'CommunityController@add')->name('admin.communities.add');
		Route::get('/admin/communities/edit/{id}', 'CommunityController@edit')->name('admin.communities.edit');
		Route::post('/admin/communities/delete/{id}', 'CommunityController@delete')->name('admin.communities.delete');
		Route::post('/admin/communities/update', 'CommunityController@update')->name('admin.communities.update');
		Route::post('/admin/communities/publish', 'CommunityController@publish')->name('admin.communities.publish');

		//admin new in the community routes
		Route::get('/admin/community/offers/{id}', 'CommunityController@getCommunityOffers')->name('admin.community.offers.get');
		Route::get('/admin/community/data/new', 'CommunityController@newDataToCommunity')->name('admin.community.data.new');
		Route::get('/admin/community/data/new/add', 'CommunityController@addNewDataOfferToCommunity')->name('admin.community.data.new.add');
		Route::post('/admin/community/data/new/update', 'CommunityController@updateNewDataofCommunity')->name('admin.community.data.new.update');
		Route::get('/admin/community/data/new/edit/{id}', 'CommunityController@editNewDataOfferToCommunity')->name('admin.community.data.new.edit');
		Route::post('/admin/community/data/new/delete/{id}', 'CommunityController@deleteNewDataOfferToCommunity')->name('admin.community.data.new.delete');

		//admin discover data in the community routes
		Route::get('/admin/community/data/discover', 'CommunityController@discoverDataOfCommunity')->name('admin.community.data.discover');
		Route::get('/admin/community/data/discover/add', 'CommunityController@addDiscoverDataToCommunity')->name('admin.community.data.discover.add');
		Route::post('/admin/community/data/discover/update', 'CommunityController@updateDiscoverDataToCommunity')->name('admin.community.data.discover.update');
		Route::get('/admin/community/data/discover/edit/{id}', 'CommunityController@editDiscoverDataToCommunity')->name('admin.community.data.discover.edit');
		Route::post('/admin/community/data/discover/delete/{id}', 'CommunityController@deleteDiscoverDataToCommunity')->name('admin.community.data.discover.delete');

		// admin providers

		Route::get('/admin/providers', 'ProvidersController@list')->name('admin.providers');
		
		Route::get('/admin/providers/edit/{id}', 'ProvidersController@edit')->name('admin.providers.edit');
		Route::post('/admin/providers/delete/{id}', 'ProvidersController@delete')->name('admin.providers.delete');
		Route::post('/admin/providers/update', 'ProvidersController@update')->name('admin.providers.update');
		Route::post('/admin/providers/publish', 'ProvidersController@publish')->name('admin.providers.publish');

		// admin theme

		Route::get('/admin/themes', 'ThemeController@list')->name('admin.themes');
		Route::get('/admin/themes/add', 'ThemeController@add')->name('admin.themes.add');
		Route::get('/admin/themes/edit/{id}', 'ThemeController@edit')->name('admin.themes.edit');
		Route::post('/admin/themes/delete/{id}', 'ThemeController@delete')->name('admin.themes.delete');
		Route::post('/admin/themes/update', 'ThemeController@update')->name('admin.themes.update');
		Route::post('/admin/themes/publish', 'ThemeController@publish')->name('admin.themes.publish');

		// admin partners

		Route::get('/admin/partners', 'PartnerController@list')->name('admin.partners');
		Route::get('/admin/partners/add', 'PartnerController@add')->name('admin.partners.add');
		Route::get('/admin/partners/edit/{id}', 'PartnerController@edit')->name('admin.partners.edit');
		Route::post('/admin/partners/delete/{id}', 'PartnerController@delete')->name('admin.partners.delete');
		Route::post('/admin/partners/update', 'PartnerController@update')->name('admin.partners.update');
		Route::post('/admin/partners/publish', 'PartnerController@publish')->name('admin.partners.publish');
		Route::post('/admin/partners/proud-partner', 'PartnerController@proudPartner')->name('admin.partners.proud');
		// admin settings

		Route::get('/admin/settings/configurations/list', 'ConfigurationController@configurationList')->name('admin.settings.configuration_list');
		Route::get('/admin/settings/configuration/add', 'ConfigurationController@addConfiguration')->name('admin.settings.configuration.add');
		Route::get('/admin/settings/configuration/reset', 'ConfigurationController@resetConfiguration')->name('admin.settings.configuration.reset');
		Route::get('/admin/settings/configuration/edit/{id}', 'ConfigurationController@addConfiguration')->name('admin.settings.configuration.edit');
		Route::get('/admin/settings/configuration/view/{id}', 'ConfigurationController@viewConfiguration')->name('admin.settings.configuration.view');
		Route::post('/admin/settings/configurations/publish', 'ConfigurationController@publishConfiguration')->name('admin.settings.theming.publish_configuration');
		Route::post('/admin/settings/configurations/delete/{id}', 'ConfigurationController@deleteConfiguration')->name('admin.settings.theming.delete_configuration');

		Route::get('/admin/settings/themes', 'ConfigurationController@list')->name('admin.settings.theming');
		Route::get('/admin/settings/theming/add', 'ConfigurationController@add')->name('admin.settings.theming.add');
		
		Route::get('/admin/settings/theming/edit/{id}', 'ConfigurationController@edit')->name('admin.settings.theming.edit');
		Route::get('/admin/settings/theming/view/{id}', 'ConfigurationController@viewTheme')->name('admin.settings.theming.view');
		Route::post('/admin/settings/theming/delete/{id}', 'ConfigurationController@delete')->name('admin.settings.theming.delete');
		Route::post('/admin/settings/theming/update', 'ConfigurationController@update')->name('admin.settings.theming.update');
		Route::get('/admin/settings/theming/reset', 'ConfigurationController@resetTheme')->name('admin.settings.theming.reset');
		Route::post('/admin/settings/configuration/update', 'ConfigurationController@configurationUpdate')->name('admin.settings.configuration.update');
		Route::post('/admin/settings/theming/publish', 'ConfigurationController@publish')->name('admin.settings.theming.publish');
		
		

		//admin about us 

		Route::get('/admin/content/{id}', 'ContentController@editContent')->name('admin.content.edit');
		Route::post('/admin/content/update', 'ContentController@storeContent')->name('admin.content.save');
		Route::get('/admin/content/add-stories/{id}/{storyID?}', 'ContentController@AddStories')->name('admin.content.addstories');
		Route::get('/admin/content/add-team-member/{id}/{memberID?}', 'ContentController@AddTeamMember')->name('admin.content.addTeam');
		Route::post('/admin/stories/store', 'ContentController@storeStories')->name('admin.content.store_stories');
		Route::post('/admin/teams/store', 'ContentController@storeTeam')->name('admin.content.store_team');
		Route::post('/admin/content/delete/{type}/{mid}', 'ContentController@deleteAction')->name('admin.content.delete_action');
		Route::post('/admin/content/publish', 'ContentController@publishAction')->name('admin.content.publish');

		// admin purchases
		Route::get('/admin/purchases', 'AdminController@purchases')->name('admin.purchases');
		Route::get('/admin/user-activity-log', 'UserActivityController@list')->name('admin.user_activity');
		Route::get('/admin/purchases/export', 'AdminController@exportPurchases')->name('admin.purchases.export');
		
		Route::get('/admin/searched-keys', 'AdminController@searchKeys')->name('admin.searched_keys');
		Route::get('/admin/searchedkeys/export', 'AdminController@exportSearchedKeys')->name('admin.searchedkeys.export');
	
	});

	$communities = Community::where('status', 1)->get();
	
	$datacontroller = new DataController();
	foreach ($communities as $key => $community) {		
		$community_route = $community->slug;		
		$data = array('datacontroller'=>$datacontroller, 'community'=>$community);
		
		Route::get('/'.$community_route, function() use($data){			
			return $data['datacontroller']->category($data['community']->slug);
		})->name('data_community.'.$community_route);	

		Route::get('/community/'.$community_route, function() use($data){			
			return $data['datacontroller']->community($data['community']->slug);
		})->name('data.community_'.$community_route);
	}
	Route::get('/category_search', 'Datacontroller@category_search')->name('category_search');
	Route::get('/register_nl', 'AboutController@register_nl')->name('register_nl'); 
	Route::post('/register_nl', 'AboutController@create_nl')->name('create_nl');
	Route::get('/email_validator', 'AboutController@email_validator')->name('email_validator'); 
	Route::get('/validate_otp', 'AboutController@validate_otp')->name('validate_otp'); 
	Route::get('/refresh_captcha', 'AboutController@refreshCaptcha')->name('refresh_captcha');
	Route::get('/verify_success', 'AboutController@verify_success')->name('verify_success');
	Route::get('/register_success', 'AboutController@register_success')->name('register_success');

	Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap.index');

});

//comment to enable verification link
Auth::routes(['verify' => true]);
Auth::routes();