<?php

namespace App\Filament\Pages;

use App\Models\Kendaraan;
use App\Models\PembelianBensin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;

class LaporanPenerimaanBBM extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Laporan Penerimaan BBM';
    protected static ?string $title = 'Laporan Penerimaan BBM Kendaraan Dinas';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.laporan-penerimaan-b-b-m';

    public ?array $data = [];
    public $bulan;
    public $tahun;
    public $selectedKendaraanIds = [];
    public $showPreview = false;
    public $previewData = [];
    public $bulanLabel = '';
    public function mount(): void
    {
        $this->bulan = date('n');
        $this->tahun = date('Y');
        $this->form->fill();
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('bulan')
                                    ->label('Bulan')
                                    ->options([
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember',
                                    ])
                                    ->required()
                                    ->default(date('n')),
                                Forms\Components\TextInput::make('tahun')
                                    ->label('Tahun')
                                    ->numeric()
                                    ->required()
                                    ->default(date('Y')),
                                Forms\Components\Select::make('selectedKendaraanIds')
                                    ->label('Pilih Kendaraan')
                                    ->multiple()
                                    ->options(function () {
                                        return Kendaraan::orderBy('plat_nomor')
                                            ->pluck('plat_nomor', 'id')
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                            ]),
                        Forms\Components\Actions::make([
                            Action::make('preview')
                                ->label('Preview Laporan')
                                ->button()
                                ->action('generatePreview'),
                            Action::make('print')
                                ->label('Cetak PDF')
                                ->button()
                                ->color('success')
                                ->action('generatePDF')
                                ->hidden(fn() => !$this->showPreview),
                        ]),
                    ]),
            ]);
    }
    public function generatePreview()
    {
        $this->validate([
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric|min:2000|max:2100',
            'selectedKendaraanIds' => 'required|array|min:1',
        ]);

        // $nomorTandaTangan = [
        //     'H 1626 IX' => 1,
        //     'H 1675 XA' => 2,
        //     'H 1678 XA' => 3,
        //     'H 9504 BH' => 4,
        //     'H 1578 XA' => 5,
        //     'H 1401 XA' => 6,
        //     'H 8643 XH' => 7,
        //     'H 19 A' => 8,
        // ];

        // $this->previewData = ['nomorTandaTangan'] = $nomorTandaTangan;

        $bulanOptions = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $this->bulanLabel = $bulanOptions[$this->bulan];

        $pembelianData = PembelianBensin::with(['kendaraan', 'pengguna'])
            ->whereIn('kendaraan_id', $this->selectedKendaraanIds)
            ->where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->get()
            // ->sortBy('kendaraan.plat_nomor');
            ->sortBy('id');

        if ($pembelianData->count() === 0) {
            Notification::make()
                ->title('Data tidak ditemukan')
                ->body('Tidak ada data penerimaan BBM untuk kendaraan yang dipilih pada periode tersebut.')
                ->danger()
                ->send();

            $this->showPreview = false;
            return;
        }

        $totalJumlah = 0;

        foreach ($pembelianData as $item) {
            $totalJumlah += $item->jumlah_harga;
        }

        $this->previewData = [
            'items' => $pembelianData,
            'bulan' => $this->bulanLabel,
            'tahun' => $this->tahun,
            'totalJumlah' => $totalJumlah,
            'tanggalCetak' => Carbon::now()->locale('id')->translatedFormat('d F Y'),
            // 'nomorTandaTangan' => $nomorTandaTangan,
        ];

        $this->showPreview = true;
    }

    public function generatePDF()
    {
        if (empty($this->previewData)) {
            $this->generatePreview();
        }

        if (empty($this->previewData['items']) || $this->previewData['items']->count() === 0) {
            Notification::make()
                ->title('Data tidak ditemukan')
                ->body('Tidak ada data untuk dicetak.')
                ->danger()
                ->send();
            return;
        }

        $pdf = PDF::loadView('pdf.laporan-penerimaan-bbm', $this->previewData);
        $pdf->setPaper('Folio', 'landscape');

        $filename = "Laporan_Penerimaan_BBM_{$this->bulanLabel}_{$this->tahun}.pdf";

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
