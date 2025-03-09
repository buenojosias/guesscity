<?php

namespace App\Livewire\Admin\Place;

use App\Models\Place;
use Livewire\Component;

class ListPlace extends Component
{
    public $rows = [];
    public $headers = [];

    public function mount()
    {
        $this->headers = [
            ['index' => 'name', 'label' => 'Nome'],
            ['index' => 'type', 'label' => 'Tipo'],
            ['index' => 'city_id', 'label' => 'Cidade'],
            ['index' => 'latitude', 'label' => 'Latitude'],
            ['index' => 'longitude', 'label' => 'Longitude'],
        ];

        $this->rows = Place::all()->toArray();
    }

    public function render()
    {
        return view('livewire.admin.place.list-place');
    }
}
