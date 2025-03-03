<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}

        <x-filament::widget>
    <x-filament::card>
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold">Anggaran Kendaraan Bulanan</h2>
            <select 
                wire:model.live="filter" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
            >
                @foreach($months as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">Plat Nomor</th>
                        <th scope="col" class="px-4 py-3">Merk / Model</th>
                        <th scope="col" class="px-4 py-3">Anggaran Bulanan</th>
                        <th scope="col" class="px-4 py-3">Bensin</th>
                        <th scope="col" class="px-4 py-3">STNK/TNKB</th>
                        <th scope="col" class="px-4 py-3">Servis</th>
                        <th scope="col" class="px-4 py-3">Total Pengeluaran</th>
                        <th scope="col" class="px-4 py-3">Sisa Anggaran</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($budgetData as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $item['plat_nomor'] }}</td>
                            <td class="px-4 py-3">{{ $item['merk'] }} {{ $item['model'] }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($item['monthlyBudget'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($item['bensinExpense'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($item['stnkExpense'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($item['servisExpense'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($item['totalExpenses'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 {{ $item['remainingBudget'] < 0 ? 'text-red-500' : 'text-green-500' }}">
                                Rp {{ number_format($item['remainingBudget'], 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full {{ $item['remainingBudget'] < 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <h3 class="text-md font-medium">Ringkasan</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-2">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Total Anggaran</p>
                    <p class="text-xl font-bold">
                        Rp {{ number_format($budgetData->sum('monthlyBudget'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Total Pengeluaran</p>
                    <p class="text-xl font-bold">
                        Rp {{ number_format($budgetData->sum('totalExpenses'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Total Sisa</p>
                    <p class="text-xl font-bold">
                        Rp {{ number_format($budgetData->sum('remainingBudget'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Persentase Penggunaan</p>
                    <p class="text-xl font-bold">
                        {{ number_format(($budgetData->sum('totalExpenses') / max(1, $budgetData->sum('monthlyBudget'))) * 100, 1) }}%
                    </p>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
    </x-filament::section>
</x-filament-widgets::widget>
