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

class SiteTheme extends Model
{
    protected $table = 'site_themes';
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'header_color', 
        'footer_color',
        'primary_button_color',
        'secondary_button_color',
        'body_text_size',
        'body_font_family',
        'status',
        'updated_by',
        'search_button_color'
    ];

    
}
