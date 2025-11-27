<?php

namespace App\Filament\Resources\Geography\ProvinceResource\Pages;

use App\Filament\Resources\Geography\ProvinceResource\ProvinceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProvinces extends ManageRecords
{
    protected static string $resource = ProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('New Provinsi'),
        ];
    }
}
