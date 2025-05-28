<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtraResource\Pages;
use App\Models\Extra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExtraResource extends Resource
{
    protected static ?string $model = Extra::class;

    // 3. Меню «Налаштування»
    protected static ?string $navigationGroup = 'Налаштування';

    // 4. Іконка для «Опцій автомобіля»
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    // 5. Лейбли моделі
    public static function getModelLabel(): string
    {
        return 'Опція авто';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Опції авто';
    }

    public static function getNavigationLabel(): string
    {
        return 'Опції авто';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва')           // 1. переклад
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('category')
                    ->label('Категорія')       // 1. переклад
                    ->maxLength(255),

                Forms\Components\TextInput::make('price')
                    ->label('Ціна')            // 1. переклад
                    ->required()
                    ->numeric()
                    ->prefix('₴'),             // если валюта — гривня

                Forms\Components\Toggle::make('price_per_day')
                    ->label('Ціна за день')    // 1. переклад
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Опис')            // 1. переклад
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Категорія')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Ціна')
                    ->money('UAH')            // при необходимости
                    ->sortable(),

                Tables\Columns\IconColumn::make('price_per_day')
                    ->label('Ціна за день')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),    // «Редагувати»
                Tables\Actions\DeleteAction::make(),  // «Видалити»
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
            // Файли Pages/ManageExtras.php:
            'index' => Pages\ManageExtras::route('/'),
        ];
    }
}
