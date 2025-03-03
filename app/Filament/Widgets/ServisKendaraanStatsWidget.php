<?php

namespace App\Filament\Widgets;

use App\Models\ServisKendaraan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class ServisKendaraanStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Total servis bulan ini
        $servisBulanIni = ServisKendaraan::whereMonth('tanggal_servis', $currentMonth)
            ->whereYear('tanggal_servis', $currentYear)
            ->count();

        // Total biaya bulan ini
        $biayaBulanIni = ServisKendaraan::whereMonth('tanggal_servis', $currentMonth)
            ->whereYear('tanggal_servis', $currentYear)
            ->sum('biaya');

        // Rata-rata biaya per servis
        $rataBiaya = ServisKendaraan::avg('biaya');

        return [
            Stat::make('Total Servis Bulan Ini', $servisBulanIni)
                ->description('Jumlah servis di bulan ' . Carbon::now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('primary'),

            Stat::make('Total Biaya Bulan Ini', 'Rp ' . number_format($biayaBulanIni, 0, ',', '.'))
                ->description('Total pengeluaran untuk servis bulan ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Rata-rata Biaya Servis', 'Rp ' . number_format($rataBiaya, 0, ',', '.'))
                ->description('Rata-rata biaya per servis kendaraan')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('warning'),
        ];
    }
}
