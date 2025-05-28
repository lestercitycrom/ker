<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('contact_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('vehicle_category_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('base_location_id')
                    ->numeric(),
                Forms\Components\TextInput::make('current_location_id')
                    ->numeric(),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255)
                    ->default('Car'),
                Forms\Components\TextInput::make('brand')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('registration_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year'),
                Forms\Components\TextInput::make('vin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('transmission'),
                Forms\Components\TextInput::make('engine_volume')
                    ->numeric(),
                Forms\Components\TextInput::make('fuel_type'),
                Forms\Components\TextInput::make('body_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('drive_type'),
                Forms\Components\TextInput::make('color')
                    ->maxLength(255),
                Forms\Components\TextInput::make('odometer')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('fuel_level')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('tank_volume')
                    ->numeric(),
                Forms\Components\TextInput::make('fuel_consumption')
                    ->numeric(),
                Forms\Components\TextInput::make('seat_count')
                    ->numeric(),
                Forms\Components\TextInput::make('door_count')
                    ->numeric(),
                Forms\Components\TextInput::make('large_bags')
                    ->numeric(),
                Forms\Components\TextInput::make('small_bags')
                    ->numeric(),
                Forms\Components\TextInput::make('features'),
                Forms\Components\TextInput::make('extra_attributes'),
                Forms\Components\TextInput::make('tracker_imei')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tracker_phone_number')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('draft'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contact_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicle_category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_location_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_location_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\TextColumn::make('vin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transmission'),
                Tables\Columns\TextColumn::make('engine_volume')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fuel_type'),
                Tables\Columns\TextColumn::make('body_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('drive_type'),
                Tables\Columns\TextColumn::make('color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('odometer')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fuel_level')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tank_volume')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fuel_consumption')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('seat_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('door_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('large_bags')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('small_bags')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tracker_imei')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tracker_phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'view' => Pages\ViewVehicle::route('/{record}'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
