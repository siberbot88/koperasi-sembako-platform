<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Component;
use Livewire\Attributes\On;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $showDropdown = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    #[On('notification-created')]
    public function loadNotifications()
    {
        if (!auth()->check()) {
            return;
        }

        $this->notifications = Notification::forUser(auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $this->unreadCount = Notification::forUser(auth()->id())
            ->unread()
            ->count();
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        
        if ($notification && $notification->user_id == auth()->id()) {
            $notification->markAsRead();
            $this->loadNotifications();
            
            if ($notification->action_url) {
                return $this->redirect($notification->action_url, navigate: true);
            }
        }
    }

    public function markAllAsRead()
    {
        Notification::forUser(auth()->id())
            ->unread()
            ->get()
            ->each(fn($n) => $n->markAsRead());

        $this->loadNotifications();
        $this->dispatch('toast', message: 'Semua notifikasi ditandai sudah dibaca');
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
