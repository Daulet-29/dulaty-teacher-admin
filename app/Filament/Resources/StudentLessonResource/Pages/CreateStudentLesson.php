<?php

namespace App\Filament\Resources\StudentLessonResource\Pages;

use App\Filament\Resources\StudentLessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentLesson extends CreateRecord
{
    protected static string $resource = StudentLessonResource::class;
}
