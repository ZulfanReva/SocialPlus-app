<?php

namespace App\Filament\Resources\Geography\RegencyResource\Pages;

use App\Filament\Resources\Geography\RegencyResource\RegencyResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRegencies extends ManageRecords
{
    protected static string $resource = RegencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('New Kabupaten'),
        ];
    }
}
