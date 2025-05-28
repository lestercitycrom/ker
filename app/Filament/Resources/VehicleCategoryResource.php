<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleCategoryResource\Pages;
use App\Models\VehicleCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VehicleCategoryResource extends Resource
{
    protected static ?string $model = VehicleCategory::class;

    // 3. Меню «Налаштування»
    protected static ?string $navigationGroup = 'Налаштування';

    // 4. Иконка ресурса
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    // Системные метки ресурса
    public static function getModelLabel(): string
    {
        return 'Категорія авто';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Категорії авто';
    }

    public static function getNavigationLabel(): string
    {
        return 'Категорії авто';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва')        // 1. перевод
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('description')
                    ->label('Опис')         // 1. перевод
                    ->maxLength(255),

                Forms\Components\TextInput::make('daily_rate')
                    ->label('Щоденна ставка') // 1. перевод
                    ->numeric(),

                Forms\Components\TextInput::make('monthly_rate')
                    ->label('Місячна ставка') // 1. перевод
                    ->numeric(),

                Forms\Components\TextInput::make('seat_count')
                    ->label('Кількість сидінь') // 1. перевод
                    ->numeric(),

                Forms\Components\TextInput::make('door_count')
                    ->label('Кількість дверей') // 1. перевод
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Опис')
                    ->searchable(),

                Tables\Columns\TextColumn::make('daily_rate')
                    ->label('Щоденна ставка')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('monthly_rate')
                    ->label('Місячна ставка')
                    ->numeric()
                    ->sortable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')     // 1. перевод
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Оновлено')     // 1. перевод
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),  // кнопка «Редагувати»
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // групове видалення
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
            'index'  => Pages\ListVehicleCategories::route('/'),
            'create' => Pages\CreateVehicleCategory::route('/create'),
            'edit'   => Pages\EditVehicleCategory::route('/{record}/edit'),
        ];
    }
}
