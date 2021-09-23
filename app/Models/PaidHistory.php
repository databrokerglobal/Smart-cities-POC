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

class PaidHistory extends Model
{
    protected $table        = 'paidHistories';
    protected $primaryKey   = 'paidHistoryIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userIdx', 
        'productIdx', 
        'transactionId', 
        'paymentMethodIdx', 
        'paidAmount', 
        'paidCurrency', 
        'cardIdx', 
        'cardType', 
        'cardCountry', 
        'expMonth', 
        'expYear', 
        'cvcCheck', 
        'last4', 
        'fingerprint', 
        'funding', 
        'installments', 
        'network', 
        'wallet', 
        'amountRefunded', 
        'application', 
        'applicationFee', 
        'applicationFeeAmount', 
        'balanceTransaction', 
        'captured', 
        'customer', 
        'description', 
        'destination', 
        'dispute', 
        'disputed', 
        'failureCode', 
        'failureMessage', 
        'invoice', 
        'liveMode', 
        'order', 
        'paid', 
        'paymentIntent', 
        'paymentMethod', 
        'receiptEmail', 
        'receiptNumber', 
        'receiptURL', 
        'refunded', 
        'review', 
        'shipping', 
        'status', 
        'errorCode', 
        'errorDocURL', 
        'errorMessage', 
        'errorParam', 
        'errorType'
    ];
}
