<div class="relative h-full w-full">
    @livewire('player.street-view')
    {{-- <div class="header absolute top-8 z-50 mx-6 flex justify-between">
        <div>GuessCity</div>
        <div>Menu</div>
        <div>Pontos</div>
    </div> --}}

    <header class="fixed top-4 right-4 px-4 py-2 bg-black-900/95 rounded flex gap-4 text-gray-100">
        <x-ts-icon name="heart" class="h-5 w-5">
            <x-slot:right>
                3 vidas
            </x-slot:right>
        </x-icon>
        <x-ts-icon name="circle-stack" class="h-5 w-5">
            <x-slot:right>
                3.841 pontos
            </x-slot:right>
        </x-icon>
        <x-ts-icon name="user" class="h-5 w-5" />
    </header>

    @livewire('player.map-alternative')

    <footer class="fixed bottom-8 w-full pl-3 pr-16">
        {{-- @livewire('player.map') --}}
        <div class="absolute right-0">
            asdf
        </div>
        <div class="footer-wrapper px-4 flex justify-between items-center bg-black-900/95 rounded">
            <div><x-ts-button icon="information-circle" color="white" lg round flat /></div>
            <div class="w-[728px] h-[90px] bg-sky-950 text-white">ADS</div>
            <div>
                <x-ts-button text="Dica" />
                <x-ts-button wire:click="$dispatch('load-street-view')" text="Responder" />
            </div>
        </div>
    </footer>

    {{-- <div class="footer absolute bottom-8 p-4 z-50 rounded-lg w-full flex justify-center bg-gray-800/90">
        <button wire:click="$dispatch('load-street-view')">Carregar Street View</button>
        <button wire:click="$dispatch('change-location')">Novo Local</button>
    </div> --}}
</div>
