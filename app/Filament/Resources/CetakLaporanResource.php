<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CetakLaporanResource\Pages\ListCetakLaporans;
use App\Models\PembelianBensin;
use App\Models\ServisKendaraan;
use App\Filament\Resources\CetakLaporanResource\Pages;
use App\Filament\Resources\CetakLaporanResource\RelationManagers;
use App\Models\CetakLaporan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CetakLaporanResource extends Resource
{
    protected static ?string $model = PembelianBensin::class; // Default ke BBM, bisa diubah di Page
    protected static ?string $navigationIcon = 'heroicon-m-document-arrow-down';
    protected static ?string $navigationGroup = 'Laporan & Export (Sedang Dalam Perbaikan)';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             //
    //         ]);
    // }
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Menu tidak akan muncul di sidebar
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('tanggal_beli')->label('Tanggal')->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.plat_nomor')
                    ->label('Plat Nomor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_liter')
                    ->label('Jumlah Liter')
                    ->numeric(decimalPlaces: 2),
                Tables\Columns\TextColumn::make('harga_per_liter')
                    ->label('Harga/Liter')
                    ->numeric(
                        decimalPlaces: 0,
                        // prefix: 'Rp.',
                        thousandsSeparator: '.',
                    ),
                Tables\Columns\TextColumn::make('jumlah_harga')
                    ->label('Total Harga')
                    ->numeric(
                        decimalPlaces: 0,
                        // prefix: 'Rp.',
                        thousandsSeparator: '.',
                    ),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('bulan')
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
                        12 => 'Desember'
                    ])
                    ->label('Bulan'),
                Tables\Filters\SelectFilter::make('tahun')
                    ->options(fn() => array_combine(range(date('Y') - 5, date('Y')), range(date('Y') - 5, date('Y'))))
                    ->label('Tahun'),
            ])
            ->actions([
                Tables\Actions\Action::make('Export PDF')
                    ->label('PDF')
                    ->icon('heroicon-m-printer')
                    ->url(fn() => route('export.pdf.bbm'))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('Export Excel')
                    ->label('Excel')
                    ->icon('heroicon-m-printer')
                    ->url(fn() => route('export.excel.bbm'))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         //
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCetakLaporans::route('/'),
            // 'create' => Pages\CreateCetakLaporan::route('/create'),
            // 'edit' => Pages\EditCetakLaporan::route('/{record}/edit'),
        ];
    }
}
