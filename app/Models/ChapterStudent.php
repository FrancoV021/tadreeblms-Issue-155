<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterStudent extends Model
{
    protected $table = "chapter_students";
    protected $guarded = [];

    public function model()
    {
        return $this->morphTo();
    }

    public function student()
    {
        return $this->belongsTo(Auth\User::class,'user_id');
    }

}
