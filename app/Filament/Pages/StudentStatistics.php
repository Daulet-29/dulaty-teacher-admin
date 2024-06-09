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

    public $students;

    public function mount()
    {
        // Извлечение данных о студентах и их оценках
        $this->students = StudentLesson::with('student')
            ->select('student_id', DB::raw('AVG(total) as average_score'))
            ->groupBy('student_id')
            ->get()
            ->map(function ($studentLesson) {
                return [
                    'name' => $studentLesson->student->name,
                    'average_score' => $studentLesson->average_score,
                ];
            });
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view(static::$view, [
            'students' => $this->students,
        ])->layout('filament::components.layouts.app'); // Убедитесь, что макет существует
    }
}
