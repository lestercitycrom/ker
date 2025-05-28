<?php

namespace App\Filament\Resources\MaintenanceScheduleResource\Pages;

use App\Filament\Resources\MaintenanceScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceSchedule extends EditRecord
{
    protected static string $resource = MaintenanceScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
	
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }	
}
