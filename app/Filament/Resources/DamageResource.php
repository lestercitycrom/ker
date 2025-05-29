<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DamageResource\Pages;
use App\Models\Damage;
use App\Models\Contact;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    Fieldset,
    Select,
    TextInput,
    Textarea,
    Toggle,
    SpatieMediaLibraryFileUpload,
};
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\{
    TextColumn,
    IconColumn,
};
use Filament\Tables\Actions\{
    EditAction,
    DeleteAction,
    BulkActionGroup,
    DeleteBulkAction,
};

class DamageResource extends Resource
{
    protected static ?string $model = Damage::class;

    // Іконка в меню
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';
    // Заголовок в меню (множина)
    protected static ?string $navigationLabel = 'Пошкодження';
    // Мітка моделі (однина)
    protected static ?string $modelLabel = 'Пошкодження';
    // Мітка моделі (множина)
    protected static ?string $pluralModelLabel = 'Пошкодження';
	// Группа меню
	protected static ?string $navigationGroup = 'Транспорт';


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Загальні дані')
                ->schema([
                    Select::make('vehicle_id')
                        ->label('Автомобіль')
                        ->relationship('vehicle', 'registration_number')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('order_id')
                        ->label('Замовлення')
                        ->relationship('order', 'code')
                        ->searchable()
                        ->preload(),
                    Select::make('contact_id')
                        ->label('Контакт')
                        ->relationship('contact', 'first_name')
                        ->getOptionLabelUsing(fn (?int $contactId): string => Contact::find($contactId)?->display_name ?? '')
                        ->searchable()
                        ->preload(),
                ])
                ->columns(3),

            Fieldset::make('Характер пошкодження')
                ->schema([
                    TextInput::make('title')
                        ->label('Заголовок')
                        ->maxLength(255),
                    Select::make('severity')
                        ->label('Ступінь серйозності')
                        ->options(config('damage.severity'))
                        ->default(config('damage.default_severity'))
                        ->required(),
                    TextInput::make('part')
                        ->label('Частина')
                        ->maxLength(255),
                    Toggle::make('is_interior')
                        ->label('Внутрішнє пошкодження')
                        ->required(),
                    Toggle::make('resolved')
                        ->label('Вирішено')
                        ->required(),
                ])
                ->columns(2),

            Fieldset::make('Детальний опис')
                ->schema([
                    Textarea::make('description')
                        ->label('Опис')
                        ->columnSpanFull(),
                ]),

            // Фотографії пошкодження
            Fieldset::make('Фотографії')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('photos')
                        ->label('Фото пошкоджень')
                        ->collection('photos')
                        ->multiple()
                        ->image()
                        ->enableDownload()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable(),			
                TextColumn::make('vehicle.registration_number')
                    ->label('Автомобіль')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order.code')
                    ->label('Замовлення')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('severity')
                    ->label('Ступінь')
                    ->formatStateUsing(fn (?string $state): string => config('damage.severity')[$state] ?? $state)
                    ->sortable(),
                IconColumn::make('resolved')
                    ->label('Вирішено')
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
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDamages::route('/'),
        ];
    }
}
