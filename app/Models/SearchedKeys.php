<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchedKeys extends Model
{
    protected $table = 'searched_keys';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'search_key',  'searched_by', 'created_at','updated_at'
    ];
}
