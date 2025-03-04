<div>
    @if ($panoramaId)
        <div class="min-w-full h-screen flex overflow-x-auto">
            <img src="https://maps.googleapis.com/maps/api/streetview?size=2048x2048&pano={{ $panoramaId }}&key={{ $apiKey }}&fov=90&heading=90&pitch=0"
                alt="Carregar visualização do Street View" class="h-full" />
            <img src="https://maps.googleapis.com/maps/api/streetview?size=1200x800&pano={{ $panoramaId }}&key={{ $apiKey }}&fov=90&heading=180&pitch=0"
                alt="Carregar visualização do Street View" class="h-full" />
        </div>
        <div id="street-view" style="width: 100%; height: 100vh;"></div>

        <script>
            function initStreetView() {
                var panorama = new google.maps.StreetViewPanorama(
                    document.getElementById("street-view"), {
                        pano: "{{ $panoramaId }}",
                        pov: {
                            heading: 90,
                            pitch: 0
                        }, // Direção da câmera
                        zoom: 0, // Nível de zoom
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

                // Adiciona um listener para o evento de mudança de status
                // panorama.addListener('status_changed', function() {
                //     if (panorama.getStatus() === 'ZERO_RESULTS' || panorama.getStatus() === 'UNKNOWN_ERROR') {
                //         // Emite um evento para o Livewire
                //         console.log('Invalid panorama ID');
                //         Livewire.emit('streetViewError', 'Invalid panorama ID');
                //     }
                // });

                /*                // Adiciona um listener de teclado com prioridade máxima
                                document.addEventListener('keydown', handleKeyDown, {
                                    capture: true
                                });

                                function handleKeyDown(event) {
                                    // Verifica se as teclas up ou down foram pressionadas
                                    if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
                                        event.stopPropagation(); // Impede que o evento seja processado pela API
                                        event.preventDefault(); // Anula o comportamento padrão

                                        // Adiciona o comportamento personalizado
                                        const currentPov = panorama.getPov();
                                        const pitchIncrement = 5; // Quantos graus o ângulo deve mudar

                                        if (event.key === 'ArrowUp') {
                                            currentPov.pitch = Math.min(currentPov.pitch + pitchIncrement,
                                            90); // Limita o ângulo máximo para 90°
                                        } else if (event.key === 'ArrowDown') {
                                            currentPov.pitch = Math.max(currentPov.pitch - pitchIncrement, -
                                            90); // Limita o ângulo mínimo para -90°
                                        }

                                        // Atualiza o POV do Street View
                                        panorama.setPov(currentPov);
                                    }
                                }*/
            }
        </script>

        {{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initStreetView" async defer>
        </script> --}}
    @else
        <p class="text-danger">Nenhuma visualização do Street View disponível para este local.</p>
    @endif
</div>
