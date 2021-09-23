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

class HelpTopic extends Model
{
    protected $table        = 'helpTopics';
    protected $primaryKey   = 'helpTopicIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page', 
        'title', 
        'description', 
        'meta_title', 
        'meta_description', 
        'active'
    ];
}
