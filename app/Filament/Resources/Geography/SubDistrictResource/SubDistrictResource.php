<?php

namespace App\Filament\Resources\Geography\SubDistrictResource;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SubDistrict;
use App\Models\District;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubDistrictResource\RelationManagers;
use App\Filament\Resources\Geography\SubDistrictResource\Pages\ManageSubDistricts;

class SubDistrictResource extends Resource
{
    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('admin') ?? false;
    }

    protected static ?string $pluralLabel = 'Kelurahan'; // Tittle Page

    protected static ?string $model = SubDistrict::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'Kelurahan';

    public static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Geografi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('district_id')
                    ->relationship('district', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('district.name')
                    ->label('Kecamatan'),
            ])
            ->filters([
                SelectFilter::make('district_id')
                    ->label('Kecamatan')
                    ->placeholder('All Kecamatan')
                    ->options(District::pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSubDistricts::route('/'),
        ];
    }
}
