<?php

namespace App\Filament\Resources\StudentLessonResource\Pages;

use App\Filament\Resources\StudentLessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentLesson extends EditRecord
{
    protected static string $resource = StudentLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
