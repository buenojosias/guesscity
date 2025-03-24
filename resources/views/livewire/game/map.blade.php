<div>
    <x-ts-button text="Marcar no mapa" x-on:click="$modalOpen('map-modal')" color="amber" />
    <x-ts-modal id="map-modal" size="5xl" blur persistent center>
        <div wire:ignore id="map" class="w-full">Mapa não carregado</div>
        <x-slot:footer>
            <div class="w-full flex justify-between items-center">
                @if (!$distance)
                    <x-ts-button wire:click="$dispatchSelf('center-map')" text="Centralizar mapa" />
                    <div>
                        <x-ts-button wire:click="calculateDistance" text="Confirmar resposta" color="amber"
                            :disabled="$clicked === null" />
                        <x-ts-button icon="x-mark" color="gray" x-on:click="$modalClose('map-modal')" />
                    </div>
                @else
                    <p class="text-gray-800 text-xl">Distância entre o local marcado e o correto:
                        <strong>{{ $distance < 1 ? number_format($distance * 1000, 0, null) . ' metros' : number_format($distance, 1, ',') . ' km' }}</strong>.<br>
                        Você ganhou <strong>999</strong> pontos!
                    </p>
                    <div>
                        <x-ts-button wire:click="newGame" text="Nova rodada" color="amber" />
                        <x-ts-button icon="x-mark" color="gray" x-on:click="$dispatch('reset-map')" />
                    </div>
                @endif
            </div>
        </x-slot:footer>
    </x-ts-modal>
</div>
@script
    <script>
        let map;
        let placeMarker, clickedMarker, line;

        initialPosition = {
            lat: {{ $initialPosition['lat'] }},
            lng: {{ $initialPosition['lng'] }}
        };

        $wire.on('load-map', () => {
            setTimeout(() => {
                initializeMap();
            }, 100);
        });

        $wire.on('center-map', () => {
            console.log('Centralizar mapa');
            centerMap();
        });

        function centerMap() {
            if (map) {
                // Usa panTo com animação para mover suavemente o mapa para a posição inicial
                map.panTo(initialPosition, {
                    animate: true,
                    duration: 1000 // Duração da animação em milissegundos
                });

                // Define o zoom após a animação de panTo
                setTimeout(() => {
                    map.setZoom(15);
                }, 100); // Ajuste o tempo conforme necessário para sincronizar com a animação
            } else {
                console.error("Mapa não foi inicializado corretamente.");
            }
        }

        function initializeMap() {
            var options = {
                zoom: 15, // Nível de zoom
                center: initialPosition, // Centro do mapa
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
                }]
            };

            // Cria o mapa no elemento div com id "map"
            map = new google.maps.Map(document.getElementById('map'), options);
            if (map) {
                $wire.dispatch('map-loaded');
            } else {
                console.error("Erro ao inicializar o mapa");
            }

            map.setOptions({
                draggableCursor: 'crosshair' // Altera o cursor para um ícone de "mira"
            });

            // Ícones personalizados para os marcadores
            var placeIcon = {
                url: 'https://maps.google.com/mapfiles/kml/pal4/icon54.png', // Ícone personalizado (bandeira)
                scaledSize: new google.maps.Size(32, 32) // Tamanho do ícone
            };

            var clickIcon = {
                url: 'https://maps.google.com/mapfiles/kml/pal2/icon10.png', // Ícone personalizado (alvo)
                scaledSize: new google.maps.Size(32, 32) // Tamanho do ícone
            };

            map.addListener('click', function(event) {
                if (line) return;

                // Remove o marcador anterior, se existir
                if (clickedMarker instanceof google.maps.Marker) {
                    clickedMarker.setMap(null);
                }

                // Obtém as coordenadas do clique
                let clickedCoords = {
                    lat: event.latLng.lat(),
                    lng: event.latLng.lng()
                };

                // Cria um novo marcador
                clickedMarker = new google.maps.Marker({
                    position: clickedCoords,
                    map: map,
                });

                // Envia as coordenadas para o Livewire
                $wire.dispatch('set-clicked', {
                    coords: clickedCoords
                });
            });
        }

        $wire.on('clean-clicked', () => {
            if (clickedMarker) clickedMarker.setMap(null);
            $wire.dispatch('set-clicked');
        });

        $wire.on('reset-map', () => {
            $modalClose('map-modal');

            // Remove o marcador de lugar se existir
            if (placeMarker instanceof google.maps.Marker) {
                placeMarker.setMap(null);
                placeMarker = null;
            }

            // Remove o marcador de clique se existir
            if (clickedMarker instanceof google.maps.Marker) {
                clickedMarker.setMap(null);
                clickedMarker = null;
            }

            // Remove a linha se existir
            if (line instanceof google.maps.Polyline) {
                line.setMap(null);
                line = null;
            }

            console.log(clickedMarker, placeMarker, line);

            // Centraliza o mapa na posição inicial
            centerMap();
            $wire.dispatch('set-clicked');
        });

        $wire.on('draw-line', ({ place, clicked, distance }) => {
            clickedMarker.setMap(null)
            placeMarker = place;
            clickedMarker = clicked;

            clickedMarker = new google.maps.Marker({
                position: {
                    lat: clicked.lat,
                    lng: clicked.lng
                },
                map: map,
            });

            placeMarker = new google.maps.Marker({
                position: {
                    lat: place.lat,
                    lng: place.lng
                },
                map: map,
            });

            line = new google.maps.Polyline({
                path: [{
                        lat: place.lat,
                        lng: place.lng
                    },
                    {
                        lat: clicked.lat,
                        lng: clicked.lng
                    }
                ],
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2,
                map: map
            });
        });
    </script>
@endscript
