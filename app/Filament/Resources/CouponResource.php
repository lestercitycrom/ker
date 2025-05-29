<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class CouponResource extends Resource
{
	protected static ?string $model = Coupon::class;

	// Navigation settings
	protected static ?string $navigationIcon   = 'heroicon-o-ticket';
	protected static ?string $navigationGroup  = 'Замовлення';
	protected static ?string $navigationLabel  = 'Купони';
	protected static ?string $modelLabel       = 'Купон';
	protected static ?string $pluralModelLabel = 'Купони';

	// Display total count in menu badge
	public static function getNavigationBadge(): ?string
	{
		return (string) static::$model::count();
	}

	public static function form(Form $form): Form
	{
		return $form
			->columns(2)
			->schema([
				// Basic details
				Fieldset::make('Основне')
					->columns(3)
					->schema([
						TextInput::make('code')
							->label('Код купона')
							->default(fn (): string => strtoupper(Str::random(10)))
							->required()
							->maxLength(255),

						TextInput::make('discount_amount')
							->label('Сума знижки')
							->numeric()
							->nullable(),

						TextInput::make('discount_percent')
							->label('Відсоток знижки')
							->numeric()
							->nullable(),
					]),

				// Validity period
				Fieldset::make('Термін дії')
					->columns(2)
					->schema([
						DatePicker::make('valid_from')
							->label('Дійсний з')
							->default(fn (): string => Carbon::now()->toDateString()),

						DatePicker::make('valid_to')
							->label('Дійсний до')
							->default(fn (): string => Carbon::now()->addMonth()->toDateString()),
					]),

				// Usage limits
				Fieldset::make('Використання')
					->columns(2)
					->schema([
						TextInput::make('max_uses')
							->label('Максимум використань')
							->numeric()
							->nullable(),

						TextInput::make('times_used')
							->label('Використано разів')
							->required()
							->numeric()
							->default(0),
					]),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				TextColumn::make('code')
					->label('Код')
					->searchable(),

				TextColumn::make('discount_amount')
					->label('Сума')
					->numeric()
					->sortable(),

				TextColumn::make('discount_percent')
					->label('Відсоток')
					->numeric()
					->sortable(),

				TextColumn::make('valid_from')
					->label('Дійсний з')
					->date()
					->sortable(),

				TextColumn::make('valid_to')
					->label('Дійсний до')
					->date()
					->sortable(),

				TextColumn::make('max_uses')
					->label('Максимум використань')
					->numeric()
					->sortable(),

				TextColumn::make('times_used')
					->label('Використано')
					->numeric()
					->sortable(),

				TextColumn::make('created_at')
					->label('Створено')
					->dateTime()
					->sortable()
					->toggleable(isToggledHiddenByDefault: true),
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
			'index' => Pages\ManageCoupons::route('/'),
		];
	}
}
