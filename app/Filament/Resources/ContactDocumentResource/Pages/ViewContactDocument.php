<?php

namespace App\Filament\Resources\ContactDocumentResource\Pages;

use App\Filament\Resources\ContactDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactDocument extends ViewRecord
{
    protected static string $resource = ContactDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
