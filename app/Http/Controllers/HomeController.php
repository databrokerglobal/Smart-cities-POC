<?php
/**
 *  
 *  Home Controller
 * 
 * This file is a part of the Databroker.Global package.
 *
 * (c) Databroker.Global
 *
 * @author    Databroker.Global
 * 
 */
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\HomeFeaturedData;
use App\Models\HomeTrending;
use App\Models\HomeMarketplace;
use App\Models\HomeTeamPicks;
use App\Models\HomeFeaturedProvider;
use Mail;
use App\Models\Article;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Region;
use App\Models\Company;
use App\Helper\SiteHelper;
use DB;
use App\User;
use Config;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        //$this->middleware(['auth','verified']);        

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
          $featured_data = Offer::with(['region', 'provider', 'usecase'])
                                ->select('home_featured_data.*','offers.*','offers.slug as offer_slug','providers.*','companies.*','companies.slug as company_slug')
                                ->join('communities', 'offers.communityIdx', '=',  'communities.communityIdx')
                                ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                                ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                                ->join('home_featured_data', 'offers.offerIdx', '=', 'home_featured_data.offerIdx')
                                ->where('offers.status', 1)
                                ->where('home_featured_data.id',1)                            
                                ->first();
        
        $trendings      = HomeTrending::with('offer')->where('active', 1)->whereNotNull('offerIdx')->orderby('order', 'asc')->limit(6)->get();  
        $marketplaces   = Offer::with(['region', 'provider', 'usecase'])
                                ->select('offers.*','offers.slug as offer_slug','providers.*','companies.*','companies.slug as company_slug')
                                ->join('communities', 'offers.communityIdx', '=',  'communities.communityIdx')
                                ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                                ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                                ->where('offers.status', 1)
                                ->orderby('offers.offerIdx', 'ASC')
                                ->limit(3)
                                ->get();

        $teampicks      = HomeTeamPicks::where('active', 1)->orderby('order', 'asc')->limit(3)->get();
        $featured_providers = HomeFeaturedProvider::join('providers', 'providers.providerIdx', '=', 'home_featured_provider.providerIdx')
                                            ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                            ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                                            ->where('active', 1)
                                            ->orderby('order', 'asc')
                                            ->limit(6)
                                            ->get();
        $top_usecases   = Article::where('communityIdx', '<>', null)->with('community')->where('top_use_case', 1)->limit(3)->get();
        $data           = array('featured_data', 'trendings', 'marketplaces', 'teampicks', 'featured_providers', 'top_usecases');   
        return view('home_cms', compact($data));
    }
    /**
     * 
     *  Send email
     * 
     */
    public function sendEmail($tplName, $params){
		return;
        $from       = $params['from'];
        $to         = $params['to'];
        $name       = $params['name'];
        $subject    = $params['subject'];

        Mail::send('email.'.$tplName, $params,
            function($mail) use ($from, $to, $name, $subject){
                $mail->from($from, $name);
                $mail->to($to, $to);
                $mail->subject($subject);
        });
    }

    /**
     * 
     *  Verfiy email reminder
     * 
     */ 

    public function verify_email_reminder(){
        $users = User::where('users.email_verified_at',NULL)->get();
        foreach($users as $user){       
            $this->sendEmail1("verify_remaider", [
                'from'      =>   env('DB_TEAM_EMAIL'), 
                'to'        =>   $user->email, 
                'subject'   =>  'Verify your email on Databroker!', 
                'name'      =>  APPLICATION_NAME,
                'data'      =>  $user
            ]);
        }        
    }
 
    /**
     * Send email
     * 
     * 
     */
	public function sendEmail1($tplName, $params){		
        $from       = $params['from'];
        $to         = $params['to'];
        $name       = $params['name'];
        $subject    = $params['subject'];
        Mail::send('email.'.$tplName, $params,
            function($mail) use ($from, $to, $name, $subject){
                $mail->from($from, $name);
                $mail->to($to, $to);
                $mail->subject($subject);
        });
    }


    /**
     * 
     * Generate slug url of existing data
     * 
     */
    public function generateSlugURL() {
        // /admin/generateslugurl    - hit this URL to generate
        // articles
        $result = DB::select("SELECT articleIdx, articleTitle, slug FROM articles WHERE slug IS NULL ");
        if(count($result)) {
            foreach ($result as $obj){
                $articleIdx     = $obj->articleIdx;
                $articleTitle   = $obj->articleTitle;
                $slug           = SiteHelper::slugify($articleTitle);
                $slugCount      = Article::where('slug', $slug)->where('articleIdx', '!=', $articleIdx)->count();
                if ($slugCount > 0) {
                    $slug = $slug. '-'.$articleIdx;
                }
                // now update the slug if the count
                $data               = [];         
                $data['articleIdx'] = $articleIdx;
                $data['slug']       = $slug;
                Article::find($articleIdx)->update($data);                 
            }
            echo "Article Slug Updated <br>";
        } else {
            echo "No record pending in Article <br>";
        }
        
        //companies        
        $result = DB::select("SELECT companyIdx, companyName, slug FROM companies WHERE slug IS NULL ");
            if(count($result)) {
                foreach ($result as $obj){
                $companyIdx     = $obj->companyIdx;
                $companyName    = $obj->companyName;                
                $slug           = SiteHelper::slugify($companyName);
                $slugCount      = Company::where('slug', $slug)->where('companyIdx', '!=', $companyIdx)->count();
                if ($slugCount > 0) {
                    $slug = $slug. '-'.$companyIdx;
                }
                // now update the slug if the count
                $data               = [];         
                $data['companyIdx'] = $companyIdx;
                $data['slug']       = $slug;
                Company::find($companyIdx)->update($data);                 
                }
                echo "Company Slug Updated <br>";
            }else {
                echo "No record pending in Company <br>";
            }       
        
            //offers
            $result = DB::select("SELECT offerIdx, offerTitle, slug FROM offers WHERE slug IS NULL  ");
            if(count($result)) {
                foreach ($result as $obj){
                    $offerIdx   = $obj->offerIdx;                
                    $offerTitle = $obj->offerTitle;
                    
                    $slug       = SiteHelper::slugify($offerTitle);
                    $slugCount  = Offer::where('slug', $slug)->where('offerIdx', '!=', $offerIdx)->count();
                    if ($slugCount > 0) {
                        $slug = $slug. '-'.$offerIdx;
                    }
                    // now update the slug if the count
                    $data               = [];         
                    $data['offerIdx']   = $offerIdx;
                    $data['slug']       = $slug;
                    Offer::find($offerIdx)->update($data);                 
                }
                echo "offerTitle Slug Updated <br>";
            }else {
                echo "No record pending in offerTitle <br>";
            }       
        
            //regions
            $result = DB::select("SELECT regionIdx, regionName, slug FROM regions WHERE slug IS NULL  ");
            if(count($result)) {
                foreach ($result as $obj){
                    $regionIdx      = $obj->regionIdx;                
                    $regionName     = $obj->regionName;                    
                    $slug           = SiteHelper::slugify($regionName);
                    $slugCount      = Region::where('slug', $slug)->where('regionIdx', '!=', $regionIdx)->count();
                    if ($slugCount > 0) {
                        $slug = $slug. '-'.$regionIdx;
                    }
                    // now update the slug if the count
                    $data               = [];         
                    $data['regionIdx']  = $regionIdx;
                    $data['slug']       = $slug;
                    Region::find($regionIdx)->update($data);                 
                }
                echo "regionName Slug Updated <br>";
            }else {
                echo "No record pending in regionName <br>";
            }

            //communities                    
            $result = DB::select("SELECT communityIdx, communityName, slug FROM communities WHERE slug IS NULL  ");
            if(count($result)) {
                foreach ($result as $obj){
                $communityIdx   = $obj->communityIdx;                
                $communityName  = $obj->communityName;                
                $slug           = SiteHelper::slugify($communityName);
                $slugCount      = Community::where('slug', $slug)->where('communityIdx', '!=', $communityIdx)->count();
                if ($slugCount > 0) {
                    $slug = $slug. '-'.$communityIdx;
                }
                // now update the slug if the count
                $data                   = [];         
                $data['communityIdx']   = $communityIdx;
                $data['slug']           = $slug;
                Community::find($communityIdx)->update($data);                 
                }
                echo "communityName Slug Updated <br>";
            }else {
                echo "No record pending in communityName <br>";
            }

            echo "Finished generating slug URL";
            exit;
        
            }

