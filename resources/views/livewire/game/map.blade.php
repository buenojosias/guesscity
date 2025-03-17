<div class="absolute z-100 bottom-0 right-16 mx-auto my-32 w-1/3 h-72 bg-white rounded p-1">
    <div wire:ignore id="map" class="w-full h-full">Carregar mapa</div>
    <x-ts-button wire:click="$dispatch('get-place')" text="Carregar outro local" />
    <x-ts-button wire:click="$dispatchSelf('center-map')" text="Centralizar mapa" />
</div>
@script
    <script>
        let map;
        let placeMarker, clickedMarker, line;

        // Coordenadas da posição inicial
        initialPosition = {
            lat: {{ $initialPosition['lat'] }},
            lng: {{ $initialPosition['lng'] }}
        };

        $wire.on('load-map', () => {
            console.log('Renderizar mapa');
            setTimeout(() => {
                initializeMap();
            }, 100);
        });

        // $wire.on('set-place', ({
        //     lat,
        //     lng
        // }) => {
        //     placeCoords = {
        //         lat: lat,
        //         lng: lng
        //     };
        //     if (placeMarker) placeMarker.setMap(null);
        //     if (clickedMarker) clickedMarker.setMap(null);
        //     if (line) line.setMap(null);

        //     console.log('Local definido:', placeCoords);
        //     centerMap();
        // });

        $wire.on('clear-map', () => {
            if (placeMarker) placeMarker.setMap(null);
            if (clickedMarker) clickedMarker.setMap(null);
            if (line) line.setMap(null);
        });

        $wire.on('center-map', () => {
            console.log('Centralizar mapa');
            centerMap();
        });

        function centerMap() {
            if (map) { // Verifica se o objeto map foi criado
                map.setCenter(initialPosition);
            } else {
                console.error("Mapa não foi inicializado corretamente.");
            }
        }

        function initializeMap() {
            var options = {
                zoom: 14, // Nível de zoom
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

            // google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
            //     $wire.dispatch('map-loaded');
            //     console.log('Mapa carregado');
            // });

            // Personaliza o cursor do mouse
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
                var latClick = event.latLng.lat();
                var lngClick = event.latLng.lng();
                clickedCoords = {
                    lat: latClick,
                    lng: lngClick
                };
                console.log('Coordenadas do clique:', clickedCoords);
                // if (placeMarker) placeMarker.setMap(null);
                if (clickedMarker) clickedMarker.setMap(null);
                if (line) line.setMap(null);
                $wire.dispatch('set-clicked', {
                    coords: clickedCoords
                });
            });
        }

        $wire.on('draw-line', ({
            place,
            clicked,
            distance
        }) => {
            placeMarker = place;
            clickedMarker = clicked;
            console.log(placeMarker, clickedMarker, distance)

            placeMarker = new google.maps.Marker({
                position: {
                    lat: place.lat,
                    lng: place.lng
                },
                map: map,
            });

            clickedMarker = new google.maps.Marker({
                position: {
                    lat: clicked.lat,
                    lng: clicked.lng
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
