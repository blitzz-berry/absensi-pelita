@extends('layouts.mobile-app')

@section('title', 'Lokasi Kehadiran')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #admin-lokasi-map {
            width: 100%;
            height: 100%;
        }

        #admin-lokasi-map .leaflet-container {
            font-family: 'Sora', sans-serif;
        }
    </style>
@endpush

@section('content')
<div class="space-y-4">
    <x-ui.section-title title="Lokasi" subtitle="Peta lokasi absensi semua guru." />

    <x-ui.card class="space-y-3">
        <div class="relative h-[420px] overflow-hidden rounded-[16px] border border-slate-100 bg-slate-100">
            <div id="admin-lokasi-map" class="h-full w-full"></div>
            <div id="admin-lokasi-overlay" class="absolute inset-0 flex items-center justify-center bg-slate-900/40 text-xs font-semibold text-white">
                Memuat peta...
            </div>
        </div>
        <div id="admin-lokasi-status" class="text-[11px] text-slate-500">
            Menyiapkan data lokasi...
        </div>
    </x-ui.card>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapEl = document.getElementById('admin-lokasi-map');
            const overlayEl = document.getElementById('admin-lokasi-overlay');
            const statusEl = document.getElementById('admin-lokasi-status');

            if (!mapEl) {
                return;
            }

            if (typeof L === 'undefined') {
                if (overlayEl) {
                    overlayEl.textContent = 'Peta tidak bisa dimuat.';
                }
                return;
            }

            const defaultTanggal = @json($tanggal ?? date('Y-m-d'));
            const schoolLatLng = [-6.470063, 106.703517];

            const map = L.map(mapEl, {
                zoomControl: true,
                scrollWheelZoom: false,
            }).setView(schoolLatLng, 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const markersLayer = L.layerGroup().addTo(map);

            function escapeHtml(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#x27;');
            }

            function statusColor(status) {
                switch (status) {
                    case 'hadir':
                        return '#22c55e';
                    case 'terlambat':
                        return '#f97316';
                    case 'izin':
                        return '#4c8df6';
                    case 'sakit':
                        return '#a855f7';
                    default:
                        return '#ef4444';
                }
            }

            function createMarkerIcon(label, color) {
                return L.divIcon({
                    className: 'admin-location-marker',
                    html: '<div style="background:' + color + ';width:24px;height:24px;border-radius:999px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;border:2px solid #fff;font-size:11px;">' + label + '</div>',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
            }

            function normalizeNumber(value) {
                const numberValue = typeof value === 'number' ? value : parseFloat(value);
                return Number.isFinite(numberValue) ? numberValue : null;
            }

            function addMarkers(locations) {
                markersLayer.clearLayers();

                if (!locations.length) {
                    if (overlayEl) {
                        overlayEl.classList.add('hidden');
                    }
                    if (statusEl) {
                        statusEl.textContent = 'Belum ada lokasi absensi. Peta tetap aktif untuk monitoring.';
                    }
                    return;
                }

                if (overlayEl) {
                    overlayEl.classList.add('hidden');
                }
                if (statusEl) {
                    statusEl.textContent = `Menampilkan ${locations.length} titik lokasi absensi.`;
                }

                const bounds = [];

                locations.forEach((location) => {
                    const lat = normalizeNumber(location.lat);
                    const lng = normalizeNumber(location.lng);

                    if (lat === null || lng === null) {
                        return;
                    }

                    const initial = (location.name || 'U').trim().charAt(0).toUpperCase();
                    const icon = createMarkerIcon(initial, statusColor(location.status));
                    const popupHtml =
                        '<div style="min-width:180px;">' +
                        '<div style="font-weight:600;color:#0f172a;">' + escapeHtml(location.name || 'Guru') + '</div>' +
                        '<div style="margin-top:4px;font-size:12px;color:#64748b;">' + escapeHtml(location.jabatan || '-') + '</div>' +
                        '<div style="margin-top:8px;font-size:12px;color:#334155;">Status: ' + escapeHtml(location.status || '-') + '</div>' +
                        '<div style="margin-top:4px;font-size:12px;color:#334155;">Waktu: ' + escapeHtml(location.time || '-') + '</div>' +
                        '</div>';

                    const marker = L.marker([lat, lng], { icon })
                        .addTo(markersLayer)
                        .bindPopup(popupHtml);

                    bounds.push(marker.getLatLng());
                });

                if (bounds.length) {
                    map.fitBounds(bounds, { padding: [30, 30] });
                }
            }

            function loadLocations() {
                if (overlayEl) {
                    overlayEl.textContent = 'Memuat lokasi...';
                    overlayEl.classList.remove('hidden');
                }
                if (statusEl) {
                    statusEl.textContent = 'Memuat data lokasi...';
                }

                fetch(`/admin/api/lokasi-kehadiran?scope=all`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Gagal memuat lokasi');
                        }
                        return response.json();
                    })
                    .then((data) => {
                        const locations = Array.isArray(data.lokasi_guru) ? data.lokasi_guru : [];
                        addMarkers(locations);
                    })
                    .catch(() => {
                        if (overlayEl) {
                            overlayEl.textContent = 'Gagal memuat lokasi.';
                        }
                        if (statusEl) {
                            statusEl.textContent = 'Gagal memuat data lokasi.';
                        }
                    })
                    .finally(() => {
                        setTimeout(() => map.invalidateSize(), 100);
                    });
            }

            loadLocations();
        });
    </script>
@endpush
