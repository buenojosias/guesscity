<?php

namespace App\Livewire\Game;

use App\Models\Place;
use Livewire\Attributes\On;
use Livewire\Component;

class Map extends Component
{
    # TODO: Obter posição inicial do usuário

    public $initialPosition;
    public $place;
    public $clicked;

    public function mount($lat = -25.4322, $lng = -49.2811)
    {
        $this->initialPosition = [
            'lat' => (float) $lat,
            'lng' => (float) $lng,
        ];
    }

    #[On('set-place')]
    public function setPlace($place)
    {
        $this->dispatch('clear-map')->self();
        $this->place = [
            'name' => $place['name'],
            'lat' => (float) $place['latitude'],
            'lng' => (float) $place['longitude'],
        ];
    }

    #[On('set-clicked')]
    public function setClicked($coords)
    {
        $this->clicked = $coords;
        $this->calculateDistance();
    }

    public function calculateDistance()
    {
        if ($this->place && $this->clicked) {
            $theta = $this->place['lng'] - $this->clicked['lng'];
            $dist = sin(deg2rad($this->place['lat'])) * sin(deg2rad($this->clicked['lat'])) + cos(deg2rad($this->place['lat'])) * cos(deg2rad($this->clicked['lat'])) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $this->distance = $dist * 60 * 1.1515 * 1.609344;
        }
        $this->dispatch('draw-line', place: $this->place, clicked: $this->clicked, distance: $this->distance)->self();
    }

    public function render()
    {
        return view('livewire.game.map');
    }
}
