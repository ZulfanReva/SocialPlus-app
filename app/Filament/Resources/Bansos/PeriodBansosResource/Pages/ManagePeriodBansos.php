<?php

namespace App\Filament\Resources\Bansos\PeriodBansosResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Bansos\PeriodBansosResource\PeriodBansosResource;

class ManagePeriodBansos extends ManageRecords
{
    protected static string $resource = PeriodBansosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
