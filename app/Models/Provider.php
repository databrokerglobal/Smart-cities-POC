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

class Provider extends Model
{
    protected $primaryKey = 'providerIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userIdx', 
        'regionIdx', 
        'companyName', 
        'companyURL', 
        'companyLogo', 
        'companyVAT', 
        'status'
    ];
    /**
     * 
     *  User binding
     * 
     */
    public function user(){
    	return $this->hasOne('App\User', 'userIdx', 'userIdx');
    }
    /**
     * 
     * Region binding
     * 
     */
    public function region(){
    	return $this->hasOne('App\Models\Region', 'regionIdx', 'regionIdx')->withDefault();
    }
    
}
