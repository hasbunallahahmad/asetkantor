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
        // $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        // $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        return Kendaraan::where('status', 'Aktif')
            ->get()
            ->map(function (Kendaraan $kendaraan) use ($year, $month) {
                // Annual budget for the vehicle
                $annualBudget = $kendaraan->anggaran_tahunan;

                // Accumulate all expenses from beginning of year through the selected month
                $yearStart = Carbon::createFromDate($year, 1, 1)->startOfMonth();
                $monthEnd = Carbon::createFromDate($year, $month, 1)->endOfMonth();

                // Get total year-to-date expenses through previous month
                $previousExpenses = $this->getExpensesForPeriod($kendaraan->id, $yearStart, Carbon::createFromDate($year, $month, 1)->startOfMonth()->subDay());

                // Get current month expenses
                $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

                // Current month expenses breakdown
                $bensinExpense = PembelianBensin::where('kendaraan_id', $kendaraan->id)
                    ->where('bulan', $month)
                    ->where('tahun', $year)
                    ->sum('jumlah_harga');

                $stnkExpense = PembayaranStnk::where('kendaraan_id', $kendaraan->id)
                    ->whereBetween('tanggal_bayar', [$startOfMonth, $endOfMonth])
                    ->sum('biaya');

                $servisExpense = ServisKendaraan::where('kendaraan_id', $kendaraan->id)
                    ->whereBetween('tanggal_servis', [$startOfMonth, $endOfMonth])
                    ->sum('biaya');

                // Current month total expenses
                $currentMonthExpenses = $bensinExpense + $stnkExpense + $servisExpense;

                // Year-to-date total expenses (including current month)
                $ytdExpenses = $previousExpenses + $currentMonthExpenses;

                // Remaining budget after all expenses to date
                $remainingBudget = $annualBudget - $ytdExpenses;

                $percentageUsed = $annualBudget > 0 ? ($ytdExpenses / $annualBudget) * 100 : 0;

                return [
                    'id' => $kendaraan->id,
                    'plat_nomor' => $kendaraan->plat_nomor,
                    'merk' => $kendaraan->merk,
                    'model' => $kendaraan->model,
                    'monthlyBudget' => $annualBudget, // For display purposes
                    'bensinExpense' => $bensinExpense,
                    'stnkExpense' => $stnkExpense,
                    'servisExpense' => $servisExpense,
                    'totalExpenses' => $currentMonthExpenses, // Current month expenses
                    'remainingBudget' => $remainingBudget, // Remaining budget after all year-to-date expenses
                    'percentageUsed' => min(100, $percentageUsed),
                    'status' => $remainingBudget >= 0 ? 'Dalam Anggaran' : 'Melebihi Anggaran',
                ];
            });
    }

    private function getExpensesForPeriod(int $kendaraanId, Carbon $startDate, Carbon $endDate): float
    {
        // Skip if end date is before start date (happens when viewing January)
        if ($endDate->lt($startDate)) {
            return 0;
        }

        // Get fuel expenses for this period
        $bensinExpense = PembelianBensin::where('kendaraan_id', $kendaraanId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    // Convert the month and year to a date range
                    $startYear = $startDate->year;
                    $startMonth = $startDate->month;
                    $endYear = $endDate->year;
                    $endMonth = $endDate->month;

                    for ($year = $startYear; $year <= $endYear; $year++) {
                        $monthStart = ($year == $startYear) ? $startMonth : 1;
                        $monthEnd = ($year == $endYear) ? $endMonth : 12;

                        for ($month = $monthStart; $month <= $monthEnd; $month++) {
                            $q->orWhere(function ($innerQ) use ($year, $month) {
                                $innerQ->where('tahun', $year)
                                    ->where('bulan', $month);
                            });
                        }
                    }
                });
            })
            ->sum('jumlah_harga');

        // Get STNK payments for this period
        $stnkExpense = PembayaranStnk::where('kendaraan_id', $kendaraanId)
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->sum('biaya');

        // Get service expenses for this period
        $servisExpense = ServisKendaraan::where('kendaraan_id', $kendaraanId)
            ->whereBetween('tanggal_servis', [$startDate, $endDate])
            ->sum('biaya');

        return $bensinExpense + $stnkExpense + $servisExpense;
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
