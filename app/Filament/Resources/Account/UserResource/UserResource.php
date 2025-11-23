<?php

namespace App\Filament\Resources\Account\UserResource;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\District;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\Account\UserResource\Pages\EditUser;
use App\Filament\Resources\Account\UserResource\Pages\ListUsers;
use App\Filament\Resources\Account\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('admin') ?? false;
    }

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Users';

    public static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Account';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Informasi Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Masukan nama lengkap')
                            ->validationMessages([
                                'required' => 'Nama lengkap wajib diisi.',
                                'max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
                            ]),

                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Handphone')
                            ->tel()
                            ->required()
                            ->placeholder('Masukan nomor handphone')
                            ->unique(ignoreRecord: true)
                            ->minLength(8)
                            ->maxLength(12)
                            ->validationMessages([
                                'required' => 'Nomor handphone wajib diisi.',
                                'unique' => 'Nomor handphone ini sudah terdaftar.',
                                'min' => 'Nomor handphone minimal harus 10 angka.',
                                'max' => 'Nomor handphone maksimal harus 12 angka.',
                            ]),

                        Forms\Components\Select::make('district_id')
                            ->label('Kecamatan')
                            ->options(District::all()->pluck('name', 'id'))
                            // ->relationship('district', 'name')
                            ->searchable()
                            ->placeholder('Pilih Kecamatan')
                            ->required()
                            ->validationMessages([
                                'required' => 'Kecamatan wajib dipilih.',
                            ]),
                    ]),
                Fieldset::make('Informasi Akun')
                    ->schema([

                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->required()
                            ->unique(
                                table: User::class,
                                column: 'email',
                                modifyRuleUsing: function ($rule, $context, $record) {
                                    if ($context === 'edit' && $record) {
                                        return $rule->ignore($record->id);
                                    }
                                    return $rule;
                                }
                            )
                            ->maxLength(50)
                            ->placeholder('Masukan alamat email')
                            ->validationMessages([
                                'required' => 'Alamat email wajib diisi.',
                                'email' => 'Format alamat email tidak valid.',
                                'unique' => 'Alamat email ini sudah terdaftar.',
                            ]),

                        Forms\Components\TextInput::make('password')
                            ->label('Kata Sandi')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->minLength(8)
                            ->maxLength(255)
                            ->placeholder('Masukan kata sandi')
                            ->helperText('Kosongkan jika tidak ingin mengubah kata sandi (untuk edit)')
                            ->validationMessages([
                                'required' => 'Kata sandi wajib diisi.',
                                'min' => 'Kata sandi minimal harus 8 karakter.',
                            ]),

                        Forms\Components\Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'officer' => 'Officer',
                            ])
                            ->required()
                            ->default('officer'),
                        Forms\Components\Select::make('is_active')
                            ->label('Active')
                            ->label('Status User')
                            ->options([
                                true => 'Aktif',
                                false => 'Tidak Aktif',
                            ])
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex() // Nomor urut otomatis per halaman
                    ->label('No.'), // Label kolom
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nomor Handphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district.name')
                    ->label('Kecamatan')
                    ->default('N/A'),
                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'admin' => 'Admin',
                        'officer' => 'Officer',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'success',
                        'officer' => 'primary',
                    })
                    ->icon(fn(string $state) => match ($state) {
                        'admin' => 'heroicon-o-key',
                        'officer' => 'heroicon-o-building-office',
                        default => 'heroicon-o-question-mark-circle',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Tanggal Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->placeholder('All Role')
                    ->options([
                        'admin' => 'Admin',
                        'officer' => 'Officer',
                    ]),
                SelectFilter::make('district_id')
                    ->label('Kecamatan')
                    ->placeholder('All Districts')
                    ->options(District::pluck('name', 'id')),
                TernaryFilter::make('is_active')
                    ->placeholder('All Status')
                    ->label('Active'),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
