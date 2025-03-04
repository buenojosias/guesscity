<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CreateLocation extends Component
{
    public $apiKey;
    public $url = "https://www.google.com/maps/@-25.394452,-49.2728614,3a,75y,199.54h,88.61t/data=!3m7!1e1!3m5!1sKBbK_E_8Gpj1jeqs_Lj68Q!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D1.3940045770586238%26panoid%3DKBbK_E_8Gpj1jeqs_Lj68Q%26yaw%3D199.5440426669186!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI1MDIyNi4xIKXMDSoJLDEwMjExNDU1SAFQAw%3D%3D";
    public $latitude;
    public $longitude;
    public $heading;
    public $pitch = 0;
    public $thumbnails = [];

    public function mount()
    {
        $this->apiKey = config('services.google_maps.key');
        dd($this->extractStreetViewData($this->url));
    }

    function extractStreetViewData($url)
    {
        preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+),3a,75y,([\d\.]+)h,([\d\.]+)t/', $url, $matches);

        if (count($matches) < 5) {
            return ['error' => 'URL inválida ou formato inesperado'];
        }

        $this->latitude = $matches[1];
        $this->longitude = $matches[2];
        // $this->heading = $matches[3];
        // $this->pitch = $matches[4];

        preg_match('/panoid%3D([^%]+)%26yaw%3D/', $url, $panoidMatch);

        if (!isset($panoidMatch[1])) {
            return ['error' => 'Panoid não encontrado na URL'];
        }

        $this->panoid = $panoidMatch[1];

        $angles = [
            ['heading' => 0, 'pitch' => 0],   // Norte
            ['heading' => 90, 'pitch' => 0],  // Leste
            ['heading' => 180, 'pitch' => 0], // Sul
            ['heading' => 270, 'pitch' => 0], // Oeste
        ];

        $this->thumbnails[1] = "https://streetviewpixels-pa.googleapis.com/v1/thumbnail?cb_client=maps_sv.tactile&w=900&h=600&pitch=0&panoid={$this->panoid}&yaw={$angles[0]['heading']}";
        $this->thumbnails[2] = "https://streetviewpixels-pa.googleapis.com/v1/thumbnail?cb_client=maps_sv.tactile&w=900&h=600&pitch=0&panoid={$this->panoid}&yaw={$angles[1]['heading']}";

        return [
            'url' => $url,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'panoid' => $this->panoid,
            'heading' => $this->heading,
            'pitch' => $this->pitch,
            'thumbnails' => $this->thumbnails,
        ];
    }

    public function render()
    {
        return view('livewire.create-location');
    }
}
