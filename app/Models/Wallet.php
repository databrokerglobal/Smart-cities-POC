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
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    //
    protected $table        = 'wallets';
    protected $primaryKey   = 'walletIdx';

    protected $fillable = [
        'userIdx', 
        'walletAddress'
    ];
}
