<div>
    <h1 class="text-2xl font-semibold mb-6">Adicionar local</h1>
    <form wire:submit="submit">
        <div class="space-y-4">
            <x-ts-input label="URL do Street View" wire:model="url">
                <x-slot:suffix>
                    <x-ts-button text="Carregar" wire:click="extractStreetViewData" class="ml-2" />
                </x-slot:suffix>
            </x-ts-input>
            <div class="grid sm:grid-cols-2 gap-4">
                <x-ts-input label="Latitude" wire:model="latitude" readonly />
                <x-ts-input label="Longitude" wire:model="longitude" readonly />
            </div>
            <x-ts-input label="Nome" wire:model="name" />
            <div class="grid sm:grid-cols-2 gap-4">
                <x-ts-input label="Cidade" wire:model="city_id" />
                <x-ts-toggle label="Salvar imagem" wire:model="addImage" />
                <x-ts-select.native label="Tipo" wire:model="type" :options="['road', 'corner', 'square', 'park', 'tourist', 'building', 'monument', 'other']" />
                <x-ts-select.native label="Nível de dificuldade" wire:model="level" :options="[1, 2, 3, 4, 5]" />
            </div>
            <x-ts-button type="submit" text="Salvar" :disabled="$panoid == ''" />
        </div>
    </form>
</div>
