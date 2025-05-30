<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaintenanceTypeResource\Pages;
use App\Models\MaintenanceType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaintenanceTypeResource extends Resource
{
    protected static ?string $model = MaintenanceType::class;

    // 3. Меню «Налаштування»
    protected static ?string $navigationGroup = 'Налаштування';

    // 4. Іконка (наприклад, гаєчний ключ)
    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    // 5. Лейбли моделі
    public static function getModelLabel(): string
    {
        return 'Тип обслуговування';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Типи обслуговування';
    }

    public static function getNavigationLabel(): string
    {
        return 'Типи обслуговування';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва')            // 1. переклад
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('interval_km')
                    ->label('Інтервал (км)')     // 1. переклад
                    ->numeric(),

                Forms\Components\TextInput::make('interval_days')
                    ->label('Інтервал (днів)')   // 1. переклад
                    ->numeric(),

                Forms\Components\Textarea::make('description')
                    ->label('Опис')             // 1. переклад
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

                Tables\Columns\TextColumn::make('interval_km')
                    ->label('Інтервал (км)')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('interval_days')
                    ->label('Інтервал (днів)')
                    ->numeric()
                    ->sortable(),

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
            'index' => Pages\ManageMaintenanceTypes::route('/'),
        ];
    }
}
