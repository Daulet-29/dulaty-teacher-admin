<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentLesson extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'student_lessons';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
     protected $fillable = ['student_id', 'lesson_id', 'first_boundary_control', 'second_boundary_control',
         'session', 'year_id', 'semester_id', 'teacher_id', 'total',
     ];

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function semester(): BelongsTo {
        return $this->belongsTo(Semester::class);
    }

    public function getCarBrandTitleAttribute()
    {
        return $this->carModel->carBrand->title ?? null;
    }

    public function lesson(): BelongsTo {
        return $this->belongsTo(Lesson::class);
    }

    public function year(): BelongsTo {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function teacher(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teacher2(): BelongsTo {
        $teacher = $this->belongsTo(User::class, 'user_id');
        $teacher->full = $teacher->name . ' - ' . $teacher->email;
        return $teacher;
    }

    public function getFullAttribute($value)
    {
        return $this->name . '-' . $this->email;
    }
}
