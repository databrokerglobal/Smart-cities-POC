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

class HomeTrending extends Model
{
    protected $table        = 'home_trending';
    protected $primaryKey   = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'title',
        'image',
        'order',
        'logo_url',
        'active' ,
        'offerIdx'
    ];
    /**
     * 
     * Offer binding
     * 
     */
    public function offer(){
    	return $this->belongsTo('App\Models\Offer', 'offerIdx', 'offerIdx')->select('offerIdx','slug','offerTitle','providerIdx');
    }
}
