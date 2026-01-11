<div class="topbar">
    <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="clock-display" id="live-clock">00:00 WIB</div>
    <div class="profile-menu dropdown-trigger" data-target="dropdown-profile">
        <img src="{{ $currentUser->foto_profile ? asset($currentUser->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($currentUser->nama).'&color=1976D2&background=F5F5F5' }}"
             alt="Profile" class="circle" width="40" height="40">
        <span style="margin-left: 10px; font-weight: 500;">
            @if($currentUser->gelar)
                {{ $currentUser->nama }} {{ $currentUser->gelar }}
            @else
                {{ $currentUser->nama }}
            @endif
        </span>
    </div>
    <ul id="dropdown-profile" class="dropdown-content">
        <li><a href="{{ route('admin.profil') }}"><i class="material-icons left">person</i> Profil Saya</a></li>
        <li><a href="{{ route('admin.pengaturan') }}"><i class="material-icons left">settings</i> Pengaturan</a></li>
        <li class="divider"></li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons left">exit_to_app</i> Keluar</a></li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
