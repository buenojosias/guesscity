<?php

namespace App\Livewire\Admin\Place;

use App\Enums\PlaceLevelEnum;
use App\Enums\PlaceTypeEnum;
use App\Models\City;
use App\Models\Place;
use App\Services\PopulateEnumSelect;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class CreatePlace extends Component
{
    use Interactions;

    public $types = [];
    public $levels = [];
    public $cities = [];
    public $url;
    public $city_id;
    public $neighborhood;
    public $name;
    public $latitude;
    public $longitude;
    public $panoid;
    public $pov;
    public $type;
    public $level;
    public $hints = [];

    public function mount()
    {
        $this->types = PopulateEnumSelect::getCases(PlaceTypeEnum::class, true);
        $this->levels = PopulateEnumSelect::getCases(PlaceLevelEnum::class, true);
        $this->cities = City::select('name','id')->get()->toArray();
        array_unshift($this->cities, ['id' => null, 'name' => 'Selecione uma cidade']);
    }

    public function submit()
    {
        if ($this->extractStreetViewData()) {
            $data = $this->validate([
                'city_id' => 'required|integer',
                'neighborhood' => 'nullable',
                'name' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'panoid' => 'nullable',
                'pov.heading' => 'required',
                'pov.pitch' => 'required',
                'type' => 'required',
                'level' => 'required',
                'hints' => 'nullable|array',
            ]);
            $data['active'] = true;
            $data['created_by'] = auth()->id();

            try {
                $createdPlace = Place::create($data);
                $this->toast()->success('Local cadastrado com sucesso.')->send();
                $this->reset(['url', 'city_id', 'neighborhood', 'name', 'latitude', 'longitude', 'panoid', 'pov', 'hints']);
            } catch (\Throwable $th) {
                \Log::error('Erro ao cadastrar local: ' . $th->getMessage(), ['exception' => $th]);
                $this->toast()->error('Erro ao cadastrar local.')->send();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.place.create-place');
    }

    public function extractStreetViewData()
    {
        if (!$this->url) {
            $this->toast()->error('Informe uma URL.')->send();
            return false;
        }

        preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+),3a,75y,([\d\.]+)h,([\d\.]+)t/', $this->url, $matches);

        if (count($matches) < 5) {
            $this->toast()->error('Informe uma URL válida.')->send();
            return false;
        }

        $this->latitude = $matches[1];
        $this->longitude = $matches[2];
        $this->pov['heading'] = number_format($matches[3], 0);
        $this->pov['pitch'] = 0;

        preg_match('/panoid%3D([^%]+)%26yaw%3D/', $this->url, $panoidMatch);

        $this->panoid = $panoidMatch[1] ?? null;

        return true;
    }
}
