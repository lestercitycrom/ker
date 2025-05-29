<?php

namespace App\Filament\Resources\ContactResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;
use App\Filament\Resources\ContactResource;
use App\Filament\Forms\Traits\ContactFormSchema;


class CreateIndividualContact extends CreateRecord
{
    use ContactFormSchema;

    protected static string $resource = ContactResource::class;

    // Заголовок сторінки
    protected static ?string $title = 'Створення індивідуального контакту';

    // Назва в хлібних крихтах
    protected static ?string $breadcrumb = 'Контакти';

    public function getTitle(): string
    {
        return static::$title;
    }

    public function getBreadcrumb(): string
    {
        return static::$breadcrumb;
    }

    public function form(Form $form): Form
    {
        return $this->formIndividual($form);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

}
