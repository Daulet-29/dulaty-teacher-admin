<?php

namespace App\Filament\Resources\StudentLessonResource\Pages;

use App\Filament\Resources\StudentLessonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentLessons extends ListRecords
{
    protected static string $resource = StudentLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
