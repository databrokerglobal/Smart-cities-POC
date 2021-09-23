<?php
/**
 *  
 *  Help Controller
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

use App\Models\Provider;
use App\Models\Region;
use App\Models\Purchase;
use App\Models\Community;
use App\Models\Offer;
use App\Models\Theme;
use App\Models\OfferTheme;
use App\Models\OfferSample;
use App\Models\OfferCountry;
use App\Models\OfferProduct;
use App\Models\UseCase;
use App\Models\FAQ;
use App\Models\HelpTopic;
use App\Models\Complaint;
use App\User;
use App\Rules\Mathcaptcha;
use App\Models\ProductPriceMap;
use Session;
use DB;

class HelpController extends Controller
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
     * 
     *  main route of the Help
     * 
     */
    public function index(Request $request) {
        $teammates = array(
            array(
                'id'        => 1, 
                'avatar'    => '../images/dummy/Matthew_DB.png', 
                'name'      => 'Matthew van Niekerk',
                'title'     => 'Co-founder and CEO', 
            ),
        );        
        $data = array( 'teammates' );
        return view('help.overview', compact($data));
    }

    /**
     * 
     *  Buying help data
     * 
     */
    public function buying_data(Request $request) {
        $topics     = HelpTopic::where('page', 'buying')->where('active', 1)->get();
        $header     = HelpTopic::where('page', 'buying_header')->get()->first();
        $faqs       = FAQ::where('for', 'buying')->orderby('created_at', 'desc')->limit(10)->get();
        $data       = array( 'topics', 'header', 'faqs' );
        return view('help.buying-data', compact($data));
    }
    /**
     * 
     *  Buying help data topic
     * 
     */
    public function buying_data_topic(Request $request){
        $topics     = HelpTopic::get();
        $topic      = null;
        foreach ($topics as $key => $t) {
            if($request->title == str_replace(" ", "-", strtolower($t->title))){
                $topic = $t;
                break;
            }
        }
        if(!$topic) 
            return view('errors.404');
        $data = array('topic');
        return view('help.buying-data-topic', compact($data));
    }
    /**
     * 
     *  Selling help data
     * 
     */
    public function selling_data(Request $request) {
        $topics     = HelpTopic::where('page', 'selling')->where('active', 1)->get();
        $header     = HelpTopic::where('page', 'selling_header')->get()->first();
        $faqs       = FAQ::where('for', 'selling')->orderby('created_at', 'desc')->limit(10)->get();
        $data       = array( 'topics', 'header', 'faqs' );
        return view('help.selling-data', compact($data));
    }
    /**
     * 
     * Selling data topic
     * 
     */
    public function selling_data_topic(Request $request) {
        $topics     = HelpTopic::get();
        $topic      = null;
        foreach ($topics as $key => $t) {
            if($request->title == str_replace(" ", "-", strtolower($t->title))){
                $topic = $t;
                break;
            }
        }
        if(!$topic) 
            return view('errors.404');
        $data = array('topic');
        return view('help.selling-data-topic', compact($data));
    }
    /**
     * 
     *  Help Guarantee
     * 
     */
    public function guarantee() {
        $topics     = HelpTopic::where('page', 'guarantees')->get();
        $data       = array('topics');
        return view('help.guarantee', compact($data));
    }
    /**
     * 
     *  Help - File complain
     * 
     */
    public function file_complaint() {
        $topics     = HelpTopic::where('page', 'complaints')->get();
        $data       = array('topics');
        return view('help.file_complaint', compact($data));
    }
    /**
     * 
     * Send file complain
     * 
     */
    public function send_file_complaint(Request $request) {
        $user = $this->getAuthUser();
        if(!$user) {
           return redirect('/login')->with('target', 'file a complaint');
        } else{
            // creating value for captch
            $n1     = rand(1, 6); //Generate First number between 1 and 6 
            $n2     = rand(5, 9); //Generate Second number between 5 and 9 
            $answer = $n1 + $n2; 
            $request->session()->put('verscode', $answer);
            $math_captcha           = "Please solve this math problem: ".$n1." + ".$n2."  = ";
            $params['math_captcha'] = $math_captcha;
            if($request->pid) {
                $paidProduct    = Purchase::where('userIdx', $user->userIdx)->where('productIdx', $request->pid)->get()->first();
                if($paidProduct){
                    $product    = OfferProduct::where('productIdx', $request->pid)
                                    ->get()
                                    ->first();
                    $company    = Provider::join('offers', 'offers.providerIdx', '=', 'providers.providerIdx')
                                    ->join('offerProducts', 'offerProducts.offerIdx', '=', 'offers.offerIdx')
                                    ->where('offerProducts.productIdx', $request->pid)
                                    ->get()
                                    ->first();
                    $data       = array('product', 'company','math_captcha');
                    return view('help.send_file_complaint', compact($data));
                } else{
                      $data     = array('math_captcha');
                      return view('help.send_file_complaint', compact($data));
                }
            }
            else{
                $data           = array('math_captcha');
                return view('help.send_file_complaint', compact($data));
            }
        }
    }
    /**
     * 
     *  Post send file complain
     * 
     */
    public function post_send_file_complaint(Request $request) {
        $user = $this->getAuthUser();        
        if($request->productIdx) {
            $validator      = Validator::make($request->all(),[
                'message'   => 'required|min:5|max:1000',
                'captcha'   => ['required',function ($attribute, $value, $fail) {
                                if (Session::get("verscode") != $value) {
                                    $fail('Pelase enter correct answer.');
                                        }
                                    }
                            ],
                'recaptcha' => [new Mathcaptcha]
            ]);
        } else {
            $validator      = Validator::make($request->all(),[
                'period'                => "required",
                'provider_company_name' => 'required_without_all:seller_company_name,other',
                'seller_company_name'   => 'required_without_all:provider_company_name,other',
                'other'                 => 'required_without_all:provider_company_name,seller_company_name',
                'message'               => 'required|min:5|max:1000',
                'captcha'               => ['required',function ($attribute, $value, $fail) {
                    if (Session::get("verscode") != $value) {
                        $fail('Pelase enter correct answer.');
                            }
                        }
                ],
                'recaptcha' => [new Mathcaptcha]
            ]);
            }
        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }


         // google recaptcha test
         $url       = 'https://www.google.com/recaptcha/api/siteverify';
         $remoteip  = $_SERVER['REMOTE_ADDR'];        
         $ch        = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, "secret=".config('services.recaptcha.secret')."&response=".$request->get('recaptcha'));
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $output = curl_exec($ch);
         curl_close($ch);
         $resultJson = json_decode($output, true);       
         // google recaptcha test

        $provider_company_name  = $request->provider_company_name;
        $seller_company_name    = $request->seller_company_name;
        $other                  = $request->other;
        $message                = $request->message;
        $data['message']        = $message;

        if(isset($request->productIdx)){
            $data['productTitle']   = OfferProduct::where('productIdx', $request->productIdx)->get()->first()->productTitle;
            $data['companyName']    = $request->companyName;
        }
        else
            $data['companyName']    = $provider_company_name ? $provider_company_name : ($seller_company_name ? $seller_company_name : $other);
            $data['user']           = User::join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                                    ->where('userIdx', $user->userIdx)
                                    ->get()
                                    ->first();
        $complaint['userIdx']           = $user->userIdx;
        $complaint['complaintTarget']   = $data['companyName'];
        $complaint['complaintContent']  = $message;
        if(isset($request->productIdx)) $complaint['productIdx'] = $request->productIdx;
        
        Complaint::create($complaint);

        $this->sendEmail("complaint", [
            'from'      => env('DB_TEAM_EMAIL'), 
            'to'        => env('DB_TEAM_EMAIL'), 
            'name'      => APPLICATION_NAME, 
            'subject'   => 'Someone has sent a complaint on '.APPLICATION_NAME,
            'data'      => $data
        ]);
        return view('help.send_complaint_success');
    }
    /**
     * 
     * Get authenticate user
     * 
     */
    public function getAuthUser () {
        return Auth::user();
    }
    /**
     * Feedback
     * 
     * 
     * 
     */
    public function feedback() {
        $topics     = HelpTopic::where('page', 'feedbacks')->get();
        $data       = array('topics');
        return view('help.feedback', compact($data));
    }

    public function oldProductPricePeriodMapping(){
        $prodcuts = DB::select("SELECT * FROM `offerProducts` 
            WHERE productIdx NOT IN (SELECT productIdx FROM `product_price_mapping` GROUP BY productIdx)");
        foreach($prodcuts as $product){
                /* print_r($product->productBidType); */
                $price = $product->productPrice;
                $period =  $product->productAccessDays;
               
                if($product->productBidType == 'bidding_only' || $product->productBidType == 'free'){

                    $price = 0;
                }

                $obj = ProductPriceMap::create(array('productIdx'           =>  $product->productIdx,
                                                     'productPrice'         =>  $price,
                                                     'productAccessDays'    =>  $period));

                $product_data = array('productPrice'        => '',
                                      'productAccessDays'   => '');
                $obj_update = OfferProduct::find($product->productIdx)->update($product_data);                
        }
        echo "Successfully udpated product price period mapping.";
    }
}
