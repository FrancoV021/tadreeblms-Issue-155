<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'token'];
    public $timestamps = false;
    protected $primaryKey = 'email'; // Specify primary key
    public $incrementing = false;    // Since email is not an integer
    protected $keyType = 'string';   // Specify the key type as string
}
