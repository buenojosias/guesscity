<div class="fixed z-100 top-3 mx-auto my-32 w-2/3 h-2/3 bg-white">
    <x-ts-button wire:click="$dispatchSelf('load-map')" text="Carregar mapa" />
    <x-ts-button wire:click="$dispatch('get-place')" text="Carregar local" />
    <x-ts-button wire:click="$dispatchSelf('center-map')" text="Centralizar mapa" />
    <p>Distância entre os pontos: {{ $distance ?? 'N/A' }} km</p>
    <div wire:ignore id="map" class="w-full h-full">Carregar mapa</div>
</div>
@script
    <script>
        initialPosition = {
            lat: {{ $initialPosition['lat'] }},
            lng: {{ $initialPosition['lng'] }}
        };

        $wire.on('load-map', () => {
            console.log('Carregar mapa');
            setTimeout(() => {
                initMap();
            }, 100);
        });

        function initMap() {
            var point1 = {
                lat: {{ $lat1 }},
                lng: {{ $lon1 }}
            };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                disableDefaultUI: true, // Desativa todos os controles padrão
                streetViewControl: false, // Remove o botão do Street View
                mapTypeControl: false, // Remove o controle de tipo de mapa
                fullscreenControl: false, // Remove o botão de tela cheia
                zoomControl: true, // Mantém o controle de zoom (opcional)
                styles: [{
                    featureType: "poi", // Pontos de interesse (comércios, etc.)
                    elementType: "labels",
                    stylers: [{
                        visibility: "off"
                    }] // Oculta os nomes dos comércios
                }],
                center: initialPosition
            });

            map.setOptions({
                draggableCursor: 'crosshair' // Altera o cursor para um ícone de "mira"
            });

            var marker1 = new google.maps.Marker({
                position: point1,
                map: map,
                title: 'Ponto 1'
            });

            var marker2;
            var line;

            // Captura o evento de clique no mapa
            map.addListener('click', function(event) {
                var clickedLocation = event.latLng;

                // Remove o marcador anterior, se existir
                if (marker2) {
                    marker2.setMap(null);
                }

                // Adiciona um novo marcador no local clicado
                marker2 = new google.maps.Marker({
                    position: clickedLocation,
                    map: map,
                    title: 'Ponto 2'
                });

                // Atualiza a linha entre os pontos
                if (line) {
                    line.setMap(null);
                }
                line = new google.maps.Polyline({
                    path: [point1, clickedLocation],
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                    map: map
                });

                // Envia as coordenadas para o Livewire
                // $wire.dispatch('updateCoordinates', { lat: clickedLocation.lat(), lng: clickedLocation.lng()});
                $wire.dispatchSelf('clicked', {
                    lat: clickedLocation.lat(),
                    lng: clickedLocation.lng()
                });
            });
        }

        $wire.on('clicked', (coords) => {
            console.log('Clicado', coords);
            $wire.dispatchSelf('updateCoordinates', {
                coords: coords
            });
        });
    </script>
@endscript
