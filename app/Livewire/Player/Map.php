<?php

namespace App\Livewire\Player;

use Livewire\Attributes\On;
use Livewire\Component;

class Map extends Component
{
    public $center;
    public function mount($lat = -25.4322, $lng = -49.2811)
    {
        $this->center = [
            'lat' => $lat,
            'lng' => $lng,
        ];
    }

    #[On('load-map')]
    public function loadMap()
    {
        $this->dispatch('render-map')->self();
    }

    public function render()
    {
        return view('livewire.player.map');
    }
}
