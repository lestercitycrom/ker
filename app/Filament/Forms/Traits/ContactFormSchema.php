<?php

namespace App\Filament\Forms\Traits;

use Filament\Forms\Form;
use App\Enums\ContactDocumentType;
use App\Enums\ContactMethodType;
use App\Enums\ContactType;
use Filament\Forms\Components\{ DatePicker, Fieldset, Grid, Hidden, Repeater, Section, Select, 
SpatieMediaLibraryFileUpload, TextInput, Textarea };

/**
 * ContactFormSchema — общий набор полей для форм контактов
 */
trait ContactFormSchema
{
	
	
	
    public function formIndividual(Form $form): Form
    {
        return $form
            ->schema([
                // Персональні дані
                Fieldset::make('Загальні дані')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('photo')
                            ->label('Фото')
                            ->image()
                            ->collection('photo'),
                        TextInput::make('first_name')
                            ->label('Ім’я')
                            ->required(),
                        TextInput::make('last_name')
                            ->label('Прізвище'),
                        Select::make('group_id')
                            ->label('Група')
                            ->relationship('group', 'name')
                            ->required(),
                        Select::make('gender')
                            ->label('Стать')
                            ->options([
                                1 => 'Чол.',
                                2 => 'Жін.',
                                3 => 'Не вказано',
                            ])
                            ->required(),
                        DatePicker::make('birthday')
                            ->label('Дата народження'),
                        Hidden::make('type')
                            ->default(ContactType::Individual->value),							
							
                    ])
                    ->columns(3),

                // Контактна інформація
                Fieldset::make('Контактна інформація')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        TextInput::make('phone')
                            ->label('Телефон')
                            ->tel(),
                    ])
                    ->columns(2),

                // Адреса
                Fieldset::make('Адреса')
                    ->schema([
                        TextInput::make('city')
                            ->label('Місто'),
                        TextInput::make('street')
                            ->label('Вулиця'),
                        TextInput::make('building')
                            ->label('Будинок'),
                    ])
                    ->columns(3),


                // Примітки
                Textarea::make('notes')
                    ->label('Примітки')
                    ->columnSpanFull(),

                // Репітер: месенджери
                Section::make()
                    ->schema([
                        ...self::messengersRepeater(),
                    ]),

                // Репітер: документи
                Section::make()
                    ->schema([
                        ...self::documentsRepeater(),
                    ]),
            ]);
    }
	
	
    public function formCompany(Form $form): Form
    {
        return $form
            ->schema([
                // Загальні дані
                Fieldset::make('Загальні дані')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('photo')
                            ->label('Фото')
                            ->image()
                            ->collection('photo')
                            ->columnSpanFull(),
                        TextInput::make('company_name')
                            ->label('Назва компанії')
                            ->required(),
                        TextInput::make('first_name')
                            ->label('Ім’я водiя')
                            ->required(),
                        TextInput::make('last_name')
                            ->label('Прізвище водiя'),
                        Select::make('group_id')
                            ->label('Група')
                            ->relationship('group', 'name')
                            ->required(),
                    ])
                    ->columns(3),

                // Контактна інформація
                Fieldset::make('Контактна інформація')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        TextInput::make('phone')
                            ->label('Телефон')
                            ->tel(),
                        TextInput::make('website')
                            ->label('Сайт'),
                    ])
                    ->columns(3),

                // Адреса
                Fieldset::make('Адреса')
                    ->schema([
                        TextInput::make('city')
                            ->label('Місто'),
                        TextInput::make('street')
                            ->label('Вулиця'),
                        TextInput::make('building')
                            ->label('Будинок'),
                    ])
                    ->columns(3),

                // Податкові дані
                Fieldset::make('Податкові дані')
                    ->schema([
                        TextInput::make('registration_number')
                            ->label('Реєстраційний №'),
                        TextInput::make('vat_number')
                            ->label('VAT'),
                    ])
                    ->columns(2),

                // Додаткова інформація
                Fieldset::make('Додаткова інформація')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Примітки')
                            ->columnSpanFull(),
                        DatePicker::make('birthday')
                            ->label('Дата заснування'),
                        Hidden::make('type')
                            ->default(ContactType::Company->value),
                    ])
                    ->columns(3),

                // Репітер: месенджери
                Section::make()
                    ->schema([
                        ...self::messengersRepeater(),
                    ]),

                // Репітер: документи
                Section::make()
                    ->schema([
                        ...self::documentsRepeater(),
                    ]),
            ]);
    }
	
	
	
	/**
	 * Repeater for contact methods (messengers, phone, email и т.п.).
	 *
	 * @return array<int, \Filament\Forms\Components\Repeater>
	 */
	protected static function messengersRepeater(): array
	{
		return [
			Repeater::make('methods')
				->label('Месенджери')
				->relationship()
				// не создавать элементы по умолчанию, но требовать минимум 1
				->defaultItems(0)
				//->minItems(0)
				->columns(2)
				->collapsible()
				->createItemButtonLabel('Додати спосіб звʼязку')
				->schema([
					Select::make('type')
						->label('Тип')
						->options(ContactMethodType::class)
						->required(),
					TextInput::make('value')
						->label('Значення')
						->required(),
				])->grid(2),
		];
	}

	/**
	 * Repeater for contact documents with file upload and notes.
	 *
	 * @return array<int, \Filament\Forms\Components\Repeater>
	 */
	protected static function documentsRepeater(): array
	{
		return [
			Repeater::make('documents')
				->label('Документи')
				->relationship()
				// без элементов по умолчанию, минимум 1 и максимум 1
				->defaultItems(0)
				//->minItems(1)->maxItems(1)
				->collapsible()
				->createItemButtonLabel('Додати документ')
				->schema([

							// Правый столбец: все остальные поля
							Grid::make()
								->schema([
									Select::make('type')
										->label('Тип документа')
										->options(ContactDocumentType::class)
										->required(),
									TextInput::make('number')
										->label('Номер'),
									DatePicker::make('issue_date')
										->label('Дата видачі'),
									DatePicker::make('exp_date')
										->label('Термін дії'),
									Textarea::make('notes')
										->label('Нотатки')
										->columnSpan(2),
								])
								->columns(2),
								//->columnSpan(1),

							SpatieMediaLibraryFileUpload::make('files')
								->label('Файли')
								->collection('files')
								->multiple()
								->enableReordering()
								->disk('public')
								->acceptedFileTypes(['image/*', 'application/pdf'])
								->columnSpan(1),

				])->grid(2),
		];
	}
}
