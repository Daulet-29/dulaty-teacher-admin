<?php

namespace App\Providers;

use App\Models\StudentLesson;
use App\Observers\StudentLessonObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        StudentLesson::observe(StudentLessonObserver::class);
    }
}
