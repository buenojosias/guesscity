<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.key');
    }

    public function index()
    {
        $url = "https://maps.googleapis.com/maps/api/streetview/metadata";

        $location = Location::find(1);

        if (!$location->panorama_id) {
            dump('Obtendo Panorama ID...');
            $response = Http::get($url, [
                'location' => "$location->latitude,$location->longitude",
                'key' => $this->apiKey,
            ]);

            dump('Panorama ID obtido com sucesso!');
            $data = $response->json();

            if ($data['status'] === 'OK') {
                $location->panorama_id = $data['pano_id'];
                $location->save();
                dump('Panorama ID salvo no banco de dados!', $location);
            } else {
                dump('Erro ao obter o Panorama ID: ' . $response->status());
            }
        } else {
            dump('Panorama ID já está salvo no banco de dados!');
            $data = $location;
        }

        dump($data);
    }

    // public function streetView()
    // {
    //     $this->getPanorama(1);
    //     // return view('welcome');
    // }

    // function getPanorama($locationId)
    // {
    //     $location = $this->locations[$locationId];

    //     // Obtém o Panorama ID usando o serviço
    //     $panoramaId = $this->getPanoramaId(
    //         $location['latitude'],
    //         $location['longitude']
    //     );

    //     // Retorna o Panorama ID para o front-end
    //     return response()->json(['panorama_id' => $panoramaId]);
    // }

    // public function getPanoramaId($latitude, $longitude)
    // {
    //     $cacheKey = 'street_view_panorama_id_' . md5("{$latitude}_{$longitude}");

    //     // Verifica se o Panorama ID já está em cache
    //     if (Cache::has($cacheKey)) {
    //         return Cache::get($cacheKey);
    //     }

    //     // Faz a requisição à API do Google Street View para obter o Panorama ID
    //     $response = Http::get('https://maps.googleapis.com/maps/api/streetview/metadata', [
    //         'location' => "{$latitude},{$longitude}",
    //         'key' => $this->apiKey,
    //     ]);

    //     if ($response->successful()) {
    //         $data = $response->json();

    //         if ($data['status'] === 'OK') {
    //             $panoramaId = $data['pano_id'];

    //             // Armazena o Panorama ID em cache por 30 dias
    //             Cache::put($cacheKey, $panoramaId, now()->addDays(30));

    //             return $panoramaId;
    //         }
    //     }

    //     // Trate erros de requisição
    //     throw new \Exception("Erro ao obter o Panorama ID: " . $response->status());
    // }
}
