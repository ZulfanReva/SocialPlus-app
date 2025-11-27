<?php

namespace App\Filament\Resources\SociaEco\RelationshipResource;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Relationship;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RelationshipResource\Pages;
use App\Filament\Resources\RelationshipResource\RelationManagers;
use App\Filament\Resources\SociaEco\RelationshipResource\Pages\ManageRelationships;

class RelationshipResource extends Resource
{
    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('admin') ?? false;
    }

    protected static ?string $pluralLabel = 'Status Hubungan'; // Tittle Page

    protected static ?string $model = Relationship::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Status Hubungan';
    public static ?int $navigationSort = 8;
    protected static ?string $navigationGroup = 'Sosial Ekonomi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Hubungan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('score_relationship')
                    ->label('Skor Hubungan')
                    ->required()
                    ->numeric()
                    ->integer(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Hubungan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score_relationship')
                    ->label('Skor Hubungan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
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
            'index' => ManageRelationships::route('/'),
        ];
    }
}
