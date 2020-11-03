<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->data['user'] . ' has commented and rate ' . $this->data['rate'] . ' star in your product: ' . $this->data['product_name'],
            'class' => $this->data['class'],
            'status' => $this->data['status'],
            'icon' => $this->data['icon'],
            'comment_id' => $this->data['comment_id'],
            'product_id' => $this->data['product_id'],
            'created_at' => $this->data['created_at'],
        ];
    }
}
