<x-filament-panels::page>
    <form wire:submit="send" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-end">
            <x-filament::button type="submit" icon="heroicon-o-paper-airplane" wire:loading.attr="disabled">
                Kirim Blast
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
