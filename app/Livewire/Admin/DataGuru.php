<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class DataGuru extends Component
{
    public function render()
    {
        $teachers = User::where('role', 'guru')
            ->orderBy('nama')
            ->limit(8)
            ->get();

        return view('livewire.admin.data-guru', [
            'teachers' => $teachers,
        ])->layout('layouts.mobile-app', [
            'title' => 'Data Guru',
        ]);
    }
}
