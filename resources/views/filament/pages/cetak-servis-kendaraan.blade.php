<x-filament-panels::page>
    <x-filament-panels::form wire:submit="submit">
        {{ $this->form }}
    </x-filament-panels::form>

    @if($showPreview)
        <div class="mt-6 p-6 bg-white rounded-lg shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Laporan Servis Kendaraan</h2>
                <p class="text-gray-500">Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <div class="mb-6 p-4 bg-gray-50 rounded">
                <h3 class="text-lg font-semibold mb-2">Detail Kendaraan</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p><span class="font-medium">Plat Nomor:</span> {{ $servisData['kendaraan']->plat_nomor }}</p>
                        <p><span class="font-medium">Pemilik/Pengguna:</span> {{ $servisData['kendaraan']->pengguna->nama ?? '-' }}</p>
                        
                    </div>
                    <div>
                        <p><span class="font-medium">Merek:</span> {{ $servisData['kendaraan']->merk ?? '-' }}</p>
                        <p><span class="font-medium">Tipe Kendaraan:</span> {{ $servisData['kendaraan']->model ?? '-' }}</p>
                        <p><span class="font-medium">Tahun:</span> {{ $servisData['kendaraan']->tahun_pengadaan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-4">Riwayat Servis</h3>
            
            @if(count($servisData['records']) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Servis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Servis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bengkel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($servisData['records'] as $record)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $record->tanggal_servis->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $record->jenis_servis }}</td>
                                <td class="px-6 py-4">{{ number_format($record->kilometer_kendaraan) }} KM</td>
                                <td class="px-6 py-4">{{ $record->bengkel ?? '-' }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($record->biaya, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="4" class="px-6 py-4 text-right font-bold">Total:</td>
                            <td class="px-6 py-4 font-bold">Rp {{ number_format($servisData['total_biaya'], 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="text-center p-6 bg-gray-50 rounded">
                    <p class="text-gray-500">Tidak ada data servis untuk kendaraan ini.</p>
                </div>
            @endif
        </div>
    @endif
</x-filament-panels::page>