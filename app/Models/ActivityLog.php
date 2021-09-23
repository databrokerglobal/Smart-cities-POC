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

class ActivityLog extends Model
{
    protected $table        = 'user_activity_log';
    protected $primaryKey   = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action_type', 
        'action_by', 
        'action_date', 
        'action_detail'
    ];
    /**
     *   User table binding with activity log
     * 
     * 
     */
    public function user(){
    	return $this->belongsTo('App\User','action_by','userIdx')->withDefault();
    }  
}
