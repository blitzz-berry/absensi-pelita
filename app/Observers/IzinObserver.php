<?php

namespace App\Observers;

use App\Models\Izin;
use App\Models\Notification;
use App\Models\User;

class IzinObserver
{
    /**
     * Handle the Izin "created" event.
     */
    public function created(Izin $izin): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Pengajuan Izin Baru',
                'message' => 'Pengajuan izin baru dari ' . $izin->user->nama . ' telah diajukan.',
                'link' => route('admin.pengajuan-izin'),
            ]);
        }
    }

    /**
     * Handle the Izin "updated" event.
     */
    public function updated(Izin $izin): void
    {
        if ($izin->isDirty('status')) {
            $title = '';
            $message = '';

            if ($izin->status === 'disetujui') {
                $title = 'Pengajuan Izin Disetujui';
                $message = 'Pengajuan izin Anda pada tanggal ' . $izin->tanggal_mulai . ' telah disetujui.';
            } elseif ($izin->status === 'ditolak') {
                $title = 'Pengajuan Izin Ditolak';
                $message = 'Pengajuan izin Anda pada tanggal ' . $izin->tanggal_mulai . ' telah ditolak.';
            }

            if ($title && $message) {
                Notification::create([
                    'user_id' => $izin->user_id,
                    'title' => $title,
                    'message' => $message,
                    'link' => '#', // Link to user's leave history page (to be created)
                ]);
            }
        }
    }

    /**
     * Handle the Izin "deleted" event.
     */
    public function deleted(Izin $izin): void
    {
        //
    }

    /**
     * Handle the Izin "restored" event.
     */
    public function restored(Izin $izin): void
    {
        //
    }

    /**
     * Handle the Izin "force deleted" event.
     */
    public function forceDeleted(Izin $izin): void
    {
        //
    }
}
