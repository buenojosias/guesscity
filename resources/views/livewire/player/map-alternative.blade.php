<div class="fixed z-100 top-3 mx-auto my-32 w-2/3 h-2/3 bg-white">
    <x-ts-button wire:click="$dispatchSelf('load-map')" text="Carregar mapa" />
    <x-ts-button wire:click="$dispatch('getPlace')" text="Carregar local" :disabled="$loadPlaceDisabled" />
    <x-ts-button wire:click="$dispatchSelf('center-map')" text="Centralizar mapa" />
    <p>Distância entre os pontos: {{ $distance ?? 'N/A' }} km</p>
    <div wire:ignore id="map" class="w-full h-full">Carregar mapa</div>
</div>

@script
    <script>
        let map;
        let marker1, marker2, line;

        $wire.on('load-map', () => {
            console.log('Carregar mapa');
            setTimeout(() => {
                initMap();
            }, 100);
        });

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                disableDefaultUI: true,
                streetViewControl: false,
                mapTypeControl: false,
                fullscreenControl: false,
                zoomControl: true,
                styles: [{
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                }],
                center: {
                    lat: {{ $initialPosition['lat'] }},
                    lng: {{ $initialPosition['lng'] }}
                }
            });
        }

        $wire.on('center-map', () => {
            if (map) {
                map.setCenter({
                    lat: {{ $initialPosition['lat'] }},
                    lng: {{ $initialPosition['lng'] }}
                });
            }
        });

        $wire.on('update-map', ({ lat1, lon1, lat2, lon2 }) => {
            if (marker1) marker1.setMap(null);
            if (marker2) marker2.setMap(null);
            if (line) line.setMap(null);

            marker1 = new google.maps.Marker({
                position: { lat: lat1, lng: lon1 },
                map: map,
                title: 'Ponto 1'
            });

            marker2 = new google.maps.Marker({
                position: { lat: lat2, lng: lon2 },
                map: map,
                title: 'Ponto 2'
            });

            line = new google.maps.Polyline({
                path: [
                    { lat: lat1, lng: lon1 },
                    { lat: lat2, lng: lon2 }
                ],
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2,
                map: map
            });
        });

        $wire.on('get-place', () => {
            console.log('Carregando local aleatório...');
        });

        $wire.on('clicked', (coords) => {
            console.log('Coordenadas clicadas:', coords);
            $wire.dispatch('updateCoordinates', { lat: coords.lat, lng: coords.lng });
        });

        map?.addListener('click', function(event) {
            let clickedLocation = event.latLng;
            $wire.dispatch('clicked', {
                lat: clickedLocation.lat(),
                lng: clickedLocation.lng()
            });
        });
    </script>
@endscript
