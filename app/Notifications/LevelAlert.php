<?php

namespace App\Notifications;

use App\Alert;
use App\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class LevelAlert extends Notification
{
    use Queueable;

    protected $device;
    protected $alert;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Device $device, Alert $alert)
    {
        $this->device = $device;
        $this->alert = $alert;
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

        if ($notifiable->settings && $notifiable->settings->mailAlerts) {
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
            ->subject(sprintf('%s - level Alert', config('app.name')))
            ->greeting($data->title)
            ->line($data->body)
            ->action('View', route('devices.show', $this->device));
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
        switch ($this->alert->trigger) {
            case 1:
                $action = sprintf('dropped below %d%%', $this->alert->percent);
                break;
            case 2:
                $action = sprintf('risen above %d%%', $this->alert->percent);
                break;
            default:
                $action = 'changed';
                break;
        }

        return [
            'title' => sprintf('You water level has %s', $action),
            'body' => sprintf(
                'The level in your water tank (%s) is now at %d%% capacity.',
                $this->device->name,
                $this->device->currentPercent
            ),
        ];
    }
}
