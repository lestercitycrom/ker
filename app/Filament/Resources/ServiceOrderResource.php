<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceOrderResource\Pages;
use App\Models\ServiceOrder;
use App\Models\Contact;                                  // ← імпорт
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\BadgeColumn;


class ServiceOrderResource extends Resource
{
    protected static ?string $model = ServiceOrder::class;

    protected static ?string $navigationGroup = 'Обслуговування';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getModelLabel(): string
    {
        return 'Сервісне замовлення';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Сервісні замовлення';
    }

    public static function getNavigationLabel(): string
    {
        return 'Сервісні замовлення';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vehicle_id')
                    ->label('Автомобіль')
                    ->relationship('vehicle', 'registration_number')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('contact_id')
                    ->label('Власник')
                    ->options(fn() => Contact::whereNull('deleted_at')
                        ->get()
                        ->pluck('display_name', 'id')
                        ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

				Select::make('status')
					->label('Статус')
					->options(config('service_order_statuses'))
					->default('planned')    // по умолчанию «Заплановано»
					->required(),


                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Дата початку'),

                Forms\Components\DateTimePicker::make('end_date')
                    ->label('Дата завершення'),

                Forms\Components\TextInput::make('odometer')
                    ->label('Пробіг')
                    ->numeric(),

                Forms\Components\TextInput::make('total_cost')
                    ->label('Вартість')
                    ->numeric()
                    ->default(0.00),

                Forms\Components\Toggle::make('paid')
                    ->label('Оплачено')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Примітки')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
			
                SpatieMediaLibraryImageColumn::make('vehicle.photos')
                    ->collection('photos')
                    ->conversion('thumb')
                    ->size(50)
                    ->circular()
                    ->label('Фото авто'),
					
                TextColumn::make('vehicle.registration_number')
                    ->label('Номер')
                    ->sortable()
                    ->searchable(),

            TextColumn::make('partner.display_name')
                ->label('Власник')
                ->searchable()
                ->sortable(),

            // 2) Статус — бейдж з enum з конфига
BadgeColumn::make('status')
    ->label('Статус')
    // Формируем текст метки по ключу из конфига
    ->formatStateUsing(fn (string $state): string => config('service_order_statuses')[$state] ?? $state)
    // Задаём цвета бейджей по состоянию
    ->colors([
        'secondary' => 'planned',
        'warning'   => 'in_service',
        'success'   => 'completed',
    ]),

                TextColumn::make('start_date')
                    ->label('Дата початку')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Дата завершення')
                    ->dateTime()
                    ->sortable(),

                IconColumn::make('paid')
                    ->label('Оплачено')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServiceOrders::route('/'),
            'create' => Pages\CreateServiceOrder::route('/create'),
            'edit'   => Pages\EditServiceOrder::route('/{record}/edit'),
        ];
    }
}
