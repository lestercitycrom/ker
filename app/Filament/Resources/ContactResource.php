<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Media Library
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

// Ввод контакта
use App\Enums\ContactMethodType;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

	public static function form(Form $form): Form
	{
		return $form->schema([
			// Переменная type (hidden): управляет видимостью полей
			Forms\Components\Hidden::make('type')
				->default('individual')
				->reactive(),

			Forms\Components\Tabs::make('contact_tabs')
				->persistTabInQueryString()
				->tabs([
					Forms\Components\Tabs\Tab::make('Фізособа')
						->schema([
							// При входе на вкладку — выставляем type
							Forms\Components\Hidden::make('type')
								->default('individual')
								->afterStateHydrated(function ($component, $state, $record) {
									if (blank($state)) {
										$component->state('individual');
									}
								}),

							...self::commonFields(),

							Forms\Components\Select::make('gender')
								->label('Стать')
								->options([
									1 => 'Чоловіча',
									2 => 'Жіноча',
									3 => 'Не вказано',
								])
								->required(fn ($get) => $get('type') === 'individual'),

							Forms\Components\DatePicker::make('birthday')
								->label('Дата народження')
								->required(fn ($get) => $get('type') === 'individual'),
						])->columns(3),

					Forms\Components\Tabs\Tab::make('Компанія')
						->schema([
							Forms\Components\Hidden::make('type')
								->default('company')
								->afterStateHydrated(function ($component, $state, $record) {
									if (blank($state)) {
										$component->state('company');
									}
								}),

							...self::commonFields(),

							Forms\Components\TextInput::make('company_name')
								->label('Назва компанії')
								->required(fn ($get) => $get('type') === 'company'),

							Forms\Components\TextInput::make('contact_person')
								->label('Контактна особа'),

							Forms\Components\TextInput::make('registration_number')
								->label('Реєстраційний номер'),

							Forms\Components\TextInput::make('vat_number')
								->label('VAT номер'),

							Forms\Components\TextInput::make('website')
								->label('Веб-сайт'),
						])->columns(3),
				])
				->columnSpanFull(),
		]);
	}

	/**
	 * Общие поля для контактів.
	 * @return array
	 */
	protected static function commonFields(): array
	{
		return [
			SpatieMediaLibraryFileUpload::make('photo')
				->label('Фото')
				->image()
				->imageEditor()
				->maxSize(10240)
				->collection('photo')
				//->columnSpanFull()
				,

			Forms\Components\TextInput::make('first_name')
				->label('Ім’я')
				->required()
				->maxLength(255),

			Forms\Components\TextInput::make('last_name')
				->label('Прізвище')
				->maxLength(255),

			Forms\Components\Select::make('group_id')
				->label('Група')
				->relationship('group', 'name')
				->required(),

			Forms\Components\TextInput::make('email')
				->label('Email')
				->email()
				->maxLength(255),

			Forms\Components\TextInput::make('phone')
				->label('Телефон')
				->tel()
				->maxLength(255),

			Forms\Components\Textarea::make('notes')
				->label('Примітки')
				->columnSpanFull(),

			// Адрес
			Forms\Components\TextInput::make('country')
				->label('Країна')
				->maxLength(255),
			Forms\Components\TextInput::make('state')
				->label('Область')
				->maxLength(255),
			Forms\Components\TextInput::make('city')
				->label('Місто')
				->maxLength(255),
			Forms\Components\TextInput::make('street')
				->label('Вулиця')
				->maxLength(255),
			Forms\Components\TextInput::make('building')
				->label('Будинок')
				->maxLength(255),
			Forms\Components\TextInput::make('zip')
				->label('Поштовий індекс')
				->maxLength(255),
				
			Repeater::make('methods')
				->label('Мессенджери / способи звʼязку')
				->relationship()            // hasMany -> contact_methods
				->schema([
					Select::make('type')
						->label('Тип')
						->options(ContactMethodType::class)   // enum → ["skype"=>"Skype", …]
						->required(),

					TextInput::make('value')
						->label('Логін / номер')
						->required()
						->maxLength(255),
				])
				->addActionLabel('Додати контакт')  // подпись кнопки «+»
				->columns(2)                        // две колонки в строке
				->defaultItems(0)                   // старт без строк
				->deletable()                       // иконка корзины по умолчанию
				->reorderable()                     // перетаскивание ↑↓
				->columnSpanFull(),
				
				
				
		];
	}







    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('group.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_person')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vat_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('birthday')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('building')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
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
