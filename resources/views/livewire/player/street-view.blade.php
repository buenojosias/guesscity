<div class="h-full w-full">
    <div class="w-1/2">
        @if ($showStreetView)
            <div id="street-view" style="width: 50%; height: 500px;"></div>
        @endif
    </div>
</div>
@if ($showStreetView)
    @script
        <script>
            let panorama;

            function initializeStreetView(lat, lng) {
                if (!isValidCoordinates(lat, lng)) {
                    console.error("Erro ao inicializar Street View: Coordenadas inválidas", {
                        lat,
                        lng
                    });
                    return;
                }

                panorama = new google.maps.StreetViewPanorama(
                    document.getElementById("street-view"), {
                        position: {
                            lat: lat,
                            lng: lng
                        },
                        pov: {
                            heading: 0,
                            pitch: 0
                        },
                        zoom: 1,
                        disableDefaultUI: true, // Remove botões extras
                        showRoadLabels: false, // Oculta nomes de ruas
                        linksControl: false, // Desativa links de navegação
                        clickToGo: false, // Impede movimento ao clicar
                        motionTracking: false, // Impede movimentação automática em dispositivos móveis
                        motionTrackingControl: false, // Remove controle de movimentação móvel
                        scrollwheel: true, // Impede zoom com scroll
                        zoomControl: false, // Ativa controle de zoom
                    }
                );
            }

            function updateStreetViewLocation(lat, lng) {
                if (!isValidCoordinates(lat, lng)) {
                    console.error("Erro ao atualizar localização: Coordenadas inválidas", {
                        lat,
                        lng
                    });
                    return;
                }

                if (panorama) {
                    panorama.setPosition({
                        lat: lat,
                        lng: lng
                    });
                }
            }

            function isValidCoordinates(lat, lng, heading, pitch) {
                return typeof lat === "number" && !isNaN(lat) &&
                    typeof lng === "number" && !isNaN(lng);
            }

            $wire.on('initializeStreetView', ({
                latitude,
                longitude,
            }) => {
                console.log("Inicializando Street View:", {
                    latitude,
                    longitude
                });
                initializeStreetView(Number(latitude), Number(longitude));
            });

            $wire.on('updateStreetViewLocation', ({
                latitude,
                longitude,
            }) => {
                console.log("Atualizando localização para:", {
                    latitude,
                    longitude,
                });
                updateStreetViewLocation(Number(latitude), Number(longitude));
            });
        </script>
    @endscript
@endif
