<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalUserSentNotiofication extends Model
{

    protected $table = 'external_user_notification';
    protected $fillable = [
        'email', 
    ];

    
}
