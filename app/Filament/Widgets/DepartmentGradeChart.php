<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\StudentLesson;
use Filament\Widgets\ChartWidget;

class DepartmentGradeChart extends ChartWidget
{
    protected static ?string $heading = 'Оценка по кафедре';

    public ?string $filter = null;

    protected function getData(): array
    {
        // Если выбран фильтр "Все" (пустая строка), то выбираем все группы
        $departmentIds = $this->filter ? [$this->filter] : Department::query()->pluck('id')->toArray();

        // Получаем ID студентов в выбранных группах
        $studentIds = Student::whereIn('department_id', $departmentIds)->pluck('id')->toArray();

        // Получаем данные для каждой категории оценок
        $grades = [
            'A'  => [95, 100],
            'A-' => [90, 94],
            'B+' => [85, 89],
            'B'  => [80, 84],
            'B-' => [75, 79],
            'C+' => [70, 74],
            'C'  => [65, 69],
            'C-' => [60, 64],
            'D+' => [55, 59],
            'D'  => [50, 54],
            'F'  => [0, 49],
        ];

        $data = [];
        $labels = [];
        $backgroundColor = [
            'rgba(75, 192, 192, 0.2)', // A
            'rgba(54, 162, 235, 0.2)', // A-
            'rgba(255, 206, 86, 0.2)', // B+
            'rgba(75, 192, 192, 0.2)', // B
            'rgba(153, 102, 255, 0.2)', // B-
            'rgba(255, 159, 64, 0.2)', // C+
            'rgba(255, 99, 132, 0.2)', // C
            'rgba(201, 203, 207, 0.2)', // C-
            'rgba(255, 205, 86, 0.2)', // D+
            'rgba(75, 192, 192, 0.2)', // D
            'rgba(255, 99, 132, 0.2)', // F
        ];
        $borderColor = [
            'rgba(75, 192, 192, 1)', // A
            'rgba(54, 162, 235, 1)', // A-
            'rgba(255, 206, 86, 1)', // B+
            'rgba(75, 192, 192, 1)', // B
            'rgba(153, 102, 255, 1)', // B-
            'rgba(255, 159, 64, 1)', // C+
            'rgba(255, 99, 132, 1)', // C
            'rgba(201, 203, 207, 1)', // C-
            'rgba(255, 205, 86, 1)', // D+
            'rgba(75, 192, 192, 1)', // D
            'rgba(255, 99, 132, 1)', // F
        ];

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
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => $borderColor,
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getFilters(): ?array
    {
        // Формируем фильтры для выбора групп
        return ['' => 'Все'] + Department::query()->pluck('title', 'id')->toArray();
    }
}
