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

class Bid extends Model
{
    protected $table        = 'bids';
    protected $primaryKey   = 'bidIdx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bidIdx', 'userIdx', 'productIdx','actualProductPrice','productAccessDays','bidPrice', 'bidMessage', 'bidResponse', 'bidStatus'
    ];
}
