<?php
namespace App\Filament\Resources\SociaEco\WorkResource;


use Filament\Forms;
use App\Models\Work;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WorkResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WorkResource\RelationManagers;
use App\Filament\Resources\SociaEco\WorkResource\Pages\ManageWorks;

class WorkResource extends Resource
{
    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('admin') ?? false;
    }

    protected static ?string $pluralLabel = 'Pekerjaan'; // Tittle Page

    protected static ?string $model = Work::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Pekerjaan';
    public static ?int $navigationSort = 6;
    protected static ?string $navigationGroup = 'Sosial Ekonomi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pekerjaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('score_work')
                    ->label('Skor Pekerjaan')
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
                    ->label('Nama Pekerjaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score_work')
                    ->label('Skor Pekerjaan')
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
            'index' => ManageWorks::route('/'),
        ];
    }
}
