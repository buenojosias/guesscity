<?php

namespace App\Livewire\Admin\Place;

use App\Models\Place;
use Livewire\Component;
use Livewire\WithPagination;

class ListPlace extends Component
{
    use WithPagination;

    public $rows = [];
    public $headers = [];

    public function mount()
    {
        $this->headers = [
            ['index' => 'name', 'label' => 'Nome'],
            ['index' => 'type', 'label' => 'Tipo'],
            ['index' => 'city', 'label' => 'Cidade'],
            ['index' => 'latitude', 'label' => 'Latitude'],
            ['index' => 'longitude', 'label' => 'Longitude'],
        ];

        $this->rows = Place::with('city')->get();

        $this->rows = $this->rows->map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'city' => $row->city->name,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude,
                'type' => $row->type->label(),
            ];
        });
    }

    public function render()
    {
        return view('livewire.admin.place.list-place');
    }
}
