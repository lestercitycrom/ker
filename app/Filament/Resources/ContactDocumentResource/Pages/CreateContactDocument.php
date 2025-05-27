<?php

namespace App\Filament\Resources\ContactDocumentResource\Pages;

use App\Filament\Resources\ContactDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactDocument extends CreateRecord
{
    protected static string $resource = ContactDocumentResource::class;
}
