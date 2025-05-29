<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderPaymentResource\Pages;
use App\Models\OrderPayment;
use Carbon\Carbon;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class OrderPaymentResource extends Resource
{
	protected static ?string $model = OrderPayment::class;

	// Navigation settings
	protected static ?string $navigationIcon   = 'heroicon-o-currency-dollar';
	protected static ?string $navigationGroup  = 'Замовлення';
	protected static ?string $navigationLabel  = 'Платежі';
	protected static ?string $modelLabel       = 'Платіж';
	protected static ?string $pluralModelLabel = 'Платежі';

	// Display total count in menu badge
	public static function getNavigationBadge(): ?string
	{
		return (string) static::$model::count();
	}

	// Define form schema
	public static function form(Form $form): Form
	{
		return $form
			->columns(2)
			->schema([
				// Relation to Order: display order code instead of ID
				Fieldset::make('Відношення')
					->columns(1)
					->schema([
						Select::make('order_id')
							->relationship('order', 'code')
							->label('Замовлення')
							->searchable()
							->preload(),
					]),

				// Payment details with three columns
				Fieldset::make('Деталі платежу')
					->columns(3)
					->schema([
						Select::make('type')
							->label('Тип транзакції')
							->options(config('transaction_types'))
							->required(),

						Select::make('method')
							->label('Метод транзакції')
							->options(config('transaction_methods'))
							->nullable(),

						TextInput::make('transaction_id')
							->label('ID транзакції')
							->maxLength(255)
							->nullable(),
					]),

				// Amount and timestamp
				Fieldset::make('Сума та дата')
					->columns(2)
					->schema([
						TextInput::make('amount')
							->label('Сума')
							->required()
							->numeric(),

						DateTimePicker::make('date')
							->label('Дата та час')
							->withoutSeconds() // hide seconds
							->required()
							->default(fn (): ?string => Carbon::now()->toDateTimeString()),
					]),
			]);
	}

	// Define table columns
	public static function table(Table $table): Table
	{
		return $table
			->columns([
				TextColumn::make('order.code')
					->label('Замовлення')
					->sortable()
					->searchable(),

				TextColumn::make('type')
					->label('Тип транзакції')
					->sortable(),

				TextColumn::make('method')
					->label('Метод транзакції'),

				TextColumn::make('amount')
					->label('Сума')
					->numeric()
					->sortable(),

				TextColumn::make('date')
					->label('Дата та час')
					->dateTime('Y-m-d H:i') // format without seconds
					->sortable(),

				TextColumn::make('transaction_id')
					->label('ID транзакції')
					->searchable(),

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

	// Define resource pages
	public static function getPages(): array
	{
		return [
			'index' => Pages\ManageOrderPayments::route('/'),
		];
	}
}
