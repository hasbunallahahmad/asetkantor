<?php

namespace App\Filament\Pages;

use App\Models\Kendaraan;
use App\Models\ServisKendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Collection;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CetakServisKendaraan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static ?string $navigationLabel = 'Cetak Laporan Servis';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.cetak-servis-kendaraan';

    public ?string $kendaraan_id = null;
    public ?array $servisData = [];
    public bool $showPreview = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pilih Kendaraan')
                    ->schema([
                        Forms\Components\Select::make('kendaraan_id')
                            ->label('Plat Nomor Kendaraan')
                            ->options(Kendaraan::all()->pluck('plat_nomor', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function () {
                                $this->resetPreview();
                            }),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Tampilkan Preview')
                ->action(function () {
                    $this->loadServisData();
                    $this->showPreview = true;
                })
                ->disabled(fn() => $this->kendaraan_id === null),

            Action::make('print')
                ->label('Cetak PDF')
                ->action('generatePdf')
                ->disabled(fn() => !$this->showPreview),
        ];
    }

    public function loadServisData(): void
    {
        if (!$this->kendaraan_id) {
            return;
        }

        $servisRecords = ServisKendaraan::with(['kendaraan'])
            ->where('kendaraan_id', $this->kendaraan_id)
            ->orderBy('tanggal_servis', 'desc')
            ->get();

        // $kendaraan = Kendaraan::find($this->kendaraan_id);
        $kendaraan = Kendaraan::with('jenisKendaraan', 'pengguna')
            ->find($this->kendaraan_id);

        $this->servisData = [
            'kendaraan' => $kendaraan,
            'records' => $servisRecords,
            'total_biaya' => $servisRecords->sum('biaya')
        ];
    }

    public function resetPreview(): void
    {
        $this->showPreview = false;
        $this->servisData = [];
    }

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function generatePdf(): \Symfony\Component\HttpFoundation\Response
    {
        $this->loadServisData();

        if (empty($this->servisData)) {
            return back()->with('error', 'No data to generate PDF');
        }

        $kendaraan = $this->servisData['kendaraan'];
        $platNomor = str_replace(' ', '_', $kendaraan->plat_nomor);
        $fileName = "servis-kendaraan_{$platNomor}.pdf";
        $user = $this->getCurrentUser();

        $records = $this->servisData['records']->map(function ($record) {

            return (object) [
                'tanggal_servis' => $record->tanggal_servis,
                'jenis_servis' => mb_convert_encoding($record->jenis_servis, 'UTF-8', 'auto'),
                'kilometer_kendaraan' => $record->kilometer_kendaraan,
                'bengkel' => $record->bengkel ? mb_convert_encoding($record->bengkel, 'UTF-8', 'auto') : '-',
                'biaya' => $record->biaya
            ];
        });

        // Dapatkan informasi user yang sedang login

        $pdf = PDF::loadView('pdf.servis-kendaraan', [
            'kendaraan' => $this->servisData['kendaraan'],
            'records' => $this->servisData['records'],
            'total_biaya' => $this->servisData['total_biaya'],
            'tanggal_cetak' => now()->format('d/m/Y H:i'),
            'user' => $user
        ]);
        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans'
        ]);
        // return $pdf->download($fileName);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'servis-kendaraan.pdf');
    }
    // public function generatePdf(): void
    // {
    //     $this->loadServisData();

    //     if (empty($this->servisData)) {
    //         return;
    //     }

    //     $kendaraan = $this->servisData['kendaraan'];
    //     $platNomor = str_replace(' ', '_', $kendaraan->plat_nomor);
    //     $fileName = "servis_kendaraan_{$platNomor}.pdf";

    //     // Dapatkan informasi user yang sedang login
    //     $user = $this->getCurrentUser();

    //     $pdf = PDF::loadView('pdf.servis-kendaraan', [
    //         'kendaraan' => $this->servisData['kendaraan'],
    //         'records' => $this->servisData['records'],
    //         'total_biaya' => $this->servisData['total_biaya'],
    //         'tanggal_cetak' => now()->format('d/m/Y H:i'),
    //         'user' => $user
    //     ]);

    //     return $pdf->download($fileName);
    //     // return response()->streamDownload(
    //     fn() => print($pdf->output()),
    //     $fileName
    // );
    // return response()->streamDownload(
    //     fn() => $pdf->output(),
    //     $fileName
    // );
    // return response()->streamDownload(function () use ($pdf): void {
    //     print $pdf->output();
    // }, $fileName);

    // return $pdf->download($fileName);}
}
