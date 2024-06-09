<?php

namespace App\Policies;

use App\Models\StudentLesson;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentLessonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentLesson  $studentLesson
     * @return mixed
     */
    public function view(User $user, StudentLesson $studentLesson)
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentLesson  $studentLesson
     * @return mixed
     */
    public function update(User $user, StudentLesson $studentLesson)
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentLesson  $studentLesson
     * @return mixed
     */
    public function delete(User $user, StudentLesson $studentLesson)
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentLesson  $studentLesson
     * @return mixed
     */
    public function restore(User $user, StudentLesson $studentLesson)
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentLesson  $studentLesson
     * @return mixed
     */
    public function forceDelete(User $user, StudentLesson $studentLesson)
    {
        return $user->role === 'teacher';
    }
}
