<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Position;

class EmployeeProfile extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','department'
    ];

    /**
    * Get the teacher profile that owns the user.
    */
    public function employee(){
        return $this->belongsTo(User::class);
    }

    public function department_details(){
        return $this->belongsTo(Department::class,'department');
    }

    public function position_details(){
        return $this->belongsTo(Position::class,'position');
    }


}
