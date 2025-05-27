<?php

namespace App\Filament\Resources\ContactDocumentResource\Pages;

use App\Filament\Resources\ContactDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactDocument extends EditRecord
{
    protected static string $resource = ContactDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
