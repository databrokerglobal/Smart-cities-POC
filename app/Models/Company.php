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

class Company extends Model
{
    protected $primaryKey = 'companyIdx';
    
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
        'slug'
    ];

    /**
     *   
     * User model binding
     * 
     */
    public function user(){
    	return $this->hasOne('App\User', 'userIdx', 'userIdx');
    }
    /**
     *  
     * Region model binding
     * 
     */
    public function region(){
    	return $this->hasOne('App\Models\Region', 'regionIdx', 'regionIdx');
    }
}
