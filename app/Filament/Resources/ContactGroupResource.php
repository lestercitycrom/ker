<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactGroupResource\Pages;
use App\Models\ContactGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactGroupResource extends Resource
{
	// Модель ресурса
	protected static ?string $model = ContactGroup::class;

	// Иконка меню (можно заменить на подходящую)
	protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

	// Группа меню "Налаштування"
	protected static ?string $navigationGroup = 'Контакти';

	// Название раздела в меню (украинский)
	protected static ?string $navigationLabel = 'Групи контактів';

	// Заголовок страницы
	protected static ?string $label = 'Група контактів';
	protected static ?string $pluralLabel = 'Групи контактів';

	/**
	 * Показывает количество записей возле иконки меню
	 */
	public static function getNavigationBadge(): ?string
	{
		return (string) ContactGroup::count();
	}

	/**
	 * Схема формы (украинский перевод)
	 */
	public static function form(Form $form): Form
	{
		return $form->schema([
			// Название группы
			Forms\Components\TextInput::make('name')
				->label('Назва')
				->required()
				->maxLength(255),
		]);
	}

	/**
	 * Схема таблицы (украинский перевод)
	 */
	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('name')
					->label('Назва')
					->searchable(),
				Tables\Columns\TextColumn::make('created_at')
					->label('Створено')
					->dateTime('d.m.Y H:i')
					->sortable()
					->toggleable(isToggledHiddenByDefault: true),
				Tables\Columns\TextColumn::make('updated_at')
					->label('Оновлено')
					->dateTime('d.m.Y H:i')
					->sortable()
					->toggleable(isToggledHiddenByDefault: true),
			])
			->filters([
				// Фільтри, якщо потрібно
			])
			->actions([
				Tables\Actions\EditAction::make()->label('Редагувати'),
				Tables\Actions\DeleteAction::make()->label('Видалити'),
			])
			->bulkActions([
				Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DeleteBulkAction::make()->label('Видалити вибране'),
				]),
			]);
	}

	/**
	 * Страницы ресурса (украинский перевод)
	 */
	public static function getPages(): array
	{
		return [
			'index' => Pages\ManageContactGroups::route('/'),
		];
	}
}
