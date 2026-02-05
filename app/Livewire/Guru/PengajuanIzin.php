<?php

namespace App\Livewire\Guru;

use App\Models\Izin;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PengajuanIzin extends Component
{
    use WithPagination;

    public string $tab = 'izin';

    protected $paginationTheme = 'tailwind';

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['izin', 'sakit'], true)) {
            $this->tab = $tab;
        }
    }

    public function render()
    {
        $user = Auth::user();
        $pengajuanIzin = collect();

        if ($user) {
            $pengajuanIzin = Izin::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->paginate(5);
        }

        return view('livewire.guru.pengajuan-izin', [
            'pengajuanIzin' => $pengajuanIzin,
        ])->layout('layouts.mobile-app', [
            'title' => 'Pengajuan Izin',
        ]);
    }
}
