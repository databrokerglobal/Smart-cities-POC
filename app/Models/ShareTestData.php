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

class ShareTestData extends Model
{
    protected $table        = 'testdata_shares';
    protected $primaryKey   = 'testshareIdx';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'testshareIdx', 
        'userEmail', 
        'isRegistered',
        'productIdx',
        'token'
    ];
}
