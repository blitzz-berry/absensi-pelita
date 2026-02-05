<div class="space-y-4">
    <x-ui.section-title
        :title="'Selamat Datang, ' . ($user?->nama ?? 'Guru')"
        subtitle="Dashboard Guru - Sistem Absensi Guru"
    />

    @php
        $alreadyMasuk = $absensiHariIni?->jam_masuk;
        $alreadyPulang = $absensiHariIni?->jam_pulang;
    @endphp

    <div class="grid grid-cols-2 gap-3">
        <x-ui.card class="animate-fade-up">
            <div class="text-[11px] uppercase tracking-wide text-slate-500">Tanggal & Jam</div>
            <div class="mt-2 text-sm font-semibold text-slate-900">{{ $now->format('d M Y') }}</div>
            <div class="mt-1 text-xs text-slate-500" id="live-clock">
                {{ $now->format('H:i') }} WIB
            </div>
        </x-ui.card>
        <x-ui.card class="animate-fade-up stagger-1">
            <div class="text-[11px] uppercase tracking-wide text-slate-500">Status Hari Ini</div>
            <div class="mt-2 text-sm font-semibold text-slate-900" id="status-hari-ini">
                {{ $absensiHariIni?->status ? ucfirst($absensiHariIni->status) : '-' }}
            </div>
            <div class="mt-1 text-xs text-slate-500" id="status-detail">
                {{ $absensiHariIni?->jam_masuk ? 'Masuk: ' . substr($absensiHariIni->jam_masuk, 0, 5) : 'Belum absen' }}
            </div>
        </x-ui.card>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <button type="button"
            class="animate-fade-up rounded-[16px] bg-emerald-500 px-4 py-3 text-xs font-semibold text-white shadow-soft disabled:cursor-not-allowed disabled:opacity-60"
            data-action="masuk"
            id="absen-masuk-btn"
            @disabled($alreadyMasuk)
        >
            {{ $alreadyMasuk ? 'Sudah Masuk' : 'Absen Masuk' }}
        </button>
        <button type="button"
            class="animate-fade-up stagger-1 rounded-[16px] bg-rose-500 px-4 py-3 text-xs font-semibold text-white shadow-soft disabled:cursor-not-allowed disabled:opacity-60"
            data-action="pulang"
            id="absen-pulang-btn"
            @disabled($alreadyPulang)
        >
            {{ $alreadyPulang ? 'Sudah Pulang' : 'Absen Pulang' }}
        </button>
    </div>

    @php
        $statusVariant = function (?string $status) {
            return match ($status) {
                'hadir' => 'success',
                'terlambat' => 'warning',
                'izin' => 'info',
                'sakit' => 'danger',
                default => 'neutral',
            };
        };
    @endphp

    <x-ui.table-card title="Riwayat Absensi Terakhir">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-[10px] uppercase tracking-wide text-slate-400">
                    <th class="pb-2">Tanggal</th>
                    <th class="pb-2">Jam Masuk</th>
                    <th class="pb-2">Status</th>
                </tr>
            </thead>
            <tbody class="text-slate-700">
                @forelse ($riwayatAbsensi as $absen)
                    <tr class="border-t border-slate-100">
                        <td class="py-2">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                        <td class="py-2">{{ $absen->jam_masuk ? substr($absen->jam_masuk, 0, 5) : '-' }}</td>
                        <td class="py-2">
                            <x-ui.badge :variant="$statusVariant($absen->status)">
                                {{ ucfirst($absen->status ?? '-') }}
                            </x-ui.badge>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-slate-100">
                        <td colspan="3" class="py-3 text-center text-xs text-slate-400">Belum ada riwayat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-ui.table-card>

    <div id="absen-modal" class="fixed inset-0 z-50 hidden items-end justify-center bg-slate-900/70 px-4 pb-[calc(120px+env(safe-area-inset-bottom))] pt-8">
        <div class="w-full max-w-[420px] max-h-[calc(100vh-160px)] overflow-y-auto rounded-[24px] bg-white p-4 shadow-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs uppercase tracking-wide text-slate-400">Konfirmasi</div>
                    <div class="text-base font-semibold text-slate-900" id="absen-modal-title">Absen</div>
                </div>
                <button type="button" id="absen-modal-close" class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-500">
                    <span class="text-lg leading-none">&times;</span>
                </button>
            </div>

            <div class="mt-4 space-y-3">
                <x-ui.card class="border border-slate-100 bg-slate-50/80">
                    <div class="text-[11px] uppercase tracking-wide text-slate-500">Lokasi</div>
                    <div class="mt-1 text-sm font-semibold text-slate-900" id="absen-location-status">Belum diambil</div>
                    <div class="mt-1 text-xs text-slate-500" id="absen-location-coords">-</div>
                    <button type="button" id="absen-location-refresh" class="mt-3 w-full rounded-[14px] border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700">
                        Ambil Lokasi
                    </button>
                </x-ui.card>

                <x-ui.card class="border border-slate-100 bg-white/95" id="selfie-section">
                    <div class="text-[11px] uppercase tracking-wide text-slate-500">Foto Selfie</div>
                    <div class="mt-2 space-y-3">
                        <div class="relative h-40 overflow-hidden rounded-[14px] bg-slate-900">
                            <video id="absen-video" class="h-full w-full object-cover" autoplay muted playsinline></video>
                            <img id="absen-photo" class="hidden h-full w-full object-cover" alt="Preview">
                            <div id="absen-camera-fallback" class="absolute inset-0 flex items-center justify-center text-[11px] text-slate-200">
                                Kamera belum aktif.
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <button type="button" id="absen-start-camera"
                                class="w-full rounded-[14px] border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700">
                                Aktifkan Kamera
                            </button>
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" id="absen-capture"
                                    class="rounded-[14px] bg-slate-900 px-3 py-2 text-xs font-semibold text-white">
                                    Ambil Foto
                                </button>
                                <button type="button" id="absen-retake"
                                    class="rounded-[14px] border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700">
                                    Ulangi
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-[10px] text-slate-400" id="selfie-note">
                        {{ $requiresSelfie ? 'Foto wajib diambil sebelum absen.' : 'Opsional, jika diperlukan.' }}
                    </div>
                </x-ui.card>

                <div class="rounded-[12px] bg-slate-50 px-3 py-2 text-[11px] text-slate-500" id="absen-message">
                    Siap untuk absen.
                </div>

                <button type="button" id="absen-submit" class="w-full rounded-[16px] bg-[color:var(--color-primary)] px-4 py-3 text-xs font-semibold text-white shadow-soft">
                    Kirim Absen
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (function () {
            const requiresLocation = @json($requiresLocation);
            const requiresSelfie = @json($requiresSelfie);
            const routes = {
                masuk: @json(route('guru.absen.masuk')),
                pulang: @json(route('guru.absen.pulang')),
            };

            const modal = document.getElementById('absen-modal');
            const modalTitle = document.getElementById('absen-modal-title');
            const modalClose = document.getElementById('absen-modal-close');
            const locationStatus = document.getElementById('absen-location-status');
            const locationCoords = document.getElementById('absen-location-coords');
            const locationRefresh = document.getElementById('absen-location-refresh');
            const messageBox = document.getElementById('absen-message');
            const selfieSection = document.getElementById('selfie-section');
            const videoEl = document.getElementById('absen-video');
            const photoEl = document.getElementById('absen-photo');
            const cameraFallback = document.getElementById('absen-camera-fallback');
            const startCameraBtn = document.getElementById('absen-start-camera');
            const captureBtn = document.getElementById('absen-capture');
            const retakeBtn = document.getElementById('absen-retake');
            const submitBtn = document.getElementById('absen-submit');
            const clockEl = document.getElementById('live-clock');

            let currentAction = null;
            let currentLocation = null;
            let isSubmitting = false;
            let mediaStream = null;
            let capturedBlob = null;
            let capturedUrl = null;

            if (!requiresSelfie && selfieSection) {
                const note = document.getElementById('selfie-note');
                if (note) {
                    note.textContent = 'Opsional, jika diperlukan.';
                }
            }

            function updateClock() {
                if (!clockEl) {
                    return;
                }
                const now = new Date();
                const time = new Intl.DateTimeFormat('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false,
                    timeZone: 'Asia/Jakarta',
                }).format(now);
                clockEl.textContent = `${time} WIB`;
            }

            updateClock();
            setInterval(updateClock, 1000);

            function setMessage(text, tone) {
                if (!messageBox) {
                    return;
                }
                const toneClass = tone === 'error' ? 'text-rose-600' : tone === 'success' ? 'text-emerald-600' : 'text-slate-500';
                messageBox.className = `rounded-[12px] bg-slate-50 px-3 py-2 text-[11px] ${toneClass}`;
                messageBox.textContent = text;
            }

            function openModal(action) {
                if (!modal) {
                    return;
                }
                currentAction = action;
                modalTitle.textContent = action === 'masuk' ? 'Absen Masuk' : 'Absen Pulang';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setMessage('Siap untuk absen.', 'neutral');
                resetSelfie();
                hydrateStoredLocation();
                if (requiresLocation && !currentLocation) {
                    requestLocation();
                }
            }

            function closeModal() {
                if (!modal) {
                    return;
                }
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                currentAction = null;
                isSubmitting = false;
                submitBtn.disabled = false;
                stopCamera();
            }

            function resetSelfie() {
                capturedBlob = null;
                if (capturedUrl) {
                    URL.revokeObjectURL(capturedUrl);
                    capturedUrl = null;
                }
                if (photoEl) {
                    photoEl.src = '';
                    photoEl.classList.add('hidden');
                }
                if (videoEl) {
                    videoEl.classList.remove('hidden');
                }
                startCamera();
            }

            function showCameraFallback(message) {
                if (!cameraFallback) {
                    return;
                }
                cameraFallback.textContent = message;
                cameraFallback.classList.remove('hidden');
            }

            function hideCameraFallback() {
                if (!cameraFallback) {
                    return;
                }
                cameraFallback.classList.add('hidden');
            }

            function startCamera() {
                if (!videoEl) {
                    return;
                }
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    showCameraFallback('Browser tidak mendukung kamera.');
                    return;
                }
                if (mediaStream) {
                    videoEl.srcObject = mediaStream;
                    hideCameraFallback();
                    return;
                }
                navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 720 } },
                    audio: false,
                })
                .then((stream) => {
                    mediaStream = stream;
                    videoEl.srcObject = stream;
                    hideCameraFallback();
                })
                .catch((error) => {
                    console.error(error);
                    showCameraFallback('Izin kamera ditolak.');
                });
            }

            function stopCamera() {
                if (mediaStream) {
                    mediaStream.getTracks().forEach((track) => track.stop());
                    mediaStream = null;
                }
                if (videoEl) {
                    videoEl.pause();
                    videoEl.srcObject = null;
                }
            }

            function capturePhoto() {
                if (!videoEl || !mediaStream) {
                    setMessage('Kamera belum aktif.', 'error');
                    return;
                }
                const width = videoEl.videoWidth;
                const height = videoEl.videoHeight;
                if (!width || !height) {
                    setMessage('Kamera belum siap. Coba lagi.', 'error');
                    return;
                }
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(videoEl, 0, 0, width, height);
                canvas.toBlob((blob) => {
                    if (!blob) {
                        setMessage('Gagal mengambil foto.', 'error');
                        return;
                    }
                    capturedBlob = blob;
                    if (capturedUrl) {
                        URL.revokeObjectURL(capturedUrl);
                    }
                    capturedUrl = URL.createObjectURL(blob);
                    if (photoEl) {
                        photoEl.src = capturedUrl;
                        photoEl.classList.remove('hidden');
                    }
                    if (videoEl) {
                        videoEl.classList.add('hidden');
                    }
                    setMessage('Foto siap digunakan.', 'success');
                }, 'image/jpeg', 0.9);
            }

            function updateLocationUI() {
                if (!locationStatus || !locationCoords) {
                    return;
                }
                if (!currentLocation) {
                    locationStatus.textContent = 'Belum diambil';
                    locationCoords.textContent = '-';
                    return;
                }
                const accuracy = Math.round(currentLocation.accuracy);
                locationStatus.textContent = accuracy ? `Lokasi siap (${accuracy}m)` : 'Lokasi siap';
                locationCoords.textContent = `${currentLocation.lat.toFixed(6)}, ${currentLocation.lng.toFixed(6)}`;
            }

            function storeLocation(location) {
                try {
                    localStorage.setItem('absensi_location', JSON.stringify(location));
                } catch (error) {
                    console.warn('Gagal menyimpan lokasi', error);
                }
            }

            function hydrateStoredLocation() {
                currentLocation = null;
                try {
                    const raw = localStorage.getItem('absensi_location');
                    if (!raw) {
                        updateLocationUI();
                        return;
                    }
                    const parsed = JSON.parse(raw);
                    if (!parsed || !Number.isFinite(parsed.lat) || !Number.isFinite(parsed.lng) || !Number.isFinite(parsed.accuracy) || !parsed.timestamp) {
                        updateLocationUI();
                        return;
                    }
                    const ageMs = Date.now() - parsed.timestamp;
                    if (ageMs > 10 * 60 * 1000) {
                        updateLocationUI();
                        return;
                    }
                    currentLocation = parsed;
                    updateLocationUI();
                } catch (error) {
                    updateLocationUI();
                }
            }

            function requestLocation() {
                if (!navigator.geolocation) {
                    setMessage('Browser tidak mendukung lokasi.', 'error');
                    return;
                }
                locationStatus.textContent = 'Mencari lokasi...';
                locationCoords.textContent = 'Mohon tunggu';
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        currentLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                            accuracy: position.coords.accuracy,
                            timestamp: Date.now(),
                        };
                        storeLocation(currentLocation);
                        updateLocationUI();
                        setMessage('Lokasi siap digunakan.', 'success');
                    },
                    (error) => {
                        console.error(error);
                        currentLocation = null;
                        updateLocationUI();
                        setMessage('Gagal mendapatkan lokasi. Coba lagi.', 'error');
                    },
                    { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                );
            }

            function submitAbsensi() {
                if (isSubmitting) {
                    return;
                }
                if (requiresLocation && !currentLocation) {
                    setMessage('Lokasi wajib diambil sebelum absen.', 'error');
                    return;
                }
                if (requiresSelfie && !capturedBlob) {
                    setMessage('Foto selfie wajib sebelum absen.', 'error');
                    return;
                }
                if (!currentAction) {
                    setMessage('Aksi tidak valid.', 'error');
                    return;
                }

                const formData = new FormData();
                if (capturedBlob) {
                    const filename = `selfie_${currentAction}_${Date.now()}.jpg`;
                    const file = new File([capturedBlob], filename, { type: capturedBlob.type || 'image/jpeg' });
                    formData.append('foto', file);
                }
                if (currentLocation) {
                    formData.append('lokasi', `${currentLocation.lat},${currentLocation.lng}`);
                    formData.append('akurasi', String(currentLocation.accuracy || 0));
                }

                isSubmitting = true;
                submitBtn.disabled = true;
                setMessage('Mengirim absensi...', 'neutral');

                fetch(routes[currentAction], {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                })
                .then(async (response) => {
                    const contentType = response.headers.get('content-type') || '';
                    if (contentType.includes('application/json')) {
                        return response.json();
                    }
                    const text = await response.text();
                    throw new Error(text || 'Gagal memproses absensi');
                })
                .then((data) => {
                    if (data && data.success) {
                        setMessage(data.message || 'Absensi berhasil.', 'success');
                        setTimeout(() => window.location.reload(), 1200);
                        return;
                    }
                    setMessage(data && data.message ? data.message : 'Absensi gagal.', 'error');
                })
                .catch((error) => {
                    console.error(error);
                    setMessage('Terjadi kesalahan saat mengirim absensi.', 'error');
                })
                .finally(() => {
                    isSubmitting = false;
                    submitBtn.disabled = false;
                });
            }

            const masukBtn = document.getElementById('absen-masuk-btn');
            const pulangBtn = document.getElementById('absen-pulang-btn');

            if (masukBtn) {
                masukBtn.addEventListener('click', () => {
                    if (masukBtn.disabled) {
                        return;
                    }
                    openModal('masuk');
                });
            }

            if (pulangBtn) {
                pulangBtn.addEventListener('click', () => {
                    if (pulangBtn.disabled) {
                        return;
                    }
                    openModal('pulang');
                });
            }

            if (modalClose) {
                modalClose.addEventListener('click', closeModal);
            }

            if (locationRefresh) {
                locationRefresh.addEventListener('click', requestLocation);
            }

            if (submitBtn) {
                submitBtn.addEventListener('click', submitAbsensi);
            }

            if (startCameraBtn) {
                startCameraBtn.addEventListener('click', startCamera);
            }

            if (captureBtn) {
                captureBtn.addEventListener('click', capturePhoto);
            }

            if (retakeBtn) {
                retakeBtn.addEventListener('click', resetSelfie);
            }

            if (modal) {
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
            }
        })();
    </script>
@endpush
