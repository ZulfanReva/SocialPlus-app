<?php

namespace App\Filament\Resources\Citizen\CitizenResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Citizen\CitizenResource\CitizenResource;

class ListCitizens extends ListRecords
{
    protected static string $resource = CitizenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create Data Penduduk'), // Ubah label tombol di sini
        ];
    }
}
