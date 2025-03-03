<?php

namespace App\Filament\Widgets;

use App\Models\PembayaranStnk;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PembayaranStnkExpiry extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    protected function getTableHeading(): string
    {
        return 'STNK yang Akan Segera Kadaluarsa';
    }
    public function table(Table $table): Table
    {
        // Ambil filter dari session
        $filters = Session::get('dashboard_filters', []);

        // Buat query dasar
        $query = PembayaranStnk::query()
            ->where('berlaku_hingga', '>=', now())
            ->where('berlaku_hingga', '<=', now()->addMonths(3));

        // Terapkan filter plat nomor jika ada
        if (!empty($filters['plat_nomor'])) {
            $query->where('kendaraan_id', $filters['plat_nomor']);
        }

        // Jika filter bulan ada, ambil data dari bulan tersebut
        if (!empty($filters['bulan'])) {
            $filterDate = Carbon::createFromFormat('Y-m', $filters['bulan']);
            $query->whereMonth('tanggal_bayar', $filterDate->month)
                ->whereYear('tanggal_bayar', $filterDate->year);
        }
        return $table
            ->query(
                // ...
                PembayaranStnk::query()
                    ->where('berlaku_hingga', '>=', now())
                    ->where('berlaku_hingga', '<=', now()->addMonths(3))
                    ->orderBy('berlaku_hingga')
            )
            ->columns([
                // ...
                Tables\Columns\TextColumn::make('kendaraan.nomor_plat')
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
                    }),

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

                Tables\Columns\TextColumn::make('biaya')
                    ->label('Biaya Terakhir')
                    ->money('IDR'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(
                        fn(PembayaranStnk $record): string =>
                        route('filament.admin.resources.pembayaran-stnks.view', ['record' => $record])
                    )
                    ->icon('heroicon-o-eye'),
            ])
            ->emptyStateHeading('Tidak ada pembayaran yang akan kadaluarsa dalam 3 bulan ke depan');
    }
}
