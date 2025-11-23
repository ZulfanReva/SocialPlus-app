<?php

namespace App\Filament\Resources\Geography\SubDistrictResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Geography\SubDistrictResource\SubDistrictResource;

class ManageSubDistricts extends ManageRecords
{
    protected static string $resource = SubDistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Create Kelurahan'),
        ];
    }
}
