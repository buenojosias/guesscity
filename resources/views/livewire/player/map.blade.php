<div class="mx-auto my-32 w-2/3 h-2/3 bg-white">
    <x-ts-button wire:click="$dispatchSelf('render-map')" text="Carregar mapa" />
    <div id="map" class="w-full h-full">Carregar mapa</div>
</div>
@script
    <script>
        $wire.on('render-map', () => {
            console.log('Carregar Street View');
            initMap();
        });

        function initMap() {
            // Coordenadas da posição inicial
            var initialPosition = {
                lat: -25.4322,
                lng: -49.2811
            };

            // Coordenadas do local
            var placeCoords = {
                lat: -25.4426,
                lng: -49.3438
            };

            // Opções do mapa
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
            var map = new google.maps.Map(document.getElementById('map'), options);

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

            // Variáveis para armazenar os marcadores e a linha
            var placeMarker = null;
            var clickMarker = null;
            var linha = null;

            // Intercepta o clique do usuário no mapa
            map.addListener('click', function(event) {
                // Obtém as coordenadas do clique
                var latClick = event.latLng.lat();
                var lngClick = event.latLng.lng();
                var clickCoords = {
                    lat: latClick,
                    lng: lngClick
                };

                // Exibe no console as coordenadas da memória e do clique
                console.log('Coordenadas da memória:', placeCoords);
                console.log('Coordenadas do clique:', clickCoords);

                // Remove marcadores e linha anteriores (se existirem)
                if (placeMarker) placeMarker.setMap(null);
                if (clickMarker) clickMarker.setMap(null);
                if (linha) linha.setMap(null);

                // Adiciona marcadores no mapa com ícones personalizados
                placeMarker = new google.maps.Marker({
                    position: placeCoords,
                    map: map,
                    icon: placeIcon, // Ícone personalizado
                    title: 'Local correto'
                });

                clickMarker = new google.maps.Marker({
                    position: clickCoords,
                    map: map,
                    icon: clickIcon, // Ícone personalizado
                    title: 'Local clicado'
                });

                // Traça uma linha entre os dois pontos
                linha = new google.maps.Polyline({
                    path: [placeCoords, clickCoords],
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                    map: map
                });

                // Calcula a distância entre os dois pontos em km
                var distance = calcularDistance(placeCoords, clickCoords);
                console.log('Distância entre os pontos:', distance.toFixed(2), 'km');
            });

            // Função para calcular a distância entre dois pontos em km (fórmula de Haversine)
            function calcularDistance(coordinates1, coordinates2) {
                var earthRadius = 6371; // Raio da Terra em km
                var lat1 = coordinates1.lat * (Math.PI / 180);
                var lng1 = coordinates1.lng * (Math.PI / 180);
                var lat2 = coordinates2.lat * (Math.PI / 180);
                var lng2 = coordinates2.lng * (Math.PI / 180);

                var dLat = lat2 - lat1;
                var dLng = lng2 - lng1;

                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1) * Math.cos(lat2) *
                    Math.sin(dLng / 2) * Math.sin(dLng / 2);

                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                return earthRadius * c;
            }
        }
    </script>
@endscript
