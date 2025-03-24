<div>
    <div class="flex justify-between flex-col sm:flex-row items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold">Adicionar local</h1>
        <x-ts-button text="Adicionar local" :href="route('admin.places.create')" />
    </div>
    <x-ts-table :$headers :$rows />
</div>
