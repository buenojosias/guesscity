<?php

namespace App\Livewire;

use App\Models\Place;
use Livewire\Attributes\On;
use Livewire\Component;

class Game extends Component
{
    public $isPlaying = false;
    public $mapLoaded = false;
    public $streetViewLoaded = false;

    public function startGame()
    {
        $this->dispatch('load-map')->to('game.map');
        $this->dispatch('load-street-view')->to('game.street-view');
    }

    #[On('map-loaded')]
    public function mapLoaded()
    {
        $this->mapLoaded = true;
        $this->check();
    }

    #[On('street-view-loaded')]
    public function streetViewLoaded()
    {
        $this->streetViewLoaded = true;
        $this->check();
    }

    public function check()
    {
        if ($this->mapLoaded && $this->streetViewLoaded) {
            $this->isPlaying = true;
            $this->getPlace();
        }
    }

    #[On('get-place')]
    public function getPlace()
    {
        $this->getRandomPlace();
        // $this->dispatch('updateStreetViewLocation', latitude: (float) $this->latitude, longitude: (float) $this->longitude, heading: $this->pov['heading']);
    }

    public function getRandomPlace()
    {
        $place = Place::inRandomOrder()->first();

        if ($place) {
            $this->latitude = $place->latitude;
            $this->longitude = $place->longitude;
            $this->pov = $place->pov;
            $this->dispatch('set-place', $place->toArray());
        } else {
            dd('No places found');
        }
    }

    public function render()
    {
        return view('livewire.game')
            ->layout('layouts.player');
    }
}
