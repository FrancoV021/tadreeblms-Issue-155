<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenuItem extends Model
{
    // Specify the table if it doesn't follow Laravel naming convention
    protected $table = 'admin_menu_items';

    // Mass-assignable fields
    protected $fillable = [
        'label',      // existing label field
        'label_ar',   // new Arabic label
        'link',       // URL or route
        'parent_id',  // parent menu item if nested
        'sort_order', // ordering
        'icon',       // optional
    ];
}
