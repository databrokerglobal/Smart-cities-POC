<?php
/**
 *  
 *  Profile Controller
 * 
 * This file is a part of the Databroker.Global package.
 *
 * (c) Databroker.Global
 *
 * @author    Databroker.Global
 * 
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


use App\Models\Business;
use App\Models\Provider;
use App\Models\Company;
use App\Models\Complaint;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\ProductPriceMap;
use App\Models\Bid;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Message;
use App\Models\Region;
use App\Models\Transaction;
use App\Models\LinkedUser;
use App\Models\Stream;
use App\Helper\SiteHelper;
use App\Models\BuyerSaleFeedback;

use Redirect;
use Image;
use DB;
use Config;
use Session;
use Carbon\Carbon;

use App\Models\SharingOrganisation;
use App\Models\OrgUsers;
use App\Models\ProductShares;
use App\Models\OfferCountry;
use App\Models\ShareTestData;
use App\Models\ContactCommercials;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->middleware(['auth','verified']);
    }
    /**
     * 
     *  get user authenticate
     * 
     * 
     */
    public function getAuthUser () {
        return Auth::user();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user           = $this->getAuthUser();
        $users          = User::where('companyIdx', $user->companyIdx)->where('userIdx', '<>' ,$user->userIdx)->get();        
        $invited_users  = LinkedUser::where('invite_userIdx', $user->userIdx)->get();            
        $businesses     = Business::get();
        $admin          = User::where('companyIdx', $user->companyIdx)->where('userStatus', '=', 1)->get()->first(); 
        $company        = Company::where('companyIdx', '=', $user->companyIdx)->get()->first();
        $data           = array('admin', 'user', 'users', 'invited_users', 'businesses', 'company');
        return view('account.profile', compact($data));
    }

    /**
     * 
     *  My account
     * 
     * 
     */
    public function myaccount(){
        $user           = $this->getAuthUser();
        $users          = User::where('companyIdx', $user->companyIdx)->where('userIdx', '<>' ,$user->userIdx)->get();        
        $invited_users  = LinkedUser::where('invite_userIdx', $user->userIdx)->get();            
        $businesses     = Business::get();
        $admin          = User::where('companyIdx', $user->companyIdx)->where('userStatus', '=', 1)->get()->first();         
        $company        = Company::where('companyIdx', '=', $user->companyIdx)->get()->first();

        $bids       = \App\Models\Bid::where('userIdx', $user->userIdx)->get();
        $purchases  = \App\Models\Purchase::where('userIdx', $user->userIdx)->get();
        $offers     = \App\Models\Offer::join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                                  ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                  ->where('users.userIdx', $user->userIdx)->get();

        $data       = array('admin', 'user', 'users', 'invited_users', 'businesses', 'company','bids','purchases','offers');
        return view('account.myaccount', compact($data));

    }
    /**
     * 
     *  Company
     * 
     */
    public function company(){
        $user       = $this->getAuthUser();    
        $countries  = Region::where('regionType', 'country')->get(); 
        $company    = Company::with('region')->join('users', 'users.companyIdx', '=', 'companies.companyIdx')->where('userIdx', $user->userIdx)->first();
        $data       = array('countries', 'user', 'company');
        return view('account.company', compact($data));
    }
    /**
     * 
     * Purchases
     * 
     */
    public function purchases(Request $request)
    {
        $user = $this->getAuthUser();
        $purchases = OfferProduct::with(['region'])
                        ->select("offerProducts.*", "offers.*", "providers.*", "users.*", "companies.*", "purchases.*", "bids.*", "purchases.productIdx as productIDX","purchases.productAccessDays as accessDays")
                        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')                        
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->join('purchases', 'purchases.productIdx', '=', 'offerProducts.productIdx')
                        ->leftjoin('bids', 'bids.bidIdx', '=', 'purchases.bidIdx')                         
                        ->where('purchases.userIdx', $user->userIdx)
                        ->orderby('purchases.created_at', 'desc')
                        ->get();
        foreach($purchases as $key => $purchase){
            $is_accessble_now = true;
            if($purchase->from > date('Y-m-d H:i:s'))
                $is_accessble_now = false;
            $purchases[$key]['is_accessble_now'] = $is_accessble_now;
        }
        $data = array('purchases');
        return view('account.purchases', compact($data));
    }
    /**
     * 
     * Purchase detail
     * 
     */
    public function purchases_detail(Request $request) {
        $user           = $this->getAuthUser();
        $purchase_det   = Purchase::where('purchaseIdx',$request->pid)->get()->first();
                
        if($user->userIdx != $purchase_det->userIdx){
            return view('errors.noacces');
        }
        $userObj    = User::where('userIdx', $user->userIdx)->get()->first();
        $detail     = OfferProduct::with(['region'])
                        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->join('purchases', 'purchases.productIdx', '=', 'offerProducts.productIdx')
                        ->leftjoin('apiProductKeys', 'apiProductKeys.purchaseIdx', '=', 'purchases.purchaseIdx')
                        ->leftjoin('bids', 'bids.bidIdx', '=', 'purchases.bidIdx')
                        ->where('purchases.purchaseIdx', $request->pid)
                        ->get()
                        ->first();
        
        
        if(!$detail) 
            return view('errors.404');

        $company    = Offer::join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                        ->where('offers.offerIdx', $detail['offerIdx'])
                        ->get()
                        ->first()
                        ->companyName;
        $stream     = Stream::where('userIdx', $user->userIdx)->where('purchaseIdx', $request->pid)->get()->first();

        if(!$detail) 
            return redirect(route('account.purchases'));
                
        $client     = new \GuzzleHttp\Client();
        $dataAccess = null;
        if($detail->did != null && $detail->did != ''){
            $url        = Config::get('global_constants.dxsapiurl')."/dxc/datasource/".$detail->did."/geturlfor/".$userObj->wallet.'?privatekey='.$userObj->walletPrivateKey;
            $response   = $client->request("GET", $url, [
                'headers'   => ['Content-Type' => 'application/json', 
                                'DXS_API_KEY' => Config::get('global_constants.dxsapikey')],
                'body'      =>'{}'
            ]);
            $dataAccess = json_decode($response->getBody()->getContents());
        }
        $data = array('detail', 'company', 'stream', 'dataAccess','purchase_det');
        return view('account.purchases_detail', compact($data));
    }
    /**
     * 
     * Sales
     * 
     */
    public function sales(Request $request){
        $user   = $this->getAuthUser();
        $sales  = OfferProduct::with(['region'])
                        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->join('sales', 'sales.productIdx', '=', 'offerProducts.productIdx')
                        ->leftjoin('bids', 'bids.bidIdx', '=', 'sales.bidIdx')
                        ->leftjoin('purchases', 'purchases.purchaseIdx', '=', 'sales.purchaseIdx')
                        ->leftjoin('buyer_sale_feedback', 'buyer_sale_feedback.saleIdx', '=', 'sales.saleIdx')
                        ->where('sales.sellerIdx', $user->userIdx)
                        ->orderby('sales.created_at', 'desc') 
                        ->get(["offers.*", "offerProducts.*", "sales.*", "bids.*", "offerProducts.productIdx as pid"
                              ,"buyer_sale_feedback.isBuyerSatisfiedWithData","buyer_sale_feedback.buyerComment"]);
        foreach ($sales as $key => $sale) {
            $buyerIdx           = $sale->buyerIdx;
            $buyerCompanyName   = Company::join('users', 'users.companyIdx', '=', 'companies.companyIdx')
                                    ->join('sales', 'sales.buyerIdx', '=', 'users.userIdx')
                                    ->where('users.userIdx', $buyerIdx)
                                    ->get()
                                    ->first()
                                    ->companyName;
            $hasComplaints      = Complaint::where('productIdx', $sale->productIdx)->get()->count();
            $sale['redeem_date'] = date('Y-m-d', strtotime('+30 days', strtotime($sale->from)));
            $sale['buyerCompanyName'] = $buyerCompanyName;
            if($hasComplaints) 
                $sale['hasComplaints'] = 1;
            else 
                $sale['hasComplaints'] = 0;
        }
        $user           = User::where('userIdx', $user->userIdx)->get()->first();
        $totalSale      = 0;
        $pendingSale    = 0;
        foreach ($sales as $sale) {
            if(!$sale->bidPrice && $sale->productPrice>0) 
                $totalSale += $sale->productPrice;
            else
                $totalSale += $sale->bidPrice;
            if($sale->redeemed == 0){
                if(!$sale->bidPrice && $sale->productPrice>0) 
                    $pendingSale += $sale->productPrice;
                else
                    $pendingSale += $sale->bidPrice;
            }
        }        
        $totalSale      = number_format((float)$totalSale, 2, '.', '');
        $pendingSale    = number_format((float)$pendingSale, 2, '.', '');
        //$balance = json_decode($response->getBody()->getContents());
        $data           = array('sales', 'user', 'totalSale', 'pendingSale');
        return view('account.sales', compact($data));
    }
    /**
     * 
     * Sales Detail
     * 
     */
    public function sales_detail(Request $request){
        $user   = $this->getAuthUser();
        $detail = OfferProduct::with(['region'])
                        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->join('sales', 'sales.productIdx', '=', 'offerProducts.productIdx')
                        ->leftjoin('apiProductKeys', 'apiProductKeys.purchaseIdx', '=', 'sales.purchaseIdx')
                        ->leftjoin('bids', 'bids.bidIdx', '=', 'sales.bidIdx')
                        ->where('sales.saleIdx', $request->sid)
                        ->get()
                        ->first();
        if(!$detail) 
            return view('errors.404');
        $company = Offer::join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                        ->where('offers.offerIdx', $detail['offerIdx'])
                        ->get()
                        ->first()
                        ->companyName;
        $stream = Stream::where('purchaseIdx', $detail->purchaseIdx)->get()->first();
        if(!$detail) 
            return redirect(route('account.sales'));
        $data = array('detail', 'company', 'stream');
        return view('account.sales_detail', compact($data));
    }
    /**
     * 
     * Sales redeem
     * 
     */
    public function sales_redeem(Request $request){       
        $this->payoutDXCDleal($request->sid);
        if($request->from == 'wallet'){
            return redirect(route('account.wallet'));
        }else{
            return redirect(route('account.sales'));
        }
    
        
    }

    /**
     * 
     * close deal
     * 
     */

    public function payoutDXCDleal($sid){
        
        if($sid != null && $sid != ''){

            $user   = $this->getAuthUser();
            $sale   = Sale::where('saleIdx', $sid)->get()->first();
            $amount = 0;
        
                $user   = User::where('userIdx', $user->userIdx)->get()->first();
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
    /**
     * 
     * Update profile data
     * 
     */
    public function update(Request $request) {
        $user = Auth::user();

        $fields = [
            'firstname'     => ['required', 'string', 'max:25'],
            'lastname'      => ['required', 'string', 'max:25'],
            'businessName'  => [ 'max:100'],
            'businessName2' => [ 'max:100'],
            'role2'          => ['max:25'],
            'jobTitle'      => ['max:75'],
            'email'         => ['required', 'string', 'email', 'max:150', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix']
        ];

        // if any of the password fields present, validate
        $oldPassword        = $request->input('oldPassword');
        $password           = $request->input('password');
        $passwordConfirm    = $request->input('password_confirmation');

        if ((!empty($oldPassword)) || (!empty($password)) || (!empty($passwordConfirm))) {
            $updatePassword                 = true;
            $fields['password']             = ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'];
            $fields['password_confirmation'] = ['same:password'];
        }
        else {
            $updatePassword = false;
        }

        $validator = Validator::make($request->all(), $fields, [
            'password.min'              =>'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password.required'         =>'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password.regex'            =>'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password_confirmation.same'=>"Passwords do not match.",
        ]);

        if($validator->fails()){
            return response()->json(array( "success" => false, 'result' => $validator->errors() ));                    
        }
        
        // check old password        
        $user->firstname    = $request->input('firstname');
        $user->lastname     = $request->input('lastname');
        $user->email        = $request->input('email');
        $user->jobTitle     = $request->input('jobTitle');
        $user->businessName = $request->input('businessName2')!='Other industry'
                                ? $request->input('businessName2')
                                : $request->input('businessName');
        $user->role = $request->input('role2')!='Other'
                                ? $request->input('role2')
                                : $request->input('role');

        if ($updatePassword == true) {
            if (!Hash::check($oldPassword, $user->password)) {                                
                return response()->json(array("success" => false, 'result' => array('oldPassword'=> "Old password is not correct.")));
            } else {
                $user->password = Hash::make($request->input('password'));
            }            
        }
        $user->save();
        Session::flash('flash_success', 'Profile updated successfully.');         
        return response()->json(['success' => true, 'result' => "Updated successfully."]);
    }
    /**
     * 
     *  Update Company
     * 
     */
    public function update_company(Request $request){
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        
        $fields = [
            'companyName'   => ['required', 'string', 'max:255'],
            'regionIdx'     => ['required', 'integer'],
            'companyURL'    => ['required', 'string', 'max:255', "regex:".$regex],
            'companyVAT'    =>['required', 'string', 'max:255']
        ];
        $messages = [
            'companyName.required'  =>'The company name is required.',
            'regionIdx.required'    =>'The region is required.',
            'companyURL.required'   =>'The company url is required.',
            'companyURL.regex'      =>'The url format is invalid.',
            'companyVAT.required'   =>'The company VAT number is required.',
            'companyURL.max'        =>'The company URL may not be greater than 255 characters.',
            'companyVAT.max'        =>'The company VAT may not be greater than 255 characters.',
        ];

        $validator = Validator::make($request->all(), $fields, $messages);
        if($validator->fails()){
            return response()->json(array( "success" => false, 'result' => $validator->errors() ));                    
        }
        
        $user                   = $this->getAuthUser();
        $company                = [];
        $company['companyName'] = $request->companyName;;
        $company['regionIdx']   = $request->regionIdx;
        $company['companyURL']  = $request->companyURL;
        $company['companyVAT']  = $request->companyVAT;
        
        $slug       = SiteHelper::slugify($request->companyName);      
        $slugCount  = Company::where('slug', $slug)->where('companyIdx', '!=', $request->companyIdx)->count();
         if ($slugCount > 0) {
            $company['slug'] = $slug.'-'.$request->companyIdx;
         }else{
            $company['slug'] = $slug;
         }

        if($request->file('companyLogo_1') != null){            
            $companyLogo_path   = public_path('uploads/company');
            $fileName           = "company_".$request->companyIdx.'.'.$request->file('companyLogo_1')->extension();
            
            if(file_exists($companyLogo_path.'/'.$request->old_companyLogo)){                                
                File::delete($companyLogo_path.'/'.$request->old_companyLogo);
            }
            $getfiles = $request->file('companyLogo_1');
            SiteHelper::resizeAndUploadImage($getfiles,'COMPANY',$fileName);           
            $company['companyLogo'] = $fileName;  
        }

        Company::where('companyIdx', $request->companyIdx)->update($company);

        $providers = Provider::where('userIdx', '=', $user->userIdx)->get();
        foreach($providers as $index=>$provider){
            $updatedProvider['regionIdx']       = $request->regionIdx;
            $updatedProvider['companyName']     = $request->companyName;
            $updatedProvider['companyURL']      = $request->companyURL;
            $updatedProvider['companyVAT']      = $request->companyVAT;
            if($request->file('companyLogo_1') != null)
                $updatedProvider['companyLogo'] = $fileName;
            Provider::where('providerIdx', '=', $provider->providerIdx)->update($updatedProvider);
        }
        return response()->json(array( "success" => true, 'redirect' => route('account.company') ));
    }
    /**
     * 
     *  Wallet
     * 
     */
    public function wallet(Request $request){
        $user       = $this->getAuthUser();
        $userObj    = User::where('userIdx', $user->userIdx)->get()->first();

        if(!$userObj->wallet){
            $client2    = new \GuzzleHttp\Client();
            $url        = Config::get('global_constants.dxsapiurl')."/ethereum/wallet";
            $response   = $client2->request("POST", $url, [
                'headers'   => ['Content-Type' => 'application/json', 
                                'DXS_API_KEY' => Config::get('global_constants.dxsapikey')],
                'body'      =>'{}'
            ]);
            $responseBody       = json_decode($response->getBody()->getContents());
            $walletAddress      = $responseBody->address;
            $walletPrivateKey   = $responseBody->privatekey;
            User::where('userIdx', $user->userIdx)->update([
                'wallet'=>$walletAddress, 
                'walletPrivateKey'=>$walletPrivateKey
            ]);
        }

        $address    = $userObj->wallet;
        $client3    = new \GuzzleHttp\Client();        
        $url        = Config::get('global_constants.dxsapiurl')."/user/apikey/".$address;
        $response   = $client3->request("GET", $url, [
            'headers'   => ['Content-Type' => 'application/json', 
                            'DXS_API_KEY' => Config::get('global_constants.dxsapikey')],
            'body'      =>'{}'
        ]);
        
        $apiKey     = $response->getBody()->getContents();
        $client     = new \GuzzleHttp\Client();
        $url        = Config::get('global_constants.dxsapiurl')."/ethereum/balanceof/".$address;
        $response   = $client->request("GET", $url, [
            'headers'   => ['Content-Type' => 'application/json', 
                            'DXS_API_KEY' => Config::get('global_constants.dxsapikey')],
            'body'      => '{}'
        ]);
        $balance        = json_decode($response->getBody()->getContents());        
        $transactions   = Transaction::leftjoin('sales', 'sales.saleIdx', '=', 'transactions.saleIdx')
                                    ->leftjoin('buyer_sale_feedback','buyer_sale_feedback.saleIdx', '=', 'transactions.saleIdx')
                                    ->where('transactions.userIdx', $user->userIdx)
                                    ->orderby('transactions.updated_at', 'desc')
                                    ->get(['transactions.*', 'sales.*', 'transactions.updated_at as updatedAt',
                                           'buyer_sale_feedback.isBuyerSatisfiedWithData','buyer_sale_feedback.buyerComment']);

        $sales          = Sale::join('offerProducts', 'offerProducts.productIdx', 'sales.productIdx')
                        ->leftJoin('bids', 'bids.bidIdx', '=', 'sales.bidIdx')
                        ->where('sales.sellerIdx', $user->userIdx)
                        ->get();
        $totalSale      = 0;
        $pendingSale    = 0;        
        foreach ($sales as $sale) {
            if(!$sale->bidPrice && $sale->productPrice>0) 
                $totalSale += $sale->productPrice;
            else
                $totalSale += $sale->bidPrice;
            if($sale->redeemed==0){
                if(!$sale->bidPrice && $sale->productPrice>0) 
                    $pendingSale += $sale->productPrice;
                else
                    $pendingSale += $sale->bidPrice;
            }
        }
        $totalSale      = number_format((float)$totalSale, 2, '.', '');
        $pendingSale    = number_format((float)$pendingSale, 2, '.', '');
        $data           = array('address', 'apiKey', 'balance', 'transactions', 'totalSale', 'pendingSale');        
        return view('account.wallet', compact($data));
    }
    /**
     * 
     * Buyer bids
     * 
     */
    public function buyer_bids(){
        $user           = Auth::user();
        $bidProducts    = OfferProduct::with('region')
                        ->join(DB::raw("(SELECT *, bids.created_at as createdAt FROM bids ORDER BY createdAt DESC) as bids"), function($join){
                                $join->on("bids.productIdx", "=", "offerProducts.productIdx");})
                        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                        ->join('providers', 'offers.providerIdx', '=', 'providers.providerIdx')
                        ->join('regions', 'regions.regionIdx', '=', 'providers.regionIdx')
                        ->where('bids.userIdx', $user->userIdx)
                        ->groupby('offerProducts.productIdx')
                        ->orderby('bids.created_at', 'desc')
                        ->get();
        
        $bidUsers       = array();
        foreach ($bidProducts as $key => $bid) {
            $provider = Provider::join("offers", 'providers.providerIdx', '=', 'offers.providerIdx')
                                ->join('offerProducts', 'offerProducts.offerIdx', '=', 'offers.offerIdx')
                                ->join("users", 'users.userIdx', '=', 'providers.userIdx')
                                ->where('offerProducts.productIdx', $bid['productIdx'])
                                ->get()
                                ->first();
            $ppmapping = ProductPriceMap::where('productIdx','=', $bid['productIdx'])->get();
            $bidProducts[$key]['ppmappings'] = $ppmapping;
            
            $sellerCompanyName = $provider['companyName'];
            $sellerName = $provider['firstname']." ".$provider['lastname'];

            $users = Bid::join('users', 'users.userIdx', '=', 'bids.userIdx')
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->join('offerProducts', 'offerProducts.productIdx', '=', 'bids.productIdx')
                        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                        ->where('bids.productIdx', $bid['productIdx'])
                        ->where('bids.userIdx', $user->userIdx)
                        ->orderby('bids.created_at', 'desc')
                        ->get(["users.*", 'companies.*', 'offerProducts.*', 'offers.*', 'bids.*', 'bids.created_at as createdAt']);
            foreach ($users as $key => $user) {
                $messages = Message::where('bidIdx', $user->bidIdx)->orderby('created_at', 'DESC')->get();
                $user['messages'] = $messages;
            }
            
            array_push($bidUsers, array(
                'offerIdx'          => $bid['offerIdx'],
                'productIdx'        => $bid['productIdx'], 
                'sellerCompanyName' => $sellerCompanyName, 
                'sellerName'        => $sellerName, 
                'users'             => $users)
            );
        }
        Bid::where('userIdx',$user->userIdx)->update(array('isBuyyerViewed'=> true));
        $data = array('bidProducts', 'bidUsers', 'user');
        return view('account.buyer_bids', compact($data));
    }
    /**
     * 
     * Seller bids
     * 
     */
    public function seller_bids(Request $request){
        $user           = Auth::user();        
        $bidProducts    = OfferProduct::with('region')
                                ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                                ->join(DB::raw("(SELECT *, bids.created_at as createdAt FROM bids ORDER BY createdAt DESC) as bids"), function($join){
                                        $join->on("bids.productIdx", "=", "offerProducts.productIdx");})
                                ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                                ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                ->where('users.userIdx', $user->userIdx)
                                ->groupby('offerProducts.productIdx')
                                ->orderby('bids.created_at', 'desc')
                                ->get();

        $bidUsers       = array();
        foreach ($bidProducts as $key => $bid) {
            $provider = Provider::join("offers", 'providers.providerIdx', '=', 'offers.providerIdx')
                                ->join('offerProducts', 'offerProducts.offerIdx', '=', 'offers.offerIdx')
                                ->join("users", 'users.userIdx', '=', 'providers.userIdx')
                                ->where('offerProducts.productIdx', $bid['productIdx'])
                                ->get()
                                ->first();

            $ppmapping = ProductPriceMap::where('productIdx','=', $bid['productIdx'])->get();
            $bidProducts[$key]['ppmappings'] = $ppmapping;

            $sellerCompanyName = $provider['companyName'];
            $sellerName = $provider['firstname']." ".$provider['lastname'];

            $users = Bid::join('users', 'users.userIdx', '=', 'bids.userIdx')
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->join('offerProducts', 'offerProducts.productIdx', '=', 'bids.productIdx')
                        ->join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                        ->where('bids.productIdx', $bid['productIdx'])
                        ->orderby('bids.created_at', 'desc')
                        ->get(["users.*", 'companies.*', 'offerProducts.*', 'offers.*', 'bids.*', 'bids.created_at as createdAt']);
            foreach ($users as $key => $user) {
                $messages           = Message::where('bidIdx', $user->bidIdx)->orderby('created_at', 'DESC')->get();
                $user['messages']   = $messages;
            }
            array_push($bidUsers, array(
                'offerIdx'          => $bid['offerIdx'],
                'productIdx'        => $bid['productIdx'], 
                'sellerCompanyName' => $sellerCompanyName, 
                'sellerName'        => $sellerName, 
                'users'             => $users)
            );
        }
        
        $logged_userid      = Auth::user()->userIdx;
        //updating viewed satatus
        $users_query        = "SELECT op.productIdx  FROM `offerProducts` op LEFT JOIN offers o ON op.`offerIdx` = o.offerIdx LEFT JOIN  providers p ON  p.providerIdx = o.providerIdx WHERE p.userIdx = $logged_userid";
        $update_bid_status  = DB::statement("update bids set isSellerViewed = true where productIdx in ($users_query)");        
        $data               = array('bidProducts', 'bidUsers', 'user');
        return view('account.seller_bids', compact($data));
    }
    /**
     * 
     * Invite user
     * 
     */
    public function invite_user(Request $request){
        $data = $request->all();
        $user = $this->getAuthUser();
        
        
        foreach ($data['linked_email'] as $key => $value) {
            if($value){
                $linked['invite_userIdx']   = $data['invite_userIdx'];
                $linked['linked_email']     = $value;
                $linked_user                = LinkedUser::where('linked_email', '=', $value)->first();
                if(!$linked_user){
                    LinkedUser::create($linked);
                    $linkedUserData['user']     = $user;

                    //getting company detials
                    $company_det = Company::where('companyIdx',$user->companyIdx)->get()->first();                    
                    $linkedUserData['user_company']     = $company_det->companyName;
                    
                    $linkedUserData['email']    = base64_encode($linked['linked_email']);
                    try{                    
                        $this->sendEmail("invite", [
                            'from'      =>  env('DB_TEAM_EMAIL'), 
                            'to'        => $linked['linked_email'], 
                            'name'      => 'Welcome to '.APPLICATION_NAME, 
                            'subject'   => 'You’ve been invited to join a '.APPLICATION_NAME.' account',
                            'data'      => $linkedUserData
                        ]);
                    }catch(\Swift_TransportException $e){

                    }
                }
            }
        }
        return response()->json(array( "success" => true ));         
    }
    /**
     * 
     *  Delete User
     * 
     */
    public function delete(Request $request){
        if($request->user_id){
            if($request->type == "registered")
                User::where('userIdx', $request->user_id)->delete();    
            if($request->type == "pendding")
                LinkedUser::where('linkedIdx', $request->user_id)->delete();    
        }        
        return response()->json(array( "success" => true) );
    }
    /**
     * 
     * Validate fields
     * 
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'firstname'     => ['required', 'string', 'max:255'],
            'lastname'      => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);
    }
    /**
     * 
     *  My private data network
     * 
     */
    public function my_private_data_network(Request $request){

        $user           = $this->getAuthUser();         
        $provider       =  Provider::where('userIdx', $user->userIdx)->get();
        $providerIdx    = $provider[0]->providerIdx;
        
        $sharingOrganisations =  SharingOrganisation::where('providerIdx',$providerIdx)
                                 ->orderby('created_at', 'ASC')->get();
        $total_produt_shares = 0;
        foreach($sharingOrganisations as $key=> $org){
            $total_produt_shares    = 0;
            $org_users              = OrgUsers::where('orgIdx',$org->orgIdx)->get(); 
            foreach($org_users as $user_key=>$org_user){
                $product_shares = ProductShares::join('orgusers','orgusers.orgUserIdx','=','productshares.orgUserIdx')
                                                 ->where('productshares.orgUserIdx',$org_user->orgUserIdx)
                                                 ->where('orgusers.orgIdx',$org_user->orgIdx)->get();
                $org_users[$user_key]->product_shares = count($product_shares);
                $total_produt_shares +=count($product_shares);
            }
            $sharingOrganisations[$key]['org_users'] = $org_users;
            $sharingOrganisations[$key]['total_product_shares'] = $total_produt_shares;
        }
        
        $data = array('sharingOrganisations','providerIdx');        
        return view('account.sharingorganisations', compact($data));

    }
    /**
     * 
     * Add sharing organization
     * 
     */
    public function add_sharing_organisation(Request $request) {
        $org_data       = [];
        $user           = $this->getAuthUser();         
        $provider       =  Provider::where('userIdx', $user->userIdx)->get();
        $providerIdx    = $provider[0]->providerIdx;

        $org_data['orgName']        = $request->orgName;
        $org_data['providerIdx']    = $providerIdx;       
        $result = SharingOrganisation::create($org_data);        
        return response()->json(array( "success" => true )); 
        
    }
    /**
     * 
     * Update sharing organization data
     * 
     */
    public function update_sharing_organisation(Request $request) {        
        SharingOrganisation::where('orgIdx', $request->orgIdx)->update([
            'orgName' => $request->orgName,            
        ]);                       
        return response()->json(array( "success" => true ));         
    }
    /**
     * 
     *  Delete sharing organization
     * 
     */
    public function delete_sharing_organisation(Request $request) {        
        if($request->orgIdx){
            SharingOrganisation::where('orgIdx', $request->orgIdx)->delete();     
            OrgUsers::where('orgIdx', $request->orgIdx)->delete();  
        }        
        return response()->json(array( "success" => true) );
        
    }
    /**
     * 
     * Add user to organization
     * 
     */
    public function add_user_to_organisation(Request $request){
        $org_user_data                  = [];

        $user                           = $this->getAuthUser();
        $org_user_data['orgIdx']        = $request->orgIdx;
        $org_user_data['orgUserEmail']  = $request->orgUserEmail;   

        $user_det = User::where('email',$request->orgUserEmail)->get();
        if(count($user_det) > 0){
            $org_user_data['isUserRegistered'] = true;
        }   
        
        $org_user = OrgUsers::where('orgIdx',$request->orgIdx)->where('orgUserEmail',$request->orgUserEmail)->first();
        if(!$org_user){            
            $company                = Company::where('companyIdx',$user->companyIdx)->first();        
            $user->companyName      = $company->companyName;   
            $result                 = OrgUsers::create($org_user_data);         

            if( $request->sendAutomatic == 'automatic'){
                $company_det        = Company::where('companyIdx',$user->companyIdx)->first();                
                $linkedUserData     = [];
                $linkedUserData['user']         = $user;
                $linkedUserData['companyName']  = $company_det->companyName;
                $linkedUserData['email']        = base64_encode($request->orgUserEmail);

                $this->sendEmail("shareoffer", [
                    'from'      => $user->email, 
                    'to'        => $request->orgUserEmail, 
                    'name'      => 'Welcome to '.APPLICATION_NAME, 
                    'subject'   => 'You’ve been invited to access data products',
                    'data'      => $linkedUserData
                ]);               
            }
            return response()->json(array( "success" => true )); 
        }  /* if user already exists */
        else {            
            return response()->json(array( "success" => false )); 
        }          
    }
    /**
     * 
     * Edit organization user 
     * 
     */
    public function edit_user_to_organisation(Request $request){
        $org_user_data                  = [];
        $user                           = $this->getAuthUser();        
        $org_user_data['orgUserEmail']  = $request->orgUserEmail;
        $user_det                       = User::where('email',$request->orgUserEmail)->first();
        if(!$user_det){
            $org_user_data['isUserRegistered'] = true;
        }else{
            $org_user_data['isUserRegistered'] = false;
        }  

        $org_user = OrgUsers::where('orgIdx',$request->orgIdx)->where('orgUserEmail',$request->orgUserEmail)->first();
        if(!$org_user){
            $company            = Company::where('companyIdx',$user->companyIdx)->first();        
            $user->companyName  = $company->companyName;            
            /* $result = OrgUsers::create($org_user_data);   */
            OrgUsers::where('orgUserIdx', $request->orgUserIdx)->update([
                'orgUserEmail'=> $request->orgUserEmail,            
            ]);          

            if( $request->sendAutomatic == 'automatic'){
                $company                = Company::where('companyIdx',$user->companyIdx)->first();
                $linkedUserData         = [];
                $linkedUserData['user'] = $user;
                $linkedUserData['email'] = base64_encode($request->orgUserEmail);

                $this->sendEmail("invite", [
                    'from'      => $user->email, 
                    'to'        => $request->orgUserEmail, 
                    'name'      => 'Welcome to '.APPLICATION_NAME, 
                    'subject'   => 'You’ve been invited to join a '.APPLICATION_NAME.' account',
                    'data'      => $linkedUserData
                ]);
            }
        }            
        return response()->json(array( "success" => true )); 
    }
    /**
     * 
     * Delete organization user
     * 
     */
    public function delete_org_user(Request $request){
        if($request->orgUserIdx){
            OrgUsers::where('orgUserIdx', $request->orgUserIdx)->delete();     
        }        
        return response()->json(array( "success" => true) );
    }
    /**
     * 
     *  Resend invitation to orgnization user
     * 
     */
    public function resend_org_user_invite(Request $request){
        $org_user   = OrgUsers::where('orgUserIdx',$request->orgUserIdx)->get();
        $user       = $this->getAuthUser();       
        
        if(sizeof($org_user) > 0){            

            $company            = Company::where('companyIdx',$user->companyIdx)->first();        
            $user->companyName  = $company->companyName;   
         
            if( $request->sendAutomatic == 'automatic'){
                $company                    = Company::where('companyIdx',$user->companyIdx)->first();
                $linkedUserData             = [];
                $linkedUserData['user']     = $user;
                $linkedUserData['email']    = base64_encode($request->orgUserEmail);
                $linkedUserData['user_company']     = $user->companyName;

                $this->sendEmail("invite", [
                    'from'      => $user->email, 
                    'to'        => $org_user[0]->orgUserEmail, 
                    'name'      => 'Welcome to '.APPLICATION_NAME, 
                    'subject'   => 'You’ve been invited to join a '.APPLICATION_NAME.' account',
                    'data'      => $linkedUserData
                ]);
            }
        }            
        return response()->json(array( "success" => true ));       
    }
    /**
     * 
     * Get orgnaziation
     * 
     */

    public function get_organizations(Request $request){
        $user                   = $this->getAuthUser();         
        $provider               =  Provider::where('userIdx', $user->userIdx)->get();
        $providerIdx            = $provider[0]->providerIdx;
        $product_sahre_users    = '';        
        $sharingOrganisations   =  SharingOrganisation::where('providerIdx',$providerIdx)
                                 ->orderby('created_at', 'ASC')->get();
        foreach($sharingOrganisations as $key=> $org){
            $org_users = OrgUsers::where('orgIdx',$org->orgIdx)->get(); 
            $sharingOrganisations[$key]['org_users'] = $org_users;
           
        }  
        if(isset($request->productIdx) && $request->productIdx != ''){
            $sahred_with_users      = ProductShares::where('productIdx',$request->productIdx)->pluck('orgUserIdx')->toArray();
            $product_sahre_users    = implode(',',$sahred_with_users);
            $product_sahre_users    = $product_sahre_users;
        }
        return response()->json(array( "success" => true,
                                        'sharingOrganisations' => $sharingOrganisations,
                                        'providerIdx' => $providerIdx,
                                        'product_sahre_users' => $product_sahre_users
                                     )); 
    }

    /**
     * 
     *  get my data providers
     * 
     */
    public function get_my_data_providers(){
        $providers  = [];
        $user       = $this->getAuthUser();         
      
        $providers =  DB::table('productshares')
                     ->select('offers.offerIdx','offers.providerIdx','orgusers.orgUserEmail','orgusers.orgUserIdx','providers.companyName')
                     ->join('orgusers','orgusers.orgUserIdx','=','productshares.orgUserIdx')
                     ->join('offerProducts' ,'offerProducts.productIdx','=','productshares.productIdx')
                     ->join('offers','offers.offerIdx','=','offerProducts.offerIdx')
                     ->join('providers','offers.providerIdx','=','providers.providerIdx')
                     ->where('orgusers.orgUserEmail',$user->email)
                     ->groupBy('orgusers.orgIdx')->get();
        
        foreach($providers as $key => $provider){
            $products =  DB::table('productshares')
                        ->select('offers.offerIdx','offers.offerTitle','offerProducts.*','orgusers.orgUserEmail','providers.companyName','companies.slug as company_slug')
                        ->join('orgusers','orgusers.orgUserIdx','=','productshares.orgUserIdx')
                        ->join('offerProducts' ,'offerProducts.productIdx','=','productshares.productIdx')
                        ->join('offers','offers.offerIdx','=','offerProducts.offerIdx')
                        ->join('providers','offers.providerIdx','=','providers.providerIdx')                        
                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->where('offers.providerIdx',$provider->providerIdx)
                        ->where('orgusers.orgUserIdx',$provider->orgUserIdx)
                        ->get();

            
            foreach($products as $pro_key => $product){
                $regions = OfferCountry::join('regions','regions.regionIdx','=','offerCountries.regionIdx')
                                         ->where('offerIdx',$product->offerIdx)->get();
                $check_purchase = Purchase::where('userIdx',$user->userIdx)->where('productIdx',$product->productIdx)->first();                
                $products[$pro_key]->regions    = $regions;
                $products[$pro_key]->validTill  = '';
                $products[$pro_key]->isExpired  = false; 
                
                //fetching first price product match
                $mapping = ProductPriceMap::where('productIdx','=',$product->productIdx)->first();
                $products[$pro_key]->productpricemapping = $mapping;
                
                if($check_purchase){                    
                    if(strtotime($check_purchase->to) > strtotime(date('Y-m-d'))){
                        $products[$pro_key]->validTill = date('d-m-Y',strtotime($check_purchase->to));
                    }else{
                        $products[$pro_key]->isExpired = true;
                    }                    
                }
            }
            $providers[$key]->shared_products = $products;
        }
        $data = array('providers');        
        return view('account.my_data_providers', compact($data));
    }
    /**
     * 
     *  Invite user to on data product
     * 
     */
    public function invite_users_to_data_product(Request $request){
            $org_users  = [];
            $user       = $this->getAuthUser();
            //ProductShares::where('productIdx',$request->productIdx)->delete();
            if($request->selected_users != ''){                   
                    $org_users = explode(',',$request->selected_users);    
            }
            
            foreach($org_users as $org_user){
                $product_share_details = ProductShares::where('productIdx',$request->productIdx)->where('orgUserIdx',$org_user)->get();
                if(count($product_share_details) == 0){

                    $offer_data = array('productIdx' => $request->productIdx,
                                        'orgUserIdx' => $org_user);
                    $res        = ProductShares::create($offer_data);

                    $org_user_details = OrgUsers::where('orgUserIdx',$org_user)->first();                
                    $company_det = Company::where('companyIdx',$user->companyIdx)->first();
                    $linkedUserData                 = [];
                    $linkedUserData['user']         = $user;
                    $linkedUserData['companyName']  = $company_det->companyName;                    
                    $linkedUserData['email']        = base64_encode($org_user_details->orgUserEmail);
    
                    $this->sendEmail("shareoffer", [
                        'from'      => $user->email, 
                        'to'        => $org_user_details->orgUserEmail, 
                        'name'      => 'Welcome to '.APPLICATION_NAME, 
                        'subject'   => 'You’ve been invited to access data products',
                        'data'      => $linkedUserData
                    ]);
                }
            }
           return response()->json(array( "success" => true)); 
    }
    /**
     * 
     * free access invitation start
     * 
     */

    public function invite_user_for_free_access(Request $request){
        $data = $request->all();
        $user = $this->getAuthUser();
        foreach ($data['linked_email'] as $key => $value) {
            if($value != ''){                
                $linked['productIdx']   = $data['invite_productIdx'];
                $linked['userEmail']    = $value;
                $linked_user            = ShareTestData::where('userEmail', '=', $value)->where('productIdx','=',$linked['productIdx'])->first();
                
                if(!$linked_user){
                    $isUserReg              = User::where('email', $linked['userEmail'])->first(); 
                    $linked['isRegistered'] = false;
                    if(!$isUserReg){
                        $linked['isRegistered'] = true;
                    }

                    $testshareIdx   = DB::table('testdata_shares')->insertGetId($linked);
                    $id             = md5($testshareIdx);
                    ShareTestData::where('testshareIdx', $testshareIdx)->update([
                        'token' => $id
                    ]);

                    $company_det        = Company::where('companyIdx',$user->companyIdx)->first();                
                    $linkedUserData     = [];
                    $linkedUserData['user']         = $user;
                    $linkedUserData['companyName']  = $company_det->companyName;
                    $linkedUserData['email']        = base64_encode($value);
                    $linkedUserData['testshareIdx'] = $id;                  
                    try{  
                        $res = $this->sendEmail("share_free_access", [
                            'from'      => env('DB_TEAM_EMAIL'), 
                            'to'        => $value, 
                            'name'      => 'Welcome to '.APPLICATION_NAME, 
                            'subject'   => 'You’ve been invited to access data products',
                            'data'      => $linkedUserData
                        ]);  
                        
                    }catch(\Swift_TransportException $e){

                    }                             
                }
            }
        } 
        return response()->json(array( "success" => true )); 
    }
    /**
     * 
     *  Downoload files
     * 
     */

    public function downloadFiles(){
        return view('account.download_files');
    }

    /**
     * 
     * free access invitation end
     *  contact commercial team starts
     * 
     */
    public function contact_commercial_team(Request $request){
        $user       = $this->getAuthUser();        
        $countries  = Region::where('regionType', 'country')->get(); 
        if($user){
            $userData = User::join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                            ->join('regions', 'regions.regionIdx', '=', 'companies.regionIdx')
                            ->where('userIdx', $user->userIdx)
                            ->get()
                            ->first();
        }else{
            $userData = null;
        }
        // creating value for captch
        $n1     = rand(1, 6); //Generate First number between 1 and 6 
        $n2     = rand(5, 9); //Generate Second number between 5 and 9 
        $answer = $n1 + $n2; 
        $request->session()->put('verscode', $answer);
        $math_captcha   = "Please solve this math problem: ".$n1." + ".$n2."  = ";         
        $data           = array( 'countries', 'userData','math_captcha');
        return view('account.contact_commercial_team', compact($data));
    }
    /**
     * 
     * send to Contact commercial
     * 
     */
    function contact_commercial_send(Request $request){        
             //regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix
             $validator = Validator::make($request->all(),[
                'full_name'             => 'required|min:2|max:100',
                'contact_number'        => 'required|min:10|max:15',
                'email'                 => 'required|max:150|email',
                'companyName'           => 'required|min:2|max:100',
                'bank_account_number'   => 'max:25',
                'amount_to_be_redeemed' => 'max:15',
                'iban_number'           => 'max:100',
                'bank_name'             => 'max:50',
                'branch_code'           => 'max:50',
                'company_reg_no'        => 'max:50',
                'company_tax_no'        => 'max:50',
                'regionIdx'             => 'required',
                'captcha'               => 'required'
            ],[
                'community.required'    => 'Please choose at least one.',
                'regionIdx.required'    => 'The country field is required.',
            ]);
    
            if ($validator->fails()) {
                return redirect(url()->previous())
                        ->withErrors($validator)
                        ->withInput();
            }    
            if(Session::get("verscode")!=$request->captcha){    
                return redirect(url()->previous())
                        ->withErrors(['captcha' => 'Please enter correct answer.'])
                        ->withInput();
            }    
            // google recaptcha test
            $url        = 'https://www.google.com/recaptcha/api/siteverify';
            $remoteip   = $_SERVER['REMOTE_ADDR'];
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "secret=".config('services.recaptcha.secret')."&response=".$request->get('recaptcha'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            $resultJson = json_decode($output, true);                
            // google recaptcha test
    
            if (isset($resultJson['score']) && $resultJson['score'] >= 0.3) {
    
                $businessName   = $request->businessName2 ==='Other industry' ? $request->businessName:$request->businessName2;
                $role           = $request->role2==='Other'?$request->role:$request->role2;
    
                $contact_data['full_name']          = $request->full_name;
                $contact_data['email']              = $request->email;        
                $contact_data['companyName']        = $request->companyName;
                $contact_data['regionIdx']          = $request->regionIdx;
                $contact_data['contact_number']     = $request->contact_number;
                $contact_data['bank_account_number']           = $request->bank_account_number;
                $contact_data['amount_to_be_redeemed']        = $request->amount_to_be_redeemed;
                $contact_data['iban_number']        = $request->iban_number;
                $contact_data['bank_name']          = $request->bank_name;
                $contact_data['branch_code']        = $request->branch_code;
                $contact_data['company_reg_no']     = $request->company_reg_no;
                $contact_data['company_tax_no']     = $request->company_tax_no;
                
                $contact_obj            = ContactCommercials::create($contact_data);
                $data                   = $contact_data;
                $region                 = Region::where('regionIdx', $request->regionIdx)->get()->first();
                $data['region']         = $region['regionName'];                
    
                $this->sendEmail("contact_commercials", [
                    'from'      => $data['email'], 
                    'to'        => env('DB_SALES_EMAIL'), 
                    'name'      => APPLICATION_NAME, 
                    'subject'   => 'Message to the '.APPLICATION_NAME.' Team',
                    'data'      => $data
                ]); 
                return view('about.contact_success');
            } else {    
                return redirect(url()->previous())
                        ->withErrors(['google_captcha' => 'Google ReCaptcha Error']);
            }
    }

    public function updateSaleFeedBack(Request $request){
        $feedback_data = array(
            'saleIdx'                  => $request->saleIdx,
            'isBuyerSatisfiedWithData' => $request->isBuyerSatisfiedWithData,
            'buyerComment'             => $request->buyerComment            
        );
       
        $res = BuyerSaleFeedback::create($feedback_data);
        return $res;
    }
    
}
