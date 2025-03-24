<div>
    <h1 class="text-2xl font-semibold mb-6">Adicionar local</h1>
    <form wire:submit="submit">
        <div class="space-y-4">
            <x-ts-input label="URL do Street View" wire:model="url" />
            <x-ts-input label="Nome" wire:model="name" />
            <div class="grid sm:grid-cols-2 gap-4">
                <x-ts-select.native label="Cidade" wire:model="city_id" :options="$cities" select="label:name|value:id" />
                <x-ts-input label="Bairro" wire:model="neighborhood" />
                <x-ts-select.native label="Tipo" wire:model="type" :options="$types" />
                <x-ts-select.native label="Nível de dificuldade" wire:model="level" :options="$levels" />
            </div>
            <x-ts-button type="submit" text="Salvar" />
        </div>
    </form>
</div>
