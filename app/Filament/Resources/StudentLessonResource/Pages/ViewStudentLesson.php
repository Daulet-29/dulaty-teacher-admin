<?php

namespace App\Filament\Resources\StudentLessonResource\Pages;

use App\Filament\Resources\StudentLessonResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentLesson extends ViewRecord
{
    protected static string $resource = StudentLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
