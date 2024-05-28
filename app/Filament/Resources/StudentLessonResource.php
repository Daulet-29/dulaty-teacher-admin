<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentLessonResource\Pages;
use App\Filament\Resources\StudentLessonResource\RelationManagers;
use App\Models\StudentLesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                    ->relationship('student', 'last_name')
                    ->searchable()
                    ->default(null),
                Forms\Components\Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->default(null),
                Forms\Components\TextInput::make('first_boundary_control')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('second_boundary_control')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('session')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('year_id')
                    ->relationship('year', 'title')
                    ->default(null),
                Forms\Components\Select::make('semester_id')
                    ->relationship('semester', 'title')
                    ->default(null),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lesson.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_boundary_control')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('second_boundary_control')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('session')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
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
        ];
    }
}
