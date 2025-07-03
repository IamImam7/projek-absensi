<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
   public function getNotification()
    {
        $notifications = \App\Models\RealtimeNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->get();

        if ($notifications->isNotEmpty()) {
            foreach ($notifications as $notification) {
                // Kirim perintah JS untuk menampilkan toast
                $this->js("
                    Toastify({
                        text: '{$notification->message}',
                        duration: 5000, gravity: 'top', position: 'right',
                        style: { background: 'linear-gradient(to right, #00b09b, #96c93d)' },
                        onClick: () => window.location.href = '".route('admin.cuti.manajemen')."'
                    }).showToast();
                ");

                // Tandai notifikasi sebagai sudah dibaca
                $notification->update(['read_at' => now()]);
            }
        }
    }

    public function render()
    {
        // Tampilan komponen ini tidak perlu menampilkan apa-apa (hanya logic)
        // wire:poll akan memanggil method getNotification
        return view('livewire.notification-bell');
    }
}
