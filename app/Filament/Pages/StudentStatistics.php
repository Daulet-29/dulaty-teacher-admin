<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\StudentLesson;
use Illuminate\Support\Facades\DB;

class StudentStatistics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.student-statistics';
    protected static ?string $navigationLabel = 'Диаграмма';
    protected static ?string $pluralModelLabel = 'Диаграмма';
    protected static ?string $modelLabel = 'Диаграмма';
    protected static ?string $navigationGroup = 'Диаграмма';

    public function mount()
    {
        $this->students = DB::table('student_lessons')
            ->select('student_id', DB::raw('AVG(total) as average_score'))
            ->groupBy('student_id')
            ->get();
    }
}
