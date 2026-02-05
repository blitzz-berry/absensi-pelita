<div class="space-y-4">
    <x-ui.section-title title="Lokasi Saya" subtitle="Pastikan lokasi kamu terdeteksi dengan baik." />

    <x-ui.card class="animate-fade-up">
        <div class="relative h-44 overflow-hidden rounded-[18px] bg-slate-100">
            <div id="lokasi-map" class="h-full w-full"></div>
            <div id="lokasi-map-overlay" class="absolute inset-0 flex items-center justify-center bg-slate-900/40 text-xs font-semibold text-white">
                Memuat peta...
            </div>
        </div>
    </x-ui.card>

    <button type="button" id="lokasi-ambil" class="w-full rounded-[16px] bg-[color:var(--color-primary)] px-4 py-3 text-xs font-semibold text-white shadow-soft">
        Ambil Lokasi Sekarang
    </button>

    <x-ui.card class="border border-emerald-100 bg-emerald-50/70">
        <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700" id="lokasi-status">
            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
            Lokasi belum diambil.
        </div>
        <div class="mt-2 text-xs text-emerald-700" id="lokasi-koordinat">-</div>
        <div class="mt-1 text-[11px] text-emerald-600" id="lokasi-akurasi"></div>
    </x-ui.card>
</div>

@push('scripts')
    <script>
        (function () {
            const statusEl = document.getElementById('lokasi-status');
            const koordinatEl = document.getElementById('lokasi-koordinat');
            const akurasiEl = document.getElementById('lokasi-akurasi');
            const button = document.getElementById('lokasi-ambil');

            function setStatus(text, tone) {
                if (!statusEl) {
                    return;
                }
                const base = 'flex items-center gap-2 text-xs font-semibold';
                const color = tone === 'error' ? 'text-rose-600' : 'text-emerald-700';
                statusEl.className = `${base} ${color}`;
                statusEl.innerHTML = `<span class="h-2 w-2 rounded-full ${tone === 'error' ? 'bg-rose-500' : 'bg-emerald-500'}"></span>${text}`;
            }

            function storeLocation(payload) {
                try {
                    localStorage.setItem('absensi_location', JSON.stringify(payload));
                } catch (error) {
                    console.warn('Gagal menyimpan lokasi', error);
                }
            }

            function hydrateLocation() {
                try {
                    const raw = localStorage.getItem('absensi_location');
                    if (!raw) {
                        return;
                    }
                    const payload = JSON.parse(raw);
                    if (!payload || !Number.isFinite(payload.lat) || !Number.isFinite(payload.lng) || !Number.isFinite(payload.accuracy)) {
                        return;
                    }
                    if (koordinatEl) {
                        koordinatEl.textContent = `${payload.lat.toFixed(6)}, ${payload.lng.toFixed(6)}`;
                    }
                    if (akurasiEl) {
                        akurasiEl.textContent = `Akurasi ${Math.round(payload.accuracy)} meter`;
                    }
                    setStatus('Lokasi terakhir siap digunakan.', 'success');
                } catch (error) {
                    return;
                }
            }

            function handleSuccess(position) {
                const payload = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                    accuracy: position.coords.accuracy,
                    timestamp: Date.now(),
                };
                storeLocation(payload);
                if (koordinatEl) {
                    koordinatEl.textContent = `${payload.lat.toFixed(6)}, ${payload.lng.toFixed(6)}`;
                }
                if (akurasiEl) {
                    akurasiEl.textContent = `Akurasi ${Math.round(payload.accuracy)} meter`;
                }
                if (typeof window.__updateLokasiMap === 'function') {
                    window.__updateLokasiMap(payload.lat, payload.lng, payload.accuracy);
                }
                setStatus('Lokasi siap digunakan untuk absensi.', 'success');
            }

            function handleError() {
                setStatus('Gagal mendapatkan lokasi. Coba lagi.', 'error');
                if (koordinatEl) {
                    koordinatEl.textContent = '-';
                }
                if (akurasiEl) {
                    akurasiEl.textContent = '';
                }
            }

            function requestLocation() {
                if (!navigator.geolocation) {
                    handleError();
                    return;
                }
                setStatus('Mencari lokasi...', 'success');
                navigator.geolocation.getCurrentPosition(handleSuccess, handleError, {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0,
                });
            }

            if (button) {
                button.addEventListener('click', requestLocation);
            }

            hydrateLocation();
        })();
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #lokasi-map .leaflet-container {
            font-family: 'Sora', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function () {
            const mapEl = document.getElementById('lokasi-map');
            const overlayEl = document.getElementById('lokasi-map-overlay');
            let mapInstance = null;
            let marker = null;
            let accuracyCircle = null;

            function hideOverlay() {
                if (overlayEl) {
                    overlayEl.classList.add('hidden');
                }
            }

            function showOverlay(message) {
                if (!overlayEl) {
                    return;
                }
                overlayEl.textContent = message;
                overlayEl.classList.remove('hidden');
            }

            function initMap(lat, lng, accuracy) {
                if (!mapEl || typeof L === 'undefined') {
                    showOverlay('Peta gagal dimuat.');
                    return;
                }

                const center = [lat, lng];

                if (!mapInstance) {
                    mapInstance = L.map(mapEl, {
                        zoomControl: false,
                    }).setView(center, 16);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(mapInstance);
                } else {
                    mapInstance.setView(center, 16);
                }

                if (!marker) {
                    marker = L.marker(center).addTo(mapInstance);
                } else {
                    marker.setLatLng(center);
                }

                if (accuracy && Number.isFinite(accuracy)) {
                    const radius = Math.min(accuracy, 150);
                    if (!accuracyCircle) {
                        accuracyCircle = L.circle(center, {
                            radius: radius,
                            color: '#38bdf8',
                            fillColor: '#38bdf8',
                            fillOpacity: 0.25,
                        }).addTo(mapInstance);
                    } else {
                        accuracyCircle.setLatLng(center);
                        accuracyCircle.setRadius(radius);
                    }
                }

                hideOverlay();
                setTimeout(() => mapInstance.invalidateSize(), 100);
            }

            function hydrateMapFromStorage() {
                try {
                    const raw = localStorage.getItem('absensi_location');
                    if (!raw) {
                        showOverlay('Lokasi belum diambil.');
                        return;
                    }
                    const payload = JSON.parse(raw);
                    if (!payload || !Number.isFinite(payload.lat) || !Number.isFinite(payload.lng)) {
                        showOverlay('Lokasi belum diambil.');
                        return;
                    }
                    initMap(payload.lat, payload.lng, payload.accuracy);
                } catch (error) {
                    showOverlay('Lokasi belum diambil.');
                }
            }

            hydrateMapFromStorage();

            window.__updateLokasiMap = function (lat, lng, accuracy) {
                initMap(lat, lng, accuracy);
            };
        })();
    </script>
@endpush
