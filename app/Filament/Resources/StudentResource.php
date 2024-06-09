<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Department;
use App\Models\Group;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Студент';
    protected static ?string $pluralModelLabel = 'Студенты';
    protected static ?string $modelLabel = 'Студент';
    protected static ?string $navigationGroup = 'Администрирование';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label('Имя')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('parent_name')
                    ->label('Отчество')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('last_name')->label('Фамилия')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('date_of_birth')
                    ->label('День рождения')
//                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->label('Эл.почта')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->label('Телефон')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('enrollment_year_id')
                    ->relationship('enrollment_year', 'title')
                    ->label('Год поступления')
                    ->default(null),
                Forms\Components\Select::make('faculty_id')
                    ->relationship('faculty', 'title')
                    ->label('Факультет')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('department_id', null))
                    ->default(null),
                Forms\Components\Select::make('department_id')
                    ->options(fn (Get $get): Collection => Department::query()
                        ->where('faculty_id', $get('faculty_id'))
                        ->pluck('title', 'id'))
                    ->label('Кафедра')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->default(null),
                Forms\Components\Select::make('group_id')
                    ->options(fn (Get $get): Collection => Group::query()
                        ->where('department_id', $get('department_id'))
                        ->pluck('title', 'id'))
                    ->label('Группа')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->default(null),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_name')->label('Отчество')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Кафедра')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('День рождения')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Эл.почта')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                Tables\Columns\TextColumn::make('enrollment_year.title')
                    ->label('Год поступления')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.title')
                    ->label('Группа')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.title')
                    ->label('Кафедра')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('faculty.title')
                    ->label('Факультет')
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
