<?php

namespace App\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pengaturan extends Component
{
    public function render()
    {
        return view('livewire.guru.pengaturan', [
            'user' => Auth::user(),
        ])->layout('layouts.mobile-app', [
            'title' => 'Pengaturan',
        ]);
    }
}
