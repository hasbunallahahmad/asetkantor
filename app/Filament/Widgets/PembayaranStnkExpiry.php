<?php

namespace App\Filament\Widgets;

use App\Models\PembayaranStnk;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PembayaranStnkExpiry extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
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
