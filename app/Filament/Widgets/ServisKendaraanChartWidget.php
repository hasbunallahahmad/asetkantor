<?php

namespace App\Filament\Widgets;

use App\Models\ServisKendaraan;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ServisKendaraanChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Biaya Servis Kendaraan';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = ServisKendaraan::select(
            DB::raw('MONTH(tanggal_servis) as month'),
            DB::raw('YEAR(tanggal_servis) as year'),
            DB::raw('SUM(biaya) as total_biaya')
        )
            ->whereYear('tanggal_servis', Carbon::now()->year)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $months = [];
        $totals = [];

        foreach ($data as $item) {
            $monthName = Carbon::createFromDate($item->year, $item->month, 1)->translatedFormat('F');
            $months[] = $monthName;
            $totals[] = $item->total_biaya;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Biaya Servis',
                    'data' => $totals,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#2196F3',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "Rp " + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }',
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return "Biaya: Rp " + context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }',
                    ],
                ],
            ],
        ];
    }
}
