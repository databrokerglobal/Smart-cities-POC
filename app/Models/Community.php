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

class Community extends Model
{
    protected $primaryKey = 'communityIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'communityName', 
        'communityDescription',
        'image',
        'status',
        'description',
        'slug', 
        'overview',
        'meta_title',
        'meta_desc',
        'sort'
    ];
    
}
