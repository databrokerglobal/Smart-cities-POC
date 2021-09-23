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

class Teams extends Model
{
    protected $table        = 'teams';
    protected $primaryKey   = 'teamIdx';
    public $timestamps      = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teamIdx',
        'name',
        'position',
        'content_id',
        'pic',
        'status'
       
    ];

    
}
