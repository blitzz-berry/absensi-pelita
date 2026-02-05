<?php

namespace App\Livewire\Guru;

use Carbon\Carbon;
use Livewire\Component;

class LokasiSaya extends Component
{
    public function render()
    {
        $now = Carbon::now('Asia/Jakarta');

        return view('livewire.guru.lokasi-saya', [
            'now' => $now,
        ])->layout('layouts.mobile-app', [
            'title' => 'Lokasi Saya',
        ]);
    }
}
