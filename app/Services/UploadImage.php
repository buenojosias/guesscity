<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class UploadImage
{
    public static function uploadThumbnail($panoid, $pov)
    {
        if (!$panoid) {
            return ['error' => 'Panoid não encontrado'];
        }

        $angle = [
            'heading' => $pov['heading'] + 0,
            'pitch' => $pov['pitch']
        ];

        $image = "https://streetviewpixels-pa.googleapis.com/v1/thumbnail?cb_client=maps_sv.tactile&w=900&h=600&pitch={$angle['pitch']}&panoid={$panoid}&yaw={$angle['heading']}";

        $client = new Client();
        $response = $client->get($image);
        $filename = $panoid . '.jpg';
        $storagePath = 'panoramas/' . $filename;

        return Storage::disk('public')->put($storagePath, $response->getBody()->getContents());
    }

    public static function uploadStaticAPI($panoid, $pov, $latitude, $longitude)
    {
        $apiKey = config('services.google_maps.key');

        if (!$panoid) {
            return ['error' => 'Panoid não encontrado'];
        }

        $angle = [
            'heading' => $pov['heading'], 'pitch' => $pov['pitch']
        ];

        $image = "https://maps.googleapis.com/maps/api/streetview?size=600x600&location={$latitude},{$longitude}&fov=90&heading={$angle['heading']}&pitch={$angle['pitch']}&key={$apiKey}";
    }
}
