<div class="sidebar">
    <div style="padding: 0 10px 5px 10px; text-align: center; border-bottom: 1px solid #eee; display: flex; justify-content: center; align-items: center; margin-top: -60px;">
        <img src="{{ asset('image/logo-pelita.png') }}" alt="Logo Pelita" style="width: 140px; height: 140px; object-fit: contain;">
    </div>
    <ul>
        <li><a href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) class="active" @endif><i class="material-icons">dashboard</i> Dashboard</a></li>
        <li><a href="{{ route('guru.riwayat.kehadiran') }}" @if(request()->routeIs('guru.riwayat.kehadiran')) class="active" @endif><i class="material-icons">history</i> Riwayat Kehadiran</a></li>
        <li><a href="{{ route('guru.lokasi.saya') }}" @if(request()->routeIs('guru.lokasi.saya')) class="active" @endif><i class="material-icons">location_on</i> Lokasi Saya</a></li>
        <li><a href="{{ route('guru.izin') }}" @if(request()->routeIs('guru.izin')) class="active" @endif><i class="material-icons">event_note</i> Izin/Sakit</a></li>
        <li><a href="{{ route('guru.pengaturan') }}" @if(request()->routeIs('guru.pengaturan')) class="active" @endif><i class="material-icons">settings</i> Pengaturan</a></li>
    </ul>
</div>
