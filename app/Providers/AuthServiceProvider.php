<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentLesson;
use App\Models\User;
use App\Models\Year;
use App\Policies\AdminPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\FacultyPolicy;
use App\Policies\GroupPolicy;
use App\Policies\LessonPolicy;
use App\Policies\SemesterPolicy;
use App\Policies\StudentLessonPolicy;
use App\Policies\StudentPolicy;
use App\Policies\UserPolicy;
use App\Policies\YearPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        AdminPolicy::class,
        Department::class => DepartmentPolicy::class,
        Faculty::class => FacultyPolicy::class,
        Group::class => GroupPolicy::class,
        Lesson::class => LessonPolicy::class,
        Semester::class => SemesterPolicy::class,
        StudentLesson::class => StudentLessonPolicy::class,
        Student::class => StudentPolicy::class,
        Year::class => YearPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
