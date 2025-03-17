{{-- <div class="h-full w-full z-0 fixed top-0 left-0 bg-slate-950/90"> --}}
<div class="fixed top-0 left-0 h-screen w-full">
    {{-- <div class="fixed w-full h-full z-10"></div> --}}
    <div id="street-view" class="fixed top-0 left-0 h-screen w-full" wire:ignore></div>
</div>
{{-- @if ($showStreetView) --}}
    @script
        <script>
            let panorama;

            function initializeStreetView() {
                console.log("Inicializando Street View");
                // if (!isValidCoordinates(lat, lng)) {
                //     console.error("Erro ao inicializar Street View: Coordenadas inválidas", { lat, lng });
                //     return;
                // }

                if (!panorama) { // Só cria se ainda não existir
                    panorama = new google.maps.StreetViewPanorama(
                        document.getElementById("street-view"), {
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
                    if (panorama) {
                        $wire.dispatch('street-view-loaded');
                    } else {
                        console.error("Erro ao inicializar Street View");
                    }
                } else {
                    console.log("Street View já foi inicializado");
                }

                // Observador para remover interatividade do link da logo
                // const observer = new MutationObserver(() => {
                //     document.querySelectorAll('.gm-style a[href^="https://maps.google.com/maps"]').forEach(link => {
                //         link.style.pointerEvents = 'none';
                //         link.style.cursor = 'default';
                //     });
                // });

                // Monitorar mudanças na árvore DOM
                // observer.observe(document.body, {
                //     childList: true,
                //     subtree: true
                // });
            }

            function updateStreetViewLocation(lat, lng, heading) {
                if (!isValidCoordinates(lat, lng)) {
                    console.error("Erro ao atualizar localização: Coordenadas inválidas", { lat, lng });
                    return;
                }

                if (panorama) {
                    console.log("Atualizando localização para:", { lat, lng, heading });
                    panorama.setPosition({ lat: lat, lng: lng });
                    panorama.setPov({
                        heading: heading,
                        pitch: 0
                    });
                }
            }

            function isValidCoordinates(lat, lng) {
                return typeof lat === "number" && !isNaN(lat) &&
                    typeof lng === "number" && !isNaN(lng);
            }

            $wire.on('load-street-view', () => {
                initializeStreetView();
            });

            $wire.on('updateStreetViewLocation', ({
                latitude,
                longitude,
                heading,
            }) => {
                console.log("Atualizando localização para:", {
                    latitude,
                    longitude,
                    heading,
                });
                updateStreetViewLocation(Number(latitude), Number(longitude), Number(heading));
            });
        </script>
    @endscript
{{-- @endif --}}
