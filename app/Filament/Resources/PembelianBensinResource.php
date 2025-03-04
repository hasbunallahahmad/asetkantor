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
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Select::make('kendaraan_id')
                            ->label('Kendaraan')
                            ->relationship('kendaraan', 'plat_nomor')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            // ->dehydrated(false)
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $kendaraan = Kendaraan::find($state);
                                    if ($kendaraan) {

                                        //mengambil jenis kendaraan 
                                        $set('jenis_kendaraan', $kendaraan->jenis);

                                        //mengambil tahun pengadaan kendaraan
                                        $tahun = $kendaraan->tahun ?? $kendaraan->tahun_pengadaan ?? '';
                                        $set('tahun_pengadaan', $tahun);

                                        //mengambil informasi merk kendaraan 
                                        $set('merk', $kendaraan->merk);

                                        //set pengguna kendaraan
                                        // $set('pengguna_id', $kendaraan->pemegang);
                                        if (isset($kendaraan->pemegang)) {
                                            $set('pengguna_id', $kendaraan->pemegang);
                                        } elseif ($kendaraan->pengguna) {
                                            $set('pengguna_id', $kendaraan->pengguna->nama ?? '');
                                        } else {
                                            $set('pengguna_id', '');
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
                                        // Ambil jumlah roda kendaraan dari database
                                        $jumlahRoda = $kendaraan->jenisKendaraan->jumlah_roda ?? 0;

                                        // // Jika kendaraan roda 2 maka 1 liter, jika roda 4 maka 7 liter
                                        // $jatahPerHari = ($jumlahRoda == 2) ? 1 : 7;

                                        // $jenisKendaraan = $kendaraan->jenisKendaraan;
                                        // $jatahPerHari = 1;
                                        // if ($jenisKendaraan && isset($jenisKendaraan->jumlah_roda)) {
                                        //     // Set 1 liter for 2-wheelers, 7 liters for 4-wheelers
                                        //     $jatahPerHari = ($jenisKendaraan->jumlah_roda == 2) ? 1 : 7;
                                        // }

                                        // $set('jatah_liter_per_hari', $jatahPerHari);
                                        // Calculate monthly quota based on the current month
                                        // $bulan = date('n'); // Current month if none selected
                                        // $tahun = date('Y'); // Current year if none selected
                                        // $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                        // $jatahPerBulan = $jatahPerHari * $daysInMonth;

                                        // $set('jatah_liter_per_bulan', $jatahPerBulan)
                                    }
                                }
                            }),
                        Forms\Components\TextInput::make('jenis_kendaraan')
                            ->label('Jenis Kendaraan')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('tahun_pengadaan')
                            ->label('Tahun Kendaraan')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('merk')
                            ->label('Merk Kendaraan')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('pengguna_id')
                            ->label('Pemegang')
                            ->disabled()
                            ->dehydrated(false),
                    ]),
                Forms\Components\Grid::make('6')
                    ->schema([
                        Forms\Components\Select::make('bulan')
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
                            ->required(),
                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun Periode')
                            ->numeric()
                            ->required()
                            ->default(date('Y')),
                        Forms\Components\TextInput::make('jatah_liter_per_hari')
                            ->label('Jatah Liter Per Hari')
                            ->numeric()
                            ->disabled(),
                        // ->reactive()
                        // ->afterStateUpdated(function (callable $set, callable $get) {
                        //     $set('jumlah_liter', (int) $get('jatah_liter_per_hari') * (int) $get('jatah_liter_per_bulan'));
                        // })
                        // ->required(),
                        Forms\Components\TextInput::make('jatah_liter_per_bulan')
                            ->label('Jatah Liter Per Bulan')
                            // ->numeric()
                            // // ->reactive()
                            // // ->afterStateUpdated(function (callable $set, callable $get) {
                            // //     $set('jumlah_liter', (int) $get('jatah_liter_per_hari') * (int) $get('jatah_liter_per_bulan'));
                            // // })
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                //menghitung kalkulasi
                                $jatahPerHari = $get('jatah_liter_per_hari');
                                $jatahPerBulan = $get('jatah_liter_per_bulan');
                                if ($jatahPerHari && $jatahPerBulan) {
                                    $set('jumlah_liter', $jatahPerHari * $jatahPerBulan);
                                }
                            }),
                        Forms\Components\Select::make('jenis_bbm')
                            ->label('Jenis BBM')
                            ->options([
                                'PERTAMAX' => 'PERTAMAX',
                                'PERTAMAX DEX' => 'PERTAMAX DEX',
                                'PERTALITE' => 'PERTALITE',
                                'SOLAR' => 'SOLAR'
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('jumlah_liter')
                            ->label('Jumlah Liter')
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $jumlahLiter = $get('jumlah_liter');
                                $hargaPerLiter = $get('harga_per_liter');
                                if ($jumlahLiter && $hargaPerLiter) {
                                    $set('jumlah_harga', $jumlahLiter * $hargaPerLiter);
                                }
                            }),
                    ]),

                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('harga_per_liter')
                            ->label('Harga Per Liter (Rp)')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $jumlahLiter = $get('jumlah_liter');
                                $hargaPerLiter = $get('harga_per_liter');
                                if ($jumlahLiter && $hargaPerLiter) {
                                    $set('jumlah_harga', $jumlahLiter * $hargaPerLiter);
                                }
                            }),
                        Forms\Components\TextInput::make('jumlah_harga')
                            ->label('Jumlah Harga (Rp)')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->disabled(),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.jenis')
                    ->label('Jenis Kendaraan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.tahun')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.merk')
                    ->label('Merk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.plat_nomor')
                    ->label('No. Polisi')
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
                    ->label('1 Liter')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_harga')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pengguna.nama')
                    ->label('Pemegang')
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
            ->defaultSort('created_at', 'desc');
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
