<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\DepartmentsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\FacultiesRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\GroupsRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Преподаватели';
    protected static ?string $pluralModelLabel = 'Преподаватели';
    protected static ?string $modelLabel = 'Преподаватель';
    protected static ?string $navigationGroup = 'Администрирование';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        if (Auth::user()->role == 'teacher') {
            return User::query()->where('role', 'teacher');
//            return parent::getEloquentQuery()->where('role', 'teacher');
        } else {
            return User::query()->where('role', 'teacher');
//            return parent::getEloquentQuery()->where('role', 'teacher');
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Эл.почта')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label('Дата проверки почты'),
                Forms\Components\TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label('Роль')
                    ->options(['teacher' => 'teacher'])
                    ->default('teacher')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Эл.почта')
                    ->searchable(),
//                Tables\Columns\TextColumn::make('full')
//                    ->label('Имя - email')
//                    ->sortable()
//                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Дата проверки почты')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')->label('Роль'),
                Tables\Columns\TextColumn::make('created_at')->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('name')
            ->filters([
                //                TextConstraint::make('name')->label('Имя'),
//                QueryBuilder::make()
//                    ->constraints([
//                        TextConstraint::make('name')->label('Имя'),
////                        BooleanConstraint::make('is_visible'),
////                        NumberConstraint::make('stock'),
////                        SelectConstraint::make('status')
////                            ->options([
////                                'draft' => 'Draft',
////                                'reviewing' => 'Reviewing',
////                                'published' => 'Published',
////                            ])
////                            ->multiple(),
////                        DateConstraint::make('created_at'),
////                        RelationshipConstraint::make('categories')
////                            ->multiple()
////                            ->selectable(
////                                IsRelatedToOperator::make()
////                                    ->titleAttribute('name')
////                                    ->searchable()
////                                    ->multiple(),
////                            ),
////                        NumberConstraint::make('reviewsRating')
////                            ->relationship('reviews', 'rating')
////                            ->integer(),
//                    ])
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
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
            GroupsRelationManager::class,
            DepartmentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

}
