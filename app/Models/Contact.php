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

class Contact extends Model
{
    //
    protected $primaryKey = 'contactIdx';

    protected $fillable = [
        'firstname', 
        'lastname', 
        'email', 
        'companyName', 
        'regionIdx', 
        'role', 
        'businessName', 
        'content', 
        'communities',
        'isOptCommunication'
    ];
}
