<?php 

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Mail;
use Newsletter;

use App\User;
use App\Models\Community;
use App\Models\Region;
use App\Models\Company;
use App\Models\Business;
use App\Models\LinkedUser;
use App\Models\Subscription;
use App\Models\Wallet;
use App\Models\OrgUsers;
use App\Helper\SiteHelper;
use Session;
use App\Rules\Mathcaptcha;

use Config;
use \stdClass;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //comment to enable verification link
    protected $redirectTo = '/register_success';
    /* protected $redirectTo = '/register_nl'; */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * 
     *  Display registration form
     * 
     * 
     */
    public function showRegistrationForm(Request $request)
    {        
        $email      = $request->e?base64_decode($request->e):"";
        $companyIdx = $request->cid?$request->cid:"";
        $company    = Company::where('companyIdx', '=', $companyIdx)->get()->first();

        $params['email']        = $email;
        $params['company']      = $company;
        $params['businesses']   = Business::get();

         // creating value for captch
         $n1    =   rand(1,6); //Generate First number between 1 and 6 
         $n2    =   rand(5,9); //Generate Second number between 5 and 9 
         $answer=   $n1+$n2; 
         $request->session()->put('verscode', $answer);
         $math_captcha = "Please solve this math problem: ".$n1." + ".$n2."  = "; 

         $params['math_captcha'] = $math_captcha;

        return view('auth.register')->with($params);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // 'ends_with:.com,.me.in,.in,.global'
    //'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
    
    protected function validator(array $data)
    {
        $rules = [
            'firstname'     => ['required', 'string', 'max:255'],
            'lastname'      => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users','ends_with:.com,.co,.in,.co.in,.live,.global,.edu,.info'],
            'companyName'   => ['required'],
            'businessName2' => ['required'],
            'role2'         => ['required'],
            'password'      => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'password_confirmation'=>['same:password'],
            'term_conditions'       => ['required'],
            'captcha'               => ['required',function ($attribute, $value, $fail) {
                                        if (Session::get("verscode")!=$value) {
                                            $fail('Pelase enter correct answer.');
                                        }
                                    }
                                ],
            'recaptcha' => [new Mathcaptcha]
        ];
        
        if($data['businessName2']   == "Other industry")
            $rules['businessName'] = ['required', 'string'];
        else if($data['role2'] == "Other")
            $rules['role'] = ['required', 'string'];
        return Validator::make($data, $rules, [
            'companyName.required'      =>  'Your company name is required.',
            'businessName2.required'    =>  'Your industry is required.',
            'businessName.required'     =>  'Your industry is required.',
            'role2.required'            =>  'Your role is required.',
            'role.required'             =>  'Your role is required.',
            'password.min'              =>  'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password.required'         =>  'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password.regex'            =>  'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password_confirmation.same'=>"Passwords do not match.",
            'term_conditions.required'  =>'Please confirm that you accept '.APPLICATION_NAME.'’s terms and conditions and privacy policy.',  
            'email.ends_with'           => 'Please enter valid email.',           
        ]);

       /*  if(Session::get("verscode")!=$request->captcha){

            return redirect(url()->previous())
                    ->withErrors(['captcha' => 'Please enter correct answer.'])
                    ->withInput();
        } */
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data){
      
        
            $businessName   = $data['businessName2'] === 'Other industry' ? $data['businessName'] : $data['businessName2'];
            $role           = $data['role2'] === 'Other' ? $data['role'] : $data['role2'];

            $userStatus     = 1;
            if($data['companyIdx'] != 0) 
                $userStatus = 2;
            $isLinkedUser   = LinkedUser::where('linked_email', '=', $data['email'])->first();
            if($isLinkedUser) 
                $isLinkedUser->delete();
            $companyIdx = $data['companyIdx'];

            if($data['companyIdx']==0) {
                
                $slugString     = SiteHelper::slugify($data['companyName']);
                $slugCount      = Company::where('slug', $slugString)->count();
                if ($slugCount > 0) {
                    $slug = '';
                }else {
                    $slug = $slugString;
                }

                // $companyObj = Company::where('CompanyName', '=', $data['companyName'])->first();
                // if(!$companyObj)
                    $companyObj = Company::create([                
                        'companyName'   => $data['companyName'],
                        'slug'          => $slug
                    ]);
                //else $userStatus=2;
                $data['companyIdx'] = $companyObj['companyIdx'];
                $companyIdx = $companyObj['companyIdx'];

                if ($slugCount > 0) {
                    $slug = $slugString.'-'.$companyIdx;
                    Company::where('companyIdx', $companyIdx)->update(['slug' => $slug]);
                }

            }
            $data['userStatus'] = $userStatus;

            $query              = $data;
            $query['user_type'] = "data_buyer";
            $query['job_title'] = "";
            $query['region']    = "";
            $query['companyURL'] = "";
            $query['companyVAT'] = "";

            unset($query['_token']);
            unset($query['companyIdx']);
            unset($query['userStatus']);
            unset($query['password']);
            unset($query['password_confirmation']);

            $client1 = new \GuzzleHttp\Client();
            $url        = Config::get('global_constants.azure_workflow_api_url')."/bdf7e02c893d426c8f8e101408d30471/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=RvoLkDUgsGbKOUk8oorOUrhXpjcSIdf1_29oSPDA-Tw";
            $response   = $client1->request("POST", $url, [
                'headers'   => ['Content-Type' => 'application/json'],
                'body'      => json_encode($query)
            ]);

            //storing dat in hubspot 
            $hubspot_data = array("firstname" => $data['firstname'],
                                  "lastname"  => $data['lastname'],
                                  "email"     => $data['email'],
                                  "industry"  => $businessName,
                                  "jobtitle"  => $role,
                                  "company"   => $data['companyIdx']);                        
            
            Session::put('hubspot_signup_data', json_encode($hubspot_data));
           
            //create a wallet
            $client2    = new \GuzzleHttp\Client();
            $url        = Config::get('global_constants.dxsapiurl')."/ethereum/wallet";
            $response   = $client2->request("POST", $url, [
                'headers'   => ['Content-Type' => 'application/json', 'DXS_API_KEY' => Config::get('global_constants.dxsapikey')],
                'body'      =>'{}'
            ]);
            $responseBody       = json_decode($response->getBody()->getContents());
            $walletAddress      = $responseBody->address;
            $walletPrivateKey   = $responseBody->privatekey;
            $otp                = mt_rand(100000,999999);             

            try{
                $this->sendEmail("register", [
                    'from'      =>  env('DB_TEAM_EMAIL'), 
                    'to'        =>  $data['email'], 
                    'subject'   => 'Welcome to '.APPLICATION_NAME, 
                    'name'      => APPLICATION_NAME,
                    'userData'  => $data,
                    'otp'       => $otp
                ]);  
            }catch(\Exception $e){
                //echo $e->getMessage();
            }      

            $objUser =  User::create([
                'firstname'     => $data['firstname'],
                'lastname'      => $data['lastname'],
                'email'         => $data['email'],
                'companyIdx'    => $companyIdx,
                'businessName'  => $businessName,
                'role'          => $role,
                'userStatus'    => $userStatus,
                'wallet'        => $walletAddress,
                'walletPrivateKey'=> $walletPrivateKey,
                'password'      => Hash::make($data['password']),
                'otp'           => $otp
            ]);

            $logDetail = 'Register: ID-'.$objUser->userIdx.', Email-'.$data['email'].', Business Name- '.$businessName;
            SiteHelper::logActivity('USER_ACCOUNT', $logDetail, $objUser->userIdx);
            return $objUser;

            OrgUsers::where('orgUserEmail', $data['email'])->update([
                'isUserRegistered'=> true,
            ]);               
    }

    public function makeObject($name,$value){
            $name_obj = new stdClass();
            $name_obj->name =  ''.$name;
            $name_obj->value = ''.$value;
            return $name_obj;
    }
}
