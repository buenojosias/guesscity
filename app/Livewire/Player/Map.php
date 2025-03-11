<?php

namespace App\Livewire\Player;

use App\Models\Place;
use Livewire\Attributes\On;
use Livewire\Component;

class Map extends Component
{
    public $initialPosition;
    public $place;
    public $placeLat;
    public $placeLng;

    public function mount($lat = -25.4322, $lng = -49.2811)
    {
        $this->initialPosition = [
            'lat' => (float) $lat,
            'lng' => (float) $lng,
        ];
    }

    #[On('load-map')]
    public function loadMap()
    {
        $this->dispatch('render-map')->self();
        $this->getPlace();
    }

    #[On('get-place')]
    public function getPlace()
    {
        $this->place = Place::inRandomOrder()->first();
        $this->dispatch('set-place', name: $this->place->name, lat: (float) $this->place->latitude, lng: (float) $this->place->longitude)->self();
    }

    public function render()
    {
        return view('livewire.player.map');
    }
}
