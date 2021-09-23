<?php
/**
 *  
 *  Sitemap Controller
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

use App\Models\Offer;
use App\Models\Community;
use App\Models\Company;
use App\Models\Theme;
use App\Models\Region;
use App\Models\HelpTopic;

use App\Http\Requests;
use DB;

class SitemapController extends Controller
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
     *  Main page of the sitemap
     * 
     */
    public function index()
    {
        $offers = Offer::with(['region', 'theme', 'provider', 'community', 'usecase'])
                        ->select('offers.*','offers.slug as offer_slug','providers.*','companies.*','companies.slug as company_slug','communities.slug as community_slug')
                        ->join('communities', 'offers.communityIdx', '=',  'communities.communityIdx')
                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                        ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx')
                        ->orderby('offers.created_at', 'desc')
                        ->get(['offers.*', 'offers.updated_at as updatedAt', 'providers.*', 'users.*']);
    
        $themes         = Theme::join('communities', 'themes.communityIdx', '=', 'communities.communityIdx')->get();
        $regions        = Region::get();
        $communities    = Community::where('status','=',1)->get();
        $companies      = Company::orderby('created_at', 'desc')->get();
        $selling_topics = HelpTopic::where('page', 'selling')->where('active', 1)->get();
        $buying_topics  = HelpTopic::where('page', 'buying')->where('active', 1)->get();
        $contents =  DB::table('contents')->select('contents.*')->where('isActive',1)->orderBy('sortOrder','ASC')->get();   
        $data           = array('offers', 'communities', 'companies', 'themes', 'regions', 'selling_topics', 'buying_topics','contents');  
         
      	return response()->view('sitemap.index', compact($data))->header('Content-Type', 'text/xml');
    }
}