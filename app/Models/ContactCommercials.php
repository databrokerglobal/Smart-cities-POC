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

class ContactCommercials extends Model
{
    protected $table        = 'contactCommercials';    
    protected $primaryKey   = 'Idx';

    protected $fillable = [
        'full_name', 
        'email', 
        'companyName', 
        'regionIdx', 
        'contact_number', 
        'bank_account_number', 
        'amount_to_be_redeemed', 
        'iban_number',
        'bank_name',
        'branch_code',
        'company_reg_no',
        'company_tax_no'
    ];
}
