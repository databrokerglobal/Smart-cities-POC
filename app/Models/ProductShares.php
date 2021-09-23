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

class ProductShares extends Model
{
    protected $table        = 'productshares';
    protected $primaryKey   = 'shareIdx';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'productIdx', 
        'orgUserIdx',
        'isActive'
    ];
    /**
     * 
     * SharingOrganisation binding
     * 
     */
    public function sharingorganisations(){
        return $this->hasMany('App\Models\SharingOrganisation', 'orgIdx', 'orgIdx');
    }
}
