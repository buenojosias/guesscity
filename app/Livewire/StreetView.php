<?php

namespace App\Livewire;

use App\Models\Location;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class StreetView extends Component
{
    public $locationId;
    public $panoramaId;
    public $apiKey;

    public function mount($locationId = 1)
    {
        $this->loadPanorama($locationId);
        $this->apiKey = config('services.google_maps.key');
    }

    public function loadPanorama($locationId)
    {
        // $local = Location::find($locationId);

        // if (!$local) {
        //     dd('Local não encontrado');
        //     return;
        // }

        // Define um cache para o panorama
        $this->panoramaId = Cache::remember("streetview_{$this->locationId}", now()->addDays(7), function () {
            return $this->fetchPanoramaIdFromDatabase();
        });

        // $this->panoramaId = $local->panorama_id;
        // $this->panoramaId = '46fsad4f65sad4f65';
    }

    private function fetchPanoramaIdFromDatabase()
    {
        // Simulação: Busca do panorama no banco de dados
        return \DB::table('places')->where('id', $this->locationId)->value('panorama_id');
    }

    public function render()
    {
        return view('livewire.street-view');
    }
}
