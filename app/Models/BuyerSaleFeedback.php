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

class BuyerSaleFeedback extends Model
{
    protected $table        = 'buyer_sale_feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saleIdx', 
        'isBuyerSatisfiedWithData', 
        'buyerComment'
    ];
}