/**
     * 
     * Wyre payment
     * 
     */
    public function wyrePayment() {
        // $user       = $this->getAuthUser();
        // $userObj    = User::where('userIdx', $user->userIdx)->get()->first(); 
        
        $cardDetails = $this->getCardDetails();
        $data = array('cardDetails');          
        
        return view('account.wyre', compact($data));
    }

    /**
     * 
     * 
     */
    public function wyreMakePayment() {

        // $user       = $this->getAuthUser();
        // $userObj    = User::where('userIdx', $user->userIdx)->get()->first();
       
       

        $api_key = WYRE_API_KEY;
        $secret_key = WYRE_SECRET_KEY;
        $authorization = 'Bearer '.$secret_key;

//1. call the API for order reservation, which will be used in reservationId parameter
// API support link - https://docs.sendwyre.com/v3/docs/wallet-order-reservations 
                 
                                      
                    $client         = new \GuzzleHttp\Client();   
                    $url            = WYRE_API_URL . '/v3/orders/reserve';                   
                    $response       = $client->request("POST", $url, [
                    'headers'   => [
                                'Content-Type'  => 'application/json', 
                                'cache-control' => 'no-cache',
                                'Authorization' => $authorization],
                    'body'      => '{   
                                    "amount": "8",
                                    "paymentMethod": "debit-card",
                                    "sourceCurrency": "USD",
                                    "redirectUrl": "https://www.sendwyre.com",
                                    "failureRedirectUrl": "https://www.sendwyre.com",
                                    "referrerAccountId": "'.WYRE_ACCOUNT_ID.'",
                                    "country": "US",
                                    "lockFields": ["amount","sourceCurrency"]
                    }'
                    ]);

                    $res            = json_decode($response->getBody()->getContents());

                    $reservationId = 'ABC123'; // putting dummy as this field is required
                    if (isset($res->reservation) && $res->reservation != '') {
                        $reservationId = $res->reservation; 
                    }



