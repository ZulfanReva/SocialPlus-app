<?php

namespace App\Filament\Resources\SociaEco\WorkResource\Pages;

use App\Filament\Resources\SociaEco\WorkResource\WorkResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWorks extends ManageRecords
{
    protected static string $resource = WorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
