<?php

namespace App\Filament\Widgets;

use App\Models\PembelianBensin;
use App\Models\Kendaraan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PembelianBensinStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected static ?int $sort = 3;

    // Livewire lifecycle hook untuk refresh widget ketika event dipancarkan
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

        // Query untuk bulan ini
        $queryCurrentMonth = PembelianBensin::where('bulan', $currentMonth)
            ->where('tahun', $currentYear);

        // Query untuk bulan sebelumnya
        $queryPreviousMonth = PembelianBensin::where('bulan', $previousMonth)
            ->where('tahun', $previousYear);

        // Hitung total pembelian bulan ini
        $pembelianBulanIni = $queryCurrentMonth->count();
        $pembelianBulanSebelumnya = $queryPreviousMonth->count();

        // Persentase perubahan untuk pembelian
        $perubahanPembelian = $pembelianBulanSebelumnya > 0
            ? ($pembelianBulanIni - $pembelianBulanSebelumnya) / $pembelianBulanSebelumnya * 100
            : 0;

        // Total biaya bulan ini dan bulan sebelumnya
        $biayaBulanIni = $queryCurrentMonth->sum('realisasi');
        $biayaBulanSebelumnya = $queryPreviousMonth->sum('realisasi');

        // Persentase perubahan untuk biaya
        $perubahanBiaya = $biayaBulanSebelumnya > 0
            ? ($biayaBulanIni - $biayaBulanSebelumnya) / $biayaBulanSebelumnya * 100
            : 0;

        // Total pembelian keseluruhan
        $totalPembelian = PembelianBensin::count();
        $totalBiaya = PembelianBensin::sum('realisasi');

        return [
            // Stat::make('Total Pembelian BBM ' . $currentDate->translatedFormat('F Y'), $pembelianBulanIni)
            //     ->description(abs($perubahanPembelian) > 0
            //         ? number_format(abs($perubahanPembelian), 1) . '% ' . ($perubahanPembelian >= 0 ? 'naik' : 'turun') . ' dari bulan lalu'
            //         : 'Sama dengan bulan lalu')
            //     ->descriptionIcon($perubahanPembelian > 0 ? 'heroicon-m-arrow-trending-up' : ($perubahanPembelian < 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-minus'))
            //     ->color($perubahanPembelian > 0 ? 'danger' : ($perubahanPembelian < 0 ? 'success' : 'gray')),

            Stat::make('Total Biaya BBM ' . $currentDate->translatedFormat('F Y'), 'Rp ' . number_format($biayaBulanIni, 0, ',', '.'))
                ->description(abs($perubahanBiaya) > 0
                    ? number_format(abs($perubahanBiaya), 1) . '% ' . ($perubahanBiaya >= 0 ? 'naik' : 'turun') . ' dari bulan lalu'
                    : 'Sama dengan bulan lalu')
                ->descriptionIcon($perubahanBiaya > 0 ? 'heroicon-m-arrow-trending-up' : ($perubahanBiaya < 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-minus'))
                ->color($perubahanBiaya > 0 ? 'warning' : ($perubahanBiaya < 0 ? 'success' : 'gray')),

            Stat::make('Total Biaya BBM Bulan Lalu', 'Rp ' . number_format($biayaBulanSebelumnya, 0, ',', '.'))
                ->description('Total ' . $pembelianBulanSebelumnya . ' pembelian di bulan ' . $previousDate->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),

            // Stat::make('Total Pembelian BBM', $totalPembelian)
            //     ->description('Jumlah seluruh pembelian BBM yang tercatat')
            //     ->descriptionIcon('heroicon-m-document-chart-bar')
            //     ->color('gray'),

            Stat::make('Total Pengeluaran BBM', 'Rp ' . number_format($totalBiaya, 0, ',', '.'))
                ->description('Total pengeluaran BBM keseluruhan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('gray'),
        ];
    }
}
