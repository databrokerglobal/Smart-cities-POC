<?php
/**
 *  
 *  Admin Controller
 * 
 * This file is a part of the Databroker.Global package.
 *
 * (c) Databroker.Global
 *
 * @author    Databroker.Global
 * 
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\Region;
use App\Models\Community;
use App\Models\Offer;
use App\Models\Bid;
use App\Models\Business;
use App\Models\Theme;
use App\Models\Gallery;
use App\Models\OfferTheme;
use App\Models\OfferSample;
use App\Models\OfferCountry;
use App\Models\OfferProduct;
use App\Models\UseCase;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Subscription;
use App\Models\Article;
use App\Models\LinkedUser;
use App\Models\HomeFeaturedData;
use App\Models\HomeTrending;
use App\Models\HomeMarketplace;
use App\Models\HomeTeamPicks;
use App\Models\HomeFeaturedProvider;
use App\Models\FAQ;
use App\Models\HelpTopic;
use App\Models\Admin;
use App\Models\UpdatesCategories;
use App\Models\RegionProduct;
use App\Models\BillingInfo;
use App\Models\ProductPriceMap;

use Response;
use Image;
use Session;
use Redirect;
use File;
use Illuminate\Contracts\Session\Session as SessionSession;
use Carbon\Carbon;
use Excel;
use App\Exports\UsersExport;
use App\Exports\OfferExport;
use App\Exports\PurchaseExport;
use App\Helper\SiteHelper;
use App\Models\SearchedKeys;
use App\Exports\SearchKeys;
use DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        //$this->middleware(['admin_auth', 'verified']);
    }

    /**
     *  Dashboard HTML Page
     * 
     */
    public function index(){

        return redirect(route('admin.dashboard'));
    }

    /**
     *  
     *  Admin Login
     */
    public function login(){
        return view('admin.login');
    }

    /**
     *  Check Admin user loggedIn or Not
     * 
     */
    public function check_login(Request $request){
        $validator      = Validator::make($request->all(),[
            'email'     => 'required|max:255|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }
        $adminUser = Admin::where('email', $request->email)->get()->first();
        if(!$adminUser){
            return Redirect::back()->withErrors(['email' => 'The email is not correct. Please try again.']);
        } else if($adminUser->password == md5($request->password)){
            $adminUserData['id']        = $adminUser->id;
            $adminUserData['username']  = $adminUser->username;
            $adminUserData['firstname'] = $adminUser->firstname;
            $adminUserData['lastname']  = $adminUser->lastname;
            $adminUserData['email']     = $adminUser->email;
            $adminUserData['role']      = $adminUser->role;

            Session::put('admin_user', $adminUserData);
            Session::flash('flash_success', 'Welcome Back to the Admin Panel');
            return redirect(route('admin.dashboard'));
        } else{
            return Redirect::back()->withErrors(['password'=>'The password is not correct. Please try again.']);
        }
    }

    /**
     *  Logout
     * 
     */
    public function logout(){
        if(Session::has('admin_user'))
            Session::forget('admin_user');
        if(Session::has('menu_item_parent')){
            Session::forget('menu_item_parent');
            if(Session::has('menu_item_child'))  {
                Session::forget('menu_item_child');
                if(Session::has('menu_item_child_child'))
                    Session::forget('menu_item_child_child');
            }
        }
        return 'success';
    }

    /**
     *  Dasboard data fething from DB and populate in variables to display on Dashboard page
     * 
     */
    public function dashboard()  {
        Session::put('menu_item_parent',    'dashboard');
        Session::put('menu_item_child',     '');
        Session::put('menu_item_child_child', '');  
        
        //Offers
        $totalOffers    = Offer::count();  
        $inactiveOffers = Offer::where('status', 0)->count(); 
        $activeOffres   = $totalOffers - $inactiveOffers;    

        //Articles
        $totalArticles      = Article::join('communities', 'articles.communityIdx', '=', 'communities.communityIdx')->where('articles.isUseCase',true)->whereNotNull('articles.communityIdx')->count();  
        $inactiveArticles   = Article::join('communities', 'articles.communityIdx', '=', 'communities.communityIdx')->where('articles.active', 0)->where('articles.isUseCase',true)->whereNotNull('articles.communityIdx')->count(); 
        $activeArticles     = $totalArticles - $inactiveArticles;  

        //updates
        $totalUpdates     = Article::where('isUseCase',false)->count();  
        $inactiveUpdates   = Article::where('active', 0)->where('isUseCase',false)->count(); 
        $activeUpdates     = $totalUpdates - $inactiveUpdates;  

        
        //Users
         $totalUsers    = User::count();  
         $inactiveUsers = User::where('userStatus', 0)->orWhereNull('email_verified_at')->count(); 
         $activeUsers   =  $totalUsers - $inactiveUsers;  
        //Providers
        $totalProviders = Provider::count();          
        //Bids 
        $totalBids      = Bid::count();
        //Purchases 
        $totalPurchase  =  OfferProduct::with(['region'])
                    ->select("offerProducts.*", "offers.*", "providers.*", "users.*", "companies.*", "purchases.*", "purchases.userIdx as buyyer_id", "bids.*", "purchases.productIdx as productIDX")
                    ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                    ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                    ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                    ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                    ->join('purchases', 'purchases.productIdx', '=', 'offerProducts.productIdx')
                    ->leftjoin('bids', 'bids.bidIdx', '=', 'purchases.bidIdx')
                    ->orderby('purchases.created_at', 'desc')
                    ->count();
        /* Purchase::count(); */

        $lastBackDate       = strtotime('-15 days');
        $created_date_from  = static::dateFormat(date(DB_DATE_FORMAT,$lastBackDate));
        $created_date_to    = static::dateFormatTo(date(DB_DATE_FORMAT));
        $barGraphdata       = [];
        for($i = $created_date_from; $i <= $created_date_to; $i->modify('+1 day')){
            $barGraphdata[$i->format(CHART_DATE_FORMAT)] = User::whereDate('created_at','=',$i->format(DB_DATE_FORMAT))->count();
        }
        
        $userCount      = implode("','",$barGraphdata);
        $dates          = implode("','",array_keys($barGraphdata));

        $communities    = Community::where('status',1)->orderBy('communityIdx','asc')->pluck('communityName','communityIdx')->toArray();
        $buyers         = [];
        $sellers        = [];
        $purchsed       = Purchase::with('offerproduct')->where('transactionId','<>','')->get();

        if($purchsed){
            foreach($purchsed as $purchsedVal){
                if($purchsedVal->offerproduct !== null && $purchsedVal->offerproduct->offerIdx != ""){
                    $offer = Offer::where('offerIdx',$purchsedVal->offerproduct->offerIdx)->first();
                    if($offer){
                        if(isset($buyers[$offer->communityIdx])){
                            $buyers[$offer->communityIdx] = $buyers[$offer->communityIdx] + 1;
                        }else{
                            $buyers[$offer->communityIdx] = 1;
                        }
                    }   
                }

            }
        }
        $offers = Offer::with('provider')->get();
        if($offers) {
            foreach($offers as $offersVal){
                
                    if(isset($sellers[$offersVal->communityIdx])){
                        $sellers[$offersVal->communityIdx] = $sellers[$offersVal->communityIdx] + 1;
                    }else{
                        $sellers[$offersVal->communityIdx] = 1;
                    }
                
                }
            }
            
            $buyers_keys    = array_keys($buyers);
            $sellers_keys   = array_keys($sellers);
            $buyerPercent   = [];
            $sellerPercent  = [];
            foreach($communities as $id => $communities){
                if(!in_array($id, $buyers_keys)){
                    $buyers[$id] = 0;
                }
                if(!in_array($id, $sellers_keys)){
                    $sellers[$id] = 0;
                }
                $sum = $buyers[$id] + $sellers[$id];
                if($sum > 0){
                    $buyerPercent[$id]  = round(($buyers[$id] / $sum) * 100);
                    $sellerPercent[$id] = round(($sellers[$id] / $sum) * 100);
                }else{
                    $buyerPercent[$id]  = 0;
                    $sellerPercent[$id] = 0;
                }
                
            }
          
        ksort($buyers);
        ksort($sellers);
        
        $totalSellers   =  Offer::groupBy('providerIdx')->get();
        $sellerCount    = 0;
        $sellerCountAr  = [];
        foreach($totalSellers as $totalSellerVal){
            $userID = Provider::select('userIdx')->where('providerIdx',$totalSellerVal->providerIdx)->first();
            if(isset($userID->userIdx) && $userID->userIdx > 0){
                $userDetail = User::where('userIdx',$userID->userIdx)->first();
                if($userDetail && isset($userDetail->userStatus) && $userDetail->userStatus == 1){
                    $sellerCountAr[] = $userID->userIdx;
                }
            }
        }
        
        $sellerCount            = count(array_unique($sellerCountAr));        
        $op_list                =   $OfferProducts  = OfferProduct::with(['region'])
                                        ->select("offerProducts.*", "offers.*", "providers.*", "users.*")
                                        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')     
                                        ->orderby('offerProducts.created_at', 'desc')
                                        ->get();  
        $OfferProducts          = count($op_list);
        $ActiveOfferProducts    =  OfferProduct::whereNotNull('dxc')->count();
        
        $communities = Community::where('status',1)->orderBy('communityIdx','asc')->pluck('communityName','communityIdx')->toArray();     
        
        $data = array('totalOffers', 'inactiveOffers', 'activeOffres', 
                      'totalArticles', 'inactiveArticles', 'activeArticles',
                      'totalUsers', 'inactiveUsers', 'activeUsers', 
                      'totalProviders', 'totalBids', 'totalPurchase',
                      'dates','userCount','lastBackDate','communities',
                      'sellers','buyers','buyerPercent','sellerPercent',
                      'sellerCount','OfferProducts','ActiveOfferProducts',
                      'totalUpdates', 'inactiveUpdates', 'activeUpdates',
                    );

        return view('admin.dashboard', compact($data));
    }

    /**
     * Date format function
     * 
     * 
     */
    public static function dateFormat($date) {
        if ($date != null) {
            $array  = explode('-', date("d-m-Y", strtotime($date)));
            $date   = Carbon::createFromDate($array[2], $array[1], $array[0]);
                $date->hour   = 00;
                $date->minute = 00;
                $date->second = 00;            
        }
        return $date;
    }
    
    /**
     * Description: return Date.
     * @return date 
     * 
     * 
     */
    public static function dateFormatTo($date) {
        if ($date != null) {
            $array          = explode('-', date("d-m-Y", strtotime($date)));
            $date           = Carbon::createFromDate($array[2], $array[1], $array[0]);
            $date->hour     = 23;
            $date->minute   = 59;
            $date->second   = 59;            
        }
        return $date;
    }

    /**
     *  
     *  Get Auth user
     * 
     */

    public function getAuthUser () {
        return Auth::user();
    }

    /**
     *  
     * Home page of the admin
     * 
     */
    public function home() {
        return view('admin.home');
    }

    /**********************************************************************************************   
     * 
     *  Home Featured Data Functions for Admin section
     * 
     **********************************************************************************************/

    /**
     *  
     *  Home Featured Data Admin Listing 
     * 
     */
    public function home_featured_data() {
        Session::put('menu_item_parent',    'home');
        Session::put('menu_item_child',     'home_featured_data');
        Session::put('menu_item_child_child', '');
        $boards = HomeFeaturedData::join('providers', 'providers.providerIdx', '=', 'home_featured_data.providerIdx')
                                    ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                    ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                                    ->orderBy('home_featured_data.created_at', 'desc')
                                    ->get();
        $data = array('boards');
        return view('admin.home_featured_data', compact($data));
    }
    
    /**
     *  Home Featured Data Edit Display 
     * 
     * 
     */
    public function home_featured_data_edit() {
        Session::put('menu_item_parent',    'home');
        Session::put('menu_item_child',     'home_featured_data');
        Session::put('menu_item_child_child', '');
        $board = HomeFeaturedData::first(); 
        $providers = Provider::get();

        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
            );

        $offers = Offer::where('status',1)->pluck('offerTitle','offerIdx')->toArray();
           
        $data = array('board', 'providers', 'statusList','offers');
        return view('admin.home_featured_data_edit', compact($data));
    }

    /**
     *  Home Featured Data Submit the Edited Data
     * 
     * 
     */
    public function home_featured_data_update(Request $request) {
        Session::put('menu_item_parent',    'home');
        Session::put('menu_item_child',     'home_featured_data');
        Session::put('menu_item_child_child', '');
        if($request->input('id')) {
                $id     = $request->input('id');
                $data   = $request->all();
                unset($data['id']);
                $slug       = SiteHelper::slugify($request->featured_data_title);
                $slugCount  = HomeFeaturedData::where('slug', $slug)->where('id', '!=', $id)->count();
            if ($slugCount > 0) {
                $slug = $slug. '-'.$id;
            }
            $data['slug'] =  $slug;
            HomeFeaturedData::find($id)->update($data);            
        } else {
            $data = $request->all();
            unset($data['id']);

            $slug       = SiteHelper::slugify($request->featured_data_title);
            $slugCount  = HomeFeaturedData::where('slug', $slug)->count();
            if ($slugCount > 0) {
                $data['slug'] = '';
            }else {
                $data['slug'] =  $slug;
            }            

            $insertedData = HomeFeaturedData::create($data);
            $id = $insertedData->id; 
            
            if ($slugCount > 0) {
                $data = [];              
                $data['slug'] =  $slug.'-'.$id;
                HomeFeaturedData::find($id)->update($data);
            }
        }

        $this->home_featured_data_upload_attach($request, $id);
        $this->home_featured_data_upload_logo($request, $id);
        Session::flash('flash_success', 'Featured Data has been updated successfully');
        return "success";

    }
    
    /**
     *  Home Featured Data upload Image File
     * 
     */
    private function home_featured_data_upload_attach($request, $id)  {
        if ($request->hasFile('upload_attach')) {
            $getfiles = $request->file('upload_attach');
            $fileName = $id.'.jpg';  
            //image compress start
            SiteHelper::resizeImage($getfiles, HOMEFEATURED_TINY_IMG_WIDTH,HOMEFEATURED_TINY_IMG_HEIGHT, $fileName, HOMEFEATURED_IMAGE_UPLOAD_PATH.'/tiny');
            SiteHelper::resizeImage($getfiles, HOMEFEATURED_THUMB_IMG_WIDTH,HOMEFEATURED_THUMB_IMG_HEIGHT, $fileName, HOMEFEATURED_IMAGE_UPLOAD_PATH.'/thumb');
            //image compress end
            $getfiles->move(public_path(HOMEFEATURED_IMAGE_UPLOAD_PATH), $fileName);
            HomeFeaturedData::find($id)->update(['image' => $fileName]);
        }
    }
    
    /**
     *  Home Featured Data upload Logo File
     * 
     */

    private function home_featured_data_upload_logo($request, $id) {
        if ($request->hasFile('upload_logo')) {
            $getfiles       = $request->file('upload_logo');
            $fileExtention  = $getfiles->getClientOriginalExtension();
            if($fileExtention == 'svg')  {
                $fileName = $id.'.svg';
                $getfiles->move(public_path(HOMEFEATURED_IMAGE_UPLOAD_PATH.'/logo/'), $fileName);
                HomeFeaturedData::find($id)->update(['logo' => $fileName]);
            } else {
                $fileName = $id.'.jpg';
               
                SiteHelper::resizeImage($getfiles, HOMEFEATURED_TINY_LOGO_WIDTH, HOMEFEATURED_TINY_LOGO_HEIGHT, $fileName, HOMEFEATURED_IMAGE_UPLOAD_PATH.'/logo');
              
                SiteHelper::resizeImage($getfiles, HOMEFEATURED_THUMB_LOGO_WIDTH, HOMEFEATURED_THUMB_LOGO_HEIGHT, $fileName, HOMEFEATURED_IMAGE_UPLOAD_PATH.'/logo/thumb');
            
                //image compress end
                HomeFeaturedData::find($id)->update(['logo' => $fileName]);
            }
        }
    }
    /**********************************************************************************************   
     * 
     *  Home Trending Functions for Admin section
     * 
     **********************************************************************************************/

    /**
     *   Home Trending Admin Listing 
     * 
     */

    public function home_trending()  {
        Session::put('menu_item_parent',    'home');
        Session::put('menu_item_child',     'home_trending');
        Session::put('menu_item_child_child', '');
        $boards = HomeTrending::orderby('created_at', 'desc')->get();
        $data   = array('boards');
        return view('admin.home_trending', compact($data));
    }    
      
    /**
     *  Home Trending Add/Edit page display 
     * 
     */
    public function home_trending_edit($id = '') {
        Session::put('menu_item_parent',    'home');
        Session::put('menu_item_child',     'home_trending');
        Session::put('menu_item_child_child', '');
        
        $statusList = array(
                    0   =>  'Unpublish',
                    1   =>  'Publish'
        );
        $offers = Offer::where('status',1)->pluck('offerTitle','offerIdx')->toArray();
        if($id == '')  {
            $data = array('statusList','offers');
            return view('admin.home_trending_edit', compact($data));
        }  else {
            $id     = $id;
            $board  = HomeTrending::where('id', $id)->first(); 
            $data   = array('id', 'board','statusList','offers');
            return view('admin.home_trending_edit', compact($data));
        }
    }

    /**
     *  Home Trending Add/Edit page Submit Data 
     * 
     */

      public function home_trending_update(Request $request) {
          Session::put('menu_item_parent',  'home');
          Session::put('menu_item_child',   'home_trending');
          Session::put('menu_item_child_child', '');

          if($request->input('id')) {
              $id       = $request->input('id');
              $data     = $request->all();
              unset($data['id']);
              HomeTrending::find($id)->update($data);
              $this->upload_attach($request, $id);
              Session::flash('flash_success', 'Trending has been updated successfully');
              return "success";
          } else {
              $data     = $request->all();               
              unset($data['id']);
              $saveData = HomeTrending::create($data);
              $this->upload_attach($request, $saveData->id);   
              Session::flash('flash_success', 'New Trending has been added successfully');      
              return "success";
          }
      }

    /**
     *  Home Trending upload logo on Add/Edit page
     * 
     */

      private function upload_attach($request, $id) {
          if ($request->hasFile('uploadedFile')) {
              $getfiles         = $request->file('uploadedFile');
              $fileExtention    = $getfiles->getClientOriginalExtension();
              if($fileExtention == 'svg')  {
                  $fileName = $id.'.svg';
                  $getfiles->move(public_path('uploads/home/trending/'), $fileName);                
                  HomeTrending::find($id)->update(['image' => $fileName]);
              } else  {
                  $fileName = $id.'.jpg';
                
                SiteHelper::resizeImage($getfiles, HOMETRENDING_IMG_WIDTH, HOMETRENDING_IMG_HEIGHT, $fileName,HOMETRENDING_IMAGE_UPLOAD_PATH);

               
                SiteHelper::resizeImage($getfiles, HOMETRENDING_THUMB_IMG_WIDTH, HOMETRENDING_THUMB_IMG_HEIGHT, $fileName, HOMETRENDING_IMAGE_UPLOAD_PATH.'/thumb');
                  //image compress end
                  HomeTrending::find($id)->update(['image' => $fileName]);
              }
          }
      }
    
    /********************************************************************************   
     * 
     *  Home Marketplace Functions for Admin section
     * 
     ********************************************************************************/

    /**
     *  Home Marketplace Admin Listing 
     * 
     */

    public function home_marketplace()  {
        Session::put('menu_item_parent',    'home');
        Session::put('menu_item_child',     'home_marketplace');
        Session::put('menu_item_child_child', '');
        $boards = HomeMarketplace::orderby('created_at', 'desc')->get();
        $data   = array('boards');
        return view('admin.home_marketplace', compact($data));
    }
    
    /**
     *  Home Marketplace Add/Edit page display
     * 
     */

    public function home_marketplace_edit($id = '') {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_marketplace');
        Session::put('menu_item_child_child', '');

        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
        );

        if($id == '') {
            $data = array('statusList');
            return view('admin.home_marketplace_edit', compact($data));           
        } else  {
            $id     = $id;
            $board  = HomeMarketplace::where('id', $id)->first(); 
            $data   = array('id', 'board','statusList');
            return view('admin.home_marketplace_edit', compact($data));
        }
    }

    /**
     *  Home Marketplace Add/Edit page Submit Data
     * 
     */

    public function home_marketplace_update(Request $request) {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_marketplace');
        Session::put('menu_item_child_child', '');

        if($request->input('id')) {
            $id     = $request->input('id');
            $data   = $request->all();
            unset($data['id']);

            $slug       = SiteHelper::slugify($request->title);
            $slugCount  = HomeMarketplace::where('slug', $slug)->where('id', '!=', $id)->count();
            if ($slugCount > 0) {
                $slug = $slug. '-'.$id;
            }
            $data['slug'] =  $slug;

            HomeMarketplace::find($id)->update($data);
            
            if ($request->hasFile('uploadedFileImage')) {
                $this->home_marketplace_upload_attach( $request, $id);
            }
            if ($request->hasFile('uploadedFileLogo')) {
                $this->home_marketplace_upload_logo( $request, $id);
            }
                Session::flash('flash_success', 'Marketplace has been updated successfully');
                return "success";
            } else {
                $data = $request->all();                
                unset($data['id']);

                $slug       = SiteHelper::slugify($request->title);
                $slugCount  = HomeMarketplace::where('slug', $slug)->count();
                if ($slugCount > 0) {
                    $data['slug'] = '';
                }else {
                    $data['slug'] =  $slug;
                }   
                $saveData   = HomeMarketplace::create($data);
                $id         = $saveData->id; 
                if ($request->hasFile('uploadedFileImage')) {
                    $this->home_marketplace_upload_attach( $request, $id);
                }
                if ($request->hasFile('uploadedFileLogo')) {
                    $this->home_marketplace_upload_logo( $request, $id);
                }
                if ($slugCount > 0) {
                    $data = [];              
                    $data['slug'] =  $slug.'-'.$id;
                    HomeMarketplace::find($id)->update($data);
                }
                
                Session::flash('flash_success', 'Marketplace has been added successfully'); 
                return "success";
        }
        
    }
    
    /**
     *  Home Marketplace upload Image file
     * 
     */

    private function home_marketplace_upload_attach(Request $request, $id) {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_marketplace');
        Session::put('menu_item_child_child', '');
        $getfiles = $request->file('uploadedFileImage');         
       
        $fileName = $id.'.jpg';  
        
        SiteHelper::resizeAndUploadImage($getfiles,'HOMEMARKETPLACE',$fileName,[]);
        HomeMarketplace::find($id)->update(['image' => $fileName]);
        return "true";
    }
    
    /**
     *  Home Marketplace upload Logo file
     * 
     */

    private function home_marketplace_upload_logo(Request $request, $id) {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_marketplace');
        Session::put('menu_item_child_child', '');
        $getfiles = $request->file('uploadedFileLogo');
        $fileName = $id.'.jpg';  
        //image compress start
      
        SiteHelper::resizeImage($getfiles, HOMEMARKETPLACE_TINY_LOGO_WIDTH, HOMEMARKETPLACE_TINY_LOGO_HEIGHT, $fileName, HOMEMARKETPLACE_IMAGE_UPLOAD_PATH.'/logo/tiny');
      
        SiteHelper::resizeImage($getfiles, HOMEMARKETPLACE_THUMB_LOGO_WIDTH, HOMEMARKETPLACE_THUMB_LOGO_HEIGHT, $fileName, HOMEMARKETPLACE_IMAGE_UPLOAD_PATH.'/logo/thumb');
        //image compress end
        $getfiles->move(public_path('uploads/home/marketplace/logo'), $fileName);
        HomeMarketplace::find($id)->update(['logo' => $fileName]);
        return "true";
    }
    
    /********************************************************************************   
     * 
     *  Home Team Picks Functions for Admin section
     * 
     ********************************************************************************/ 
    /**
     *  Home Team Picks Admin Listing 
     * 
     */

    public function home_teampicks() {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_teampicks');
        Session::put('menu_item_child_child', '');
        $boards = HomeTeamPicks::orderby('created_at', 'desc')->get();
        $data = array('boards');
        return view('admin.home_teampicks', compact($data));
    }
    
    /**
     *  Home Team Picks Add/Edit page display 
     * 
     */

    public function home_teampicks_edit($id = '') {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_teampicks');
        Session::put('menu_item_child_child', '');

        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
        );

        if($id == '') {
            $data = array('statusList');            
            return view('admin.home_teampicks_edit', compact($data));  
        } else {
            $id     = $id;
            $board  = HomeTeamPicks::where('id', $id)->first(); 
            $data   = array('id', 'board','statusList');
            return view('admin.home_teampicks_edit', compact($data));
        }
    }
    
    /**
     *  Home Team Picks Add/Edit submit data 
     * 
     */

    public function home_teampicks_update(Request $request) {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_teampicks');
        Session::put('menu_item_child_child', '');

        if($request->input('id')) {
            $id     = $request->input('id');
            $data   = $request->all();
            unset($data['id']);
            HomeTeamPicks::find($id)->update($data);
            Session::flash('flash_success', 'Team Pick has been updated successfully');
        } else {
            $data       = $request->all();
            unset($data['id']);
            $saveData   = HomeTeamPicks::create($data);
            $id         = $saveData->id;
            Session::flash('flash_success', 'Team Pick has been added successfully');          
        }

        if ($request->hasFile('uploadedFileImage')) {
            $this->home_teampicks_upload_attach( $request, $id);
        }
        if ($request->hasFile('uploadedFileLogo')) {
            $this->home_teampicks_upload_logo( $request, $id);
        }
        return "success";

    }
          
    /**
     *  Home Team Picks upload Image file
     * 
     */

    public function home_teampicks_upload_attach(Request $request, $id) {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_teampicks');
        Session::put('menu_item_child_child', '');
        $getfiles = $request->file('uploadedFileImage');
        $fileName = $id.'.jpg';  
        //image compress start
        SiteHelper::resizeAndUploadImage($getfiles,'HOMETEAMPICKS',$fileName,[]);
        HomeTeamPicks::find($id)->update(['image' => $fileName]);
        return "true";
    }
    
     /**
      *  Home Team Picks upload Logo file
      * 
      */

      public function home_teampicks_upload_logo(Request $request, $id) {
          Session::put('menu_item_parent', 'home');
          Session::put('menu_item_child', 'home_teampicks');
          Session::put('menu_item_child_child', '');
          $getfiles = $request->file('uploadedFileLogo');
          $fileName = $id.'.jpg';  
          //image compress start
        SiteHelper::resizeImage($getfiles,HOMETEAMPICKS_TINY_LOGO_WIDTH,HOMETEAMPICKS_TINY_LOGO_HEIGHT,$fileName,HOMETEAMPICKS_IMAGE_UPLOAD_PATH.'/logo/tiny');
       
        
         SiteHelper::resizeImage($getfiles,HOMETEAMPICKS_THUMB_LOGO_WIDTH,HOMETEAMPICKS_THUMB_LOGO_HEIGHT,$fileName,HOMETEAMPICKS_IMAGE_UPLOAD_PATH.'/logo/thumb');
  
          $getfiles->move(public_path('uploads/home/teampicks/logo'), $fileName);
          HomeTeamPicks::find($id)->update(['logo' => $fileName]);
          return "true";
      }
    
    /********************************************************************************   
     * 
     *  Home Providers Functions for Admin section
     * 
     ********************************************************************************/ 

     /**
      *  Home Providers Admin Listing 
      * 
      */

    public function home_featured_provider() {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_featured_provider');
        Session::put('menu_item_child_child', '');
        $boards = HomeFeaturedProvider::join('providers', 'providers.providerIdx', '=', 'home_featured_provider.providerIdx')
                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                        ->orderby('home_featured_provider.created_at', 'desc')
                        ->get();
        $data = array('boards');   
      
        return view('admin.home_featured_provider', compact($data));
    }
    
    /**
     *  Home Providers Edit Display page
     * 
     */

    public function home_featured_provider_edit($id = '') {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_featured_provider');
        Session::put('menu_item_child_child', '');

        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
        );

        if($id == '') {
            $providers  = Provider::get();
            $data       = array('providers', 'statusList');
            return view('admin.home_featured_provider_edit', compact($data));
        } else {
            $id         = $id;
            $providers  = Provider::get();
            $provider   = HomeFeaturedProvider::where('id', $id)->first();
            if(!$provider){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return redirect()->route('admin.home_featured_provider');
            } 
            $data       = array('id', 'providers', 'provider', 'statusList');
            return view('admin.home_featured_provider_edit', compact($data));
        }
    }

    /**
     *  Home Providers Add/Edit submit data 
     * 
     */

      public function home_featured_provider_update(Request $request) {
          Session::put('menu_item_parent', 'home');
          Session::put('menu_item_child', 'home_featured_provider');
          Session::put('menu_item_child_child', '');
       
          if($request->input('id')) {
              $id   = $request->input('id');
              $data = $request->all();
              unset($data['id']);
              HomeFeaturedProvider::find($id)->update($data);
              Session::flash('flash_success', 'Provider has been updated successfully');
              return "success";
          } else {
              $data = $request->all();              
              unset($data['id']);
              HomeFeaturedProvider::create($data);              
              Session::flash('flash_success', 'New Provider has been added successfully'); 
              return "success";
          }
      }

    /**
     *  
     *  Home Providers Delete Item 
     */

    public function home_featured_provider_delete(Request $request) {
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'home_featured_provider');
        Session::put('menu_item_child_child', '');
        $id = $request->id;
        $board = HomeFeaturedProvider::where('id', $id)->delete(); 
        Session::flash('flash_success', 'Provider has been deleted successfully'); 
        return "success";
       
    }
    
    /********************************************************************************   
     * 
     *  Home Usecases Functions for Admin section
     * 
     ********************************************************************************/    
    
    /**
     *  Usecases Admin Listing  
     * 
     */

    public function usecases($id) {   
        Session::put('menu_item_parent', 'usecases');
        Session::put('menu_item_child', $id);
        Session::put('menu_item_child_child', '');
        $communityIdx   = $id;
        $communityName  = Community::where('communityIdx', $id)->pluck('communityName')->first();
        $boards         = Article::with('community')->where('communityIdx', $id)->where('top_use_case', 0)->where('isUseCase', 1)->orderBy('published', 'DESC')->get();
        $data           = array('boards', 'communityIdx', 'communityName');
        return view('admin.usecases', compact($data));
    }
    
    /**
     *   Usecases Add New page display
     * 
     */

    public function usecases_add_new($id) {
        Session::put('menu_item_parent', 'usecases');
        Session::put('menu_item_child', $id);
        Session::put('menu_item_child_child', '');

        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
        );

        $categories         = Community::where('status',1)->get();

        $categoriesName     = Community::where('communityIdx', $id)->get()->first();
        $communityNameLabel = $categoriesName->communityName;
        $communityIdx       = $id;  
        $data               = array( 'categories', 'communityIdx', 'statusList', 'communityNameLabel' );      
        
        return view('admin.usecases_add_new', compact($data));
    }
    
    /**
     *  Usecases Edit page display
     * 
     */

    public function usecases_edit(Request $request) {
        $id             = $request->id;
        $redirectFrom   = "";
        if(isset($request->redirectfrom)){
            $redirectFrom = $request->redirectfrom;
        }
        $categories     = Community::where('status',1)->get();  
        $board          = Article::where('articleIdx', $id)->first();
        if(!$board){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        } 
        $categoriesName = Community::where('communityIdx', $board->communityIdx)->get()->first();
        $communityNameLabel = "";
        if($categoriesName){
        $communityNameLabel = $categoriesName->communityName;
        }

        
        if(isset($request->redirectfrom)){
            Session::put('menu_item_parent', 'home');
            Session::put('menu_item_child', 'top_use_cases');
        }else{
            Session::put('menu_item_parent', 'usecases');
            Session::put('menu_item_child', $board->communityIdx);
        }
       
        Session::put('menu_item_child_child', '');

        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
        );

        $communityIdx = $board->communityIdx;
        $data = array( 'categories', 'id', 'board', 'communityIdx', 'statusList', 'communityNameLabel','redirectFrom');
        return view('admin.usecases_edit', compact($data));
    }
    
    /**
     *  Usecases Delete
     * 
     */

    public function usecases_delete(Request $request){
        $board = Article::where('articleIdx', $request->id)->first(); 
        if(!$board){
            Session::flash('flash_error', 'Record you are looking to delete is not found or already deleted.');
            return "success";
        } 
        if($board->top_use_case == 1){
            Session::flash('flash_success', 'Usecase cannot be deleted, please remove from the homepage first'); 
            return "success";
        }

        Article::where('articleIdx', $request->id)->delete();
        Session::flash('flash_success', 'Usecase has been deleted successfully'); 
        return "success";
    }
    
    /**
     *  Usecases submit form Add/Edit data
     * 
     */

    public function usecases_update(Request $request) {
        
        $date = explode("/", $request->published);
        $published = $date[2].'-'.$date[1].'-'.$date[0];
        $data = $request->all();
   
        if($request->input('id')) {
            // Check slug already exist, then add ID of the item
            $articleID  = $request->input('id');
            $slug       = $data['slug'];          
            $count      = Article::where('slug', $slug)->where('articleIdx', '!=', $articleID)->count();
            if ($count > 0) {
                $data['slug'] = $slug. '-'.$articleID;
            }
        }

        if($request->input('id')) {
            $articleIdx = $request->input('id');           
            $data['published'] = date(DB_DATE_FORMAT, strtotime($published));
            unset($data['id']);
            Article::find($articleIdx)->update($data); 
            Session::flash('flash_success', 'Data has been updated successfully');
           
            $logDetail = 'Updated: ID- '.$articleIdx.', Title- '.$data['articleTitle'].', CommunityID- '.$data['communityIdx'];
            SiteHelper::logActivity('USECASE', $logDetail, 'admin');

        } else {                   
            $data['published'] = date(DB_DATE_FORMAT, strtotime($published));
            unset($data['id']);

            // Check same slug already exist, then remove slug from insertion and update later with ID
            $slug       = $data['slug'];          
            $slugCount  = Article::where('slug', $slug)->count();
            if ($slugCount > 0) {
                $data['slug'] = '';
            }

            $data['isUseCase']  = 1; 
            $savedData          = Article::create($data);          
            $articleIdx         = $savedData->articleIdx; 

            // now update the slug if the count             
            $data['articleIdx']     = $articleIdx;
            $data['slug']           = $slug. '-'.$articleIdx;
            Article::find($articleIdx)->update($data);
            
            $logDetail = 'Added: ID- '.$articleIdx.', Title- '.$data['articleTitle'].', CommunityID- '.$data['communityIdx'];
            SiteHelper::logActivity('USECASE', $logDetail, 'admin');

            Session::flash('flash_success', 'New Data has been added successfully');          
        }

        if ($request->hasFile('uploadedFile')) {
            $this->usecases_upload_attach($request, $articleIdx);
        }
        
        return "success";

    }
    
    /**
     *  Usecases Publish the Item
     * 
     */

    public function usecases_publish(Request $request){
        $articleIdx     = $request->articleIdx;
        $article        = Article::where('articleIdx', $articleIdx)->get()->first();
        $new['active']  = 1 - $article->active;
        if($new['active'] == 0 && $article->top_use_case == 1){
            Session::flash('flash_success', 'Usecase cannot be Unpublish, please remove from the homepage first'); 
            return "success"; exit;
        }
        Article::where('articleIdx', $articleIdx)->update($new);
        
        if($new['active'] == 1) {
            Session::flash('flash_success', 'Usecase has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Usecase has been Unpublished successfully'); 
        } 
        echo "success";
    }
    
    /**
     *  
     * Usecases upload the Image
     */

    public function usecases_upload_attach(Request $request, $articleIdx) {
            $getfiles = $request->file('uploadedFile');
            $fileName = $articleIdx.'.jpg';              
           
            SiteHelper::resizeAndUploadImage($getfiles,'USECASES',$fileName,[]);   
            Article::find($articleIdx)->update(['image' => $fileName]);
            return "true";
    }
    
    /**
     *  Usecases upload the File
     * 
     */

    public function usecases_summernote_upload(Request $request){
        $files = $request->file('files');
        $names = array();
        foreach ($files as $key => $file) {
            $fileName = $file->getClientOriginalName();
            array_push($names, $fileName);
            if ($file->isValid()) {
                $file->move(public_path('adminpanel/uploads/usecases'), $fileName);
            }
        }
        return json_encode(array('success'=>true, 'result'=>$names));
    }
    
    /********************************************************************************   
     * 
     *  Updates Functions for Admin section
     * 
     ********************************************************************************/ 

    /**
     *  Updates Listing page
     * 
     */

    public function updates() {   
        Session::put('menu_item_parent', 'updates');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        $boards = Article::where('isUseCase', false)->orderBy('created_at', 'DESC')->get();
        $data   = array('boards');
        return view('admin.updates', compact($data));
    }
    
    /**
     *  
     * Updates Add New page
     */

    public function updates_add_new() {
        Session::put('menu_item_parent', 'updates');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $categories = UpdatesCategories::get();
        $cats       = array();
        foreach ($categories as $key => $category) {
            array_push($cats, $category->category);
        }
        $categories = $cats;
        $data = array('categories');
        return view('admin.updates_add_new', compact($data));
    }
    
    /**
     *  Updates Edit page Display
     * 
     */

    public function updates_edit($id) {
        Session::put('menu_item_parent', 'updates');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        $id     = $id;
        $board  = Article::where('articleIdx', $id)->first();
        if(!$board){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        } 
        $categories = UpdatesCategories::get();
        $cats   = array();
        foreach ($categories as $key => $category) {
            array_push($cats, $category->category);
        }
        $categories = $cats;
        $data       = array('id', 'board', 'categories');
        return view('admin.updates_edit', compact($data));
    }
    
    /**
     *  Updates Add/Edit Submit Data
     * 
     */

    public function updates_update(Request $request) {        
        Session::put('menu_item_parent', 'updates');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $date       = explode("/", $request->published);
        $published  = $date[2].'-'.$date[1].'-'.$date[0];
        $data       = $request->all();

        if($request->input('id')) {
            // Check slug already exist, then add ID of the item
            $articleID = $request->input('id');
            $slug = $data['slug'];          
            $count = Article::where('slug', $slug)->where('articleIdx', '!=', $articleID)->count();
            if ($count > 0) {
                $data['slug'] = $slug. '-'.$articleID;
            }
        }

        if($request->input('id')) {
            $articleIdx = $request->input('id');            
            if($data['category'] == "Other") {
                $data['category'] = $data['category1'];
            }
            unset($data['category1']);
            $data['published'] = date(DB_DATE_FORMAT, strtotime($published));            
            Article::find($articleIdx)->update($data);           
            Session::flash('flash_success', 'Article has been updated successfully');            
        } else {           
            if($data['category'] == "Other") {
                $data['category'] = $data['category1'];
            }
            unset($data['category1']);
            $data['published'] = date(DB_DATE_FORMAT, strtotime($published));
            unset($data['id']);

             // Check same slug already exist, then remove slug from insertion and update later with ID
             $slug = $data['slug'];          
             $slugCount = Article::where('slug', $slug)->count();
             if ($slugCount > 0) {
                 $data['slug'] = '';
             }

            $savedData  = Article::create($data);
            $articleIdx = $savedData->articleIdx;

             // now update the slug if the count
             
             $data['articleIdx']    = $articleIdx;
             $data['slug']          = $slug. '-'.$articleIdx;
             Article::find($articleIdx)->update($data); 
            Session::flash('flash_success', 'Article has been added successfully'); 
           
        }
        if ($request->hasFile('uploadedFile')) {
            $this->usecases_upload_attach($request, $articleIdx);
        }
        return "success";
    }
    
    /**
     *  Updates Publish Item
     * 
     */

    public function updates_publish(Request $request){
        Session::put('menu_item_parent', 'updates');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        $articleIdx     = $request->articleIdx;
        $article        = Article::where('articleIdx', $articleIdx)->get()->first();
        $new['active']  = 1 - $article->active;
        Article::where('articleIdx', $articleIdx)->update($new);
        if($new['active'] == 1) {
            Session::flash('flash_success', 'Article has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Article has been Unpublished successfully'); 
        }        
        echo "success";
    }
    
    /**
     *  
     * Updates Delete Item
     */

    public function updates_delete(Request $request){
        Session::put('menu_item_parent', 'updates');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        Article::where('articleIdx', $request->id)->delete();
        Session::flash('flash_success', 'Article has been deleted successfully'); 
        return "success";
    }
    
    /**
     *  Updates upload file
     * 
     */

    public function updates_summernote_upload(Request $request){
        Session::put('menu_item_parent', 'updates');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        $files = $request->file('files');
        $names = array();
        foreach ($files as $key => $file) {
            $fileName = $file->getClientOriginalName();
            array_push($names, $fileName);
            if ($file->isValid()) {
                $file->move(public_path('adminpanel/uploads/updates'), $fileName);
            }
        }
        return json_encode(array('success'=>true, 'result'=>$names));
    }
    
    /********************************************************************************   
     * 
     *  Media Functions for Admin section
     * 
     ********************************************************************************/ 
    
    /**
     *  
     *  Media Library List page
     */

    public function media_library(Request $request,$mode){
        Session::put('menu_item_parent', 'media');
        Session::put('menu_item_child', $mode);
        Session::put('menu_item_child_child', '');

        $query = Gallery::select('gallery.*','cm.communityIdx','cm.communityName')->join('communities as cm', 'cm.communityIdx', '=', 'gallery.content');
        if($mode == "community-covers"){
            $query->where('gallery.subcontent', '0');
        }else{
           
            $query->where('gallery.subcontent', null);
        }
        $images =  $query->orderby('gallery.created_at', 'desc')->get();
        $data   = array('images','mode');
        return view('admin.media_library', compact($data));
    }
    
    /**
     *  
     *  Add/Edit Media Display page
     */

    public function add_media($mode){                
        Session::put('menu_item_parent', 'media');
        Session::put('menu_item_child', $mode);
        Session::put('menu_item_child_child', '');
       
        $communities = Community::get();
        $data        = array('communities','mode');
        
        return view('admin.media_edit', compact($data));
    }
    /**
     *  
     *  Add/Edit Media Display page
     */

    public function edit_media($id,$mode){
        Session::put('menu_item_parent', 'media');
        Session::put('menu_item_child', $mode);
        Session::put('menu_item_child_child', '');

        if( $id == 0 ){
            $communities    = Community::get();
            $data           = array('communities','mode');
        }else{
            $communities    = Community::get();
            $media          = Gallery::where('id', $id)->get()->first();
            if(!$media){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
            $data           = array('id', 'communities', 'media','mode');
        }
        return view('admin.media_edit', compact($data));
    }
    
    /**
     *   Delete Media
     * 
     */

    public function delete_media(Request $request){
        Session::put('menu_item_parent', 'media');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        Gallery::where('id', $request->mid)->delete();
        return "success";
    }
    
    /**
     *  Update Media Data
     * 
     */

    public function media_update(Request $request){
        Session::put('menu_item_parent', 'media');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        if($request->input('id')) {
            $id     = $request->input('id');
            $data   = $request->all();
            unset($data['id']);
            if($data['subcontent'] == 1) 
                $data['subcontent'] = 0;
            else 
                $data['subcontent'] = null;
            $heroExist = Gallery::with('community:communityIdx,communityName')->where('content', $data['content'])->where('subcontent', 0)->get()->first();

            if($data['subcontent'] !== 0){
                if($heroExist) {
                    $max_sequence = Gallery::where('content', $data['content'])->where('subcontent', null)->orderby('sequence', 'DESC')->get()->first();
                    if($max_sequence) { 
                        $data['sequence'] = $max_sequence->sequence + 1; 
                    } else { 
                        $data['sequence'] = 1;  $data['updated_at'] = date(DB_DATETIME_FORMAT); 
                    }
                }else{
                    return "Hero data doesn't exist. You need to add it first!";
                    }
            } else{
                if($heroExist && $id != $heroExist->id){ 
                    return $heroExist->community->communityName." community cover image data already exist. You can edit it directly!"; 
                } else { 
                    $data['sequence'] = 1;$data['updated_at'] = date(DB_DATETIME_FORMAT); 
                }
            }
            Gallery::find($id)->update($data);
            if ($request->hasFile('uploadedFile')) {
                $this->media_upload_attach($request, $id);
            }
            Session::flash('flash_success', 'Media has been updated successfully'); 
            return "success";
        } else {
            $data = $request->all();            
            unset($data['id']);
            if($data['subcontent'] == 1) 
                $data['subcontent'] = 0;
            else 
                unset($data['subcontent']);
            $data['category'] = "community";
            $heroExist = Gallery::with('community:communityIdx,communityName')->where('content', $data['content'])->where('subcontent', 0)->get()->first();

            if(!isset($data['subcontent'])){
                if($heroExist){
                    $max_sequence = Gallery::where('content', $data['content'])->where('subcontent', null)->orderby('sequence', 'DESC')->get()->first();
                    if($max_sequence) 
                        $data['sequence'] = $max_sequence->sequence + 1;
                    else 
                        $data['sequence'] = 1;
                }else{
                    return "Hero data doesn't exist. You need to add it first!";
                }
            } else{
                if($heroExist) 
                    return $heroExist->community->communityName." community cover image data already exist. You can edit it directly!";
                else 
                    $data['sequence'] = 1;
            } 
            $savedData  = Gallery::create($data);
            if ($request->hasFile('uploadedFile')) {
                $this->media_upload_attach($request, $savedData->id);
            }
            Session::flash('flash_success', 'Media has been added successfully'); 
            return "success";
        }
    }
    
    /**
     *  
     *   Media Upload file
     */

    public function media_upload_attach(Request $request, $mediaIdx = 0){
        Session::put('menu_item_parent', 'media');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        $getfiles = $request->file('uploadedFile');
        $fileName = "media_".$mediaIdx.'.jpg';         
        SiteHelper::resizeAndUploadImage($getfiles,'MEDIA',$fileName);       
        Gallery::find($mediaIdx)->update(['thumb' => $fileName]);
        return "true";
    }
    
    /**
     *  Preview Home page
     * 
     */

    public function preview_home($url, $model)
    {
        $url    = $url;
        $model  = $model;
        $featured_data = HomeFeaturedData::join('providers', 'providers.providerIdx', '=', 'home_featured_data.providerIdx')
                                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                                        ->get()
                                        ->first();
        $trendings      = HomeTrending::orderby('order', 'asc')->limit(6)->get();
        $marketplaces   = HomeMarketplace::orderby('order', 'asc')->limit(3)->get();
        $teampicks      = HomeTeamPicks::orderby('order', 'asc')->limit(3)->get();
        $featured_providers = HomeFeaturedProvider::join('providers', 'providers.providerIdx', '=', 'home_featured_provider.providerIdx')
                    ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                    ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                    ->orderby('order', 'asc')
                    ->limit(6)
                    ->get();
        $top_usecases = Article::where('communityIdx', '<>', null)->with('community')->orderby('published', 'desc')->limit(3)->get();
        $data = array('featured_data', 'trendings', 'marketplaces', 'teampicks', 'featured_providers', 'top_usecases', 'url', 'model');
        return view('preview.home', compact($data));
    }
    
    /**
     *   Preview Check
     * 
     */

    public function preview_check($url, $model, $check) {
        if($check == '1') {
            if($model == 'HomeFeaturedData') {
                HomeFeaturedData::where('active', '=', 0)->update(['active'=>1]);
            }
            if($model == 'HomeFeaturedProvider'){
                HomeFeaturedProvider::where('active', '=', 0)->update(['active'=>1]);
            }
            if($model == 'HomeMarketplace'){
                HomeMarketplace::where('active', '=', 0)->update(['active'=>1]);
            }
            if($model == 'HomeTeamPicks'){
                HomeTeamPicks::where('active', '=', 0)->update(['active'=>1]);
            }
            if($model == 'HomeTrending'){
                HomeTrending::where('active', '=', 0)->update(['active'=>1]);
            }
            return redirect()->route($url);
        } else {
            return redirect()->route($url);
        }
        
    }
    /********************************************************************************   
     * 
     *  Help Buying Data Functions for Admin section
     * 
     ********************************************************************************/ 

    /**
     *  
     *  Help buying data
     */

    public function help_buying_data(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_title_intro');
        $header = HelpTopic::where('page', 'buying_header')->get()->first();
        $data = array('header');
        return view('admin.help_buying_data', compact($data));
    }
    
    /**
     *  Update help buying data
     * 
     */

    public function update_help_buying_data(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_title_intro');
        if($request->helpTopicIdx == 0){
            $header['title']        = $request->title;
            $header['description']  = $request->description;
            $header['page']         = 'buying_header';
            HelpTopic::create($header);
            Session::flash('flash_success', 'Help Question about buying data has been added successfully'); 
        }else{
            $header['title']        = $request->title;
            $header['description']  = $request->description;
            $header['page']         = 'buying_header';
            HelpTopic::where('helpTopicIdx', $request->helpTopicIdx)->update($header);
            Session::flash('flash_success', 'Help Question about buying data has been updated successfully'); 
        }
        return "success";
    }
    
    /**
     *  
     *  help buying FAQ
     */

    public function help_buying_faqs(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_faqs');
        $faqs = FAQ::where('for', 'buying')->orderBy('created_at', 'desc')->get();
        $data = array('faqs');
        return view('admin.help_buying_data_faqs', compact($data));
    }
    
    /**
     *  Update help buying FAQ page
     * 
     */

    public function edit_help_buying_faq(Request $request, $fid = 0){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_faqs');
        if($fid == 0){
            return view('admin.help_buying_data_faq_edit');
        }else{
            $faq    = FAQ::where('faqIdx', $fid)->get()->first();
            if(!$faq){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
            $data   = array('faq');
            return view('admin.help_buying_data_faq_edit', compact($data));
        }
    }
    
    /**
     *  
     *  Update help buying FAQ
     */

    public function update_help_buying_faq(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_faqs');
        if($request->faqIdx == 0){
            $faq['faq']         = $request->faq;
            $faq['description'] = $request->description;
            $faq['for']         = "buying";
            FAQ::create($faq);
            Session::flash('flash_success', 'Buying Help FAQ has been added successfully');
        }else{
            $faq['faq']         = $request->faq;
            $faq['description'] = $request->description;
            $faq['for']         = "buying";
            FAQ::where('faqIdx', $request->faqIdx)->update($faq);
            Session::flash('flash_success', 'Buying Help FAQ has been updated successfully');
        }
        return "success";
    }
    
    /**
     *  
     *  Delete buying FAQ
     */

    public function delete_help_buying_faq(Request $request, $fid){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_faqs');
        FAQ::where('faqIdx', $fid)->delete();
        Session::flash('flash_success', 'Buying Help FAQ has been deleted successfully');
        return "success";
    }
    
    /**
     *  
     * 
     * Help buying data topic
     * 
     */

    public function help_buying_data_topics(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_topics');
        $topics = HelpTopic::where('page', 'buying')->orderBy('created_at', 'DESC')->get();
        $data   = array('topics');
        return view('admin.help_buying_data_topics', compact($data));
    }
    
    /**
     *  
     * 
     * Edit help data topic page
     * 
     */

    public function edit_help_buying_data_topic(Request $request, $tid = 0){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_topics');

        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
            );

        if($tid == 0){
            $data = array('statusList');
            return view('admin.help_buying_data_topic_edit', compact($data));           
        }else{
            $topic = HelpTopic::where('helpTopicIdx', $tid)->get()->first();
            if(!$topic){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
            $data  = array('topic', 'statusList');
            return view('admin.help_buying_data_topic_edit', compact($data));
        }
    }
    
    /**
     *  
     * 
     * Update help buying data topic
     * 
     */

    public function update_help_buying_data_topic(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_topics');
        if($request->helpTopicIdx==0){  
            $topic['page']          = "buying";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            $topic['meta_title']    = $request->meta_title;
            $topic['meta_description'] = $request->meta_description;
            $topic['active']        = $request->active;
            HelpTopic::create($topic);
            Session::flash('flash_success', 'Buying Help New Topic has been added successfully');
        }else{
            $topic['page']          = "buying";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            $topic['meta_title']    = $request->meta_title;
            $topic['meta_description'] = $request->meta_description;
            $topic['active']        = $request->active;
            HelpTopic::where('helpTopicIdx', $request->helpTopicIdx)->update($topic);
            Session::flash('flash_success', 'Buying Help Topic has been updated successfully');
        }
        return "success";
    }
    
    /**
     *  
     * 
     * Publish help buying data topic
     * 
     */

    public function publish_help_buying_data_topic(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_topics');
        $helpTopicIdx   = $request->helpTopicIdx;
        $topic          = HelpTopic::where('helpTopicIdx', $helpTopicIdx)->get()->first();
        $new['active']  = 1 - $topic->active;
        HelpTopic::where('helpTopicIdx', $helpTopicIdx)->update($new);
        echo "success";
    }
    
    /**
     *  
     * 
     * Delete help buying data topic
     * 
     */

    public function delete_help_buying_data_topic(Request $request, $tid){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'buying_data');
        Session::put('menu_item_child_child', 'buying_topics');
        HelpTopic::where('helpTopicIdx', $tid)->delete();
        Session::flash('flash_success', 'Buying Help Topic has been deleted successfully');
        return "success";
    }
    
    /**
     *  
     * 
     * Help selling data
     * 
     */

    public function help_selling_data(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_title_intro');

        $header     = HelpTopic::where('page', 'selling_header')->get()->first();
        $data       = array('header');
        return view('admin.help_selling_data', compact($data));
    }
    
    /**
     *  
     * 
     * update help selling data
     * 
     */

    public function update_help_selling_data(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_title_intro');
        if($request->helpTopicIdx == 0){
            $header['title']        = $request->title;
            $header['description']  = $request->description;
            $header['page']         = 'selling_header';
            HelpTopic::create($header);
            Session::flash('flash_success', 'Help - Selling Data - Title and Intro has been added successfully');
        }else{
            $header['title']        = $request->title;
            $header['description']  = $request->description;
            $header['page']         = 'selling_header';
            HelpTopic::where('helpTopicIdx', $request->helpTopicIdx)->update($header);
            Session::flash('flash_success', 'Help - Selling Data - Title and Intro has been updated successfully');
        }
        return "success";
    }
    
    /**
     *  
     * 
     * Help selling FAQ
     * 
     */

    public function help_selling_faqs(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_faqs');
        $faqs = FAQ::where('for', 'selling')->orderBy('created_at', 'desc')->get();
        $data = array('faqs');
        return view('admin.help_selling_data_faqs', compact($data));
    }
    
    /**
     *  
     * 
     * Edit help selling FAQ
     * 
     */

    public function edit_help_selling_faq(Request $request, $fid = 0){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_faqs');

        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
            );

        if($fid == 0){
            $data = array('statusList');            
            return view('admin.help_selling_data_faq_edit', compact($data));
        }else{
            $faq    = FAQ::where('faqIdx', $fid)->get()->first();
            if(!$faq){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
            $data   = array('faq', 'statusList');             
            return view('admin.help_selling_data_faq_edit', compact($data));
        }
    }
    
    /**
     *  
     * 
     * Update help selling FAQ
     * 
     */

    public function update_help_selling_faq(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_faqs');
        if($request->faqIdx == 0){
            $faq['faq']         = $request->faq;
            $faq['description'] = $request->description;
            $faq['for']         = "selling";
            FAQ::create($faq);
            Session::flash('flash_success', 'Help Selling FAQ has been added successfully');
        }else{
            $faq['faq']         = $request->faq;
            $faq['description'] = $request->description;
            $faq['for']         = "selling";
            FAQ::where('faqIdx', $request->faqIdx)->update($faq);
            Session::flash('flash_success', 'Help Selling FAQ has been updated successfully');
        }
        return "success";
    }
    
    /**
     *  
     * Delete help selling FAQ
     * 
     */

    public function delete_help_selling_faq(Request $request, $fid){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_faqs');
        FAQ::where('faqIdx', $fid)->delete();
        Session::flash('flash_success', 'Help Selling FAQ has been deleted successfully');
        return "success";
    }
    
    /**
     *  
     * 
     * Help selling data topics
     * 
     */

    public function help_selling_data_topics(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_topics');
        $topics = HelpTopic::where('page', 'selling')->orderBy('created_at', 'desc')->get();
        $data = array('topics');
        return view('admin.help_selling_data_topics', compact($data));
    }
    
    /**
     *  
     * 
     * Edit help selling data topics
     * 
     */

    public function edit_help_selling_data_topic(Request $request, $tid = 0){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_topics');
        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
            );

        if($tid == 0){
            $data = array('statusList');            
            return view('admin.help_selling_data_topic_edit', compact($data));  
        }else{
            $topic = HelpTopic::where('helpTopicIdx', $tid)->get()->first();
            if(!$topic){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
            $data = array('topic', 'statusList');
            return view('admin.help_selling_data_topic_edit', compact($data));
        }
    }
    
    /**
     *  
     * 
     * Update help selling data topic
     * 
     */

    public function update_help_selling_data_topic(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_topics');
        if($request->helpTopicIdx==0){
            $topic['page']          = "selling";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            $topic['meta_title']    = $request->meta_title;
            $topic['meta_description'] = $request->meta_description;
            $topic['active']        = $request->active;
            HelpTopic::create($topic);
            Session::flash('flash_success', 'Help Selling Data has been added successfully');
        }else{
            $topic['page']          = "selling";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            $topic['meta_title']    = $request->meta_title;
            $topic['meta_description'] = $request->meta_description;
            $topic['active']        = $request->active;
            HelpTopic::where('helpTopicIdx', $request->helpTopicIdx)->update($topic);
            Session::flash('flash_success', 'Help Selling Data has been updated successfully');
        }
        return "success";
    }
    
    /**
     *  
     * 
     * Publish help selling data topic
     * 
     */

    public function publish_help_selling_data_topic(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_topics');

        $helpTopicIdx   = $request->helpTopicIdx;
        $topic          = HelpTopic::where('helpTopicIdx', $helpTopicIdx)->get()->first();
        $new['active']  = 1 - $topic->active;
        HelpTopic::where('helpTopicIdx', $helpTopicIdx)->update($new);
        Session::flash('flash_success', 'Help Selling Data has been published successfully');
        echo "success";
    }
    
    /**
     *  
     * 
     * Delete help selling data topic
     * 
     */

    public function delete_help_selling_data_topic(Request $request, $tid){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'selling_data');
        Session::put('menu_item_child_child', 'selling_topics');
        HelpTopic::where('helpTopicIdx', $tid)->delete();
        Session::flash('flash_success', 'Help Selling Data has been deleted successfully');
        return "success";
    }
    
    /**
     *  
     * 
     * Help guarantees
     * 
     */

    public function help_guarantees(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'guarantee');
        $topics = HelpTopic::where('page', 'guarantees')->orderBy('created_at', 'desc')->get();
        $data = array('topics');
        return view('admin.help_guarantees', compact($data));
    }
    
    /**
     *  
     * 
     * Edit help guarantees
     * 
     */

    public function edit_help_guarantee(Request $request, $tid = 0){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'guarantee');
        Session::put('menu_item_child_child', '');
        $statusList = array(
            0   =>  'Unpublish',
            1   =>  'Publish'
            );

        if($tid == 0){
            $data = array('statusList');            
            return view('admin.help_guarantee_edit', compact($data));
        }else{
            $topic = HelpTopic::where('helpTopicIdx', $tid)->get()->first();
            if(!$topic){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
            $data = array('topic','statusList');
            return view('admin.help_guarantee_edit', compact($data));
        }
    }
    
    /**
     *  
     * 
     * Delete help guarantees
     * 
     */

    public function delete_help_guarantee(Request $request, $tid){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'guarantee');
        Session::put('menu_item_child_child', '');
        HelpTopic::where('helpTopicIdx', $tid)->delete();
        Session::flash('flash_success', 'Help Guarantee Data has been deleted successfully');
        return "success";
    }
    
    /**
     *  
     * 
     * Update help guarantees
     * 
     */

    public function update_help_guarantee(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'guarantee');

        if($request->helpTopicIdx == 0){
            $topic['page']          = "guarantees";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            $topic['active']        = $request->active;
            HelpTopic::create($topic);
            Session::flash('flash_success', 'Help Guarantee Data has been added successfully');
        } else{
            $topic['page']          = "guarantees";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            $topic['active']        = $request->active;
            HelpTopic::where('helpTopicIdx', $request->helpTopicIdx)->update($topic);
            Session::flash('flash_success', 'Help Guarantee Data has been updated successfully');
        }
        return "success";
    }
    
    /**
     *  
     * Help complaints
     * 
     */

    public function help_complaints(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'complaint');
        Session::put('menu_item_child_child', '');
        $topics = HelpTopic::where('page', 'complaints')->orderBy('created_at', 'desc')->get();
        $data = array('topics');
        return view('admin.help_complaints', compact($data));
    }
    
    /**
     *  
     * 
     * Edit help complaint
     * 
     */

    public function edit_help_complaint(Request $request, $tid = 0){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'complaint');
        Session::put('menu_item_child_child', '');
        if($tid == 0){
            return view('admin.help_complaint_edit');
        }else{
            $topic = HelpTopic::where('helpTopicIdx', $tid)->get()->first();
            if(!$topic){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
            $data = array('topic');
            return view('admin.help_complaint_edit', compact($data));
        }
    }
    
    /**
     * 
     * Delete help complaint
     *  
     * 
     */

    public function delete_help_complaint(Request $request, $tid){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'complaint');
        Session::put('menu_item_child_child', '');

        HelpTopic::where('helpTopicIdx', $tid)->delete();
        Session::flash('flash_success', 'Help Complaint has been deleted successfully');
        return "success";
    }
    
    /**
     *  
     * 
     * Update help complaint
     * 
     */

    public function update_help_complaint(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'complaint');
        Session::put('menu_item_child_child', '');

        if($request->helpTopicIdx==0){
            $topic['page']          = "complaints";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            HelpTopic::create($topic);
            Session::flash('flash_success', 'Help Complaint has been created successfully');
        }else{
            $topic['page']          = "complaints";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            HelpTopic::where('helpTopicIdx', $request->helpTopicIdx)->update($topic);
            Session::flash('flash_success', 'Help Complaint has been updated successfully');
        }
        return "success";
    }
    
    /**
     *  
     * Help feedbacks
     * 
     */

    public function help_feedbacks(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'feedback');
        Session::put('menu_item_child_child', '');

        $topics = HelpTopic::where('page', 'feedbacks')->orderBy('created_at', 'desc')->get();
        $data = array('topics');
        return view('admin.help_feedbacks', compact($data));
    }
    
    /**
     *  
     * 
     * Edit help feedback
     * 
     */

    public function edit_help_feedback(Request $request, $tid = 0){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'feedback');
        Session::put('menu_item_child_child', '');

        if($tid == 0){
            return view('admin.help_feedback_edit');
        }else{
            $topic = HelpTopic::where('helpTopicIdx', $tid)->get()->first();
            if(!$topic){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
            $data  = array('topic');
            return view('admin.help_feedback_edit', compact($data));
        }
    }
    
    /**
     * 
     * Delete help feedback
     *  
     * 
     */

    public function delete_help_feedback(Request $request, $tid){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'feedback');
        Session::put('menu_item_child_child', '');
        HelpTopic::where('helpTopicIdx', $tid)->delete();
        Session::flash('flash_success', 'Help Feedback has been deleted successfully');
        return "success";
    }
    
    /**
     *  
     * 
     * Update help feedback
     * 
     */

    public function update_help_feedback(Request $request){
        Session::put('menu_item_parent', 'help');
        Session::put('menu_item_child', 'feedback');
        Session::put('menu_item_child_child', '');

        if($request->helpTopicIdx==0){
            $topic['page']          = "feedbacks";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            HelpTopic::create($topic);
            Session::flash('flash_success', 'Help Feedback has been created successfully');
        }else{
            $topic['page']          = "feedbacks";
            $topic['title']         = $request->title;
            $topic['description']   = $request->description;
            HelpTopic::where('helpTopicIdx', $request->helpTopicIdx)->update($topic);
            Session::flash('flash_success', 'Help Feedback has been updated successfully');
        }
        return "success";
    }
    
    /**
     *  
     * 
     * Compress image
     * 
     */
 
    public function compress_images(Request $request){
        if(isset($request->path)) {
            if($request->path == "gallery"){
                $path = public_path('images/gallery/thumbs');    
            }else{
                $path = public_path('uploads/'.$request->path);    
            }
            $folderValues= ['usecases'=>'USECASES','offer'=>'OFFER','gallery'=>'MEDIA','company'=>'COMPANY'];
            
            $files = File::allfiles($path);
            // /dd($files);
            if($request->path == "usecases" || $request->path == "offer" || $request->path == "gallery" ){
                foreach ($files as $key => $file) {                
                    $fileName = $file->getFilename();                
                    if($path ."/". $fileName == $file->getpathName() && File::exists($path . "/". $fileName)){
                     
                        SiteHelper::resizeAndUploadImage($file,$folderValues[$request->path],$fileName);   
                    }                
                }    
            }
            

            if($request->path == "company"){
                foreach ($files as $key => $file) {                
                    $fileName = $file->getFilename();        
                    if($path ."/". $fileName == $file->getpathName() && File::exists($path . "/". $fileName)){
                       
                        SiteHelper::resizeAndUploadImage($file,'COMPANY',$fileName); 
                        //image compress end
                    }    
                }    
            }

            echo "success";
        }                
    }
    
    /********************************************************************************   
     * 
     *  Users Functions for Admin section
     * 
     ********************************************************************************/

    /**
     *  
     * Users listing
     * 
     * 
     */
    
    public function users(Request $request){
        Session::put('menu_item_parent', 'users');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $users = User::join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        /* ->whereIn('users.userStatus',[0,1]) */
                        ->get(["users.*", 'companies.*', 'users.created_at as createdAt']);
        foreach($users as $user){
            $count_all = User::where('companyIdx', $user->companyIdx)->where('userStatus', 2)->get()->count();
            $count_pending = LinkedUser::where('invite_userIdx', $user->userIdx)->get()->count();
            $count_products = OfferProduct::join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                        ->where('users.userIdx', $user->userIdx)
                                        ->get()
                                        ->count();
            $user['count_all'] = $count_all;
            $user['count_pending'] = $count_pending;
            $user['count_products'] = $count_products;
        }
        $data = array('users');
        return view('admin.users', compact($data));
    }
    
    /**
     *  Get the company users
     * 
     * 
     */

    public function company_users(Request $request){
        Session::put('menu_item_parent', 'users');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $companyIdx = User::where('userIdx', $request->adminUserIdx)->get()->first()->companyIdx;
        $users = User::join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->where('users.userStatus', 2)
                        ->where('companies.companyIdx', $companyIdx)
                        ->get(['users.*', 'companies.*', 'users.created_at as createdAt'])
                        ->toArray();
        $result = array();
        foreach ($users as $user) {
            $temp = $user;
            $count_products = OfferProduct::join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                        ->where('users.userIdx', $user['userIdx'])
                                        ->get()
                                        ->count();
            $temp['count_products'] = $count_products;
            array_push($result, $temp);
        }
        return json_encode(array('users'=>$result));
    }
    
    /**
     *  
     *  Edit user Display Page
     * 
     * 
     */

    public function edit_user(Request $request){
        Session::put('menu_item_parent', 'users');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $user = User::join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                    ->where('users.userIdx', $request->userIdx)
                    ->get()
                    ->first();
        if(!$user){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $businesses = Business::get();

        $data = array('user', 'businesses');
        return view('admin.edit_user', compact($data));
    }
    
    /**
     *  Update user Submit Page data 
     * 
     * 
     */

    public function update_user(Request $request){
        Session::put('menu_item_parent',    'users');
        Session::put('menu_item_child',     '');
        Session::put('menu_item_child_child', '');
        $user = User::where('userIdx', $request->userIdx)->get()->first();

        if($user){
            $data               = array();
            $data['firstname']  = $request->firstname;
            $data['lastname']   = $request->lastname;
            $data['email']      = $request->email;
            $data['jobTitle']   = $request->jobTitle;
            if($request->businessName2 == "Other industry") {
                $data['businessName'] = $request->businessName;
            } else {
                $data['businessName'] = $request->businessName2;
            }
            if($request->role2 == "Other") {
                $data['role'] = $request->role;
            } else {
                $data['role'] = $request->role2;
            }
            User::where('userIdx', $request->userIdx)->update($data);

            $logDetail = 'Updated: UserID- '.$request->userIdx.', Email- '.$data['email'].', Firstname- '.$data['firstname'].', Lastname- '.$data['lastname'];
            SiteHelper::logActivity('USER', $logDetail, 'admin');

            Session::flash('flash_success', 'User detail has been updated successfully');
            echo "success";
        }else 
            echo "fail";
    }
    
    /**
     *  Delete User from admin
     * 
     * 
     * 
     */
    
    public function delete_user(Request $request){
        Session::put('menu_item_parent', 'users');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $user = User::where('userIdx', $request->userIdx)->get()->first();
        if(!$user){
            Session::flash('flash_error', 'Record you are looking to delete is not found or already deleted.');
            return "success";
        }
        if($user){
            if($user->userStatus == 1){
                $subusers = User::where('companyIdx', $user->companyIdx)->get();
                if($subusers->count() > 0){
                    foreach ($subusers as $user) {
                        $provider = Provider::where('userIdx', $user->userIdx)->get()->first();
                        if($provider){
                            $offer = Offer::where('providerIdx', $provider->providerIdx)->get()->first();
                            if($offer){
                                $products = OfferProduct::where('offerIdx', $offer->offerIdx)->get();
                                foreach ($products as $product) {
                                    RegionProduct::where('productIdx', $product->productIdx)->delete();
                                }
                                OfferProduct::where('offerIdx', $offer->offerIdx)->delete();

                                OfferCountry::where('offerIdx', $offer->offerIdx)->delete();
                                OfferSample::where('offerIdx', $offer->offerIdx)->delete();
                                OfferTheme::where('offerIdx', $offer->offerIdx)->delete();
                                Offer::where('providerIdx', $provider->providerIdx)->delete();
                            }
                           
                            Provider::where('userIdx', $user->userIdx)->delete();
                        }
                        BillingInfo::where('userIdx', $user->userIdx)->delete();
                        User::where('userIdx', $user->userIdx)->delete();
                    }
                }
                User::where('userIdx', $request->userIdx)->delete();
                Session::flash('flash_success', 'User has been deleted successfully');
                echo "success";
            } else if($user->userStatus == 2){
                try{
                    $provider = Provider::where('userIdx', $request->userIdx)->get()->first();
                    if($provider){
                        $offer = Offer::where('providerIdx', $provider->providerIdx)->get()->first();
                        if($offer){
                            $products = OfferProduct::where('offerIdx', $offer->offerIdx)->get();
                            foreach ($products as $product) {
                                RegionProduct::where('productIdx', $product->productIdx)->delete();
                            }

                            OfferProduct::where('offerIdx', $offer->offerIdx)->delete();
                            OfferCountry::where('offerIdx', $offer->offerIdx)->delete();
                            OfferSample::where('offerIdx', $offer->offerIdx)->delete();
                            OfferTheme::where('offerIdx', $offer->offerIdx)->delete();
                            Offer::where('providerIdx', $provider->providerIdx)->delete();
                        }
                       
                        Provider::where('userIdx', $request->userIdx)->delete();
                    }
                    BillingInfo::where('userIdx', $user->userIdx)->delete();
                    User::where('userIdx', $request->userIdx)->delete();
                    Session::flash('flash_success', 'User has been deleted successfully');
                    echo "success";
                }catch(Exception $e){
                    echo "fail";
                }
            }
        }else echo "fail";
    }

    /**
     *  
     *  Offers List page
     * 
     * 
     */

    public function getOffers(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'offers');
        Session::put('menu_item_child_child', '');
        $images = Offer::with('theme','community','provider','region', 'newInCommunity')->orderby('updated_at', 'desc')
                            ->get();
        $providerCount  = [];                
        $comunityCount  = [];                
        $regionCount    = [];  

        if($images){
            foreach($images as $imagesVal){
                $providerCount[] = $imagesVal->providerIdx;
                $comunityCount[] = $imagesVal->communityIdx;
                if(count($imagesVal->region) > 0){
                    foreach($imagesVal->region as $regionVal){
                        $regionCount[] = $regionVal->regionIdx;
                    }
                }
            }
        }    
       $providerCount   = count(array_unique($providerCount));
       $comunityCount   = count(array_unique($comunityCount));
       $regionCount     = count(array_unique($regionCount));

        $community = Community::select(['communityName'])->get();
        $provider = Provider::select(['companyName'])->get();
          
        $data           = array('images','providerCount','comunityCount','regionCount', 'community', 'provider');
        return view('admin.offers', compact($data));
    }

    /**
     *  
     *  Add/Edit Offer Display page
     * 
     */

    public function editOffer($id = 0){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'offers');
        Session::put('menu_item_child_child', '');

        $communities    = Community::where('status', 1)->get();
        $providers      = Provider::get();
        $offer          = Offer::where('offerIdx', $id)->get()->first();
        if(!$offer){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $data           = array('id', 'communities', 'offer','providers');
        
        return view('admin.offer_edit', compact($data));
    }

    /**
     *  Update Offer Data
     * 
     * 
     */

    public function offerUpdate(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'offers');
        Session::put('menu_item_child_child', '');

        if($request->input('offerIdx')) {
           $id          = $request->input('offerIdx');
           $slug        = SiteHelper::slugify($request->offerTitle);
           $slugCount   = Offer::where('slug', $slug)->where('offerIdx', '!=', $id)->count();
            if ($slugCount > 0) {
                $slug = $slug. '-'.$id;
            }

            $data = $request->all();
            $data['slug'] = $slug;
           
            unset($data['offerIdx']);
            Offer::find($id)->update($data);

            $logDetail = 'Updated: ID- '.$id.', Title- '.$data['offerTitle'].', CommunityID- '.$data['communityIdx'];
            SiteHelper::logActivity('OFFER', $logDetail, 'admin');

            if ($request->hasFile('offerImage')) {
                $this->offer_upload_attach($request, $id);
            }
            Session::flash('flash_success', 'Offer has been updated successfully'); 
            return "success";
        }
    }

    /**
     *  
     *   Offer Upload file
     * 
     */

    public function offer_upload_attach(Request $request, $offerIdx = 0) {
        Session::put('menu_item_parent', 'media');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $getfiles = $request->file('offerImage');
        $fileName = "offer_".$offerIdx.'.jpg';         
        //image compress start
        SiteHelper::resizeAndUploadImage($getfiles,'OFFER',$fileName);
      
        Offer::find($offerIdx)->update(['offerImage' => $fileName]);
        return "true";
    }

    /**
     *   Delete Offer
     * 
     * 
     */

    public function deleteOffer(Request $request) {
        Session::put('menu_item_parent', 'offers');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        Offer::where('offerIdx', $request->mid)->delete();
        return "success";
    }
   
    /**
     *  Offer Publish Item
     * 
     */

    public function Offerpublish(Request $request) {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'offers');
        Session::put('menu_item_child_child', '');

        $offerIdx   = $request->offerIdx;
        $offer      = Offer::where('offerIdx', $offerIdx)->get()->first();
        $new['status'] = 1 - $offer->status;
        Offer::where('offerIdx', $offerIdx)->update($new);

        if($new['status'] == 1) {
            Session::flash('flash_success', 'Offer has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Offer has been Unpublished successfully'); 
        }        
        echo "success";
    }
    /**
     *  User Publish Item
     * 
     * 
     */

    public function userPublish(Request $request) {
        Session::put('menu_item_parent', 'users');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        $userIdx    = $request->userIdx;
        $user       = User::where('userIdx', $userIdx)->get()->first();
        $new['userStatus'] = 1 - $user->userStatus;
        User::where('userIdx', $userIdx)->update($new);

        if($new['userStatus'] == 1) {
            Session::flash('flash_success', 'User has been Active successfully'); 
        }else {
            Session::flash('flash_success', 'User has been Inactive successfully'); 
        }        
        echo "success";
    }

    
    /**
     *  Offer Detail Item
     * 
     */

    public function details(Request $request) {   
        $offers = Offer::with(['region', 'provider', 'usecase', 'theme'])                   
                        ->join('communities', 'offers.communityIdx', '=',  'communities.communityIdx')
                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->get();
        $offer = null;
        foreach ($offers as $key => $off) {
            $companyName    = str_replace(' ', '', strtolower($off->companyName));
            $reg            = $off->region;
            $offer_region   = "";
            $offer_title    = str_replace(' ', '-', strtolower($off->offerTitle));
            foreach ($reg as $key => $r) {
                $offer_region = $offer_region . str_replace(' ', '-', strtolower($r->regionName));
                if($key+1 < count($reg)) $offer_region = $offer_region . "-";
            }
            if($request->companyName == $companyName && $request->param == $offer_title.'-'.$offer_region){
                $offer = $off;
                break;
            }
        }       

        if(!$offer) return view('errors.404');

        $user_info = User::join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                            ->where('users.userIdx', $offer->provider->userIdx)
                            ->first();
        
        $offersample = OfferSample::with('offer')->where('offerIdx', $offer->offerIdx)->where('deleted', 0)->get();        
        $prev_route = "";       
                
        $products = OfferProduct::with(['region'])->where('offerIdx', '=', $offer->offerIdx)->where("productStatus", 1)->get();

        if(  $prev_route && strpos($prev_route, 'data_community.') === false ){
            $prev_route = '';
        }

        if ($offer['offerImage']) {                           
            if (strpos($offer['offerImage'], 'media_') === false ) {                           
                $offer['offerImage'] = '/uploads/offer/medium/'.$offer['offerImage'];    
            }else{
                $offer['offerImage'] = $offer['offerImage'];    
            }
        }    
            
        $data = array('id'=>$offer->offerIdx, 'offer' => $offer, 'offersample' => $offersample, 'prev_route' => $prev_route, 'user_info' => $user_info, 'products' => $products);
        return view('data.details')->with($data);        
    }
    
    /**
     *  Offer Publish Item
     * 
     */

    public function exportUser(Request $request) {
        return Excel::download(new UsersExport, APPLICATION_NAME.'_Users_'.str_Replace(' ','_',date(SIMPLE_DATE)).'.xlsx');
    }

    /**
     *  Offer export
     * 
     */

    public function exportOffers(Request $request) {
        return Excel::download(new OfferExport, APPLICATION_NAME.'_Offers_'.str_Replace(' ','_',date(SIMPLE_DATE)).'.xlsx');
    }
  
    
    /**
     *  Top use cases listing
     * 
     */

    public function homeTopUseCases() {   
        Session::put('menu_item_parent', 'home');
        Session::put('menu_item_child', 'top_use_cases');
        Session::put('menu_item_child_child', '');
        $boards = Article::with('community')->where('top_use_case', 1)->where('isUseCase', 1)->get();
        $data = array('boards');
        return view('admin.top_usecases', compact($data));
    }

    /** 
     *  Promote Article
     * 
     */

    public function promoteArticle(Request $request){
        $articleIdx = $request->articleIdx;
        $article    = Article::where('articleIdx', $articleIdx)->get()->first();

        if($request->status == 1){
            if($article->communityIdx != ""){
                $count = Article::where('top_use_case', 1)->count();
                if($count >= 3){
                    Session::flash('flash_success', 'Already three uses cases are currently visible to home page, please deactive one of them to promote this.'); 
                } else {
                    Session::flash('flash_success', 'Use case successfully promoted to homepage.');
                    Article::where('articleIdx', $articleIdx)->update(['top_use_case'=>1]);
                }
            } else{
                
                Session::flash('flash_success', 'This Usecase do not have community attached, please attached it first.'); 
            }
        } else{
            Session::flash('flash_success', 'Use case successfully removed from homepage.');
            Article::where('articleIdx', $articleIdx)->update(['top_use_case'=>0]);
        }
        echo "success";
    }

    /**
     *  
     * Usecases upload the Image
     */

    public function imageUpload(Request $request) {
            $getfiles = $request->file('upload');
            if (!file_exists('uploads/editor')) {
                mkdir('uploads/editor', 0777, true);
            }
            $originName     = $request->file('upload')->getClientOriginalName();
            $fileName       = pathinfo($originName, PATHINFO_FILENAME);
            $extension      = $request->file('upload')->getClientOriginalExtension();
            $fileName       = $fileName.'_'.time().'.'.$extension;

            $getfiles->move(public_path('uploads/editor'), $fileName);
            
            $CKEditorFuncNum    = $request->input('CKEditorFuncNum');
            $msg                = 'File uploaded successfully'; 
            $url                = asset('uploads/editor/'.$fileName); 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
    }

    /**
     *  
     *  Browse image
     * 
     */
    public function browseImages(Request $request) {
       return view('admin.content.browse');    
        
    }

    /**
     *
     *   Admin purchase list 
     * 
     */
    
    public function purchases(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'purchases');
        Session::put('menu_item_child_child', '');

        $purchases = OfferProduct::with(['region'])
                    ->select("offerProducts.*", "offers.*", "providers.*", "users.*", "companies.*", "purchases.*", "purchases.userIdx as buyyer_id", "bids.*", "purchases.productIdx as productIDX")
                    ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                    ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                    ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                    ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                    ->join('purchases', 'purchases.productIdx', '=', 'offerProducts.productIdx')
                    ->leftjoin('bids', 'bids.bidIdx', '=', 'purchases.bidIdx')
                    ->orderBy('purchases.created_at', 'desc')
                    ->get();
        foreach($purchases as $key => $purchase){            
            $purchase_user = User::where('userIdx', $purchase->buyyer_id)->first();
            if($purchase_user){
                $purchases[$key]['buyyer_name'] = $purchase_user['firstname']." ".$purchase_user['lastname'];
            }
            
        }
        
        $data = array('purchases');
        return view('admin.purchases', compact($data));
    }

    /**
     *  Purchase List Expoert
     * 
     */

    public function exportPurchases(Request $request){
        return Excel::download(new PurchaseExport, APPLICATION_NAME.'_Purchases_'.str_Replace(' ','_',date(SIMPLE_DATE)).'.xlsx');
    }

    /**
     *  Home Featured Data Submit the Edited Data
     * 
     */
    public function home_featured_data_publish(Request $request) {
        $id             = $request->id;
        $partner        = HomeFeaturedData::where('id', $id)->get()->first();
        $new['active']  = 1 - $partner->active;
        HomeFeaturedData::where('id', $id)->update($new);

        if($new['active'] == 1) {
            Session::flash('flash_success', 'Data has been Published successfully'); 
        } else {
            Session::flash('flash_success', 'Data has been Unpublished successfully'); 
        } 
        echo "success";

    }
    /**
     *  Home Featured Data Submit the Edited Data
     * 
     */
    public function home_trending_publish(Request $request) {
        $id             = $request->id;
        $partner        = HomeTrending::where('id', $id)->get()->first();
        $new['active']  = 1 - $partner->active;
        HomeTrending::where('id', $id)->update($new);
        if($new['active'] == 1) {
            Session::flash('flash_success', 'Data has been Published successfully'); 
        } else {
            Session::flash('flash_success', 'Data has been Unpublished successfully'); 
        } 
        echo "success";
    }
    
    /**
     *  Home Featured Data Submit the Edited Data
     * 
     */
    public function home_featured_provider_publish(Request $request) {
        $id             = $request->id;
        $partner        = HomeFeaturedProvider::where('id', $id)->get()->first();
        $new['active']  = 1 - $partner->active;
        HomeFeaturedProvider::where('id', $id)->update($new);
        if($new['active'] == 1) {
            Session::flash('flash_success', 'Data has been Published successfully'); 
        } else {
            Session::flash('flash_success', 'Data has been Unpublished successfully'); 
        } 
        echo "success";

    }

    /**
     *  Home Featured Data Submit the Edited Data
     * 
     */
    public function home_teampicks_publish(Request $request) {
        $id             = $request->id;
        $partner        = HomeTeamPicks::where('id', $id)->get()->first();
        $new['active']  = 1 - $partner->active;
        HomeTeamPicks::where('id', $id)->update($new);
        if($new['active'] == 1) {
            Session::flash('flash_success', 'Data has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Data has been Unpublished successfully'); 
        } 
        echo "success";

    }
    /**
     *  Home Featured Data Submit the Edited Data
     * 
     */
    public function home_marketplace_publish(Request $request) {
        $id             = $request->id;
        $partner        = HomeMarketplace::where('id', $id)->get()->first();
        $new['active']  = 1 - $partner->active;
        HomeMarketplace::where('id', $id)->update($new);
        if($new['active'] == 1) {
            Session::flash('flash_success', 'Data has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Data has been Unpublished successfully'); 
        } 
        echo "success";

    }

    /**
     *  Dasboard data fething from DB and populate in variables to display on Dashboard page
     * 
     */
    public function howtouse()  {

        return view('admin.howtouse');
    }


    /**
     *  Serached Keys listing
     * 
     */
    public function searchKeys(Request $request){


        Session::put('menu_item_parent', 'searchkeys');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        $Query = "SELECT s.*,u.firstname,u.lastname,u.email FROM `searched_keys` s
                       LEFT JOIN users u ON s.searched_by = u.userIdx ORDER BY s.created_at DESC";
        $all_keys = DB::select($Query);

        $data = array('all_keys');
        return view('admin.keys', compact($data));
        
    }

     /**
     *  Exporting Serached Keys
     * 
     */

    public function exportSearchedKeys(Request $request){
        return Excel::download(new SearchKeys, APPLICATION_NAME.'_SearchedKeywords_'.str_Replace(' ','_',date(SIMPLE_DATE)).'_'.time().'.xlsx');
    }


     /**
     *  
     *  Products List page
     * 
     * 
     */

    public function getProducts(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'products');
        Session::put('menu_item_child_child', '');
        $OfferProducts  = OfferProduct::with(['region'])
                ->select("offerProducts.*", "offerProducts.created_at as offercreated", "offerProducts.updated_at as offercupdated", "offers.*", "providers.*", "users.*")
                ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                ->join('users', 'users.userIdx', '=', 'providers.userIdx')     
                ->orderBy('offerProducts.created_at', 'desc')
                ->get();  
      
        $data           = array('OfferProducts');
        return view('admin.products', compact($data));
    }

      /**
     *  
     *  Product Details
     * 
     */

    public function productdetails(Request $request){

        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'products');
        Session::put('menu_item_child_child', '');

        $productIdx = $request->pid;

        $product  = OfferProduct::with(['region'])
        ->select("offerProducts.*", "offers.*", "providers.*", "users.*")
        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
        ->join('users', 'users.userIdx', '=', 'providers.userIdx')   
        ->where('productIdx', '=', $productIdx)
        ->get();
        
        $mappings = ProductPriceMap::where('productIdx','=',$productIdx)->get();
        $product['productpricemappings'] = $mappings;
        

        $data           = array('product');
        return view('admin.product_details', compact($data));
        

    }

    /**
     *  
     *  Add/Edit Product Display page
     * 
     */

    public function editProduct($id = 0){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'products');
        Session::put('menu_item_child_child', '');

        $communities    = Community::where('status', 1)->get();
        $providers      = Provider::get();
        $OfferProduct   = OfferProduct::where('productIdx', $id)->get()->first();
        if(!$OfferProduct){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $data           = array('id', 'communities', 'OfferProduct','providers');
        
        return view('admin.products_edit', compact($data));
    }

    /**
     *  Update Product Data
     * 
     * 
     */

    public function productUpdate(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'products');
        Session::put('menu_item_child_child', '');

        if($request->input('productIdx')) {
            $id          = $request->input('productIdx');         
            $data = $request->all();
           
            unset($data['productIdx']);
            OfferProduct::find($id)->update($data);

            $logDetail = 'Updated: ID- '.$id.', Title- '.$data['productTitle'];
            SiteHelper::logActivity('PRODUCT', $logDetail, 'admin');

            Session::flash('flash_success', 'Product has been updated successfully'); 
            return "success";
        }
    }


    /**
     *   Delete Product
     * 
     * 
     */

    public function deleteProduct(Request $request) {
        Session::put('menu_item_parent', 'products');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        RegionProduct::where('productIdx', $request->pid)->delete();
        OfferProduct::where('productIdx', $request->pid)->delete();
        return "success";
    }



    /**
     *  
     *  Content List page
     * 
     * 
     */

    public function getContents(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'contents');
        Session::put('menu_item_child_child', '');
        $Contents  = DB::select('SELECT * FROM contents ORDER BY created_at DESC');
      
        $data = array('Contents');
        return view('admin.contents', compact($data));
    }
    /**
     *  
     *  Add/Edit Content Display page
     * 
     */

    public function addContents(){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'contents');
        Session::put('menu_item_child_child', '');
        
        return view('admin.contents_add');
    }


    public function contentInsert(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'contents');
        Session::put('menu_item_child_child', '');

            $data = $request->all();
           
            $id =  DB::table('contents')->insertGetId($data);

            if ($request->hasFile('content_image_path')) {  

                $image = $request->file('content_image_path');
                $name = $id.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/home_content');
                $image->move($destinationPath, $name);                
         
                DB::table('contents')->where('id',$id)->update(['content_image_path' => '/images/home_content/'.$name]);                              
            }

            $logDetail = 'Created: Title- '.$data['content_title'];
            SiteHelper::logActivity('Contents', $logDetail, 'admin');


            Session::flash('flash_success', 'Content has been added successfully'); 
            return "success";        
    }

    public function editContents($id = 0){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'contents');
        Session::put('menu_item_child_child', '');

        $update_query = "SELECT * FROM contents WHERE id ='$id'";
        $contentDetails   =  DB::select($update_query);
        $contentDetails = $contentDetails[0];
        $data           = array('id', 'contentDetails');
        
        return view('admin.contents_edit', compact($data));
    }

    /**
     *  Update Content Data
     * 
     * 
     */

    public function contentUpdate(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'contents');
        Session::put('menu_item_child_child', '');

        if($request->input('id')) {
            $id          = $request->input('id');         
            $data = $request->all();
           
            unset($data['id']);
            DB::table('contents')->where('id',$id)->update($data);

            if ($request->hasFile('content_image_path')) {   
                
                $image = $request->file('content_image_path');
                $name = $id.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/home_content');
                $image->move($destinationPath, $name);                
         
                DB::table('contents')->where('id',$id)->update(['content_image_path' => '/images/home_content/'.$name]);                                 
            }

            $logDetail = 'Updated: ID- '.$id.', Title- '.$data['content_title'];
            SiteHelper::logActivity('Contents', $logDetail, 'admin');

            Session::flash('flash_success', 'Content has been updated successfully'); 
            return "success";
        }
    }

}
