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

class DxcVersions extends Model
{
    protected $table        = 'dxc_versions';
    protected $primaryKey   = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version', 
        'plotform', 
        'whats_new', 
        'instruction_path',
        'setup_file_path',
        'isActive'
    ];
}
