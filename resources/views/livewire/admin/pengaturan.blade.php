<div class="space-y-4">
    <x-ui.section-title title="Pengaturan Admin" subtitle="Kelola akun dan pengaturan sistem." />

    @if (session('success'))
        <x-ui.card class="border border-emerald-100 bg-emerald-50 text-xs font-semibold text-emerald-700">
            {{ session('success') }}
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
        <div class="text-sm font-semibold text-slate-900">Pengaturan Umum</div>
        <form method="POST" action="{{ route('admin.pengaturan.umum.update') }}" class="mt-3 space-y-3">
            @csrf
            @method('PUT')
            <input type="hidden" name="notifikasi_absensi" value="0">
            <input type="hidden" name="lokasi_wajib" value="0">
            <input type="hidden" name="selfie_wajib" value="0">

            <label class="flex items-center justify-between rounded-[12px] border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700">
                Notifikasi Absensi
                <input type="checkbox" name="notifikasi_absensi" value="1" {{ $settings['notifikasi_absensi'] ? 'checked' : '' }}>
            </label>
            <label class="flex items-center justify-between rounded-[12px] border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700">
                Lokasi Wajib
                <input type="checkbox" name="lokasi_wajib" value="1" {{ $settings['lokasi_wajib'] ? 'checked' : '' }}>
            </label>
            <label class="flex items-center justify-between rounded-[12px] border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700">
                Selfie Wajib
                <input type="checkbox" name="selfie_wajib" value="1" {{ $settings['selfie_wajib'] ? 'checked' : '' }}>
            </label>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="text-xs font-semibold text-slate-600">Toleransi (menit)</label>
                    <input type="number" name="toleransi_keterlambatan" value="{{ $settings['toleransi_keterlambatan'] }}"
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600">Radius Absen (m)</label>
                    <input type="number" name="radius_absen" value="{{ $settings['radius_absen'] }}"
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600">Jam Masuk</label>
                    <input type="time" name="waktu_absen_masuk" value="{{ $settings['waktu_absen_masuk'] }}"
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600">Jam Pulang</label>
                    <input type="time" name="waktu_absen_pulang" value="{{ $settings['waktu_absen_pulang'] }}"
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Pesan Pengingat</label>
                <textarea name="pesan_pengingat" rows="3"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">{{ $settings['pesan_pengingat'] }}</textarea>
            </div>

            <button type="submit" class="w-full rounded-[14px] bg-[color:var(--color-primary)] px-3 py-2 text-xs font-semibold text-white">
                Simpan Pengaturan
            </button>
        </form>
    </x-ui.card>

    <x-ui.card>
        <div class="text-sm font-semibold text-slate-900">Profil Admin</div>
        <form method="POST" action="{{ route('admin.pengaturan.akun.update') }}" enctype="multipart/form-data" class="mt-3 space-y-3">
            @csrf
            @method('PUT')
            <div>
                <label class="text-xs font-semibold text-slate-600">Nama</label>
                <input type="text" name="nama" value="{{ $user?->nama ?? '' }}"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Email</label>
                <input type="email" name="email" value="{{ $user?->email ?? '' }}"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Foto Profil</label>
                <input type="file" name="foto_profile"
                    class="mt-1 w-full rounded-[12px] border border-dashed border-slate-200 bg-slate-50 px-3 py-2 text-[11px] text-slate-500">
            </div>
            <button type="submit" class="w-full rounded-[14px] bg-slate-900 px-3 py-2 text-xs font-semibold text-white">
                Simpan Profil
            </button>
        </form>
    </x-ui.card>

    <x-ui.card>
        <div class="text-sm font-semibold text-slate-900">Ubah Password</div>
        <form method="POST" action="{{ route('admin.pengaturan.password.update') }}" class="mt-3 space-y-3">
            @csrf
            @method('PUT')
            <div>
                <label class="text-xs font-semibold text-slate-600">Password Lama</label>
                <input type="password" name="password_lama"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Password Baru</label>
                <input type="password" name="password_baru"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600">Konfirmasi Password Baru</label>
                <input type="password" name="password_baru_confirmation"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs">
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
