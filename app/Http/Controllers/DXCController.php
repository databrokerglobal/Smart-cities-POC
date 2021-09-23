<?php
/**
 *  
 *  DXC Controller
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
use App\Models\DxcVersions;
use Config;

class DXCController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware(['auth','verified']);
    }
    /**
     *  Get user authenticated
     * 
     * 
     */
    public function getAuthUser () {
        return Auth::user();
    }

    /**
     * 
     *  Main page of the DXC
     *     
     */
    public function index(){
        $user           = $this->getAuthUser();
        $userObj        = User::where('userIdx', $user->userIdx)->get()->first();
        $dxc_versions   = DxcVersions::where('isActive',true)->get();
        $address        = $userObj->wallet;
        $apiKey         = $userObj->apiKey;

        $client1    = new \GuzzleHttp\Client();
        $url        = Config::get('global_constants.dxsapiurl')."/user/apikey/".$address;
        $response   = $client1->request("GET", $url, [
            'headers'   => ['Content-Type'  => 'application/json', 
                            'DXS_API_KEY'   => Config::get('global_constants.dxsapikey')],
            'body'      =>'{}'
        ]);
        $apiKey         = $response->getBody()->getContents();
        $walletAddress  = $userObj->wallet;
        $client2        = new \GuzzleHttp\Client();
        $url            = Config::get('global_constants.dxsapiurl')."/dxc/getfor/".$walletAddress;
        $response       = $client2->request("GET", $url, [
            'headers'   => ['Content-Type'  => 'application/json', 
                            'DXS_API_KEY'   => Config::get('global_constants.dxsapikey')],
            'body'      =>'{}'
        ]);
        $response   = json_decode($response->getBody()->getContents());
        $dxcs       = $response->dxcs;
        $data       = array('address', 'apiKey', 'dxcs','dxc_versions');
        return view('dxc.data_exchange_controller', compact($data));
    }

    /**
     *  Updated API Key
     * 
     * 
     */
    public function update_apiKey(Request $request){
        $client     = new \GuzzleHttp\Client();
        $url        = Config::get('global_constants.dxsapiurl')."/user/apikey/".$request->address.'?forceNew=true';
        $response   = $client->request("GET", $url, [
            'headers'   => ['Content-Type'  => 'application/json', 
                            'DXS_API_KEY'   => Config::get('global_constants.dxsapikey')],
            'body'      =>'{}'
        ]);
        $apiKey     = $response->getBody()->getContents();

        if($apiKey != "") 
            return "success";
        else 
            return "fail";
    }
    /**
     * 
     * 
     *  Update DXC Status
     * 
     */
    public function update_dxc_status(Request $request){
        $client     = new \GuzzleHttp\Client();       
        $dxc_host   = $request->dxc;
      
    
        $query              = array();
        $query['dxcHost']   = $request->dxc;
        $query['accept']    =  $request->status;

        $host       = str_replace("/","%2F",$query['dxcHost']);
        $host       = str_replace(":","%3A",$host);
        $url        = Config::get('global_constants.dxsapiurl')."/dxc/accept/".$host.'/'.$query['accept'];                        
        $response   = $client->request("PUT", $url, [
            'headers'   => ['Content-Type'  => 'application/json', 
                            'DXS_API_KEY'   => Config::get('global_constants.dxsapikey')],
            'body'      => json_encode($query)
        ]);
        
        $apiKey     = $response->getBody()->getContents();                       

        echo "success";       
    }
}
