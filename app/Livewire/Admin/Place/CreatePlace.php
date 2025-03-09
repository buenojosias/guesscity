<?php

namespace App\Livewire\Admin\Place;

use App\Enums\PlaceLevelEnum;
use App\Enums\PlaceTypeEnum;
use App\Models\Place;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CreatePlace extends Component
{
    public $types = [];
    public $levels = [];
    public $url;
    public $city_id = 1;
    public $name;
    public $latitude;
    public $longitude;
    public $panoid = '';
    public $pov;
    public $type;
    public $level;
    public $hints = [];
    public bool $addImage = false;

    public function mount()
    {
        $this->types = PlaceTypeEnum::cases();
        $this->levels = PlaceLevelEnum::cases();
    }

    public function extractStreetViewData()
    {
        if (!$this->url) {
            dd('Informe um valor no campo URL');
            return ['error' => 'Informe um valor no campo URL'];
        }

        preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+),3a,75y,([\d\.]+)h,([\d\.]+)t/', $this->url, $matches);

        if (count($matches) < 5) {
            dd('URL inválida ou formato inesperado');
            return ['error' => 'URL inválida ou formato inesperado'];
        }

        $this->latitude = $matches[1];
        $this->longitude = $matches[2];
        $this->pov['heading'] = number_format($matches[3], 0);
        $this->pov['pitch'] = 0;
        // $this->pov['pitch'] = number_format($matches[4], 0);

        preg_match('/panoid%3D([^%]+)%26yaw%3D/', $this->url, $panoidMatch);

        if (!isset($panoidMatch[1])) {
            dd('Panoid não encontrado na URL');
            return ['error' => 'Panoid não encontrado na URL'];
        }
        $this->panoid = $panoidMatch[1];
    }

    public function submit()
    {
        if (!$this->panoid) {
            return;
        }

        if ($this->addImage) {
            $has_image = $this->getThumbnails();
        }

        $createdPlace = Place::create([
            'city_id' => $this->city_id,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'panoid' => $this->panoid,
            'pov' => $this->pov,
            'type' => $this->type,
            'level' => $this->level,
            'hints' => $this->hints,
            'created_by' => auth()->id(),
            'active' => true,
            'has_image' => $has_image ?? false
        ]);

        dd($createdPlace);
    }

    public function getThumbnails()
    {
        if (!$this->panoid) {
            dump('Panoid não encontrado');
            return ['error' => 'Panoid não encontrado'];
        }

        $angles = [
            ['heading' => $this->pov['heading'] + 0, 'pitch' => $this->pov['pitch']],   // Norte
            // ['heading' => $this->pov['heading'] + 90, 'pitch' => $this->pov['pitch']],  // Leste
            // ['heading' => $this->pov['heading'] + 180, 'pitch' => $this->pov['pitch']], // Sul
            // ['heading' => $this->pov['heading'] + 270, 'pitch' => $this->pov['pitch']], // Oeste
        ];

        $this->statics = [];

        foreach ($angles as $angle) {
            $this->statics[] = "https://streetviewpixels-pa.googleapis.com/v1/thumbnail?cb_client=maps_sv.tactile&w=900&h=600&pitch={$angle['pitch']}&panoid={$this->panoid}&yaw={$angle['heading']}";
        }

        $image = $this->statics[0];
        return $this->saveImage($image);
    }

    public function getStaticAPI()
    {
        $apiKey = config('services.google_maps.key');

        if (!$this->panoid) {
            dump('Panoid não encontrado');
            return ['error' => 'Panoid não encontrado'];
        }

        $angles = [
            // ['heading' => $this->heading + 0, 'pitch' => $this->pitch],   // Norte
            ['heading' => $this->heading + 90, 'pitch' => $this->pitch],  // Leste
            // ['heading' => $this->heading + 180, 'pitch' => $this->pitch], // Sul
            //['heading' => $this->heading + 270, 'pitch' => $this->pitch], // Oeste
        ];

        $this->statics = [];

        foreach ($angles as $angle) {
            $this->statics[] = "https://maps.googleapis.com/maps/api/streetview?size=600x600&location={$this->latitude},{$this->longitude}&fov=90&heading={$angle['heading']}&pitch={$angle['pitch']}&key={$apiKey}";
        }
    }

    public function saveImage($image)
    {
        $client = new Client();
        $response = $client->get($image);
        $filename = $this->panoid . '.jpg';
        $storagePath = 'panoramas/' . $filename;

        return Storage::disk('public')->put($storagePath, $response->getBody()->getContents());
    }

    public function render()
    {
        return view('livewire.admin.place.create-place');
    }
}
