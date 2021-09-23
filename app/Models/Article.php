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

class Article extends Model
{
    protected $table        = 'articles';
    protected $primaryKey   = 'articleIdx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'articleIdx',
        'communityIdx',
        'articleTitle',
        'articleContent',
        'category',
        'image',
        'meta_title',
        'meta_desc',
        'author',
        'link',
        'published',
        'active',
        'isUseCase',
        'slug'
    ];

    protected $casts = [
        'published' => 'date',
    ];
    /**
     *   Community table binding with Article
     * 
     * 
     */
    public function community(){
    	return $this->hasOne('App\Models\Community', 'communityIdx', 'communityIdx')->withDefault();
    }

}
