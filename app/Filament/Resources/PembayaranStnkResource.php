<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranStnkResource\Pages;
use App\Filament\Resources\PembayaranStnkResource\RelationManagers;
use App\Models\Kendaraan;
use App\Models\Pengeluaran;
use App\Models\PembayaranStnk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Get;
use Filament\Forms\Set;
// use Filament\Resources\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Card;

class PembayaranStnkResource extends Resource
{
    protected static ?string $model = PembayaranStnk::class;
    protected static ?string $navigationIcon = 'heroicon-c-identification';
    protected static ?string $navigationGroup = 'Cash Flow';
    protected static ?int $navigationSort = 2;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // Format awal Halaman Form input 
                // Forms\Components\Grid::make(2)
                //     ->schema([
                //         Forms\Components\Select::make('kendaraan_id')
                //             ->relationship('kendaraan', 'plat_nomor')
                //             ->required()
                //             ->searchable()
                //             ->preload(),
                //         Forms\Components\DatePicker::make('tanggal_bayar')
                //             ->label('Tanggal Pembayaran')
                //             ->required(),
                //         Forms\Components\TextInput::make('biaya')
                //             ->label('Biaya')
                //             ->prefix('Rp')
                //             ->numeric()
                //             ->required(),
                //         Forms\Components\DatePicker::make('berlaku_hingga')
                //             ->label('Berlaku Sampai Dengan')
                //             ->disabled()
                //             ->default(fn($get) => $get('tanggal_bayar')
                //                 ? \Carbon\Carbon::parse($get('tanggal_bayar')->addYear()->format('Y-m-d')) : null),
                //         Forms\Components\Textarea::make('keterangan')
                //             ->label('Keterangan')
                //             ->columnSpan(2),
                // ])


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
                                    ->columnSpan(2),

