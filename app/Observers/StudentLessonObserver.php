<?php

namespace App\Observers;

use App\Models\StudentLesson;
use Illuminate\Support\Facades\Auth;

class StudentLessonObserver
{
    /**
     * Handle the StudentLesson "creating" event.
     *
     * @param  \App\Models\StudentLesson  $studentLesson
     * @return void
     */
    public function creating(StudentLesson $studentLesson)
    {
        $studentLesson->teacher_id = Auth::id();
    }

    /**
     * Handle the StudentLesson "updating" event.
     *
     * @param  \App\Models\StudentLesson  $studentLesson
     * @return void
     */
    public function updating(StudentLesson $studentLesson)
    {
        $studentLesson->teacher_id = Auth::id();
    }
}
