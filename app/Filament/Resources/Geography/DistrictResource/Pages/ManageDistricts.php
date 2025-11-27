<?php

namespace App\Filament\Resources\Geography\DistrictResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Geography\DistrictResource\DistrictResource;

class ManageDistricts extends ManageRecords
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('New Kecamatan'),
        ];
    }
}
