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

class Gallery extends Model
{
    protected $table        = 'gallery';
    protected $primaryKey   = 'id';
    public $timestamps      = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category', 
        'content', 
        'subcontent', 
        'sequence', 
        'path', 
        'thumb',
        'updated_at',
        'img_title',
        'img_tooltip'
    ];

    /**
     *   Gallery table binding with community
     */
    public function community()
    {
        return $this->belongsTo('App\Models\Community', 'content', 'communityIdx')->withDefault();
    }
    
}
