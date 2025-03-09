<div>
    <h1 class="text-2xl font-semibold mb-6">Adicionar local</h1>
    <x-ts-button text="Adicionar local" :href="route('admin.places.create')" />
    <x-ts-table :$headers :$rows />
</div>
