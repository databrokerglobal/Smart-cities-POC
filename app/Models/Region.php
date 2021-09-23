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

class Region extends Model
{
    protected $primaryKey = 'regionIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regionName', 
        'regionCheck', 
        'regionType', 
        'slug'
    ];
 	/**
     * 
     * Offer binding
     * 
     */
 	 public function offer(){
    	return $this->belongsToMany('App\Models\Offer', 'App\Models\OfferCountry', 'regionIdx', 'offerIdx');
    }   
}
