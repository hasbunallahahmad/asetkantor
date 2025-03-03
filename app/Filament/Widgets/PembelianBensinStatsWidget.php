<?php

namespace App\Filament\Widgets;

use App\Models\PembelianBensin;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PembelianBensinStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected static ?int $sort = 3; // Sesuaikan untuk menampilkan di sebelah widget Biaya Servis Kendaraan

    protected function getStats(): array
    {
        // Ambil filter dari session jika ada
        $filters = Session::get('dashboard_filters', []);

        // Set default bulan dan tahun jika tidak ada filter
        $currentMonth = isset($filters['bulan']) ?
            Carbon::createFromFormat('Y-m', $filters['bulan'])->month :
            Carbon::now()->month;
        $currentYear = isset($filters['bulan']) ?
            Carbon::createFromFormat('Y-m', $filters['bulan'])->year :
            Carbon::now()->year;

        // Buat query dasar
        $query = PembelianBensin::whereMonth('tanggal_pembelian', $currentMonth)
            ->whereYear('tanggal_pembelian', $currentYear);

        // Terapkan filter plat nomor jika ada
        if (!empty($filters['plat_nomor'])) {
            $query->where('kendaraan_id', $filters['plat_nomor']);
        }

        // Terapkan filter anggaran jika ada
        if (!empty($filters['anggaran'])) {
            $query->where('sumber_anggaran', $filters['anggaran']);
        }

        // Terapkan filter realisasi jika ada
        if (!empty($filters['realisasi'])) {
            if ($filters['realisasi'] === 'sudah') {
                $query->whereNotNull('tanggal_realisasi');
            } elseif ($filters['realisasi'] === 'belum') {
                $query->whereNull('tanggal_realisasi');
            }
        }

        // Hitung total pembelian bulan ini
        $pembelianBulanIni = $query->count();

        // Total liter bulan ini
        $literBulanIni = $query->sum('jumlah_liter');

        // Total biaya bulan ini
        $biayaBulanIni = $query->sum('jumlah_biaya');

        // Rata-rata harga per liter
        $rataHargaPerLiter = $literBulanIni > 0 ?
            $biayaBulanIni / $literBulanIni : 0;

        return [
            Stat::make('Total Pembelian BBM Bulan Ini', $pembelianBulanIni)
                ->description('Jumlah pembelian di bulan ' . Carbon::createFromDate($currentYear, $currentMonth, 1)->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-fire')
                ->color('danger'),

            Stat::make('Total Biaya BBM Bulan Ini', 'Rp ' . number_format($biayaBulanIni, 0, ',', '.'))
                ->description('Total pengeluaran untuk BBM bulan ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Liter BBM', number_format($literBulanIni, 1, ',', '.') . ' L')
                ->description('Harga rata-rata: Rp ' . number_format($rataHargaPerLiter, 0, ',', '.') . '/L')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('warning'),
        ];
    }
}
