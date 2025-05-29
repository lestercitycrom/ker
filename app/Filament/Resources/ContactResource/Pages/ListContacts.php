<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use App\Models\ContactGroup;

class ListContacts extends ListRecords
{
	protected static string $resource = ContactResource::class;

	protected function getHeaderActions(): array
	{
		return [
			ActionGroup::make([
				Actions\Action::make('individual')
					->label('Фізособа')
					->icon('heroicon-o-user')
					->url(static::getResource()::getUrl('create-individual')),

				Actions\Action::make('company')
					->label('Компанія')
					->icon('heroicon-o-building-office')
					->url(static::getResource()::getUrl('create-company')),

				// Новый Action для создания группы контактов
				Actions\Action::make('create_group')
					->label('Група')
					->icon('heroicon-o-tag')
					->modalHeading('Створити групу контактів')
					->form([
						TextInput::make('name')
							->label('Назва')
							->required()
							->maxLength(255),
					])
					->action(function (array $data) {
						// Создание новой группы контактов
						ContactGroup::create([
							'name' => $data['name'],
						]);
					})
					->successNotificationTitle('Групу створено!'),
			])
				->label('Створити')
				->icon('heroicon-m-ellipsis-vertical')
				->iconPosition('after')
				->button(),
		];
	}
}
