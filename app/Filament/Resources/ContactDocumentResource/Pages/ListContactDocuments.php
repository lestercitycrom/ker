<?php

namespace App\Filament\Resources\ContactDocumentResource\Pages;

use App\Filament\Resources\ContactDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactDocuments extends ListRecords
{
    protected static string $resource = ContactDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
