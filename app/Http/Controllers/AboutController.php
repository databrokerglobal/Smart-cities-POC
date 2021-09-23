<?php

/**
 *  
 *  About Controller
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
use App\Models\Region;
use App\Models\Community;
use App\Models\Offer;
use App\Models\Business;
use App\Models\Theme;
use App\Models\OfferTheme;
use App\Models\OfferSample;
use App\Models\OfferCountry;
use App\Models\UseCase;
use App\Models\Contact;
use App\Models\Subscription;
use App\Models\Article;
use Session;
use Response;
use Newsletter;
use App\Models\ContentPages;
use App\Models\Partner;
use App\Helper\SiteHelper;

class AboutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        //$this->middleware(['auth','verified']);
    }
    /**
     * 
     * 
     * About page 
     * 
     * 
     */
    public function index(Request $request)
    {
       
        $aboutus = ContentPages::with(['teams' => function ($query) {
                                $query->where('status', 1);
                    },'stories' => function ($query){
                    $query->where('status', 1);
                    $query->orderBy('year', 'asc');
        }])->where('contentIdx',1)->first();
        
        $data = array('aboutus' );
        return view('about.about', compact($data));
    }
    /**
     * 
     * 
     *  Get auth user
     * 
     * 
     */
    public function getAuthUser ()
    {
        return Auth::user();
    }
    /**
     * 
     * 
     * Partners page
     * 
     * 
     */
    public function partners(Request $request)
    {        
        $partnersList= Partner::where('status',1)->where('logo','<>','')->orderby('created_at', 'desc')
                            ->get();
        $partners = [];
        foreach($partnersList as $partnersListVal){
            $partners[$partnersListVal->partner_type][] = $partnersListVal;
        }

        
        $data = array( 'partners' );
        return view('about.partners', compact($data));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function matchmaking(Request $request)
    {        
        return view('about.matchmaking');
    }

     /**
     * 
     * Matchmeup
     * 
     * 
     * 
     */    

    public function matchmeup(Request $request){
        $user           = $this->getAuthUser();
        $communities    = Community::where('status', 1)->get();  
        $businesses     = Business::get();
        $countries      = Region::where('regionType', 'country')->get(); 
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
        $n1 = rand(1, 6); //Generate First number between 1 and 6 
        $n2 = rand(5, 9); //Generate Second number between 5 and 9 
        $answer = $n1+$n2; 
        $request->session()->put('verscode', $answer);
        $math_captcha = "Please solve this math problem: ".$n1." + ".$n2."  = "; 
        
        $data = array( 'communities', 'businesses', 'countries', 'userData','math_captcha');
        return view('about.matchmeup', compact($data));
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function usecase(Request $request)
    {        
        //$usecases = Article::where('communityIdx', '<>', null)->with('community')->where('active', 1)->orderby('published', 'desc')->limit(9)->get();
      //  $usecases2 = Article::where('communityIdx', '<>', null)->with('community')->where('active', 1)->orderby('published', 'desc')->limit(3)->get();
        
        $usecases = Article::whereHas('community', function($q) {
            $q->where('status', 1);
        })->where('communityIdx', '<>', null)->where('active', 1)->orderby('published', 'desc')->limit(15)->get(); 
        
        $usecases2 = Article::whereHas('community', function($q) {
            $q->where('status', 1);
        })->where('communityIdx', '<>', null)->where('active', 1)->orderby('published', 'desc')->limit(3)->get(); 


        
        $communities = Community::where('status', 1)->get();
        $data = array( 'usecases', 'usecases2', 'communities' );
        return view('about.usecase', compact($data));
    }
    /**
     * 
     * 
     * News page
     * 
     * 
     */
    public function news(Request $request)
    {
        $updates = Article::where('communityIdx', null)->where('active', 1)->orderby('published', 'desc')->limit(15)->get();
        //$updates2 = Article::where('communityIdx', null)->where('active', 1)->orderby('published', 'desc')->limit(3)->get();
        $communities = Community::where('status', 1)->get();
        $data = array( 'updates','communities');

        
        return view('about.news', compact($data));
    }
    /**
     * 
     *  Updates load more
     * 
     * 
     * 
     */
    public function updates_loadmore(Request $request)
    {
        $output = '';
        $published = $request->published;
        $updates = Article::where('communityIdx', null)->where('published', '<', $published)->orderby('published', 'desc')->limit(12)->get();
        if(!$updates->isEmpty())
        {
            foreach($updates as $update)
            {
                $published  = $update->published;
                $author     = $update->author;
                $title      = $update->articleTitle;
                $slug       = $update->slug;
                $id         = $update->articleIdx;
                $image      = $update->image;
                $output .= '<div class="col-md-4">'.
                                '<a href="'.env('APP_URL').'/about/updates/'. $slug .'" target="_blank">
                                    <div class="card card-profile card-plain">
                                        <div class="card-header holder" id="responsive-card-header">'.
                                            '<img class="img" src="'.asset('uploads/usecases/medium/'. $image).'"  id="responsive-card-img">
                                        </div>
                                        <div class="card-body text-left">
                                            <div class="para-small">
                                                <span class="color-green"><b>- By&nbsp;'.$author.'&nbsp;|&nbsp;'.date_format($published,"F d, Y").'</b></span>
                                            </div>
                                            <h4 class="offer-title card-title">'.$title.'</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>';
            }
            if(count($updates) == 12)
            {
                $output .= '<div class="col-md-12">
                            <div class="flex-center" id="remove-row">
                                <button type="button" class="button blue-outline w225" id="btn-more" data-id="'. $published .'">LOAD MORE</button>
                            </div>
                        </div>';
            }
            echo $output;
        }
    }
    /**
     * 
     *  Filter updates
     * 
     * 
     * 
     */

    public function filter_updates(Request $request)
    {      
        $output = '';
        $communityIdx = $request->communityIdx;
        
        
        $updates = Article::where('communityIdx', '<>', null)
                    ->where('communityIdx', '=', $communityIdx)
                    ->orderby('published', 'desc')->get();
        if($communityIdx == 'all'){
            $updates = Article::where('communityIdx', '<>', null)
            ->orderby('published', 'desc')->get();
        }
        if(!$updates->isEmpty())
        {
            foreach($updates as $update)
            {
                $published  = $update->published;
                $author     = $update->author;
                $title      = $update->articleTitle;
                $slug       = $update->slug;
                $id         = $update->articleIdx;
                $image      = $update->image;
                $output .= '<div class="col-md-4">'.
                                '<a href="'.env('APP_URL').'/about/updates/'. $slug .'" target="_blank">
                                    <div class="card card-profile card-plain">
                                        <div class="card-header holder" id="responsive-card-header">'.
                                            '<img class="img" src="'.asset('uploads/usecases/medium/'. $image).'"  id="responsive-card-img">
                                        </div>
                                        <div class="card-body text-left">
                                            <div class="para-small">
                                                <span class="color-green"><b>- By&nbsp;'.$author.'&nbsp;|&nbsp;'.date_format($published,"F d, Y").'</b></span>
                                            </div>
                                            <h4 class="offer-title card-title">'.$title.'</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>';
            }           
            echo $output;
        }
    }


    /**
     * 
     * 
     * 
     * Use case load more
     * 
     */

    public function usecases_loadmore(Request $request)
    {
        $output     = '';
        $published  = $request->published;
        $usecases   = Article::where('communityIdx', '<>', null)->where('published', '<', $published)->orderby('published', 'desc')->limit(12)->get();
        if(!$usecases->isEmpty())
        {
            foreach($usecases as $usecase)
            {
                $published      = $usecase->published;
                $communityName  = $usecase->community->communityName;
                $title          = $usecase->articleTitle;
                $slug           = $usecase->slug;
                $id             = $usecase->articleIdx;
                $image          = $usecase->image;
                $output .= '<div class="col-md-4">'.
                                '<a href="'.env('APP_URL').'/about/usecase/'. $slug .'" target="_blank">
                                    <div class="card card-profile card-plain">
                                        <div class="card-header holder" id="responsive-card-header">'.
                                            '<img class="img" src="'.asset('uploads/usecases/medium/'. $image).'"  id="responsive-card-img">
                                        </div>
                                        <div class="card-body text-left">
                                            <div class="para-small">
                                                <span class="color-green"><b>'.$communityName.'</b></span>
                                            </div>
                                            <h4 class="offer-title card-title">'.$title.'</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>';
            }
            if(count($usecases) == 12)
            {
                $output .= '<div class="col-md-12">
                            <div class="flex-center" id="remove-row">
                                <button type="button" class="button blue-outline w225" id="btn-more" data-id="'. $published .'">LOAD MORE</button>
                            </div>
                        </div>';
            }
            echo $output;
        }
    }
    /**
     * 
     *  
     *  Filter use cases
     * 
     */


    public function filter_usecases(Request $request)
    {
        $output         = '';
        $communityIdx   = $request->communityIdx;
        
        
        $usecases = Article::where('communityIdx', '<>', null)
                    ->where('communityIdx', '=', $communityIdx)
                    ->orderby('published', 'desc')->get();
        if($communityIdx == 'all'){
            $usecases = Article::where('communityIdx', '<>', null)
            ->orderby('published', 'desc')->get();
        }
        if(!$usecases->isEmpty())
        {
            foreach($usecases as $usecase)
            {
                $published      = $usecase->published;
                $communityName  = $usecase->community->communityName;
                $title          = $usecase->articleTitle;
                $slug           = $usecase->slug;
                $id             = $usecase->articleIdx;
                $image          = $usecase->image;
                $output .= '<div class="col-md-4">'.
                                '<a href="'.env('APP_URL').'/about/usecase/'. $slug .'" target="_blank">
                                    <div class="card card-profile card-plain">
                                        <div class="card-header holder" id="responsive-card-header">'.
                                            '<img class="img" src="'.asset('uploads/usecases/medium/'. $image).'"  id="responsive-card-img">
                                        </div>
                                        <div class="card-body text-left">
                                            <div class="para-small">
                                                <span class="color-green"><b>'.$communityName.'</b></span>
                                            </div>
                                            <h4 class="offer-title card-title">'.$title.'</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>';
            }
           
            echo $output;
        }
    }


    /**
     * 
     * 
     * Use case detail
     * 
     * 
     */

    public function usecase_detail(Request $request){

        $usecases   = Article::with('community')->get();
        $usecase    = null;
        foreach ($usecases as $key => $uc) {
            if($uc->slug ==$request->title){
                $usecase = $uc;
                break;
            }
        }
        $usecases2 = Article::where('communityIdx', '<>', null)->with('community')->orderby('published', 'desc')->limit(3)->get();
        
        $data = array('usecase', 'usecases2');
        return view('about.usecase_detail', compact($data));
    }
    /**
     * 
     * 
     * News Detail
     * 
     * 
     */
    public function news_detail(Request $request){
        // usecases detail
        // $usecase = Article::where('articleIdx', $id)->with('community')->get();
        // $usecases2 = Article::with('community')->orderby('published', 'desc')->limit(3)->get();
        // $data = array('usecase', 'usecases2');
        // return view('about.news_detail', compact($data));

        $updates    = Article::get();
        $update     = null;
        foreach ($updates as $key => $u) {
            if($u->slug == $request->title){
                $update = $u;
                break;
            }
        }
        $updates2 = Article::where('communityIdx', null)->orderby('published', 'desc')->limit(3)->get();
        $data = array('update', 'updates2');
        // return view('about.news_detail', compact($data));
        return view('about.updates_detail', compact($data));
    }

    /**
     * 
     * Contact
     * 
     * 
     * 
     */    

    public function contact(Request $request){
        $user           = $this->getAuthUser();
        $communities    = Community::where('status', 1)->get();  
        $businesses     = Business::get();
        $countries      = Region::where('regionType', 'country')->get(); 
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
        $n1 = rand(1, 6); //Generate First number between 1 and 6 
        $n2 = rand(5, 9); //Generate Second number between 5 and 9 
        $answer = $n1+$n2; 
        $request->session()->put('verscode', $answer);
        $math_captcha = "Please solve this math problem: ".$n1." + ".$n2."  = "; 
        
        $data = array( 'communities', 'businesses', 'countries', 'userData','math_captcha');
        return view('about.contact', compact($data));
    }

       /**
     * 
     * 
     *  Contact pass
     * 
     * 
     */
    public function contact_pass(){
        $communities    = Community::where('status', 1)->get();  
        $businesses     = Business::get();
        $countries      = Region::where('regionType', 'country')->get(); 
        $data           = array( 'communities', 'businesses', 'countries' );
        return view('about.contact_pass', compact($data));
    }
    /**
     * 
     * 
     * Send email
     * 
     * 
     */
    public function send(Request $request){
        //regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix
        $validator = Validator::make($request->all(),[
            'firstname'     => 'required|min:2',
            'lastname'      => 'required|min:2',
            'email'         => 'required|max:255|email',
            'message'       => 'required|min:5|max:1000',
            'companyName'   => 'required|min:2',
            'regionIdx'     => 'required',
            'community'     => 'required|array|min:1',
            'captcha'       => 'required'
        ],[
            'community.required'=>'Please choose at least one.',
            'regionIdx.required'=>'The country field is required.',
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

            $contact_data['firstname']      = $request->firstname;
            $contact_data['lastname']       = $request->lastname;
            $contact_data['email']          = $request->email;        
            $contact_data['companyName']    = $request->companyName;
            $contact_data['regionIdx']      = $request->regionIdx;
            $contact_data['businessName']   = $businessName;
            $contact_data['role']           = $role;
            $contact_data['content']        = $request->message;
            $contact_data['communities']    = json_encode($request->community);
            $contact_data['isOptCommunication'] = $request->isOptCommunication == 'on' ? true : false;
            
            $contact_obj    = Contact::create($contact_data);
            $data           = $contact_data;
            $communities    = array();

            foreach ($request->community as $key => $value) {
                $comm = Community::where('communityIdx', $value)->get()->first();
                array_push($communities, $comm['communityName']);
            }
            $data['communities']    = $communities;
            $region                 = Region::where('regionIdx', $request->regionIdx)->get()->first();
            $data['region']         = $region['regionName'];
            $allCommunities         = Community::where('status', 1)->get();
            $hasInterests           = array();

            foreach ($allCommunities as $key => $comm) {
                if(in_array($comm['communityName'], $communities)) {
                    $hasInterests[$comm['communityName']]   = "true";
                } else {
                    $hasInterests[$comm['communityName']]  = "false";
                }
            }
            $query['message']       = $data['content'];
            $query['firstname']     = $data['firstname'];
            $query['lastname']      = $data['lastname'];
            $query['email']         = $data['email'];
            $query['companyName']   = $data['companyName'];
            $query['regionIdx']     = $data['regionIdx'];
            $query['businessName2'] = $request->businessName2 ? $request->businessName2 : "";
            $query['businessName']  = $request->businessName ? $request->businessName : "";
            $query['role2']         = $request->role2 ? $request->role2 : "";
            $query['role']          = $request->role ? $request->role : "";
            $query                  = array_merge($query, $hasInterests);

            $client = new \GuzzleHttp\Client();
            $url = "https://prod-33.westeurope.logic.azure.com:443/workflows/678891364593415ca0bd87aa5fdc1dae/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=L5XvuSyw821hQf4GUDLTY1OrPotQik6gvQ3nIJEAljk";
            $response = $client->request("POST", $url, [
                'headers'   => ['Content-Type' => 'application/json'],
                'body'      => json_encode($query)
            ]);

            $this->sendEmail("contact", [
                'from'      => $data['email'], 
                'to'        => env('DB_TEAM_EMAIL'), 
                'name'      => APPLICATION_NAME, 
                'subject'   => 'Message to the '.APPLICATION_NAME.' Team',
                'data'      => $data
            ]);
            $this->sendEmail("contact", [
                'from'      => $data['email'], 
                'to'        => "valentina@settlemint.com", 
                'name'      => APPLICATION_NAME, 
                'subject'   => 'Message to the '.APPLICATION_NAME.' Team',
                'data'      => $data
            ]);

            $logDetail = 'Subscribed: Email- '.$data['email'].', Name- '.$data['firstname'].' '.$data['lastname'].', Company- '.$data['companyName'];
            SiteHelper::logActivity('NEWS_BYTES', $logDetail, 0);
            
            return view('about.contact_success');
        } else {

            return redirect(url()->previous())
                    ->withErrors(['google_captcha' => 'Google ReCaptcha Error']);
        }
    }
    /**
     * 
     * Media center
     * 
     * 
     * 
     */
    public function media_center(){
        $press_list = array(
            array(
                'id'    => 1,
                'title' => 'Media inquiries',
                'text'  => 'We’re always happy to work with journalists from around the world to discuss the rising value and importance of data in general, or '.APPLICATION_NAME.'’s peer-to-peer data marketplace in particular. If you’re a member of the media and would like to talk with us, please get in touch.',
                'action'=> 'CONTACT US',
                'link'=>'contact'
            ),
            array(
                'id'    => 2,
                'title' => APPLICATION_NAME.' media kit',
                'text'  => 'Our media kit contains everything you need to write about '.APPLICATION_NAME.', including web-friendly logos, photos of our team, short biographies of our founders, a company overview and a summary of what our platform offers.',
                'action'=> 'DOWNLOAD OUR MEDIA KIT',
                'link'=> 'download.data-toolkit'
            ),
        );
        $partners = array (
            array(
                'id'    => 1,
                'logo'  => '/images/partners/ericsson.png',
                'link'  => 'http://www.blog-ericssonfrance.com/2018/11/13/databroker-dao-rejoint-le-5g-life-campus-dericsson-a-hasselt-en-belgique/'
            ),
            array(
                'id'    => 2,
                'logo'  => '/images/partners/techzine.png',
                'link'  => 'https://www.techzine.be/nieuws/29548/belgen-op-mwc-settlemint-laat-zien-waartoe-blockchain-in-staat-is.html'
            ),
            array(
                'id'    => 3,
                'logo'  => '/images/partners/LeVif.png',
                'link'  => 'https://datanews.levif.be/ict/start-ups/une-start-up-de-louvain-ouvre-une-plate-forme-de-commerce-pour-donnees-iot/article-normal-1073539.html?cookie_check=1552640905'
            ),
            array(
                'id'    => 4,
                'logo'  => '/images/partners/datanews.png',
                'link'  => 'https://datanews.knack.be/ict/start-ups/leuvense-start-up-opent-handelsplatform-voor-iot-data/article-normal-1412063.html?cookie_check=1552640929'
            ),
            array(
                'id'    => 5,
                'logo'  => '/images/partners/PRNews.png',
                'link'  => 'https://eprnews.com/internet-of-things-marketplace-databroker-dao-continues-at-full-speed-announcing-3-new-alliance-members-and-listing-on-tokenjar-359835/'
            ),
            array(
                'id'    => 6,
                'logo'  => '/images/partners/inc.png',
                'link'  => 'https://www.inc.com/darren-heitner/the-internet-of-things-doesnt-have-to-be-confusing-heres-how-your-business-can-get-in-on-600-billion-market.html'
            ),
            array(
                'id'    => 7,
                'logo'  => '/images/partners/TechBullion.png',
                'link'  => 'https://www.techbullion.com/interview-with-matthew-van-niekerk-founder-of-databroker-dao-on-databroker-dao-token-sale/'
            ),
            array(
                'id'    => 8,
                'logo'  => '/images/partners/detijd.png',
                'link'  => 'https://www.tijd.be/dossier/blockchain/leuvenaars-halen-virtuele-miljoenen-op-voor-handel-in-sensordata/10012926.html'
            ),
            array(
                'id'    => 9,
                'logo'  => '/images/partners/criptonotcias.png',
                'link'  => 'https://www.criptonoticias.com/publicidad/databroker-dao-anuncio-fechas-road-show-china-duplica-recompensas-venta-token/'
            ),
            array(
                'id'    => 10,
                'logo'  => '/images/partners/Reuters.png',
                'link'  => 'https://www.reuters.com/brandfeatures/venture-capital/article?id=32112'
            ),
            array(
                'id'    => 11,
                'logo'  => '/images/partners/Medium.png',
                'link'  => 'https://medium.com/databrokerdao/is-databroker-dao-taking-on-iota-342dc1481812'
            ),
            array(
                'id'    => 12,
                'logo'  => '/images/partners/smartbelgium.png',
                'link'  => 'https://smartbelgium.belfius.be/deelnemers/databroker-dao-is-eerste-marktplaats-iot-data/'
            ),
            array(
                'id'    => 13,
                'logo'  => '/images/partners/jinse.png',
                'link'  => 'http://www.jinse.com/news/blockchain/116602.html'
            ),
            array(
                'id'    => 14,
                'logo'  => '/images/partners/momenta_partners.png',
                'link'  => 'https://www.momenta.partners/edge/unlocking-the-value-of-sensor-data-through-the-marketplace-part-1'
            ),
            array(
                'id'    => 15,
                'logo'  => '/images/partners/identitymindglobal.png',
                'link'  => 'https://cdn2.hubspot.net/hubfs/459645/IDM-DatabrokerDAO-CaseStudy.pdf?t=1505774771437'
            ),
            array(
                'id'    => 16,
                'logo'  => '/images/partners/BlockchainNews.png',
                'link'  => 'https://www.the-blockchain.com/2017/10/14/announcing-first-members-databrokerdao-alliance/'
            ),
            array(
                'id'    => 17,
                'logo'  => '/images/partners/demorgen.png',
                'link'  => 'https://myprivacy.persgroep.net/?siteKey=6OfBU0sZ5RFXpOOK&callbackUrl=https://www.demorgen.be/privacy-wall/accept?redirectUri=/economie/geld-ophalen-was-nog-nooit-zo-makkelijk-maar-is-het-ook-veilig-b4b9bc32/'
            ),
            array(
                'id'    => 18,
                'logo'  => '/images/partners/dsdestandaard.png',
                'link'  => 'http://www.standaard.be/cnt/dmf20170914_03072983'
            ),
            array(
                'id'    => 19,
                'logo'  => '',
                'link'  => ''
            ),
            array(
                'id'    => 20,
                'logo'  => '',
                'link'  => ''
            ),
            array(
                'id'    => 21,
                'logo'  => '/images/partners/globenewswire.png',
                'link'  => 'https://www.globenewswire.com/news-release/2017/08/31/1106159/0/en/Medici-Ventures-Portfolio-Company-SettleMint-Announces-Token-Sale-for-DataBroker-DAO-Beginning-September-18-2017.html'
            ),
            array(
                'id'    => 22,
                'logo'  => '/images/partners/marketwatch.png',
                'link'  => 'https://www.marketwatch.com/press-release/medici-ventures-portfolio-company-settlemint-announces-token-sale-for-databroker-dao-beginning-september-18-2017-2017-08-31'
            ),
            array(
                'id'    => 23,
                'logo'  => '',
                'link'  => ''
            ),
            array(
                'id'    => 24,
                'logo'  => '',
                'link'  => ''
            )
        );
        $data = array( 'press_list', 'partners' );
        return view('about.media_center', compact($data));        
    }
    /**
     * 
     * 
     * Terms and conditions
     * 
     * 
     */
    public function terms_conditions(){
        return view('about.terms_conditions');
    }
    /**
     * 
     * 
     * Privacy policy
     * 
     * 
     */
    public function privacy_policy(){
        return view('about.privacy_policy');
    }
    /**
     * 
     * Cookie policy
     * 
     * 
     * 
     */
    public function cookie_policy(){
        return view('about.cookie_policy');
    }
    /**
     * 
     * Download
     * 
     * 
     * 
     */
    public function download(){
        //PDF file is stored under project/public/download/Databroker-Press-Kit.zip
        $file= public_path(). "/download/Databroker-Press-Kit.zip";
        $headers = array(
                'Content-Type: application/pdf',
                );
        return Response::download($file, 'Databroker-Press-Kit.zip', $headers);
    }
    /**
     * 
     * 
     *  Register for news bytes view page
     * 
     * 
     */
    protected function register_nl()
    {
        $communities    = Community::where('status', 1)->get();
        $businesses     = Business::get();
        $countries      = Region::where('regionType', 'country')->get(); 
        $user           = $this->getAuthUser();
        $userData       = null;
        $url            = Session::get('url.intended');       
        $next_url       = strpos($url, 'verify_success') !== false ? url('/') : $url;        
    

        $data = array( 'communities', 'businesses', 'countries', 'next_url'); 
        return view('auth.register_nl', compact($data));
    }  
    /**
     * 
     * 
     *  Sign up for news bytes 
     * 
     * 
     */
    protected function create_nl(Request $request){

        if($request->userIdx)
            $rules = [
                "community" => 'required|array|min:1'
            ];
        else
            $rules = [
                'firstname'     => 'required|min:2',
                'lastname'      => 'required|min:2',
                'email'         => 'required|max:255|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'companyName'   => 'required|min:2',
                'businessName2' => 'required',
                'role2'         => 'required',
                'community'     => 'required|array|min:1',
                
            ];
        if($request->businessName2 == "Other industry") $rules['businessName'] = "required|string";
        if($request->role2 == "Other") $rules['role'] = "required|string";
        $validator = Validator::make($request->all(), $rules, [
            'companyName.required'      =>'Your company name is required.',
            'businessName2.required'    =>'Your industry is required.',
            'businessName.required'     =>'Your industry is required.',
            'role2.required'            =>'Your role is required.',
            'role.required'             =>'Your role is required.',
            'community.required'        =>'Please choose at least one.',
            
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $businessName = ($request->businessName2 ==='Other industry' || !$request->businessName2) ? $request->businessName:$request->businessName2;
        $role = ($request->role2 === 'Other' || !$request->role2) ? $request->role:$request->role2;

        $subscription['firstname']      = $request->firstname;
        $subscription['lastname']       = $request->lastname;
        $subscription['email']          = $request->email;        
        $subscription['companyName']    = $request->companyName;
        $subscription['regionIdx']      = $request->regionIdx;
        $subscription['businessName']   = $businessName;
        $subscription['role']           = $role;
        $subscription['communities']    = json_encode($request->community);

        $subscriptionObj = Subscription::where('email', '=', $request->email)->get()->first();
        if($subscriptionObj) $subscriptionObj->delete();

        $subscriptionObj = Subscription::create($subscription);

        // if ( ! Newsletter::isSubscribed($request->email) ) {
        //     Newsletter::subscribe($request->email);
        // }

        $data           = $subscription;
        $communities    = array();
        foreach ($request->community as $key => $value) {
            $comm = Community::where('communityIdx', $value)->where('status', 1)->get()->first();
            array_push($communities, $comm['communityName']);
        }
        $data['communities']    = $communities;
        $region                 = Region::where('regionIdx', $request->regionIdx)->get()->first();
        $data['region']         = $region['regionName'];
        $allCommunities         = Community::where('status', 1)->get();
        $hasInterests           = array();
        foreach ($allCommunities as $key => $comm) {
            if(in_array($comm['communityName'], $communities)) {
                $hasInterests[$comm['communityName']] = "true";
            } else {
                $hasInterests[$comm['communityName']] = "false";
            }
        }
        $query['firstname']     = $data['firstname'];
        $query['lastname']      = $data['lastname'];
        $query['email']         = $data['email'];
        $query['companyName']   = $data['companyName'];
        $query['regionIdx']     = $request->regionIdx ? $request->regionIdx : "";
        $query['businessName2'] = $request->businessName2 ? $request->businessName2 : "";
        $query['businessName']  = $request->businessName ? $request->businessName : "";
        $query['role2']         = $request->role2 ? $request->role2 : "";
        $query['role']          = $request->role ? $request->role: "";
        $query                  = array_merge($query, $hasInterests);

        $client = new \GuzzleHttp\Client();
        $url = "https://prod-48.westeurope.logic.azure.com:443/workflows/95373d6629684ab4a3adcc6572a61659/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=nmg5h6l_9s5gJnY9JIHRcCeZPcFnOF0l-dyi5mdWVbA";
        $response = $client->request("POST", $url, [
            'headers'   => ['Content-Type' => 'application/json'],
            'body'      => json_encode($query)
        ]);

        $url        = Session::get('url.intended');
        $next_url   = strpos($url, 'verify_success') !== false ? url('/') : $url; 
        $data       = array('next_url');
        $mail_data  = array('firstname' => $request->firstname);
        $mail_data['communities'] = join(",",$communities);
        $this->sendEmail("newsletter", [
            'from'      => env('DB_TEAM_EMAIL'), 
            'to'        => $request->email, 
            'subject'   => 'Welcome to '.APPLICATION_NAME, 
            'name'      => APPLICATION_NAME,
            'userData'  => $mail_data
        ]);    


        return view('auth.register_nl_success', compact($data));
    }
    /**
     * 
     * 
     *  Refresh captcha
     * 
     * 
     */
    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img('flat')]);
    }
    
    /**
     * 
     * 
     * Email validator
     * 
     * 
     */
    public function email_validator(){
        $data       = [];     
        $user       = $this->getAuthUser();
        $userData   = null;
        $next_url   = Session::get('url.intended');
        /* if($user){ */
            $userData   = User::where('userIdx', $user->userIdx)->get()->first();
            $data       = array('userData'); 
            return view('auth.email_validator', compact($data));            
        /* } */
        

    }

    /**
     * 
     * 
     * Validate OTP
     * 
     * 
     */
    public function validate_otp(){

        $rules = [
            'otp' => 'required',            
        ];
        
        $validator = Validator::make($request->all(), $rules, [
            'otp.required'=>'Please enter otp.',            
        ]);

        if ($validator->fails()) {
        }else{

        }

    }
    /**
     * 
     * Email not verified
     * 
     * 
     * 
     */
    public function email_not_verified(){

        $data = [];
        return view('auth.verify', compact($data));  

    }

    /**
     * 
     * 
     * Verify success
     * 
     * 
     */
    public function verify_success(){
        
        $data = [];
        return view('auth.email_verify_success', compact($data));  
    }
    /**
     * 
     * Register success
     * 
     * 
     * 
     */
    public function register_success(){
        
        $data = [];
        return view('auth.register_success', compact($data));  
    }   

    /**
     * 
     *  DXC documentation
     * 
     * 
     * 
     */
    public function dxc_documentation(){        
        
        $dxc_doc = ContentPages::with(['teams' => function ($query){
            $query->where('status', 1);
        },'stories' => function ($query){
            $query->where('status', 1);
            $query->orderBy('year', 'asc');
        }])->where('contentIdx',2)->first();
        
        $data = array('dxc_doc' );
        return view('about.dxc_documentation', compact($data));
}

    
    /**
     * 
     *  smart cities content page
     * 
     * 
     * 
     */
    public function smart_cities(){

        return view('content.smart_cities');
    }

    /**
     * 
     *  iot platform content page
     * 
     * 
     * 
     */
    public function iot_platforms(){

        return view('content.iot-platforms');
    }


     /**
     * 
     *  smart cities survey content page
     * 
     * 
     * 
     */
    public function smart_cities_survey_report(){

        return view('content.smart_cities_survey_report');
    }
    /**
     * 
     *  value of data content page
     * 
     * 
     * 
     */
    public function value_of_data(){

        return view('content.value_of_data');
    }

    /**
     * 
     *  white paper content page
     * 
     * 
     * 
     */
    public function smart_white_paper(){        
            return view('content.white_paper');
    }

     /**
     * 
     *  Satellite data for agriculture content page
     * 
     * 
     * 
     */
    public function satelliteDataForAgriculture(){

        return view('content.satellite_data_for_agriculture');
    }


    public function content_contacts(){
        return view('content.get_in_touch_popup');
    }

}
