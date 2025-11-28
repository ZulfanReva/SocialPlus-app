<?php

namespace App\Filament\Resources\Citizen\CitizenResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Citizen\CitizenResource\CitizenResource;

class CreateCitizen extends CreateRecord
{
    protected static string $resource = CitizenResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    public function getTitle(): string
    {
        return 'Create Data Penduduk';
    }
}
