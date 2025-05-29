<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ViolationResource\Pages;
use App\Models\Violation;
use App\Models\Contact;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ViolationResource extends Resource
{
	protected static ?string $model = Violation::class;

	protected static ?string $navigationIcon   = 'heroicon-o-exclamation-triangle';
	protected static ?string $navigationGroup  = 'Контакти';
	protected static ?string $navigationLabel  = 'Порушення';
	protected static ?string $modelLabel       = 'Порушення';
	protected static ?string $pluralModelLabel = 'Порушення';

	// Display record count in menu badge
	public static function getNavigationBadge(): ?string
	{
		return (string) static::$model::count();
	}

	public static function form(Form $form): Form
	{
		return $form
			->columns(3)
			->schema([
				// Relations fieldset grouping related selects
				Fieldset::make('Відношення')
					->columns(3)
					->schema([
						Select::make('vehicle_id')
							->relationship('vehicle', 'registration_number')
							->label('Автомобіль')
							->native(false)
							->required(),

						Select::make('order_id')
							->relationship('order', 'code')
							->native(false)
							->label('Замовлення'),

						Select::make('contact_id')
							->label('Контакт')
							->relationship('contact', 'first_name')
							->getOptionLabelUsing(fn (?int $contactId): string => Contact::find($contactId)?->display_name ?? '')
							->searchable()->required()
							->preload(),
					]),

				// Violation details fieldset
				Fieldset::make('Деталі порушення')
					->columns(3)
					->schema([
						DateTimePicker::make('occurred_at')
							->label('Початок')
							->required()
							->withoutSeconds()                        // disable seconds selection
							->default(fn () => now()->startOfMinute()), // default to start of current minute	

						Select::make('type')
							->label('Тип порушення')
							->options(config('violations')) // використовуємо масив з конфігу
							->searchable()                        // робить опції пошуковими
							->required()
							->native(false),   

							

						TextInput::make('location')
							->label('Місце')
							->maxLength(255),

						/*
						TextInput::make('latitude')
							->label('Широта')
							->numeric()
							->nullable(),

						TextInput::make('longitude')
							->label('Довгота')
							->numeric()
							->nullable(),
						*/	
					]),

				// Fine fieldset
				Fieldset::make('Штраф')
					->columns(1)
					->schema([
						TextInput::make('fine_amount')
							->label('Сума штрафу')
							->numeric()
							->default(0.00),
					]),

				// Additional info fieldset
				Fieldset::make('Додатково')
					->columns(1)
					->schema([
						Textarea::make('details')
							->label('Деталі')
							->columnSpanFull(),

						Toggle::make('resolved')
							->label('Вирішено'),
					]),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
			
                SpatieMediaLibraryImageColumn::make('contact.photo')
                    ->collection('photo')
                    ->conversion('thumb')
                    ->size(50)
                    ->circular()
                    ->label(''),			
			
				TextColumn::make('contact.display_name')
					->label('Контакт')
					->sortable()
					->searchable(),
					
				TextColumn::make('vehicle.registration_number')
					->label('Автомобіль')
					->sortable()
					->searchable(),

				TextColumn::make('occurred_at')->label('Початок')->dateTime('d.m.Y H:i')->sortable(),
				
					

				TextColumn::make('type')
					->label('Тип порушення')
					->formatStateUsing(fn ($state) => config('violations')[$state] ?? $state)
					->sortable()
					->searchable(),


				TextColumn::make('location')
					->label('Місце')
					->searchable(),

				TextColumn::make('fine_amount')
					->label('Штраф')
					->numeric()
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
			->actions([
				EditAction::make(),
			])
			->bulkActions([
				BulkActionGroup::make([
					DeleteBulkAction::make(),
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
			'index'  => Pages\ListViolations::route('/'),
			'create' => Pages\CreateViolation::route('/create'),
			'edit'   => Pages\EditViolation::route('/{record}/edit'),
		];
	}
}
