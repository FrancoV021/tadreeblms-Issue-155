<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentAccount extends Model
{
    use SoftDeletes;
    protected $table = 'assessment_accounts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assignment_id', 'first_name', 'last_name', 'email', 'phone', 'code','trainees_id'
    ];
}