//2.  CREATE WALLET ORDER
// API help link - https://docs.sendwyre.com/v3/docs/white-label-card-processing-api
        $client         = new \GuzzleHttp\Client();    
        $url            = WYRE_API_URL . '/v3/debitcard/process/partner';
        $body = $this->getCardDetails($reservationId);

        $cardResponse       = $client->request("POST", $url, [
                            'headers'   => [
                                            'Content-Type'  => 'application/json', 
                                            'cache-control' => 'no-cache',
                                            'Authorization' => $authorization],
                            'body'      => json_encode($body)
                        ]);

        $cardResponse       = json_decode($cardResponse->getBody()->getContents());
       
//3. GET - Card Authorize
// API help link - https://docs.sendwyre.com/v3/docs/authorize-card
        $authorizeResponse = [];
        $orderId = $cardResponse->id;
        $client         = new \GuzzleHttp\Client();    
        $url            = WYRE_API_URL .'/v3/debitcard/authorization/'.$orderId;
        
        $res       = $client->request("GET", $url, [
                            'headers'   => [
                                            'Content-Type'  => 'application/json', 
                                            'cache-control' => 'no-cache',
                                            'Authorization' => $authorization],
                            
                        ]);

        $authorizeResponse       = json_decode($res->getBody()->getContents());

    // 4. POST POSTING AUTHENTICATION CODES
    // API help link - https://docs.sendwyre.com/v3/debitcard/authorize/partner
        
        
        $arrB = [

        "type"          =>"SMS",
        "walletOrderId" => $orderId,
        "reservation"   => $reservationId,
        "sms"           => "000000",
        "card2fa"       =>"000000"
        ];

        sleep(120);
        $authCodeResponse = [];
        $client                = new \GuzzleHttp\Client();   
        $partnerURL            = WYRE_API_URL .'/v3/debitcard/authorize/partner';
                
        $authCodeResponse       = $client->request("POST", $partnerURL, [
            'headers'   => [
                            'Content-Type'  => 'application/json', 
                            'cache-control' => 'no-cache',
                            'Authorization' => $authorization
                            ],
            'body'      => json_encode($arrB)
        ]);

     
        
     $authCodeResponse        = json_decode($authCodeResponse->getBody()->getContents());

        $cardDetails    = $this->getCardDetails($reservationId);       
        $data           = array('cardResponse', 'cardDetails',  'authorizeResponse', 'authCodeResponse');          
        
  return view('account.wyre', compact($data));


    }
