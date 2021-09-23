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

class HomeFeaturedData extends Model
{
    protected $table        = 'home_featured_data';
    protected $primaryKey   = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'featured_data_title',
        'featured_data_content',
        'providerIdx',
        'image',
        'logo',
        'read_more_url',
        'active',
        'slug',
        'offerIdx'
    ];
}
