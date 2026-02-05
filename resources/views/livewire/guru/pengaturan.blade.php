<div class="space-y-4">
    <x-ui.section-title title="Pengaturan" subtitle="Kelola profil dan keamanan akun." />

    @if (session('profile_success'))
        <x-ui.card class="border border-emerald-100 bg-emerald-50 text-xs font-semibold text-emerald-700">
            {{ session('profile_success') }}
        </x-ui.card>
    @endif

    @if (session('password_success'))
        <x-ui.card class="border border-emerald-100 bg-emerald-50 text-xs font-semibold text-emerald-700">
            {{ session('password_success') }}
        </x-ui.card>
    @endif

    @if (session('error'))
        <x-ui.card class="border border-rose-100 bg-rose-50 text-xs font-semibold text-rose-700">
            {{ session('error') }}
        </x-ui.card>
    @endif

    @if ($errors->any())
        <x-ui.card class="border border-rose-100 bg-rose-50 text-xs font-semibold text-rose-700">
            {{ $errors->first() }}
        </x-ui.card>
    @endif

    <x-ui.card>
        <div class="text-sm font-semibold text-slate-900">Profil Guru</div>
        <form method="POST" action="{{ route('guru.pengaturan.update.profile') }}" enctype="multipart/form-data" class="mt-3 space-y-3">
            @csrf
            <div>
                <label class="text-xs font-semibold text-slate-600">Nama</label>
                <input type="text" name="nama" value="{{ $user?->nama ?? '' }}"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Email</label>
                <input type="email" name="email" value="{{ $user?->email ?? '' }}"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ $user?->nomor_telepon ?? '' }}"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Foto Profil</label>
                <input type="file" name="foto_profile"
                    class="mt-1 w-full rounded-[12px] border border-dashed border-slate-200 bg-slate-50 px-3 py-2 text-[11px] text-slate-500">
            </div>
            <button type="submit" class="w-full rounded-[14px] bg-[color:var(--color-primary)] px-3 py-2 text-xs font-semibold text-white">
                Simpan Profil
            </button>
        </form>
    </x-ui.card>

    <x-ui.card>
        <div class="text-sm font-semibold text-slate-900">Ubah Password</div>
        <form method="POST" action="{{ route('guru.pengaturan.update.password') }}" class="mt-3 space-y-3">
            @csrf
            <div>
                <label class="text-xs font-semibold text-slate-600">Password Saat Ini</label>
                <input type="password" name="current_password"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Password Baru</label>
                <input type="password" name="new_password"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>
            <button type="submit" class="w-full rounded-[14px] bg-slate-900 px-3 py-2 text-xs font-semibold text-white">
                Simpan Password
            </button>
        </form>
    </x-ui.card>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full rounded-[16px] bg-rose-500 px-4 py-3 text-xs font-semibold text-white shadow-soft">
            Keluar
        </button>
    </form>
</div>
