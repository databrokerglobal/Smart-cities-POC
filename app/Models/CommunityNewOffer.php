<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityNewOffer extends Model
{
    protected $table = 'community_new_offers';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'communityIdx', 
        'offerIdx',
        'order'
    ];

    /**
     * Get the community that owns the new data.
     */
    public function community()
    {
        return $this->belongsTo('App\Models\Community', 'communityIdx', 'communityIdx');
    }

    /**
     * Get the offer that links the new data.
     */
    public function offer()
    {
        return $this->belongsTo('App\Models\Offer', 'offerIdx', 'offerIdx');
    }
}
