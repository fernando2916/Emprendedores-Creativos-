<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationPedido extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
    public string $tipo,
    public string $titulo,
    public string $mensaje,
    public string $url,
    public string $icono = 'fa-bell',
    public ?int $ordenId = null,
    public ?string $numeroOrden = null,
    public ?string $estado = null,
    )
    {
        
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
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    public function toDatabase(object $notifiable): array
    {
        return [
            'tipo' => $this->tipo,

            'titulo' => $this->titulo,

            'mensaje' => $this->mensaje,

            'url' => $this->url,

            'icono' => $this->icono,

            'orden_id' => $this->ordenId,

            'numero_orden' => $this->numeroOrden,

            'estado' => $this->estado,
        ];
    }

}