<x-filament-panels::page>
    {{ $this->form }}

    @if ($showPreview)
        <div class="p-4 mt-4 bg-white rounded shadow-sm">
            <h2 class="text-xl font-bold text-center mb-2">DAFTAR PENERIMAAN BBM KENDARAAN DINAS</h2>
            <h3 class="text-lg font-semibold text-center mb-2">DINAS ARSIP DAN PERPUSTAKAAN KOTA SEMARANG</h3>
            <h4 class="text-md font-semibold text-center mb-4">BULAN : {{ $previewData['bulan'] }}
                {{ $previewData['tahun'] }}</h4>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">NO.</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">JENIS KENDARAAN</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">TAHUN</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">MERK</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">NO. POLISI</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">LITER/HARI</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">DLM 1 BULAN</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">JENIS BBM</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">JUMLAH LITER</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">HARGA(RP)/LITER</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">JUMLAH</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">PEMEGANG</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">TANDA TANGAN</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">1</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">2</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">3</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">4</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">5</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">6</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">7</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">8</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">9</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">10</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">11</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">12</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs text-center">13</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($previewData['items'] as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">{{ $index + 1 }}.
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-xs">
                                    {{ $item->kendaraan->jenis ?? 'KENDARAAN RODA 4' }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">
                                    {{ $item->kendaraan->tahun_pengadaan ?? '-' }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-xs">{{ $item->kendaraan->merk ?? '-' }}
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">
                                    {{ $item->kendaraan->plat_nomor ?? '-' }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">
                                    {{ number_format($item->jatah_liter_per_hari, 0) }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">
                                    {{ number_format($item->jatah_liter_per_bulan, 0) }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">{{ $item->jenis_bbm }}
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">
                                    {{ number_format($item->jumlah_liter, 0) }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">
                                    {{ number_format($item->harga_per_liter, 0) }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-xs text-center">
                                    {{ number_format($item->jumlah_harga, 0) }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-xs">{{ $item->pengguna->nama ?? '-' }}
                                </td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-xs {{ $index % 2 == 0 ? 'text-left' : 'text-right' }}">
                                    @if ($index % 2 == 0)
                                        {{ $index + 1 }}.
                                    @else
                                        {{ $index + 1 }}.
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="10" class="border border-gray-300 px-2 py-1 text-xs text-center font-bold">
                                JUMLAH</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs text-center font-bold">
                                {{ number_format($previewData['totalJumlah'], 0) }}</td>
                            <td colspan="2" class="border border-gray-300"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- <div class="mt-8 text-center ml-12"> --}}
            <div class="mt-8 flex justify-end w-full">
                <div class="text-sm text-center">
                    <p class="text-sm">Semarang, {{ $previewData['tanggalCetak'] }}</p>
                    <p class="text-sm mt-1">Kuasa Pengguna Anggaran</p>
                    <p class="text-sm mt-1">Dinas Arsip dan Perpustakaan Kota Semarang</p>
                    <div class="h-16"></div>
                    <p class="text-sm font-bold mt-2">Dr. Muhammad Ahsan, S.Ag, M.Kom</p>
                </div>
            </div>
    @endif
</x-filament-panels::page>
