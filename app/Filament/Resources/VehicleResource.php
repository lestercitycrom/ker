<?php

namespace App\Filament\Resources;

use App\Enums\VehicleStatus;
use App\Filament\Resources\VehicleResource\Pages;
use App\Models\Vehicle;
use App\Models\Contact;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getLabel(): string { return 'Автомобіль'; }
    public static function getPluralLabel(): string { return 'Автомобілі'; }
    public static function getNavigationGroup(): string { return 'Транспорт'; }
    public static function getNavigationBadge(): ?string { return (string) static::$model::count(); }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Основні характеристики')->columns(3)->schema([
                Select::make('contact_id')->label('Власник')
                    ->options(fn() => Contact::whereNull('deleted_at')->get()->pluck('display_name','id'))
                    ->searchable()->preload()->required(),
                Select::make('vehicle_category_id')->label('Категорія')
                    ->relationship('category','name')->preload()->required(),
                Select::make('brand_id')->label('Марка')
                    ->options(config('car_brands'))->reactive()->searchable()->required(),
                Select::make('model_id')->label('Модель')
                    ->options(fn($get)=>config('car_models')[$get('brand_id')] ?? [])
                    ->searchable()->required()->disabled(fn($get)=>!$get('brand_id')),
				TextInput::make('registration_number')->label('Номер')->required()->maxLength(255),
				Select::make('status')->label('Статус')->options(VehicleStatus::class)->default(VehicleStatus::Active->value)->required(),					
				
                Select::make('year')->label('Рік')->options(fn()=>array_combine(range(date('Y'),1945,-1), range(date('Y'),1945,-1)))->searchable()->required(),
            ]),
			
            Fieldset::make('Технiчнi характеристики')->columns(3)->schema([
                

                TextInput::make('vin')->label('VIN')->maxLength(255),
                Select::make('transmission_id')->label('Коробка')
                    ->options(config('transmissions'))->searchable()->nullable(),
                Select::make('fuel_id')->label('Паливо')
                    ->options(config('fuels'))->searchable()->nullable(),
					
                //TextInput::make('engine_volume')->label('Обʼєм (л)')->numeric(),
                Select::make('body_type_id')->label('Тип кузова')
                    ->options(config('body_types'))->searchable()->nullable(),
                Select::make('drive_id')->label('Привід')
                    ->options(config('drives'))->searchable()->nullable(),
                Select::make('color_id')->label('Колір')
                    ->options(fn() => array_map(fn($c) => $c['name'], config('colors')))
                    ->searchable()
                    ->nullable(),

            ]),			

            Fieldset::make('Пробіг та габарити')->columns(4)->schema([
                TextInput::make('odometer')->label('Пробіг')->default(0)->numeric(),
                TextInput::make('fuel_level')->label('Рівень пального (%)')->default(0)->numeric(),
                TextInput::make('tank_volume')->label('Бак (л)')->numeric(),
                TextInput::make('fuel_consumption')->label('Витрата (л/100км)')->numeric(),
                TextInput::make('seat_count')->label('Місць')->numeric(),
                TextInput::make('door_count')->label('Дверей')->numeric(),
                TextInput::make('large_bags')->label('Великі валізи')->numeric(),
                TextInput::make('small_bags')->label('Малі валізи')->numeric(),
            ]),

            Fieldset::make('Додаткові опції')->schema([
                CheckboxList::make('extras')->label('Опції')
                    ->relationship('extras','name')->columns(4)->searchable()->bulkToggleable()->columnSpanFull(),
            ]),

            Fieldset::make('Трекер та фото')->schema([
                TextInput::make('tracker_imei')->label('IMEI трекера')->maxLength(255),
                TextInput::make('tracker_phone_number')->label('Телефон трекера')->tel()->maxLength(255),
                SpatieMediaLibraryFileUpload::make('photos')->label('Фотографії')
                    ->collection('photos')->conversion('thumb')->multiple()->maxFiles(5)->image()->responsiveImages(),
            ]),

        ]);
    }


    public static function table(Table $table): Table
    {
        return $table->columns([
            SpatieMediaLibraryImageColumn::make('photos')->collection('photos')->conversion('thumb')->size(50)->circular(),
            TextColumn::make('registration_number')->label('Номер')->searchable()->sortable(),
            TextColumn::make('brand_id')
                ->label('Марка')
                ->formatStateUsing(fn($state): string => config('car_brands')[$state] ?? '-')
                ->searchable()
                ->sortable()
                ->toggleable(),
            TextColumn::make('model_id')
                ->label('Модель')
                ->formatStateUsing(fn($state, $record): string => config('car_models')[$record->brand_id][$state] ?? '-')
                ->searchable()
                ->sortable()
                ->toggleable(),
            TextColumn::make('year')->label('Рік')->sortable(),
            TextColumn::make('odometer')->label('Пробіг')->numeric()->sortable(),
            BadgeColumn::make('status')->label('Статус')->formatStateUsing(fn(VehicleStatus $state) => $state->getLabel())->color(fn(VehicleStatus $state) => $state->getColor())->sortable(),
            //TagsColumn::make('extras.name')->label('Опції')->separator(', ')->limit(3)->toggleable(),
        ])->filters([TrashedFilter::make()])
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'view'   => Pages\ViewVehicle::route('/{record}'),
            'edit'   => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
