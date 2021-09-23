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

class OfferProduct extends Model
{
    protected $table        = 'offerProducts';
    protected $primaryKey   = 'productIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'productIdx', 
        'offerIdx', 
        'productType', 
        'productTitle', 
        'productMoreInfo', 
        'productAccessDays', 
        'productBidType', 
        'productPrice', 
        'dxc', 
        'did', 
        'productInstruction', 
        'productStatus', 
        'productLicenseUrl', 
        'productUrl', 
        'uniqueProductIdx',
        'offerType'
    ];    
    /**
     * 
     * Offer binding
     * 
     */
    public function offer(){
        return $this->hasMany('App\Models\Offer', 'offerIdx', 'offerIdx');
    }
    /**
     * 
     * Region binding
     * 
     */
    public function region(){
    	return $this->belongsToMany('App\Models\Region', 'App\Models\RegionProduct', 'productIdx', 'regionIdx');
    }

    public function productpricemappings(){
        return $this->belongsToMany('App\Models\OfferProduct','App\Models\ProductPriceMap','productIdx','ppmIdx');
    }
}
