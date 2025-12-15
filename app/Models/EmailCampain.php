<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampain extends Model
{

    protected $table = 'email_campain';
    protected $fillable = [
        'campain_subject', 
        'content',
        'link'
    ];

    
}
