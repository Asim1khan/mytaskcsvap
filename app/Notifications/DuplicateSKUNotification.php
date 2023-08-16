<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DuplicateSKUNotification extends Notification
{
    use Queueable;

    protected $sku;

    public function __construct($sku)
    {
        $this->sku = $sku;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Duplicate SKU Detected')
            ->line("A product with the SKU '{$this->sku}' has been detected as a duplicate.")
            ->line('Please review and manage the products accordingly.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

