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

class UseCase extends Model
{
    protected $table        = 'useCases';
    protected $primaryKey   = 'useCaseIdx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'offerIdx', 
        'useCaseDescription', 
        'useCaseContent'
    ];
    /**
     * 
     * Offer binding
     * 
     */
    public function offer(){
    	return $this->hasOne('App\Models\Offer');
    }
}
