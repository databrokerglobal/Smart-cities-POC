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

class BillingInfo extends Model
{
    //
    protected $table        = 'billingInfo';
    protected $primaryKey   = 'billingInfoIdx';

    protected $fillable = [
        'userIdx', 
        'firstname', 
        'lastname', 
        'email', 
        'companyName', 
        'companyVAT', 
        'address', 
        'city', 
        'postal_code', 
        'state', 
        'regionIdx'
    ];
}
