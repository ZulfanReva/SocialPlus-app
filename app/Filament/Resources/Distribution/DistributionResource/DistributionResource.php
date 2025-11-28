<?php

namespace App\Filament\Resources\Distribution\DistributionResource;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Distribution;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DistributionResource\Pages;
use App\Filament\Resources\DistributionResource\RelationManagers;
use App\Filament\Resources\Distribution\DistributionResource\Pages\EditDistribution;
use App\Filament\Resources\Distribution\DistributionResource\Pages\ListDistributions;
use App\Filament\Resources\Distribution\DistributionResource\Pages\CreateDistribution;

class DistributionResource extends Resource
{

    protected static ?string $pluralLabel = 'Data Penyaluran'; // Tittle Page

    protected static ?string $model = Distribution::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Data Penyaluran';
    public static ?int $navigationSort = 13;
    protected static ?string $navigationGroup = 'Penyaluran Bantuan Sosial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDistributions::route('/'),
            'create' => CreateDistribution::route('/create'),
            'edit' => EditDistribution::route('/{record}/edit'),
        ];
    }
}
