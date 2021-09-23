<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityDiscover extends Model
{
    protected $table = 'community_discover';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 
        'communityIdx',
        'offerIdx',
        'discription',
        'order'
    ];

    /**
     * Get the community that owns the discover data.
     */
    public function community()
    {
        return $this->belongsTo('App\Models\Community', 'communityIdx', 'communityIdx');
    }

    /**
     * Get the offer that links the discover data.
     */
    public function offer()
    {
        return $this->belongsTo('App\Models\Offer', 'offerIdx', 'offerIdx');
    }
}
