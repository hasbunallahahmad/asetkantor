<?php

namespace App\Filament\Widgets;

use App\Models\Kendaraan;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Session;

class DashboardFilterWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static ?int $sort = 1;

    protected static string $view = 'filament.widgets.dashboard-filter-widget';

    protected int | string | array $columnSpan = 'full';


    public $data = [];

    // public ?string $bulan = null;
    // public ?string $plat_nomor = null;

    public function mount(): void
    {
        // Ambil filter dari session jika ada
        $filters = Session::get('dashboard_filters', []);

        // Set default untuk filter bulan ke bulan saat ini jika belum ada
        if (!isset($filters['bulan'])) {
            $filters['bulan'] = Carbon::now()->format('Y-m');
        }

        // Isi form dengan filter yang tersimpan
        $this->form->fill([
            'bulan' => $filters['bulan'] ?? Carbon::now()->format('Y-m'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('bulan')
                    ->label('Pilih Bulan')
                    ->options($this->getBulanOptions())
                    ->default(Carbon::now()->format('Y-m')),

            ])
            ->statePath('data');
    }

    // protected function getFormModel(): string
    // {
    //     return 'data';
    // }



    protected function getBulanOptions(): array
    {
        $options = [];
        $now = Carbon::now();

        // Tampilkan 12 bulan sebelumnya dan 6 bulan ke depan
        for ($i = -12; $i <= 6; $i++) {
            $date = $now->copy()->addMonths($i);
            $key = $date->format('Y-m');
            $value = $date->translatedFormat('F Y'); // Format: Maret 2025
            $options[$key] = $value;
        }

        return $options;
    }

    public function filter(): void
    {
        // Simpan filter ke session
        Session::put('dashboard_filters', [
            'bulan' => $this->data['bulan'] ?? Carbon::now()->format('Y-m'),
        ]);

        // Refresh halaman untuk menampilkan data berdasarkan filter
        $this->dispatch('refreshDashboard');
    }

    public function resetFilter(): void
    {
        // Reset filter ke default
        $this->data = [
            'bulan' => Carbon::now()->format('Y-m'),
        ];

        Session::put('dashboard_filters', [
            'bulan' => Carbon::now()->format('Y-m'),
        ]);

        // Refresh halaman
        $this->dispatch('refreshDashboard');
    }
}
