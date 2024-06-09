<?php

namespace App\Filament\Resources\StudentLessonResource\Pages;

use App\Filament\Resources\StudentLessonResource;
use Filament\Resources\Pages\Page;

class StudentLessonStatistics extends Page
{
    protected static string $resource = StudentLessonResource::class;

    protected static string $view = 'filament.resources.student-lesson-resource.pages.student-lesson-statistics';

    public function mount()
    {
        $this->students = DB::table('student_lessons')
            ->select('student_id', DB::raw('AVG(total) as average_score'))
            ->groupBy('student_id')
            ->get();
    }
}