                                DatePicker::make('tanggal_bayar')
                                    ->label('Tanggal Pembayaran')
                                    ->required()
                                    ->default(now())
                                    ->columnSpan(1),
                            ])
                            ->columns(3),

                        Grid::make()
                            ->schema([
                                TextInput::make('biaya')
                                    ->label('Biaya Pembayaran')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required()
                                    ->columnSpan(1),

                                Select::make('jenis_pembayaran')
                                    ->label('Jenis Pembayaran')
                                    ->options([
                                        'TNKB' => 'Pembayaran TNKB (5 Tahun)',
                                        'STNK Tahunan' => 'STNK Tahunan (1 Tahun)'
                                    ])
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $tanggalBayar = $get('tanggal_bayar');
                                        $jenisPembayaran = $get('jenis_pembayaran');

                                        if ($tanggalBayar && $jenisPembayaran) {
                                            $tanggal = Carbon::parse($tanggalBayar);

                                            if ($jenisPembayaran === 'TNKB') {
                                                $set('berlaku_hingga', $tanggal->copy()->addYears(5)->format('Y-m-d'));
                                            } else {
                                                $set('berlaku_hingga', $tanggal->copy()->addYear()->format('Y-m-d'));
                                            }
                                        }
                                    })
                                    ->columnSpan(1),

                                DatePicker::make('berlaku_hingga')
                                    ->label('Berlaku Hingga')
                                    ->required()
                                    ->readOnly()
                                    ->helperText('Otomatis dihitung berdasarkan jenis pembayaran dan tanggal bayar')
                                    ->columnSpan(1),
                            ])
                            ->columns(3),
                    ]),

                Section::make('Informasi Tambahan')
                    ->description('Pengeluaran terkait dan keterangan')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('pengeluaran_id')
                                    ->label('Terkait Pengeluaran')
                                    // ->options(Pengeluaran::all()->pluck('nama', 'id'))
                                    ->searchable()
                                    ->relationship('pengeluaran', 'id')
                                    ->nullable()
                                    ->columnSpan(2),

                                Textarea::make('keterangan')
                                    ->label('Keterangan')
                                    ->nullable()
                                    ->columnSpan(2),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                // // Tampilan Format Awal Filamnet
                // TextColumn::make('kendaraan.plat_nomor')
                //     ->label('Plat Nomor')
                //     ->sortable(),
                // TextColumn::make('tanggal_bayar')
                //     ->label('Tanggal Bayar')
                //     ->date()
                //     ->sortable(),
                // TextColumn::make('biaya')
                //     ->label('Biaya')
                //     ->money('IDR')
                //     ->sortable(),
                // TextColumn::make('berlaku_hingga')
                //     ->label('Berlaku Hingga')
                //     ->date()
                //     ->sortable(),

                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('kendaraan.plat_nomor')
                    ->label('Nomor Plat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_pembayaran')
                    ->label('Jenis Pembayaran')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'TNKB' => 'success',
                        'STNK Tahunan' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->label('Tanggal STNK')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('biaya')
                    ->label('Biaya')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('berlaku_hingga')
                    ->label('Berlaku Hingga')
                    ->date('d M Y')
                    ->sortable()
                    ->badge()
                    ->color(
                        fn($record): string =>
                        now()->greaterThan($record->berlaku_hingga)
                            ? 'danger'
                            : (now()->addMonth()->greaterThan($record->berlaku_hingga) ? 'warning' : 'success')
                    ),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30)
                    ->state(function ($record): string {
                        $tanggalBerlaku = Carbon::parse($record->berlaku_hingga);
                        $today = Carbon::today();

                        //Jika sudah kadaluarsa
                        if ($today->isAfter($tanggalBerlaku)) {
                            return 'Sudah Kadaluarsa';
                        }

                        //Jika Hampir kadaluarsa ( 1 tahunsebelum kadaluarsa )
                        if ($today->diffInDays($tanggalBerlaku) <= 365) {
                            return 'Hampir Kadaluarsa';
                        }
                        // Jika masih aktif
                        return 'Masih Aktif';
                    })
                    ->badge() //menampilkan sebagai badge
                    ->color(function ($state): string {
                        return match ($state) {
                            'Masih Aktif ' => 'success',
                            'Hampir Kadaluarsa' => 'warning',
                            'Sudah Kadaluarsa' => 'danger',
                            default => 'gray',
                        };
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

                //Filter Awal Format Filament
                // Filter::make('tanggal_bayar')
                //     ->form([
                //         DatePicker::make('from'),
                //         DatePicker::make('until'),
                //     ])
                //     ->query(
                //         fn(Builder $query, array $data): Builder => $query
                //             ->when($data['from'], fn(Builder $query, $date): Builder => $query->whereDate('tanggal_bayar', '>=', $date))
                //             ->when($data['until'], fn(Builder $query, $date): Builder => $query->whereDate('tanggal_bayar', '<=', $date))
                //     ),

                Tables\Filters\SelectFilter::make('jenis_pembayaran')
                    ->options([
                        'TNKB' => 'Pembayaran TNKB',
                        'STNK Tahunan' => 'STNK Tahunan'
                    ]),

                Tables\Filters\Filter::make('hampir_kadaluarsa')
                    ->label('Hampir Kadaluarsa')
                    ->query(
                        fn(Builder $query): Builder =>
                        $query->where('berlaku_hingga', '<=', now()->addMonth())
                            ->where('berlaku_hingga', '>=', now())
                    ),

                Tables\Filters\Filter::make('kadaluarsa')
                    ->label('Sudah Kadaluarsa')
                    ->query(
                        fn(Builder $query): Builder =>
                        $query->where('berlaku_hingga', '<', now())
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPembayaranStnks::route('/'),
            'create' => Pages\CreatePembayaranStnk::route('/create'),
            'edit' => Pages\EditPembayaranStnk::route('/{record}/edit'),
            // 'view' => Pages\ViewPembayaranStnk::route('/{record}'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pembayaran STNK';
    }
}
