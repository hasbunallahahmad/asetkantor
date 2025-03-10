<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelianBensinResource\Pages;
use App\Filament\Resources\PembelianBensinResource\RelationManagers;
use App\Models\PembelianBensin;
use App\Models\Kendaraan;
use App\Models\Pengguna;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use function Livewire\on;

class PembelianBensinResource extends Resource
{
    protected static ?string $model = PembelianBensin::class;
    protected static ?string $navigationIcon = 'heroicon-c-battery-50';
    protected static ?string $navigationGroup = 'Cash Flow';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Penerimaan BBM Kendaraan Dinas';
    protected static ?string $pluralModelLabel = 'Penerimaan BBM Kendaraan Dinas';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Kendaraan & Pembayaran')
                    ->description('Detail kendaraan dan informasi pembayaran')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('kendaraan_id')
                                    ->label('Kendaraan')
                                    ->relationship('kendaraan', 'plat_nomor')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->reactive()
                                    ->columnSpan(2)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $kendaraan = Kendaraan::find($state);
                                            if ($kendaraan) {

                                                $set('jenis_kendaraan', $kendaraan->jenis);


                                                $tahun = $kendaraan->tahun ?? $kendaraan->tahun_pengadaan ?? '';
                                                $set('tahun_pengadaan', $tahun);

                                                $set('merk', $kendaraan->merk);


                                                if (isset($kendaraan->pemegang)) {
                                                    $set('pengguna_id', $kendaraan->pemegang);
                                                } elseif ($kendaraan->pengguna) {
                                                    $set('pengguna_id', $kendaraan->pengguna->id ?? null);
                                                } else {
                                                    $set('pengguna_id', null);
                                                }

                                                // Cek plat nomor khusus H 1676 XA
                                                if ($kendaraan->plat_nomor == 'H 1676 XA') {
                                                    // Jatah khusus 10 liter per hari
                                                    $set('jatah_liter_per_hari', 10);
                                                } else {
                                                    // Logika normal untuk kendaraan lainnya
                                                    $jumlahRoda = $kendaraan->jenisKendaraan->jumlah_roda ?? 0;
                                                    $jatahPerHari = ($jumlahRoda == 2) ? 1 : 7;
                                                    $set('jatah_liter_per_hari', $jatahPerHari);
                                                }

                                                $jumlahRoda = $kendaraan->jenisKendaraan->jumlah_roda ?? 0;
                                            }
                                        }
                                    }),

                                TextInput::make('jenis_kendaraan')
                                    ->label('Jenis Kendaraan')
                                    ->disabled()
                                    ->dehydrated(condition: true)
                                    ->columnSpan(1),
                            ])
                            ->columns(3),

                        Grid::make()
                            ->schema([
                                TextInput::make('tahun_pengadaan')
                                    ->label('Tahun Kendaraan')
                                    ->disabled()
                                    ->dehydrated(condition: true)
                                    ->columnSpan(1),
                                TextInput::make('merk')
                                    ->label('Merk Kendaraan')
                                    ->disabled()
                                    ->dehydrated(condition: true)
                                    ->columnSpan(1),
                                Select::make('pengguna_id')
                                    ->label('Pemegang')
                                    ->relationship('pengguna', 'nama') // Ini akan menampilkan nama, tetapi menyimpan ID
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
                                    ->dehydrated(condition: true)
                                    ->columnSpan(1),
                            ])
                            ->columns(3),
                    ]),

                Section::make('Informasi Bulan dan Harga BBM per Liter ')
                    ->description('Informasi pengeluaran BBM per liter')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('bulan')
                                    ->label('Bulan')
                                    ->options([
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember',
                                    ])
                                    ->required()
                                    ->columns(1),


                                TextInput::make('tahun')
                                    ->label('Tahun Pengadaan')
                                    ->numeric()
                                    ->required()
                                    ->default(date('Y'))
                                    ->columns(1),


                                TextInput::make('jatah_liter_per_hari')
                                    ->label('Jatah Liter Per Hari')
                                    ->rules('numeric')
                                    ->disabled()
                                    ->reactive()
                                    ->dehydrated(true)
                                    ->columns(1),


                                TextInput::make('jatah_liter_per_bulan')
                                    ->label('Jatah Liter Per Bulan')
                                    ->numeric()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (callable $set, callable $get) {
                                        //menghitung kalkulasi
                                        $jatahPerHari = $get('jatah_liter_per_hari');
                                        $jatahPerBulan = $get('jatah_liter_per_bulan');
                                        if ($jatahPerHari && $jatahPerBulan) {
                                            $set('jumlah_liter', $jatahPerHari * $jatahPerBulan);
                                        }
                                    })
                                    ->columns(1),


                                Select::make('jenis_bbm')
                                    ->label('Jenis BBM')
                                    ->live(onBlur: true)
                                    ->options([
                                        'PERTAMAX' => 'PERTAMAX',
                                        'PERTAMAX DEX' => 'PERTAMAX DEX',
                                        'PERTAMAX TURBO' => 'PERTAMAX TURBO',
                                        'DEXLITE' => 'DEXLITE',
                                        'PERTALITE' => 'PERTALITE',
                                        'SOLAR' => 'SOLAR'
                                    ])
                                    ->required()
                                    ->columns(1),


                                TextInput::make('jumlah_liter')
                                    ->label('Jumlah Liter')
                                    ->rules('numeric')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (callable $set, callable $get) {
                                        $jumlahLiter = $get('jumlah_liter');
                                        $hargaPerLiter = $get('harga_per_liter');
                                        if ($jumlahLiter && $hargaPerLiter) {
                                            $set('jumlah_harga', $jumlahLiter * $hargaPerLiter);
                                        }
                                    })
                                    ->columns(6),
                            ])
                            ->columns(6),

                        TextInput::make('harga_per_liter')
                            ->label('Harga Per Liter (Rp)')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->live(onBlur: true)
                            // ->reactive()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $jumlahLiter = $get('jumlah_liter');
                                $hargaPerLiter = $get('harga_per_liter');
                                if ($jumlahLiter && $hargaPerLiter) {
                                    $set('jumlah_harga', $jumlahLiter * $hargaPerLiter);
                                }
                            })
                            ->columns(6),
                        TextInput::make('jumlah_harga')
                            ->label('Jumlah Harga (Rp)')
                            ->numeric()
                            ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.'))
                            ->required()
                            ->prefix('Rp')
                            ->disabled()
                            ->live(onBlur: true)
                            ->dehydrated(true)
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $jumlahLiter = $get('jumlah_liter');
                                $hargaPerLiter = $get('harga_per_liter');
                                if ($jumlahLiter && $hargaPerLiter) {
                                    $totalBiaya = $jumlahLiter * $hargaPerLiter;
                                    $set('jumlah_harga', $totalBiaya);
                                }
                            })
                            ->columns(6),
                    ]),
                Section::make('Informasi Tambahan')
                    ->description('Pengeluaran terkati dan keterangan')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Textarea::make('keterangan')
                                    ->label('Keterangan')
                                    ->columnSpanFull(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->label('No.')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.plat_nomor')
                    ->label('No. Polisi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.jenis')
                    ->label('Jenis Kendaraan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.tahun_pengadaan')
                    ->label('Tahun Pengadaan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.merk')
                    ->label('Merk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jatah_liter_per_hari')
                    ->label('Jatah Liter/Hari')
                    ->numeric(0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('jatah_liter_per_bulan')
                    ->label('DLM 1 Bulan')
                    ->numeric(0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_bbm')
                    ->label('Jenis BBM')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_liter')
                    ->label('Jumlah Liter')
                    ->numeric(0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_per_liter')
                    ->label('Harga Per Liter')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_harga')
                    ->label('Total Biaya')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pengguna.nama')
                    ->label('Nama Pengguna')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('kendaraan_id')
                    ->label('Kendaraan')
                    ->relationship('kendaraan', 'plat_nomor'),
                Tables\Filters\SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options([
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ]),
                Tables\Filters\Filter::make('tahun')
                    ->form([
                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['tahun'],
                            fn(Builder $query, $tahun): Builder => $query->where('tahun', $tahun)
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('created_at', 'asc');
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
            'index' => Pages\ListPembelianBensins::route('/'),
            'create' => Pages\CreatePembelianBensin::route('/create'),
            'edit' => Pages\EditPembelianBensin::route('/{record}/edit'),
        ];
    }
}
