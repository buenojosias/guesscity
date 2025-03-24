<div class="game" x-data="{ playing: @entangle('isPlaying') }">
    <div x-show="playing">
        @livewire('game.street-view')
    </div>
    <header class="fixed top-4 right-4 px-4 py-2 bg-black-900/95 rounded flex gap-4 text-gray-100">
        <x-ts-icon name="heart" class="h-5 w-5">
            <x-slot:right>
                3 vidas
            </x-slot:right>
        </x-ts-icon>
        <x-ts-icon name="circle-stack" class="h-5 w-5">
            <x-slot:right>
                3.841 pontos
            </x-slot:right>
        </x-ts-icon>
        <x-ts-icon name="user" class="h-5 w-5" />
    </header>

    {{-- @if (!$isPlaying) --}}
        <section x-show="!playing" class="z-[100] w-full h-full flex flex-col justify-center items-center px-4 space-y-4">
            <img src="{{ asset('images/logo.png') }}" alt="GuessCity" class="w-56" />
            <div class="text-center py-4 inselectable">
                <h1 class="text-4xl font-semibold text-white">Você conhece bem sua cidade?</h1>
                <h2 class="text-2xl font-semibold text-amber-400">Teste seu conhecimento neste jogo!</h2>
            </div>
            <x-ts-button text="INICIAR JOGO" wire:click="startGame" color="amber" class="font-bold w-80" lg />
            <div class="flex space-x-4 w-80">
                <x-ts-button text="Preferências" icon="cog" color="white" class="w-1/2" outline />
                <x-ts-button text="Ajuda" icon="question-mark-circle" color="white" class="w-1/2" outline />
        </section>
    {{-- @endif --}}

    {{-- @if ($isPlaying) --}}
        <footer x-show="playing" class="game-footer">
            <div class="footer-wrapper">
                <div class="w-60">menu esquerdo</div>
                <div class="w-[728px] h-[90px] text-white bg-black-900/95 rounded">
                    <img src="{{ asset('images/ads.png') }}" alt="">
                </div>
                <div class="w-60">
                    @livewire('game.map')
                </div>
            </div>
        </footer>
    {{-- @endif --}}
</div>
