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
        // Проверяем, заполнены ли поля first_boundary_control, second_boundary_control, session
        if (!is_null($studentLesson->first_boundary_control) &&
            !is_null($studentLesson->second_boundary_control) &&
            !is_null($studentLesson->session))
        {
            $studentLesson->total = $studentLesson->first_boundary_control * 0.3 +
                $studentLesson->second_boundary_control * 0.3 +
                $studentLesson->session * 0.4;
        }
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
        // Проверяем, заполнены ли поля first_boundary_control, second_boundary_control, session
        if (!is_null($studentLesson->first_boundary_control) &&
            !is_null($studentLesson->second_boundary_control) &&
            !is_null($studentLesson->session))
        {
            $studentLesson->total = $studentLesson->first_boundary_control * 0.3 +
                $studentLesson->second_boundary_control * 0.3 +
                $studentLesson->session * 0.4;
        }
    }
}
