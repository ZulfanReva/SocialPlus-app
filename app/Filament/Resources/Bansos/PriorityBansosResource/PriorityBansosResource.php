<?php

namespace App\Filament\Resources\Bansos\PriorityBansosResource;


use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PriorityBansos;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PriorityBansosResource\Pages;
use App\Filament\Resources\PriorityBansosResource\RelationManagers;
use App\Filament\Resources\Bansos\PriorityBansosResource\Pages\ManagePriorityBansos;

class PriorityBansosResource extends Resource
{
    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('admin') ?? false;
    }

    protected static ?string $pluralLabel = 'Prioritas Bansos'; // Tittle Page

    protected static ?string $model = PriorityBansos::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Prioritas Bansos';
    public static ?int $navigationSort = 11;
    protected static ?string $navigationGroup = 'Bantuan Sosial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('score_min')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score_min')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => ManagePriorityBansos::route('/'),
        ];
    }
}
