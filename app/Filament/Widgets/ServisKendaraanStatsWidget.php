<?php

namespace App\Filament\Widgets;

use App\Models\ServisKendaraan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ServisKendaraanStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '60s';

    protected function getListeners(): array
    {
        return [
            'refreshDashboard' => '$refresh',
        ];
    }
    protected function getStats(): array
    {
        // Ambil filter dari session
        $filters = Session::get('dashboard_filters', []);

        // Set default bulan dan tahun jika tidak ada filter
        $currentDate = isset($filters['bulan'])
            ? Carbon::createFromFormat('Y-m', $filters['bulan'])
            : Carbon::now();

        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        // Periode bulan sebelumnya untuk perbandingan
        $previousDate = $currentDate->copy()->subMonth();
        $previousMonth = $previousDate->month;
        $previousYear = $previousDate->year;

        // Total servis bulan ini
        $servisBulanIni = ServisKendaraan::whereMonth('tanggal_servis', $currentMonth)
            ->whereYear('tanggal_servis', $currentYear)
            ->count();

        // Total servis bulan sebelumnya
        $servisBulanLalu = ServisKendaraan::whereMonth('tanggal_servis', $previousMonth)
            ->whereYear('tanggal_servis', $previousYear)
            ->count();

        // Total biaya bulan ini
        $biayaBulanIni = ServisKendaraan::whereMonth('tanggal_servis', $currentMonth)
            ->whereYear('tanggal_servis', $currentYear)
            ->sum('biaya');

        $biayaBulanLalu = ServisKendaraan::whereMonth('tanggal_servis', $previousMonth)
            ->whereYear('tanggal_servis', $previousYear)
            ->sum('biaya');

        // Rata-rata biaya per servis
        $rataBiaya = ServisKendaraan::avg('biaya');

        // Total servis keseluruhan
        // $totalServis = $biayaBulanIni +  +$rataBiaya;
        $totalServis = ServisKendaraan::count();

        // Total biaya keseluruhan
        $totalBiaya = ServisKendaraan::sum('biaya');
        return [
            // Stat::make('Total Servis Bulan Ini', $servisBulanIni)
            //     ->description('Jumlah servis di bulan ' . $currentDate->translatedFormat('F'))
            //     ->descriptionIcon('heroicon-m-wrench-screwdriver')
            //     ->color('primary'),

            Stat::make('Total Biaya Servis Bulan Ini', 'Rp ' . number_format($biayaBulanIni, 0, ',', '.'))
                ->description('Total pengeluaran untuk servis bulan ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            // Stat::make('Rata-rata Biaya Servis', 'Rp ' . number_format($rataBiaya, 0, ',', '.'))
            //     ->description('Rata-rata biaya per servis kendaraan')
            //     ->descriptionIcon('heroicon-m-calculator')
            //     ->color('warning'),

            Stat::make('Total Biaya Servis Bulan Lalu', 'Rp ' . number_format($biayaBulanLalu, 0, ',', '.'))
                ->description('Jumlah servis di bulan ' . $previousDate->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),

            Stat::make('Total Servis', 'Rp ' . number_format($totalBiaya, 0, ',', '.'))
                ->description('Jumlah seluruh servis yang tercatat')
                ->descriptionIcon('heroicon-m-document-chart-bar')
                ->color('gray'),
        ];
    }
}
