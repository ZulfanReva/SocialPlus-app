<?php

namespace App\Filament\Resources\Bansos\ProgramBansosResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Bansos\ProgramBansosResource\ProgramBansosResource;

class ManageProgramBansos extends ManageRecords
{
    protected static string $resource = ProgramBansosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
