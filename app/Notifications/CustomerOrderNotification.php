<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CustomerOrderNotification extends Notification
{
    use Queueable;

    protected $notificationInfo;

    public function __construct($notificationInfo)
    {
        $this->notificationInfo = $notificationInfo;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->notificationInfo['message'],
            'products' => $this->notificationInfo['products'],
            'address' => $this->notificationInfo['address'],
            'orderId' => $this->notificationInfo['orderId'],
            'supplierId' => $this->notificationInfo['supplierId'],
        ];
    }
}
