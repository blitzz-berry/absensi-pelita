<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $title ?? 'Absensi Pelita')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
@php
    $segment = request()->segment(1);
    $isGuru = $segment === 'guru';
    $isAdmin = $segment === 'admin';
    $user = auth()->user();
    $rawName = $user?->nama ?? $user?->name ?? 'Pengguna';
    $nameParts = collect(preg_split('/\s+/', trim($rawName)));
    $initials = $nameParts->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('');
    $initials = substr($initials, 0, 2) ?: 'U';
    $displayRole = $user?->role === 'admin' ? 'Admin' : 'Guru';
    $notificationBadge = 0;
    if ($user) {
        $notificationBadge = $user->notifications()->whereNull('read_at')->count();
    }
    $notificationRoute = $isAdmin ? route('admin.notifications') : ($isGuru ? route('guru.notifikasi') : '#');
    $settingRoute = $isAdmin ? route('admin.pengaturan') : ($isGuru ? route('guru.pengaturan') : '#');
@endphp
<body class="min-h-screen bg-gradient-to-b from-slate-50 via-slate-50 to-sky-50">
    <div class="relative min-h-screen">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-20 h-56 w-56 rounded-full bg-sky-200/50 blur-3xl"></div>
            <div class="absolute top-48 -left-24 h-64 w-64 rounded-full bg-indigo-100/60 blur-3xl"></div>
        </div>

        <header class="sticky top-0 z-30 border-b border-slate-200/70 bg-white/80 backdrop-blur">
            <div class="mx-auto flex max-w-[430px] items-center justify-between gap-3 px-4 py-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/logo.png') }}" alt="Pelita Insani" class="h-10 w-10 rounded-2xl bg-white p-1 shadow-soft">
                    <div>
                        <div class="text-xs font-semibold tracking-wide text-slate-900">PELITA INSANI</div>
                        <div class="text-[11px] text-slate-500">KB/TK/SD/SMP Nasional Plus</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if ($isAdmin || $isGuru)
                        <a href="{{ $notificationRoute }}" class="relative flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-soft">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0h6z"/>
                            </svg>
                            @if ($notificationBadge > 0)
                                <span class="absolute -top-1 right-1 h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                            @endif
                        </a>
                    @else
                        <div class="relative flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-soft">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0h6z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="relative" data-profile-menu>
                        <button type="button" class="flex items-center gap-2" data-profile-toggle>
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">
                                {{ $initials }}
                            </div>
                            <div class="text-right leading-tight">
                                <div class="text-[10px] uppercase tracking-wide text-slate-400">{{ $displayRole }}</div>
                                <div class="text-xs font-semibold text-slate-900">{{ $rawName }}</div>
                            </div>
                        </button>
                        <div class="absolute right-0 mt-2 hidden w-40 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft" data-profile-panel>
                            <a href="{{ $settingRoute }}" class="block px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                Pengaturan
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 text-left text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="relative z-10 px-4 pb-[calc(96px+env(safe-area-inset-bottom))] pt-4">
            <div class="mx-auto max-w-[430px]">
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </div>
        </main>

        <nav class="fixed bottom-4 left-1/2 z-40 w-[calc(100%-2rem)] max-w-[420px] -translate-x-1/2">
            <div class="grid grid-cols-5 gap-2 rounded-full border border-white/80 bg-white/90 p-2 shadow-card">
                @if ($isGuru)
                    <x-ui.bottom-nav-item :href="route('guru.dashboard')" label="Dashboard" :active="request()->routeIs('guru.dashboard')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                    <x-ui.bottom-nav-item :href="route('guru.absensi-harian')" label="Absensi" :active="request()->routeIs('guru.absensi-harian')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                    <x-ui.bottom-nav-item :href="route('guru.riwayat.kehadiran')" label="Riwayat" :active="request()->routeIs('guru.riwayat.kehadiran')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 11h6M7 3h10a2 2 0 0 1 2 2v14l-5-3-5 3-5-3V5a2 2 0 0 1 2-2z"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                    <x-ui.bottom-nav-item :href="route('guru.lokasi.saya')" label="Lokasi" :active="request()->routeIs('guru.lokasi.saya')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s7-6 7-12a7 7 0 0 0-14 0c0 6 7 12 7 12z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                    <x-ui.bottom-nav-item :href="route('guru.izin')" label="Izin" :active="request()->routeIs('guru.izin')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h10a2 2 0 0 1 2 2v14l-5-3-5 3-5-3V5a2 2 0 0 1 2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9h6M9 13h4"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                @elseif ($isAdmin)
                    <x-ui.bottom-nav-item :href="route('admin.dashboard')" label="Dashboard" :active="request()->routeIs('admin.dashboard')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                    <x-ui.bottom-nav-item :href="route('admin.data-guru')" label="Data Guru" :active="request()->routeIs('admin.data-guru')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 15h8M8 11h8M8 7h8M5 3h14a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                    <x-ui.bottom-nav-item :href="route('admin.rekap-absensi')" label="Rekap" :active="request()->routeIs('admin.rekap-absensi')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16M7 16V9m5 7V5m5 11v-6"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                    <x-ui.bottom-nav-item :href="route('admin.pengajuan-izin')" label="Izin" :active="request()->routeIs('admin.pengajuan-izin')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h10a2 2 0 0 1 2 2v14l-5-3-5 3-5-3V5a2 2 0 0 1 2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9h6M9 13h4"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                    <x-ui.bottom-nav-item :href="route('admin.pengaturan')" label="Setting" :active="request()->routeIs('admin.pengaturan')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm8 2.5a7.9 7.9 0 0 0-.1-1l2-1.5-2-3.5-2.3 1a8 8 0 0 0-1.7-1l-.3-2.5H8.4l-.3 2.5a8 8 0 0 0-1.7 1l-2.3-1-2 3.5 2 1.5a8.7 8.7 0 0 0 0 2L2 13.5l2 3.5 2.3-1a8 8 0 0 0 1.7 1l.3 2.5h7.2l.3-2.5a8 8 0 0 0 1.7-1l2.3 1 2-3.5-2-1.5c.1-.3.1-.7.1-1z"/>
                        </svg>
                    </x-ui.bottom-nav-item>
                @endif
            </div>
        </nav>
    </div>

    @livewireScripts
    @stack('scripts')
    <script>
        (function () {
            const menus = document.querySelectorAll('[data-profile-menu]');
            if (!menus.length) {
                return;
            }

            function closeAll() {
                menus.forEach((menu) => {
                    const panel = menu.querySelector('[data-profile-panel]');
                    if (panel) {
                        panel.classList.add('hidden');
                    }
                });
            }

            document.addEventListener('click', (event) => {
                let clickedToggle = false;
                menus.forEach((menu) => {
                    const toggle = menu.querySelector('[data-profile-toggle]');
                    const panel = menu.querySelector('[data-profile-panel]');
                    if (!toggle || !panel) {
                        return;
                    }
                    if (toggle.contains(event.target)) {
                        clickedToggle = true;
                        panel.classList.toggle('hidden');
                    } else if (!menu.contains(event.target)) {
                        panel.classList.add('hidden');
                    }
                });
                if (!clickedToggle) {
                    closeAll();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeAll();
                }
            });
        })();
    </script>
</body>
</html>
