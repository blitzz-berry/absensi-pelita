<?php

namespace App\Livewire\Admin;

use App\Models\Izin;
use Livewire\Component;
use Livewire\WithPagination;

class PengajuanIzin extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $izinQuery = Izin::with(['user', 'approvedBy'])->orderByDesc('created_at');
        $pengajuan = $izinQuery->paginate(10);

        $stats = Izin::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('livewire.admin.pengajuan-izin', [
            'pengajuan' => $pengajuan,
            'stats' => $stats,
        ])->layout('layouts.mobile-app', [
            'title' => 'Pengajuan Izin',
        ]);
    }
}
