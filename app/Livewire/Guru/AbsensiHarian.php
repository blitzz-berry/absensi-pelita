<?php

namespace App\Livewire\Guru;

use Carbon\Carbon;
use Livewire\Component;

class AbsensiHarian extends Component
{
    public function render()
    {
        $rangeEnd = Carbon::now('Asia/Jakarta');
        $rangeStart = $rangeEnd->copy()->subDays(6);

        $days = collect(range(0, 6))->map(function ($offset) use ($rangeStart) {
            return $rangeStart->copy()->addDays($offset);
        });

        return view('livewire.guru.absensi-harian', [
            'rangeStart' => $rangeStart,
            'rangeEnd' => $rangeEnd,
            'days' => $days,
        ])->layout('layouts.mobile-app', [
            'title' => 'Absensi Harian',
        ]);
    }
}
