<?php

namespace App\Livewire\Player;

use App\Models\Place;
use Livewire\Attributes\On;
use Livewire\Component;

class MapAlternative extends Component
{
    public $initialPosition;
    public $lat1 = -25.4284;
    public $lon1 = -49.2733;
    public $lat2;
    public $lon2;
    public $distance;

    public function mount($lat = -25.4322, $lng = -49.2811)
    {
        $this->initialPosition = [
            'lat' => (float) $lat,
            'lng' => (float) $lng,
        ];
    }

    #[On('get-place')]
    public function getPlace()
    {
        $place = Place::inRandomOrder()->first();
        $this->lat2 = $place->latitude;
        $this->lon2 = $place->longitude;
    }

    #[On('updateCoordinates')]
    public function updateCoordinates($coords)
    {
        $this->lat2 = $coords['lat'];
        $this->lon2 = $coords['lng'];
        $this->calculateDistance(); // Recalcula a distância
    }

    public function calculateDistance()
    {
        if ($this->lat2 && $this->lon2) {
            $theta = $this->lon1 - $this->lon2;
            $dist = sin(deg2rad($this->lat1)) * sin(deg2rad($this->lat2)) + cos(deg2rad($this->lat1)) * cos(deg2rad($this->lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $this->distance = $dist * 60 * 1.1515 * 1.609344; // Convertendo para quilômetros
        }
    }

    public function render()
    {
        return view('livewire.player.map-alternative');
    }
}
