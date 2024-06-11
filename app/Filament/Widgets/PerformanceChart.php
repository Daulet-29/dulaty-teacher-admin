<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Lesson;
use App\Models\StudentLesson;
use Illuminate\Support\Facades\Auth;

class PerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'Успеваемость студентов по дисциплине';

    public ?string $filter = null;
    protected static ?string $maxHeight = '500px';

    protected function getData(): array
    {
        // Если выбран фильтр "Все" (пустая строка), то выбираем все группы
        $lessonIds = $this->filter ? [$this->filter] : Lesson::query()->where('user_id', Auth::id())->pluck('id')->toArray();

        // Получаем данные для каждой категории оценок
        $grades = [
            'Успешные' => [50, 100],
            'Неуспешные' => [0, 49],
        ];

        $data = [];
        $labels = [];
        $backgroundColor = [
            'rgba(34, 166, 88, 0.8)', // A
            'rgba(255, 13, 13, 1)', // F
        ];
        $borderColor = [
            'rgba(34, 166, 88, 0.8)', // A
            'rgba(255, 13, 13, 1)', // F
        ];

        $totalStudents = StudentLesson::whereIn('lesson_id', $lessonIds)->get();
        $totalStudentsSum = StudentLesson::whereIn('lesson_id', $lessonIds)->sum('total');
        $countOfStudents = sizeof($totalStudents);
        $average = $totalStudentsSum / $countOfStudents;
        $gradeCounts = [];

        foreach ($grades as $label => $range) {
            $count = StudentLesson::whereIn('lesson_id', $lessonIds)
                ->whereBetween('total', $range)
                ->count();
            $data[] = $count;
            $labels[] = $label;
            $gradeCounts[$label] = $count;
        }

        $description = "Успеваемость студентов: $average. ";
        foreach ($gradeCounts as $grade => $count) {
            $description .= "$grade: $count, ";
        }
        $description = rtrim($description, ', '); // Удаление последней запятой

        return [
            'datasets' => [
                [
                    'label' => 'Количество студентов',
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => $borderColor,
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
            'description' => $description,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Тип диаграммы, можно изменить на другой, например 'bar' или 'line'
    }

    protected function getFilters(): ?array
    {
        // Формируем фильтры для выбора дисциплин
        return ['' => 'Все'] + Lesson::query()->where('user_id', Auth::id())->pluck('title', 'id')->toArray();
    }

    public function getDescription(): ?string
    {
        return $this->getData()['description'];
    }
}