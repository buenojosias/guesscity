<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GooglePanoramaService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.key');
    }

    public function fetchNewPanoramaId($latitude, $longitude)
    {
        $response = Http::get("https://maps.googleapis.com/maps/api/streetview/metadata", [
            'location' => "$latitude,$longitude",
            'key' => $this->apiKey,
        ]);

        $data = $response->json();
        return $data['status'] === 'OK' ? $data['pano_id'] : null;
    }
}
