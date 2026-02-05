@extends('layouts.mobile-app')

@section('title', 'Tambah Guru')

@section('content')
<div class="space-y-4">
    <x-ui.section-title title="Tambah Guru" subtitle="Tambah data guru baru ke sistem." />

    @if ($errors->any())
        <x-ui.card class="border border-rose-100 bg-rose-50 text-xs font-semibold text-rose-700">
            {{ $errors->first() }}
        </x-ui.card>
    @endif

    <x-ui.card>
        <form method="POST" action="{{ route('admin.data-guru.store') }}" class="space-y-4">
            @csrf
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold text-slate-600" for="nomor_id">Nomor ID *</label>
                    <input type="text" id="nomor_id" name="nomor_id" value="{{ old('nomor_id') }}" required
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs text-slate-700 focus:border-[color:var(--color-primary)] focus:outline-none">
                    @error('nomor_id')
                        <div class="mt-1 text-[10px] font-semibold text-rose-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600" for="nama">Nama Lengkap *</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs text-slate-700 focus:border-[color:var(--color-primary)] focus:outline-none">
                    @error('nama')
                        <div class="mt-1 text-[10px] font-semibold text-rose-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold text-slate-600" for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs text-slate-700 focus:border-[color:var(--color-primary)] focus:outline-none">
                    @error('email')
                        <div class="mt-1 text-[10px] font-semibold text-rose-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600" for="nomor_telepon">Nomor Telepon *</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs text-slate-700 focus:border-[color:var(--color-primary)] focus:outline-none">
                    @error('nomor_telepon')
                        <div class="mt-1 text-[10px] font-semibold text-rose-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600" for="password">Password *</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs text-slate-700 focus:border-[color:var(--color-primary)] focus:outline-none">
                @error('password')
                    <div class="mt-1 text-[10px] font-semibold text-rose-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold text-slate-600" for="jabatan">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}"
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs text-slate-700 focus:border-[color:var(--color-primary)] focus:outline-none">
                    @error('jabatan')
                        <div class="mt-1 text-[10px] font-semibold text-rose-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600" for="gelar">Gelar</label>
                    <input type="text" id="gelar" name="gelar" value="{{ old('gelar') }}" placeholder="Contoh: S.Pd, S.T, S.Ag"
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs text-slate-700 focus:border-[color:var(--color-primary)] focus:outline-none">
                    @error('gelar')
                        <div class="mt-1 text-[10px] font-semibold text-rose-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-2 sm:grid-cols-2">
                <a href="{{ route('admin.data-guru') }}" class="inline-flex items-center justify-center rounded-[14px] border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-600">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-[14px] bg-[color:var(--color-primary)] px-4 py-2 text-xs font-semibold text-white shadow-soft">
                    Simpan
                </button>
            </div>
        </form>
    </x-ui.card>
</div>
@endsection
