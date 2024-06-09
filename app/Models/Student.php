<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'students';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
     protected $fillable = [
         'first_name', 'parent_name', 'last_name', 'date_of_birth', 'email', 'phone', 'enrollment_year_id', 'department_id',
         'faculty_id', 'group_id'
     ];

    // protected $hidden = [];

    public function teacher(): BelongsTo {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function semester(): BelongsTo {
        return $this->belongsTo(Semester::class);
    }

    public function faculty(): BelongsTo {
        return $this->belongsTo(Faculty::class);
    }

    public function group(): BelongsTo {
        return $this->belongsTo(Group::class);
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function enrollment_year(): BelongsTo {
        return $this->belongsTo(Year::class, 'enrollment_year_id');
    }
    public function getFullAttribute(): string
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->parent_name;
    }

}
