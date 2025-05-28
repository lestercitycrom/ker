<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Dotswan\MapPicker\Fields\Map;
use Illuminate\Support\Facades\Http;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Налаштування';
    protected static ?string $navigationLabel = 'Локації';
    protected static ?string $label = 'Локації';
    protected static ?string $pluralLabel = 'Локації';

    /**
     * Генерує елементи графіку роботи для тижня.
     */
    private static function workingHoursFields(): array
    {
        $days = [
            'mon' => 'Пн',
            'tue' => 'Вт',
            'wed' => 'Ср',
            'thu' => 'Чт',
            'fri' => 'П\'ятниця',
            'sat' => 'Сб',
            'sun' => 'Нд',
        ];

        $toggles = [];
        $from   = [];
        $to     = [];

        foreach ($days as $key => $label) {
            $toggles[] = Toggle::make("{$key}_active")
                ->label($label)
                ->inline(false)
                ->default(fn(Get $get) => filled($get("{$key}_from")) || filled($get("{$key}_to")) || in_array($key, ['mon','tue','wed','thu','fri']))
                ->live()
                ->afterStateUpdated(function ($state, callable $set, Get $get) use ($key) {
                    // якщо вмикаємо, а часи порожні — ставимо дефолт
                    if ($state && (! filled($get("{$key}_from")) && ! filled($get("{$key}_to")))) {
                        $set("{$key}_from", '08:00');
                        $set("{$key}_to", '18:00');
                    }
                });

            $from[] = TimePicker::make("{$key}_from")
                ->label('З')
                ->seconds(false)
                ->disabled(fn(Get $get) => ! $get("{$key}_active"));

            $to[] = TimePicker::make("{$key}_to")
                ->label('По')
                ->seconds(false)
                ->disabled(fn(Get $get) => ! $get("{$key}_active"));
        }

        return [
            Grid::make(7)->schema($toggles),
            Grid::make(7)->schema($from),
            Grid::make(7)->schema($to),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Назва')
                ->required()
                ->maxLength(255),

            TextInput::make('address')
                ->label('Адреса')
                ->autocomplete('off')
                ->suffixAction(
                    Action::make('geocode')
                        ->icon('heroicon-o-map')
                        ->tooltip('Знайти на карті')
                        ->action(function ($state, callable $set, $livewire) {
                            if (! $state || mb_strlen($state) < 3) return;
                            $data = Http::withHeaders([
                                    'User-Agent' => config('app.name').' ('.config('app.url').')',
                                ])
                                ->timeout(4)
                                ->get('https://nominatim.openstreetmap.org/search', [
                                    'q' => $state,
                                    'format' => 'jsonv2',
                                    'addressdetails' => 1,
                                    'limit' => 1,
                                    'accept-language' => 'uk',
                                ])->json()[0] ?? null;
                            if (! $data) return;
                            $set('latitude', $data['lat']);
                            $set('longitude', $data['lon']);
                            $set('country', $data['address']['country'] ?? '');
                            $set('city', $data['address']['city'] ?? ($data['address']['town'] ?? ($data['address']['village'] ?? '')));
                            $set('coordinates', ['lat' => $data['lat'], 'lng' => $data['lon']]);
                            $livewire->dispatch('refreshMap');
                        })
                ),

            Map::make('coordinates')
                ->label('Мітка на карті')
                ->columnSpanFull()
                ->defaultLocation(latitude: 50.4501, longitude: 30.5234)
                ->zoom(12)
                ->draggable(true)
                ->clickable(true)
                ->showMarker(true)
                ->afterStateUpdated(function ($state, callable $set) {
                    if (is_array($state)) {
                        $set('latitude', $state['lat']);
                        $set('longitude', $state['lng']);
                    }
                })
                ->afterStateHydrated(fn($state, $record, callable $set) => $record ? $set('coordinates', ['lat'=>$record->latitude,'lng'=>$record->longitude]) : null),

            Hidden::make('city'),
            Hidden::make('country'),
            Hidden::make('latitude'),
            Hidden::make('longitude'),

            Section::make('Графік роботи')->schema(static::workingHoursFields()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                Tables\Columns\TextColumn::make('name')->label('Назва')->searchable(),
                Tables\Columns\TextColumn::make('address')->label('Адреса')->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Редагувати'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Видалити'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit'   => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
