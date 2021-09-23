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

class Complaint extends Model
{
    //
    protected $table        = 'complaints';
    protected $primaryKey   = 'complaintIdx';

    protected $fillable = [
        'userIdx', 
        'complaintTarget', 
        'complaintKind', 
        'complaintContent', 
        'productIdx'
    ];
}
