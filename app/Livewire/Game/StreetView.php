<?php

namespace App\Livewire\Game;

use App\Models\Place;
use Livewire\Attributes\On;
use Livewire\Component;

class StreetView extends Component
{
    public $showStreetView = true;
    public $latitude;
    public $longitude;
    public $pov;

    public function mount()
    {
        // $this->getRandomPlace();
        $this->latitude = -25.4284;
        $this->longitude = -49.2733;
    }

    #[On('set-place')]
    public function setPlace($place)
    {
        $this->latitude = $place['latitude'];
        $this->longitude = $place['longitude'];
        $this->pov = $place['pov'];
        $this->dispatch('updateStreetViewLocation', latitude: (float) $this->latitude, longitude: (float) $this->longitude, heading: $this->pov['heading']);
    }

    // public function getRandomPlace()
    // {
    //     $place = Place::inRandomOrder()->first();

    //     if ($place) {
    //         $this->latitude = $place->latitude;
    //         $this->longitude = $place->longitude;
    //         $this->pov = $place->pov;
    //     } else {
    //         dd('No places found');
    //     }
    // }

    // #[On('load-street-view')]
    // public function loadStreetView()
    // {
        // $this->dispatch('initializeStreetView');
        // $this->getRandomPlace();
        // if (!$this->showStreetView) {
        //     $this->showStreetView = true;
        //     $this->dispatch('initializeStreetView', latitude: (float) $this->latitude, longitude: (float) $this->longitude);
        // }
    // }

    // #[On('change-location')]
    // public function changeLocation()
    // {
    //     $this->getRandomPlace();
    //     $this->dispatch('updateStreetViewLocation', latitude: (float) $this->latitude, longitude: (float) $this->longitude, heading: $this->pov['heading']);
    // }

    public function render()
    {
        return view('livewire.game.street-view');
    }
}
