<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentLessonResource\Pages;
use App\Filament\Resources\StudentLessonResource\RelationManagers;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\StudentLesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class StudentLessonResource extends Resource
{
    protected static ?string $model = StudentLesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Оценка студента';
    protected static ?string $pluralModelLabel = 'Оценка студентов';
    protected static ?string $modelLabel = 'Оценка студента';
    protected static ?string $navigationGroup = 'Оценка';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('ФИО Студента')
                    ->options(function () {
                        return Student::all()->pluck('full', 'id');
                    })->searchable()
                    ->preload()
                    ->default(null),
                Forms\Components\Select::make('lesson_id')
                    ->searchable()
                    ->preload()
                    ->label('Дисциплина')
                    ->options(function () {
                        return Lesson::query()->where('user_id', Auth::id())->pluck('title', "id");
                    })
                    //                    ->relationship('lesson', 'title')
                    ->default(null),
                Forms\Components\TextInput::make('first_boundary_control')
                    ->label('Первая рубежка')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('second_boundary_control')
                    ->label('Вторая рубежка')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('session')
                    ->label('Сессия')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('year_id')
                    ->label('Год обучения')
                    ->relationship('year', 'title')
                    ->default(null),
                Forms\Components\Select::make('semester_id')
                    ->label('Семестр')
                    ->relationship('semester', 'title')
                    ->default(null),
                //                Forms\Components\Select::make('teacher_id')
//                    ->label('Преподаватель')
//                    ->relationship('teacher', 'name')
//                    ->default(null),
//                Forms\Components\TextInput::make('total')
//                    ->label('Итог')
//                    ->numeric()
//                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.full')
                    ->label('ФИО Студента')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lesson.title')
                    ->label('Дисциплина')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_boundary_control')
                    ->label('Первая рубежка')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('second_boundary_control')
                    ->label('Вторая рубежка')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('session')
                    ->label('Сессия')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year.title')
                    ->label('Год обучения')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.title')
                    ->label('Семестр')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Преподаватель')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Итог')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentLessons::route('/'),
            'create' => Pages\CreateStudentLesson::route('/create'),
            'view' => Pages\ViewStudentLesson::route('/{record}'),
            'edit' => Pages\EditStudentLesson::route('/{record}/edit'),
            'statistics' => Pages\StudentLessonStatistics::route('/statistics'),
        ];
    }
}
