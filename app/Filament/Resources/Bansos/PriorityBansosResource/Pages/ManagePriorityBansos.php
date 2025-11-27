<?php

namespace App\Filament\Resources\Bansos\PriorityBansosResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Bansos\PriorityBansosResource\PriorityBansosResource;

class ManagePriorityBansos extends ManageRecords
{
    protected static string $resource = PriorityBansosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
