<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaintenanceScheduleResource\Pages;
use App\Models\MaintenanceSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;

use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class MaintenanceScheduleResource extends Resource
{
    protected static ?string $model = MaintenanceSchedule::class;

    // 4. Іконка ресурсу
	protected static ?string $navigationGroup = 'Обслуговування';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    // Лейбли моделі
    public static function getModelLabel(): string
    {
        return 'Графік обслуговування';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Графіки обслуговування';
    }

    public static function getNavigationLabel(): string
    {
        return 'Графіки обслуговування';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Select::make('vehicle_id')
                ->label('Автомобіль')
                ->relationship('vehicle', 'registration_number')
                ->searchable()
                ->preload()       // <-- загрузит все опции сразу
                ->required(),

            Select::make('maintenance_type_id')
                ->label('Тип обслуговування')
                ->relationship('maintenanceType', 'name')
                ->searchable()
                ->preload()       // <-- и здесь
                ->required(),

                Forms\Components\DatePicker::make('last_date')
                    ->label('Остання дата'),

                Forms\Components\TextInput::make('last_odometer')
                    ->label('Пробіг станом на останню дату')
                    ->numeric(),

                Forms\Components\DatePicker::make('next_date_due')
                    ->label('Наступна дата'),

                Forms\Components\TextInput::make('next_odometer_due')
                    ->label('Наступний пробіг')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // мини-фото автомобиля из коллекции 'photos' с конверсией 'thumb'
                SpatieMediaLibraryImageColumn::make('vehicle.photos')
                    ->collection('photos')
                    ->conversion('thumb')
                    ->size(50)
                    ->circular()
                    ->label('Фото авто'),

                // регистрационный номер
                TextColumn::make('vehicle.registration_number')
                    ->label('Номер')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('maintenanceType.name')
                    ->label('Тип обслуговування')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('last_date')
                    ->label('Остання дата')
                    ->date()
                    ->sortable(),


                Tables\Columns\TextColumn::make('next_date_due')
                    ->label('Наступна дата')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('next_odometer_due')
                    ->label('Наступний пробіг')
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
                Tables\Actions\EditAction::make(),  // кнопка «Редагувати»
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),  // групове «Видалити»
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
            'index'  => Pages\ListMaintenanceSchedules::route('/'),
            'create' => Pages\CreateMaintenanceSchedule::route('/create'),
            'edit'   => Pages\EditMaintenanceSchedule::route('/{record}/edit'),
        ];
    }
}
