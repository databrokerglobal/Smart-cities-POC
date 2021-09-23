<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPriceMap extends Model
{
    protected $table = 'product_price_mapping';

    protected $primaryKey = 'ppmIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ppmIdx', 'productIdx', 'productPrice', 'productAccessDays'
    ];    

   /*  public function offer(){
        return $this->hasMany('App\Models\Offer', 'offerIdx', 'offerIdx');
    }

    public function region(){
    	return $this->belongsToMany('App\Models\Region', 'App\Models\RegionProduct', 'productIdx', 'regionIdx');
    } */
}
