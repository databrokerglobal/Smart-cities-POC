<?php
/**
 *  
 * This file is a part of the Databroker.Global package.
 *
 * (c) Databroker.Global
 *
 * 
 * @author    Databroker.Global
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Region;
use App\Models\Community;
use App\Models\Theme;

class Offer extends Model
{
    protected $primaryKey = 'offerIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'offerIdx', 
        'communityIdx', 
        'providerIdx', 
        'offerTitle', 
        'offerImage', 
        'offerDescription', 
        'status', 
        'offerType', 
        'themes', 
        'slug'
    ];    
    /**
     * 
     *  Community Binding
     * 
     */
    public function community(){
    	return $this->hasOne('App\Models\Community', 'communityIdx', 'communityIdx')->withDefault();
    }
    /**
     *  Provider binding
     * 
     * 
     */
    public function provider(){
        return $this->hasOne('App\Models\Provider', 'providerIdx', 'providerIdx');
    }
    /**
     * 
     *  Offersample binding
     * 
     */
    public function offersample(){
        return $this->belongsTo('App\Models\OfferSample', 'offerIdx', 'offerIdx');
    }    
    /**
     * 
     *  OfferProduct
     * 
     */
    public function offerproduct(){
        return $this->belongsTo('App\Models\OfferProduct', 'offerIdx', 'offerIdx');
    }    
    /**
     * 
     * Usecase binding
     * 
     */
    public function usecase(){
    	return $this->belongsTo('App\Models\UseCase', 'offerIdx', 'offerIdx');
    }
    /**
     * Region binding
     * 
     * 
     */
    public function region(){
    	return $this->belongsToMany('App\Models\Region', 'App\Models\OfferCountry', 'offerIdx', 'regionIdx');
    }
    /**
     * Theme binding
     * 
     * 
     */
    public function theme(){
        return $this->belongsToMany('App\Models\Theme', 'App\Models\OfferTheme', 'offerIdx', 'themeIdx');
    }

    /**
     *  New in the community bindings
     */
    public function newInCommunity(){
        return $this->hasOne('App\Models\CommunityNewOffer', 'offerIdx', 'offerIdx');
    }

    /**
     * Search offer filter
     * 
     * 
     */
    protected static function filter_offer($param){
        if($param->region){
            $dataoffer = Offer::with(['region', 'provider'])->select('offers.*', 'regions.*', 'companies.*', 'users.*')
                        ->leftjoin('offerCountries', 'offerCountries.offerIdx', '=',  'offers.offerIdx')
                        ->leftjoin('regions', 'regions.regionIdx', '=',  'offerCountries.regionIdx');
        }else{
            $dataoffer = Offer::with(['region', 'provider'])->select('offers.*', 'companies.*', 'users.*'); 
        }   

        $dataoffer->leftjoin('offerThemes', 'offerThemes.offerIdx', '=',  'offers.offerIdx')
                  ->leftjoin('themes', 'themes.themeIdx', '=',  'offerThemes.themeIdx')                    
                  ->leftjoin('communities', 'offers.communityIdx', '=',  'communities.communityIdx')
                  ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                  ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                  ->join('companies', 'companies.companyIdx', '=', 'users.companyIdx');

        if($param->community && $param->community != 'all'){            
            $dataoffer->where('communities.communityIdx', $param->community);
        }   

        if($param->theme && $param->theme != 'all' ){
            $dataoffer->where('themes.themeIdx', $param->theme);
        }

        if($param->region){
            $dataoffer->where('regions.regionIdx', $param->region);
        }   

        $dataoffer->where('offers.status', 1);
        $total_count = $dataoffer->distinct('offers')->get()->count();

        if( !isset($param->loadmore) || $param->loadmore == "false" ){
            if( $param->community == 'all' ){
                $result = $dataoffer->offset(0)->orderby('offers.offerIdx', 'DESC')->limit(12)->distinct('offers')->get();                
            }else{
                $result = $dataoffer->offset(0)->orderby('offers.offerIdx', 'DESC')->limit(11)->distinct('offers')->get();                
            }            
        }else{
            $result = $dataoffer->offset($param->loadmore)->orderby('offers.offerIdx', 'DESC')->limit(12)->distinct('offers')->get();
        }    
        
        $res = array( 'total_count' => $total_count, 'offers' => $result );

        return $res;                    
    }
    /**
     *  Get product list
     * 
     * 
     */
    protected static function getProduct($user_id){
        $dataproduct = Offer::with(['region', 'offerproduct' => function($query){
                $query->select( DB::raw('count(*) as product_count, offerIdx'))->groupby('offerIdx');
            }])                        
            ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
            ->where('providers.userIdx', '=', $user_id)
            ->orderby('offers.offerIdx', 'DESC')
            ->get();

        return $dataproduct;
    }    

}
