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

class Purchase extends Model
{
    protected $table        = 'purchases';
    protected $primaryKey   = 'purchaseIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'productIdx', 
        'userIdx', 
        'bidIdx', 
        'from', 
        'to', 
        'transactionId',
        'amount',
        'productAccessDays'
    ];
    /**
     * 
     * OfferProduct binding
     * 
     */
    public function offerproduct(){
    	return $this->belongsTo('App\Models\OfferProduct',  'productIdx', 'productIdx')->select(['offerIdx','productIdx']);
    }
}
