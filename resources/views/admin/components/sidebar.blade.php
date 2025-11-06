@php
    $currentRoute = request()->route()->getName();
@endphp

<div class="sidebar">
    <ul>
        <li><a href="{{ route('admin.dashboard') }}" @if(strpos($currentRoute, 'admin.dashboard') !== false) class="active" @endif>
            <i class="material-icons">dashboard</i> Dashboard
        </a></li>
        <li><a href="{{ route('admin.data-guru') }}" @if(strpos($currentRoute, 'admin.data-guru') !== false) class="active" @endif>
            <i class="material-icons">people</i> Data Guru
        </a></li>
        <li><a href="{{ route('admin.rekap-absensi') }}" @if(strpos($currentRoute, 'admin.rekap-absensi') !== false) class="active" @endif>
            <i class="material-icons">calendar_today</i> Rekap Absensi
        </a></li>
        <li><a href="{{ route('admin.peta-kehadiran') }}" @if(strpos($currentRoute, 'admin.peta-kehadiran') !== false) class="active" @endif>
            <i class="material-icons">map</i> Peta Kehadiran
        </a></li>
        <li><a href="{{ route('admin.pengajuan-izin') }}" @if(strpos($currentRoute, 'admin.pengajuan-izin') !== false) class="active" @endif>
            <i class="material-icons">event_note</i> Pengajuan Izin
        </a></li>
        <li><a href="{{ route('admin.notifications') }}" @if(strpos($currentRoute, 'notifikasi') !== false) class="active" @endif>
            <i class="material-icons">notifications</i> Notifikasi
        </a></li>
        <li><a href="{{ route('admin.pengaturan') }}" @if(strpos($currentRoute, 'pengaturan') !== false) class="active" @endif>
            <i class="material-icons">settings</i> Pengaturan
        </a></li>
    </ul>
</div>