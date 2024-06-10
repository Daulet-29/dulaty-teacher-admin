<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Lesson;
use App\Models\StudentLesson;
use Illuminate\Support\Facades\Auth;

class LessonChart extends ChartWidget
{
    protected static ?string $heading = 'Оценка по дисциплине';

    public ?string $filter = null;

    protected function getData(): array
    {
        // Если выбран фильтр "Все" (пустая строка), то выбираем все группы
        $lessonIds = $this->filter ? [$this->filter] : Lesson::query()->where('user_id', Auth::id())->pluck('id')->toArray();

        // Получаем ID студентов в выбранных группах
        // $studentIds = Student::whereIn('group_id', $groupIds)->pluck('id')->toArray();

        // Получаем данные для каждой категории оценок
        $grades = [
            'A(95-100)' => [95, 100],
            'A-(90-94)' => [90, 94],
            'B+(85-89)' => [85, 89],
            'B(80-84)' => [80, 84],
            'B-(75-79)' => [75, 79],
            'C+(70-74)' => [70, 74],
            'C(65-69)' => [65, 69],
            'C-(60-64)' => [60, 64],
            'D+(55-59)' => [55, 59],
            'D(50-54)' => [50, 54],
            'F(0-49)' => [0, 49],
        ];

        $data = [];
        $labels = [];
        $backgroundColor = [
            'rgba(34, 166, 88, 0.8)', // A
            'rgba(34, 227, 89, 0.48)', // A-
            'rgba(34, 80, 227, 0.83)', // B+
            'rgba(34, 80, 227, 0.62)', // B
            'rgba(34, 80, 227, 0.46)', // B-
            'rgba(255, 158, 13, 1)', // C+
            'rgba(255, 99, 132, 1)', // C
            'rgba(255, 158, 13, 0.64)', // C-
            'rgba(255, 13, 136, 0.54)', // D+
            'rgba(255, 13, 136, 1)', // D
            'rgba(255, 13, 13, 1)', // F
        ];
        $borderColor = [
            'rgba(34, 166, 88, 0.8)', // A
            'rgba(34, 227, 89, 0.48)', // A-
            'rgba(34, 80, 227, 0.83)', // B+
            'rgba(34, 80, 227, 0.62)', // B
            'rgba(34, 80, 227, 0.46)', // B-
            'rgba(255, 158, 13, 1)', // C+
            'rgba(255, 99, 132, 1)', // C
            'rgba(255, 158, 13, 0.64)', // C-
            'rgba(255, 13, 136, 0.54)', // D+
            'rgba(255, 13, 136, 1)', // D
            'rgba(255, 13, 13, 1)', // F
        ];

        foreach ($grades as $label => $range) {
            $count = StudentLesson::whereIn('lesson_id', $lessonIds)
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
        return 'doughnut'; // Тип диаграммы, можно изменить на другой, например 'bar' или 'line'
    }

    protected function getFilters(): ?array
    {

        // Формируем фильтры для выбора групп
        return ['' => 'Все'] + Lesson::query()->where('user_id', Auth::id())->pluck('title', 'id')->toArray();
    }
    public function getDescription(): ?string
    {
        return 'The number of blog posts published per month.';
    }
}