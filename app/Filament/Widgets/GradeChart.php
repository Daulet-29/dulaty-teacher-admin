<?php

namespace App\Filament\Widgets;

use App\Models\Group;
use App\Models\Student;
use App\Models\StudentLesson;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class GradeChart extends ChartWidget
{
    protected static ?string $heading = 'Диаграмма';

    public ?string $filter = null;

    protected function getData(): array
    {
        // Если выбран фильтр "Все" (пустая строка), то выбираем все группы
        $groupIds = $this->filter ? [$this->filter] : Group::query()->pluck('id')->toArray();

        // Получаем ID студентов в выбранных группах
        $studentIds = Student::whereIn('group_id', $groupIds)->pluck('id')->toArray();

        // Получаем данные для каждой категории оценок
        $grades = [
            'A'  => [95, 100],
            'A-' => [90, 94],
            'B+' => [85, 89],
            'B'  => [80, 84],
            'B-' => [75, 79],
            'C+' => [70, 74],
            'C'  => [65, 69],
            'D'  => [60, 64],
            'F'  => [0, 59],
        ];

        $data = [];
        $labels = [];

        foreach ($grades as $label => $range) {
            $count = StudentLesson::whereIn('student_id', $studentIds)
                ->whereBetween('total', $range)
                ->count();
            $data[] = $count;
            $labels[] = $label;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Количество студентов',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(255, 205, 86, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Тип диаграммы, можно изменить на другой, например 'bar' или 'line'
    }

    protected function getFilters(): ?array
    {
        // Формируем фильтры для выбора групп
        return ['' => 'Все'] + Group::query()->pluck('title', 'id')->toArray();
    }
}
