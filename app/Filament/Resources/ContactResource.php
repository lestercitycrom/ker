<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Enums\{ContactMethodType, ContactDocumentType};
use Filament\Forms\Components\{DatePicker, Repeater, Select, SpatieMediaLibraryFileUpload, Textarea, TextInput};

use App\Filament\Resources\ContactResource\Pages\{CreateIndividualContact, CreateCompanyContact};

class ContactResource extends Resource
{
	// Модель
	protected static ?string $model = Contact::class;

	// Иконка ресурса
	protected static ?string $navigationIcon = 'heroicon-o-user-group';

	// Группа меню
	protected static ?string $navigationGroup = 'Контакти';

	// Название меню
	protected static ?string $navigationLabel = 'Список контактів';

	// Названия ресурса (украинский)
	protected static ?string $label = 'Контакт';
	protected static ?string $pluralLabel = 'Контакти';

		/**
		 * Таблица контактов (полный перевод, фото, имя и фамилия отдельно)
		 */
		 
	public static function getNavigationBadge(): ?string
	{
		return (string) \App\Models\Contact::count();
	}		 


		 
	public static function table(Table $table): Table
	{
		return $table
			->columns([
				// Фото Spatie
				Tables\Columns\ImageColumn::make('photo')
					->label('Фото')
					->circular()
					->getStateUsing(fn ($record) => $record->getFirstMediaUrl('photo') ?: null),

				// Им'я (или назва компанії)
				Tables\Columns\TextColumn::make('first_name')
					->label('Ім’я')
					->formatStateUsing(function ($state, $record) {
						return $record->type === 'company'
							? ($record->company_name ?? $record->display_name)
							: $state;
					})
					->searchable(),

				// Прізвище (только для фіз.осіб)
				Tables\Columns\TextColumn::make('last_name')
					->label('Прізвище')
					->formatStateUsing(function ($state, $record) {
						return $record->type === 'company' ? '-' : $state;
					})
					->searchable(),

				// Група
				Tables\Columns\TextColumn::make('group.name')
					->label('Група')
					->sortable(),

				// Email
				Tables\Columns\TextColumn::make('email')
					->label('E-mail')
					->copyable(),

				// Телефон
				Tables\Columns\TextColumn::make('phone')
					->label('Телефон'),

				// Тип
				Tables\Columns\BadgeColumn::make('type')
					->label('Тип'),
			])
			->actions([
				\Filament\Tables\Actions\Action::make('edit')
					->label('Редагувати')
					->icon(fn ($record) =>
						($record->type instanceof \App\Enums\ContactType
							? $record->type->value === 'company'
							: $record->type === 'company'
						)
							? 'heroicon-o-building-office'
							: 'heroicon-o-user'
					)
					->url(fn ($record) =>
						($record->type instanceof \App\Enums\ContactType
							? $record->type->value === 'company'
							: $record->type === 'company'
						)
							? static::getUrl('edit-company', ['record' => $record])
							: static::getUrl('edit-individual', ['record' => $record])
					)
					->openUrlInNewTab(false),

				\Filament\Tables\Actions\DeleteAction::make()
					->label('Видалити'),
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
			'index' => Pages\ListContacts::route('/'),
			//'create' => Pages\CreateContact::route('/create'),
			'view' => Pages\ViewContact::route('/{record}'),
			//'edit' => Pages\EditContact::route('/{record}/edit'),
			'create-individual' => CreateIndividualContact::route('/create/individual'),
			'create-company' => CreateCompanyContact::route('/create/company'),
			'edit-individual' => Pages\EditIndividualContact::route('/{record}/edit-individual'),
			'edit-company' => Pages\EditCompanyContact::route('/{record}/edit-company'),			
		];
	}

	public static function getEloquentQuery(): Builder
	{
		return parent::getEloquentQuery()
			->with([
				'group',
				'documents.media',
				'methods',
			])
			->withoutGlobalScopes([
				SoftDeletingScope::class,
			]);
	}
}
