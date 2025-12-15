<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampainUser extends Model
{

    protected $table = 'email_campain_users';
    protected $fillable = [
        'campain_id', 
        'email',
        'status',
        'sent_at'
    ];

    
}
