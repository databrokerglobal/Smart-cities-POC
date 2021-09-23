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

class OrgUsers extends Model
{
    protected $table        = 'orgusers';
    protected $primaryKey   = 'orgUserIdx';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orgIdx', 
        'orgUserEmail', 
        'isActive',
        'isUserRegistered',
        'isActive'
    ];
}
