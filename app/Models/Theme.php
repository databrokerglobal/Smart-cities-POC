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

class Theme extends Model
{
    protected $primaryKey = 'themeIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'themeIdx', 
        'communityIdx', 
        'themeName', 
        'themeText'
    ];
    /**
     * Offer binding
     * 
     * 
     */ 	
 	public function offer(){
    	return $this->belongsToMany('App\Models\Offer', 'App\Models\OfferTheme', 'themeIdx', 'offerIdx');
    } 
    /**
     * 
     * Community binding
     * 
     */  
 	public function communities(){
    	return $this->belongsTo('App\Models\Community','communityIdx','communityIdx');
    }   
    /**
     * 
     * Get theme by community
     * 
     */
    protected static function get_theme_by_community($community){
    	$themes = Theme::select('themes.*', 'communities.communityName') 
                        ->join('communities', 'communities.communityIdx', '=',  'themes.communityIdx')
                        ->where('communities.slug', $community)->get();                        

		return $themes;                        
    }
}
