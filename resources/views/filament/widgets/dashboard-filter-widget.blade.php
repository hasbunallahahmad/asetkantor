<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-4 bg-white rounded-lg shadow mb-4">
            <h2 class="text-lg font-medium mb-4">Filter Dashboard</h2>
            
            <form wire:submit="filter">
                <div class="space-y-4">
                {{ $this->form }}
                
                <div class="flex items-center gap-4 mt-4">
                    <x-filament::button type="submit">
                        Terapkan Filter
                    </x-filament::button>
                    
                    <x-filament::button type="button" wire:click="resetFilter" color="secondary">
                        Reset
                    </x-filament::button>
                </div>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
