<?php

namespace App\Livewire\Player;

use App\Models\Place;
use Livewire\Attributes\On;
use Livewire\Component;

class StreetView extends Component
{
    public $showStreetView = false;
    public $latitude;
    public $longitude;

    public function mount()
    {
        // $this->getRandomPlace();
        $this->latitude = -25.4284;
        $this->longitude = -49.2733;
    }

    public function getRandomPlace()
    {
        $place = Place::inRandomOrder()->first();

        if ($place) {
            $this->latitude = $place->latitude;
            $this->longitude = $place->longitude;
        } else {
            dd('No places found');
        }
    }

    #[On('load-street-view')]
    public function loadStreetView()
    {
        $this->getRandomPlace();
        if (!$this->showStreetView) {
            $this->showStreetView = true;
            $this->dispatch('initializeStreetView', latitude: (float) $this->latitude, longitude: (float) $this->longitude);
        }
    }

    #[On('change-location')]
    public function changeLocation()
    {
        $this->getRandomPlace();
        $this->dispatch('updateStreetViewLocation', latitude: (float) $this->latitude, longitude: (float) $this->longitude);
    }

    public function render()
    {
        return view('livewire.player.street-view');
    }
}
