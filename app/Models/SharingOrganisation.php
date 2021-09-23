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

class SharingOrganisation extends Model
{
    protected $table        = 'sharingorganisations';
    protected $primaryKey   = 'orgIdx';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orgIdx', 
        'orgName', 
        'providerIdx',
        'isActive'
    ];
}
