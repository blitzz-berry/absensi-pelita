<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifikasi extends Component
{
    public string $search = '';

    public function markAllAsRead()
    {
        $user = Auth::user();

        if ($user) {
            $user->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        }

        return redirect()->route('admin.notifications');
    }

    public function render()
    {
        $user = Auth::user();
        $notifications = collect();
        $unreadCount = 0;

        if ($user) {
            $query = $user->notifications()->latest();

            if ($this->search !== '') {
                $query->where(function ($builder) {
                    $builder->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            }

            $notifications = $query->limit(6)->get();
            $unreadCount = $user->notifications()->whereNull('read_at')->count();
        }

        return view('livewire.admin.notifikasi', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ])->layout('layouts.mobile-app', [
            'title' => 'Notifikasi',
        ]);
    }
}
