<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Vehicle;
use App\Models\Location;
use Filament\Forms\Form;
use Filament\Forms\Components\{
	Fieldset,
	Select,
	TextInput,
	DateTimePicker,
	Toggle,
	Textarea,
	Hidden,
};
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\{
	TextColumn,
	BadgeColumn,
};
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\{
	ViewAction,
	EditAction,
	BulkActionGroup,
	DeleteBulkAction,
	ForceDeleteBulkAction,
	RestoreBulkAction,
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
	protected static ?string $model = Order::class;
	protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
	protected static ?string $navigationLabel = 'Замовлення';
	protected static ?string $modelLabel = 'Замовлення';
	protected static ?string $pluralModelLabel = 'Замовлення';
	protected static ?string $navigationGroup  = 'Замовлення';

	public static function getNavigationBadge(): ?string
	{
		return static::getModel()::count();
	}

	public static function getNavigationBadgeColor(): string
	{
		return 'primary';
	}

	public static function form(Form $form): Form
	{
		return $form->schema([
			Fieldset::make('Клієнт і транспорт')
				->schema([
					Select::make('contact_id')
						->label('Контакт')
						->relationship('contact', 'first_name')
						->getOptionLabelUsing(fn (?int $contactId): string => Contact::find($contactId)?->display_name ?? '')
						->searchable()
						->preload(),
					Select::make('vehicle_id')
						->label('Автомобіль')
						->relationship('vehicle', 'registration_number')
						->searchable()
						->preload(),
					Select::make('status')
						->label('Статус')
						->options(collect(OrderStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->getLabel()]))
						->default(OrderStatus::Booking->value)
						->required(),
					TextInput::make('source')
						->label('Джерело')
						->maxLength(255),
					Hidden::make('manager_id')->default(1),				
				])
				->columns(3),


				Fieldset::make('Часові рамки')
					->schema([
						DateTimePicker::make('start_at')
							->label('Початок')
							->required()
							->withoutSeconds() 
							->default(fn () => now()->startOfMinute()), // Default current datetime, no seconds
						DateTimePicker::make('end_at')
							->label('Закінчення')
							->required()
							->withoutSeconds() 
							->default(fn () => now()->addDay()->startOfMinute()), // Default +1 day, no seconds
					])
					->columns(2),

			Fieldset::make('Локації')
				->schema([
					Select::make('pickup_location_id')
						->label('Місце отримання')
						->relationship('pickupLocation', 'name')
						->searchable()
						->preload(),
					Select::make('return_location_id')
						->label('Місце повернення')
						->relationship('returnLocation', 'name')
						->searchable()
						->preload(),
					Toggle::make('return_to_different_location')
						->label('Повернення в інше місце')
						->required(),
						
				])
				->columns(2),



			Fieldset::make('Фінанси')
				->schema([
					TextInput::make('total_amount')->label('Загальна сума')->numeric()->default(0.00),
					TextInput::make('balance_due')->label('До оплати')->numeric()->default(0.00),
					TextInput::make('coupon_code')->label('Купон')->maxLength(255),
					TextInput::make('discount_amount')->label('Сума знижки')->numeric()->default(0.00),
					
				])
				->columns(4),
				
			Fieldset::make('Нотатки')
				->schema([
					Textarea::make('pickup_notes')->label('Нотатки отримання')->columnSpanFull(),
					Textarea::make('return_notes')->label('Нотатки повернення')->columnSpanFull(),
				]),				
		]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				TextColumn::make('code')->label('Код')->searchable()->sortable(),
				TextColumn::make('contact')->label('Контакт')
					->getStateUsing(fn (Order $record): string => $record->contact?->display_name ?? '')
					->searchable()->sortable(),
				TextColumn::make('vehicle.registration_number')->label('Автомобіль')->searchable()->sortable(),
				BadgeColumn::make('status')->label('Статус')->formatStateUsing(fn(OrderStatus $state) => $state->getLabel())->color(fn(OrderStatus $state) => $state->getColor())->sortable(),
				TextColumn::make('start_at')->label('Початок')->dateTime('d.m.Y H:i')->sortable(),
				TextColumn::make('end_at')->label('Закінчення')->dateTime('d.m.Y H:i')->sortable(),
				TextColumn::make('total_amount')->label('Сума')->numeric()->sortable(),
				TextColumn::make('created_at')->label('Створено')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('updated_at')->label('Оновлено')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('deleted_at')->label('Видалено')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
			])
			->filters([TrashedFilter::make()])
			->actions([ EditAction::make()])
			->bulkActions([
				BulkActionGroup::make([
					DeleteBulkAction::make(),
					ForceDeleteBulkAction::make(),
					RestoreBulkAction::make(),
				]),
			]);
	}

	public static function getRelations(): array
	{
		return [];
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListOrders::route('/'),
			'create' => Pages\CreateOrder::route('/create'),
			'view' => Pages\ViewOrder::route('/{record}'),
			'edit' => Pages\EditOrder::route('/{record}/edit'),
		];
	}

	public static function getEloquentQuery(): Builder
	{
		return parent::getEloquentQuery()
			->withoutGlobalScopes([SoftDeletingScope::class]);
	}
}
