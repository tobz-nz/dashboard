<?php

namespace App\Notifications;

use App\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class DeviceFoundNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $device;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];

        if (count($notifiable->apn_tokens)) {
            array_push($channels, ApnChannel::class);
        }

        if ($notifiable->pushSubscriptions()->count()) {
            array_push($channels, WebPushChannel::class);
        }

        if (data_get($notifiable, 'preferences.email_alerts')) {
            array_push($channels, 'mail');
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = (object) $this->toArray($notifiable);

        return (new MailMessage)
            ->level($this->alertLevel())
            ->subject($data->title)
            ->line($data->body)
            ->action('View', route('devices.show', $this->device))
            ->salutation('');
    }

    public function toWebPush($notifiable, $notification)
    {
        $data = (object) $this->toArray($notifiable);

        return (new WebPushMessage)
            ->title($data->title)
            ->icon(asset('images/app-icon.png'))
            // ->badge()
            // ->dir()
            // ->image()
            // ->lang()
            // ->renotify()
            // ->requireInteraction()
            // ->tag()
            // ->vibrate()
            ->body($data->body)
            ->action('View', route('devices.show', $this->device))
            ->data(['url' => route('devices.show', $this->device)]);
    }

    public function toApn($notifiable)
    {
        $data = (object) $this->toArray($notifiable);

        return ApnMessage::create()
        // ->badge(1)
            ->title($data->title)
            ->body($data->body)
            ->setUrlArguments(['devices/' . $this->device->uid]);
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
            'title' => __('Connection Recovered.'),
            'body' => __(
                'We are receiving information from the water tank ":name" again.',
                $this->device->only('name'),
            ),
        ];
    }
}
