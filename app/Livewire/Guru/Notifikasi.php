<?php

namespace App\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifikasi extends Component
{
    public string $search = '';

    public function render()
    {
        $user = Auth::user();
        $notifications = collect();

        if ($user) {
            $query = $user->notifications()->latest();

            if ($this->search !== '') {
                $query->where(function ($builder) {
                    $builder->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            }

            $notifications = $query->limit(6)->get();
        }

        return view('livewire.guru.notifikasi', [
            'notifications' => $notifications,
        ])->layout('layouts.mobile-app', [
            'title' => 'Notifikasi',
        ]);
    }
}
