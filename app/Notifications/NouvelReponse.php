<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelReponse extends Notification
{
    use Queueable;
    public $absence;

    /**
     * Create a new notification instance.
     */
    public function __construct($absence)
    {
        $this->absence = $absence;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->absence->user_id,
            'statut_absence_id' => $this->absence->statut_absence_id,
            'motif_absence_id' => $this->absence->motif_absence_id,
            'date_debut' => $this->absence->date_debut,
            'date_fin' => $this->absence->date_fin,
            'created_at' => $this->absence->created_at,
            'cancelled_at' => $this->absence->cancelled_at,
            'cancelled_by' => $this->absence->cancelled_by,
            'reponse' => $this->absence->reponse,
        ];
    }
}
