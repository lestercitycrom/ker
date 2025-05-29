<?php

namespace App\Filament\Resources\ViolationResource\Pages;

use App\Filament\Resources\ViolationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListViolations extends ListRecords
{
    protected static string $resource = ViolationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
