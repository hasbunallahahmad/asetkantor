<?php

namespace App\Filament\Widgets;

use App\Models\Kendaraan;
use App\Models\PembelianBensin;
use App\Models\PembayaranStnk;
use App\Models\ServisKendaraan;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class KendaraanBudgetWidget extends Widget
{
    protected static string $view = 'filament.widgets.kendaraan-budget-widget';
    protected static ?int $sort = 4;
    public ?string $filter = null;

    protected int|string|array $columnSpan = 'full';

    public function mount(): void
    {
        $this->filter = Carbon::now()->format('Y-m');
    }

    protected function getViewData(): array
    {
        $yearMonth = explode('-', $this->filter);
        $year = (int) $yearMonth[0];
        $month = (int) $yearMonth[1];

        $data = $this->calculateBudgetData($year, $month);

        return [
            'budgetData' => $data,
            'months' => $this->getMonthOptions(),
            'currentFilter' => $this->filter,
        ];
    }

    private function calculateBudgetData(int $year, int $month): Collection
    {
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        return Kendaraan::where('status', 'Aktif')
            ->get()
            ->map(function (Kendaraan $kendaraan) use ($year, $month, $startOfMonth, $endOfMonth) {
                // Monthly portion of annual budget (divided by 12)
                $monthlyBudget = $kendaraan->anggaran_tahunan;

                // Get fuel expenses for this month
                $bensinExpense = PembelianBensin::where('kendaraan_id', $kendaraan->id)
                    ->where('bulan', $month)
                    ->where('tahun', $year)
                    ->sum('realisasi');

                // Get STNK payments for this month
                $stnkExpense = PembayaranStnk::where('kendaraan_id', $kendaraan->id)
                    ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
                    ->sum('biaya');

                // Get service expenses for this month
                $servisExpense = ServisKendaraan::where('kendaraan_id', $kendaraan->id)
                    ->whereBetween('tanggal_servis', [$startOfMonth, $endOfMonth])
                    ->sum('biaya');

                // Calculate remaining budget
                $totalExpenses = $bensinExpense + $stnkExpense + $servisExpense;
                $remainingBudget = $monthlyBudget - $totalExpenses;
                $percentageUsed = $monthlyBudget > 0 ? ($totalExpenses / $monthlyBudget) * 100 : 0;

                return [
                    'id' => $kendaraan->id,
                    'plat_nomor' => $kendaraan->plat_nomor,
                    'merk' => $kendaraan->merk,
                    'model' => $kendaraan->model,
                    'monthlyBudget' => $monthlyBudget,
                    'bensinExpense' => $bensinExpense,
                    'stnkExpense' => $stnkExpense,
                    'servisExpense' => $servisExpense,
                    'totalExpenses' => $totalExpenses,
                    'remainingBudget' => $remainingBudget,
                    'percentageUsed' => min(100, $percentageUsed),
                    'status' => $remainingBudget >= 0 ? 'Dalam Anggaran' : 'Melebihi Anggaran',
                ];
            });
    }

    private function getMonthOptions(): array
    {
        $options = [];
        $currentMonth = Carbon::now();

        // Generate options for the last 12 months
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);
            $key = $date->format('Y-m');
            $label = $date->format('F Y');
            $options[$key] = $label;
        }

        return $options;
    }
}
