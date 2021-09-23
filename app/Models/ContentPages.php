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

class ContentPages extends Model
{
    protected $table        = 'content_pages';
    protected $primaryKey   = 'contentIdx';
    public $timestamps      = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];  
    /**
     *  
     * Teams model binding
     * 
     */
    public function teams(){
    	return $this->hasMany('App\Models\Teams',  'content_id','contentIdx');
    }

    /**
     *  
     * ContentStories model binding
     * 
     */    
    public function stories(){
    	return $this->hasMany('App\Models\ContentStories',  'content_id','contentIdx');
    }
    
}
