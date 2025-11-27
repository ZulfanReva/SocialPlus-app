<?php

namespace App\Filament\Resources\SociaEco\RelationshipResource\Pages;

use App\Filament\Resources\SociaEco\RelationshipResource\RelationshipResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRelationships extends ManageRecords
{
    protected static string $resource = RelationshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
