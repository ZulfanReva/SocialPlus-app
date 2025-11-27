<?php

namespace App\Filament\Resources\SociaEco\IncomeResource\Pages;

use App\Filament\Resources\SociaEco\IncomeResource\IncomeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageIncomes extends ManageRecords
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