/**
 *  Dummy card details
 * 
 */
    public function getCardDetails($reservationId = '') {

        
     
       $cardDetails =  array (
            'debitCard' => 
                    array (
                    'number'    => '4111111111111111',
                    'year'      => '2023',
                    'month'     => '01',
                    'cvv'       => '123',
                    ),
            'reservationId'     => $reservationId,
            'amount'            => '8',
            'sourceCurrency'    => 'USD',
            'destCurrency'      => 'ETH',
            'dest'              => 'ethereum:0xfc6b0e0C50837f8A5785A3D03d4323D4cF7d1118',
            'referrerAccountId' => WYRE_ACCOUNT_ID,
            'givenName'         => 'ABC',
            'familyName'        => 'XYZ',
            'email'             => 'viktor@settlemint.com',
            'phone'             => '+32473285767',
            'referenceId'       => 'your_business_id',
            'address'   => 
                        array (
                                'street1'       => 'Building B, Arnould Nobelstraat 38 Leuven',
                                'city'          => 'Leuven',
                                'state'         => 'CA',
                                'postalCode'    => '94203',
                                'country'       => 'BE',
                        ),
        );
 
        return $cardDetails;
    }


    //Cron job for auto redeeming sales that completed 30days
    public function auto_redeed_deals(){

        $sales  = OfferProduct::with(['region'])
                    ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                    ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                    ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                    ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                    ->join('sales', 'sales.productIdx', '=', 'offerProducts.productIdx')
                    ->leftjoin('bids', 'bids.bidIdx', '=', 'sales.bidIdx')
                    ->leftjoin('purchases', 'purchases.purchaseIdx', '=', 'sales.purchaseIdx')                    
                    ->where('sales.from', '<=', Carbon::now()->subDays(30))      
                    ->where('sales.redeemed','!=',1)  
                    ->whereNotNull('sales.deal_index')   
                    ->where('purchases.amount', '>',0)         
                    ->orderby('sales.created_at', 'desc') 
                    ->get(["offers.*", "offerProducts.*", "sales.*", "bids.*", "offerProducts.productIdx as pid"]); 
        foreach($sales as $sale){            
           $this->payoutDXCDleal($sale->saleIdx);
        }
    }
    /**
     * 
     * close deal
     * 
     */

    public function payoutDXCDleal($sid){
        
        if($sid != null && $sid != ''){
            
            $sale   = Sale::where('saleIdx', $sid)->get()->first();
            $amount = 0;
                        
                if($sale->bidIdx!=0){
                    $amount = Bid::where('bidIdx', $sale->bidIdx)->get()->first()->bidPrice;
                }else{
                    $amount = Purchase::where('purchaseIdx', $sale->purchaseIdx)->get()->first()->amount;
                }

                $client         = new \GuzzleHttp\Client();
                $query['index'] = $sale->deal_index;                
                $url            = Config::get('global_constants.dxsapiurl')."/ethereum/payout";                
                $response       = $client->request("POST", $url, [
                    'headers'   => ['Content-Type' => 'application/json', 
                                    'DXS_API_KEY' => Config::get('global_constants.dxsapikey')],
                    'body'      => json_encode($query)
                ]);
                $res            = $response->getBody()->getContents();                
                if($res == "Sucess"){
                    Sale::where('saleIdx', $sid)->update([
                        'redeemed'      => 1,
                        'redeemed_at'   => date('Y-m-d H:i:s')
                    ]);
                    $purchase = Purchase::where('purchaseIdx', $sale->purchaseIdx)->get()->first();
                    Transaction::where('transactionId', $sale->transactionId)->update([
                        'status' => 'complete',
                        'amount' => $amount
                    ]);
                    Transaction::where('transactionId', $purchase->transactionId)->update([
                        'status' => 'complete'
                    ]);
                }      
        }
    }



}
