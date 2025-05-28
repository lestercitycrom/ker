<?php

namespace App\Filament\Resources;

use App\Enums\VehicleStatus;
use App\Filament\Resources\VehicleResource\Pages;
use App\Models\Vehicle;

use Filament\Forms\Components\{CheckboxList, Select, SpatieMediaLibraryFileUpload, TextInput};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\TrashedFilter;

class VehicleResource extends Resource
{
    /** Модель */
    protected static ?string $model = Vehicle::class;

    /** Название иконки + счётчик */
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getLabel(): string        { return 'Автомобіль'; }
    public static function getPluralLabel(): string  { return 'Автомобілі'; }
    public static function getNavigationGroup(): string { return 'Флот'; }

    /** Значок-счётчик у пункту меню */
    public static function getNavigationBadge(): ?string
    {
        return (string) static::$model::count();      // кол-во записей
    }

    /** --------- Форма --------- */
    public static function form(Form $form): Form
    {
        return $form->schema([
            // Власник / клієнт
			
			Select::make('contact_id')
				->label('Власник')
				->options(function () {
					// Обязательно учесть soft deletes!
					return \App\Models\Contact::query()
						->whereNull('deleted_at')
						->get()
						->mapWithKeys(function ($contact) {
							return [$contact->id => $contact->display_name];
						});
				})
				->searchable()
				->preload()
				->required(),


            // Категорія
            Select::make('vehicle_category_id')
                ->label('Категорія')
                ->relationship('category', 'name')
                // ->searchable()
                ->preload()
                ->required(),

            // Базова та поточна локації
            Select::make('base_location_id')->label('Базова локація')
                ->relationship('baseLocation', 'name')->searchable()->preload(),

            Select::make('current_location_id')->label('Поточна локація')
                ->relationship('currentLocation', 'name')->searchable()->preload(),

            // Тип ТЗ
            TextInput::make('type')->label('Тип')->default('Car')->required()->maxLength(255),

            // Динамічний вибір марки та моделі
		
Select::make('brand')
    ->label('Марка')
    ->options(config('car_brands'))
    ->reactive()
    ->searchable()
    ->required(),

Select::make('model')
    ->label('Модель')
    ->options(fn ($get) => (array) (config('car_models')[$get('brand')] ?? []))
    ->searchable()
    ->required()
    ->disabled(fn ($get) => !$get('brand')),


            TextInput::make('registration_number')->label('Номер')->required()->maxLength(255),
            TextInput::make('year')->label('Рік')->numeric(),
            TextInput::make('vin')->label('VIN')->maxLength(255),
            TextInput::make('transmission')->label('Коробка'),
            TextInput::make('engine_volume')->label('Обʼєм (л)')->numeric(),
            TextInput::make('fuel_type')->label('Пальне'),
            TextInput::make('body_type')->label('Тип кузова')->maxLength(255),
            TextInput::make('drive_type')->label('Привід'),
            TextInput::make('color')->label('Колір')->maxLength(255),

            TextInput::make('odometer')->label('Пробіг')->default(0)->numeric()->required(),
            TextInput::make('fuel_level')->label('Рівень пального (%)')->default(0)->numeric()->required(),
            TextInput::make('tank_volume')->label('Бак (л)')->numeric(),
            TextInput::make('fuel_consumption')->label('Витрата (л/100км)')->numeric(),
            TextInput::make('seat_count')->label('Місць')->numeric(),
            TextInput::make('door_count')->label('Дверей')->numeric(),
            TextInput::make('large_bags')->label('Великі валізи')->numeric(),
            TextInput::make('small_bags')->label('Малі валізи')->numeric(),

            TextInput::make('features')->label('Опції'),


            /* --------- НОВОЕ: чек-лист опцій --------- */
            CheckboxList::make('extras')
                ->label('Додаткові опції')
                ->relationship('extras','name')
                ->columns(2)
                ->searchable()
                ->bulkToggleable(),

            TextInput::make('tracker_imei')->label('IMEI трекера')->maxLength(255),
            TextInput::make('tracker_phone_number')->label('Телефон трекера')->tel()->maxLength(255),

            Select::make('status')
                ->label('Статус')
                ->options(VehicleStatus::class)
                ->required(),

            // Фотографії (до 5)
            SpatieMediaLibraryFileUpload::make('photos')
                ->label('Фотографії')
                ->collection('photos')
                ->multiple()
                ->maxFiles(5)
                ->image()
                ->responsiveImages(),
        ]);
    }

    /** --------- Таблиця --------- */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photos')
                    ->collection('photos')
                    ->size(60)
                    ->circular(),

                TextColumn::make('registration_number')->label('Номер')->searchable()->sortable(),
                TextColumn::make('brand')->label('Марка')->searchable()->sortable(),
                TextColumn::make('model')->label('Модель')->searchable()->sortable(),
                TextColumn::make('year')->label('Рік')->sortable(),
                TextColumn::make('odometer')->label('Пробіг')->numeric()->sortable(),

                BadgeColumn::make('status')
                    ->label('Статус')
                    ->enum(VehicleStatus::class)
                    ->colors(VehicleStatus::class),

                TextColumn::make('category.name')->label('Категорія')->searchable()->toggleable(),
                TextColumn::make('contact.last_name')->label('Власник')->toggleable(),
                TextColumn::make('baseLocation.name')->label('База')->toggleable(),
                TextColumn::make('currentLocation.name')->label('Поточна локація')->toggleable(),

                TextColumn::make('updated_at')->label('Змінено')->dateTime()->toggleable(),
            ])
            ->filters([ TrashedFilter::make() ])
            ->actions([
                \Filament\Tables\Actions\ViewAction::make(),
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\DeleteBulkAction::make(),
                \Filament\Tables\Actions\ForceDeleteBulkAction::make(),
                \Filament\Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    /** --------- Сторінки --------- */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'view'   => Pages\ViewVehicle::route('/{record}'),
            'edit'   => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }

    /** --------- Запит Eloquent (з урах. SoftDeletes) --------- */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
