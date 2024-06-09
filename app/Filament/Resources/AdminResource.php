<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Админы';
    protected static ?string $pluralModelLabel = 'Админы';
    protected static ?string $modelLabel = 'Админ';
    protected static ?string $navigationGroup = 'Администрирование';
    protected static ?int $navigationSort = 2;

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
                    ->options(['admin'])
                    ->default('admin')
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
                Tables\Columns\TextColumn::make('full')
                    ->label('Имя - email')
                    ->sortable()
                    ->searchable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'view' => Pages\ViewAdmin::route('/{record}'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (Auth::user()->role == 'teacher') {
            return parent::getEloquentQuery()->where('role', 'else');
        } else {
            return parent::getEloquentQuery()->where('role', 'admin');
        }
    }
}
