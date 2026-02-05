<div class="space-y-4">
    <x-ui.section-title title="Data Guru" subtitle="Kelola data guru aktif." />

    <a href="{{ route('admin.data-guru.create') }}" class="inline-flex items-center rounded-[14px] bg-[color:var(--color-primary)] px-4 py-2 text-xs font-semibold text-white shadow-soft">
        + Tambah Guru
    </a>

    <x-ui.table-card title="Daftar Guru">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-[10px] uppercase tracking-wide text-slate-400">
                    <th class="pb-2">Nomor ID</th>
                    <th class="pb-2">Nama Guru</th>
                    <th class="pb-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-700">
                @forelse ($teachers as $teacher)
                    <tr class="border-t border-slate-100">
                        <td class="py-2">{{ $teacher->nomor_id ?? '-' }}</td>
                        <td class="py-2">{{ $teacher->nama ?? $teacher->name ?? '-' }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.data-guru.edit', $teacher->id) }}" class="inline-flex items-center text-[color:var(--color-primary)]">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20h4l10-10-4-4L4 16v4zM14 6l4 4"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-slate-100">
                        <td colspan="3" class="py-3 text-center text-xs text-slate-400">Data guru belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-ui.table-card>
</div>
