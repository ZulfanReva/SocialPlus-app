<?php

namespace App\Filament\Resources\Citizen\CitizenResource;


use Carbon\Carbon;
use Filament\Forms;
use App\Models\Work;
use Filament\Tables;
use App\Models\Income;
use App\Models\Citizen;
use App\Models\Regency;
use App\Models\District;
use App\Models\Province;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SubDistrict;
use App\Models\Relationship;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\Citizen\CitizenResource\Pages\EditCitizen;
use App\Filament\Resources\Citizen\CitizenResource\Pages\ListCitizens;
use App\Filament\Resources\Citizen\CitizenResource\Pages\CreateCitizen;

class CitizenResource extends Resource
{

    protected static ?string $pluralLabel = 'Data Penduduk'; // Tittle Page

    protected static ?string $model = Citizen::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Data Penduduk';
    public static ?int $navigationSort = 12;
    protected static ?string $navigationGroup = 'Kependudukan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // === DATA PRIBADI ===
                Fieldset::make('Data Pribadi')
                    ->schema([
                        TextInput::make('NIK')
                            ->label('NIK (Nomor Induk Kependudukan)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(16)
                            ->numeric()
                            ->validationMessages([
                                'required' => 'NIK wajib diisi.',
                                'unique' => 'NIK sudah didaftarkan.',
                                'maxLength' => 'NIK maksimal 16 karakter.',
                                'numeric' => 'NIK harus berupa angka.',
                            ]),

                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('place_birth')
                                    ->label('Tempat Lahir')
                                    ->required(),

                                DatePicker::make('date_birth')
                                    ->label('Tanggal Lahir')
                                    ->required()
                                    ->maxDate(now()),
                            ]),

                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan'  => 'Perempuan',
                            ])
                            ->required(),
                    ])
                    ->columns(2),   // fieldset ini pakai 2 kolom

                // === ALAMAT LENGKAP ===
                Fieldset::make('Alamat Lengkap')
                    ->schema([

                        Grid::make(2)
                            ->schema([
                                Select::make('province_id')
                                    ->label('Provinsi')
                                    ->options(Province::pluck('name', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(fn($set) => $set('regency_id', null))
                                    ->required(),

                                Select::make('regency_id')
                                    ->label('Kabupaten/Kota')
                                    ->options(
                                        fn($get) =>
                                        Regency::where('province_id', $get('province_id'))->pluck('name', 'id')
                                    )
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(fn($set) => $set('district_id', null))
                                    ->required(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('district_id')
                                    ->label('Kecamatan')
                                    ->options(
                                        fn($get) =>
                                        District::where('regency_id', $get('regency_id'))->pluck('name', 'id')
                                    )
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(fn($set) => $set('sub_district_id', null))
                                    ->required(),

                                Select::make('sub_district_id')
                                    ->label('Kelurahan/Desa')
                                    ->options(
                                        fn($get) =>
                                        SubDistrict::where('district_id', $get('district_id'))->pluck('name', 'id')
                                    )
                                    ->searchable()
                                    ->required(),
                            ]),
                        Textarea::make('address')
                            ->label('Alamat Tinggal/Domisili Sekarang (Detail)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),   // alamat lebih enak pakai 1 kolom supaya tidak terlalu sempit

                // === DATA SOSIAL EKONOMI ===
                Fieldset::make('Data Sosial & Ekonomi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('education')
                                    ->label('Pendidikan Terakhir')
                                    ->options([
                                        'Tidak Tamat SD' => 'Tidak Tamat SD',
                                        'SD'             => 'SD',
                                        'SMP'            => 'SMP',
                                        'SMA'            => 'SMA',
                                        'Diploma'        => 'Diploma',
                                        'Sarjana'        => 'Sarjana',
                                        'Lainnya'        => 'Lainnya',
                                    ])
                                    ->required(),

                                Select::make('relationship_id')
                                    ->label('Hubungan dalam Keluarga')
                                    ->options(Relationship::pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),

                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('work_id')
                                    ->label('Pekerjaan')
                                    ->options(Work::pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),

                                Select::make('income_id')
                                    ->label('Pendapatan')
                                    ->options(Income::pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Warga')
                    ->description(fn($record) => 'NIK: ' . $record->NIK) // Menampilkan NIK di baris kedua
                    ->searchable(['name', 'NIK']) // Memungkinkan pencarian berdasarkan Nama DAN NIK
                    ->sortable(),
                Tables\Columns\TextColumn::make('place_birth')
                    ->label('TTL')
                    // Menggunakan description untuk menambahkan Tanggal Lahir di bawah Tempat Lahir
                    ->description(fn($record) => \Carbon\Carbon::parse($record->date_birth)->format('d-m-Y')),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(20),
                Tables\Columns\TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('regency.name')
                    ->label('Kabupaten/Kota')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('district.name')
                    ->label('Kecamatan'),
                Tables\Columns\TextColumn::make('subDistrict.name')
                    ->label('Kelurahan/Desa'),
                Tables\Columns\TextColumn::make('education')
                    ->label('Pendidikan'),
                Tables\Columns\TextColumn::make('work.name')
                    ->label('Pekerjaan'),
                Tables\Columns\TextColumn::make('income.name')
                    ->label('Pendapatan'),
                Tables\Columns\TextColumn::make('relationship.name')
                    ->label('Hubungan Keluarga'),
                Tables\Columns\TextColumn::make('priorityBansos.label')
                    ->label('Prioritas Bansos')
                    ->badge() // Mengaktifkan mode badge
                    ->color(fn(string $state): string => match ($state) {
                        'Tinggi' => 'success', // Hijau
                        'Sedang' => 'info', // Biru
                        'Rendah' => 'danger',  // Merah
                        default => 'secondary', // Warna default jika label tidak terdaftar
                    })
                    ->formatStateUsing(fn($state) => strtoupper($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    FilamentExportBulkAction::make('export'),
                ]),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export'),
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
            'index' => ListCitizens::route('/'),
            'create' => CreateCitizen::route('/create'),
            'edit' => EditCitizen::route('/{record}/edit'),
        ];
    }
}
