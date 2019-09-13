<?php

namespace App\Notifications;

use App\Alert;
use App\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
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

        if (count($notifiable->apn_tokens ?? [])) {
            array_push($channels, ApnChannel::class);
        }

        if ($notifiable->pushSubscriptions()->count()) {
            array_push($channels, WebPushChannel::class);
        }

        if (data_get($notifiable, 'preferences.email_alerts')) {
            array_push($channels, 'mail');
        }

        if (data_get($notifiable, 'preferences.slack_alerts')) {
            array_push($channels, 'slack');
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
            ->subject(sprintf('%s - level Alert', config('app.name')))
            ->greeting($data->title)
            ->line($data->body)
            ->action('View', route('devices.show', $this->device))
            ->salutation('');
    }

    /**
     * Broadcast via native WebPush
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return \NotificationChannels\WebPush\WebPushMessage
     */
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

    /**
     * Broadcast via Apple APN service (Push)
     *
     * @param mixed $notifiable
     * @return \NotificationChannels\Apn\ApnMessage
     */
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
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from('Tankful', ':droplet:')
            ->image(asset('images/logo.svg'))
            ->to('#smarttank5000')
            ->success()
            ->attachment(function ($attachment) {
                $attachment->title(
                    'New Water Level Reading',
                    route('devices.show', $this->device)
                )
                ->fields([
                    'Tank' => $this->device->name,
                    'Percent Remaining' => $this->device->currentPercent.'%',
                    'Current Depth (cm)' => vsprintf('%d(cm) / %d(L)', [
                        $this->device->currentValue / 10,
                        $this->device->currentVolume,
                    ]),
                    'Days Left' => $this->device->daysRemaining,
                ]);
            });
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
            'title' => sprintf('You water level has %s', $this->actionText()),
            'body' => sprintf(
                'The level in your water tank (%s) is now at %d%% capacity.',
                $this->device->name,
                $this->device->currentPercent
            ),
        ];
    }

    private function actionText()
    {
        switch ($this->alert->trigger) {
            case 1:
                return sprintf('dropped below %d%%', $this->alert->percent);
            case 2:
                return sprintf('risen above %d%%', $this->alert->percent);
            default:
                return 'changed';
        }
    }

    public function alertLevel()
    {
        if ($this->device->currentPercent >= 70) {
            return 'success';
        }

        if ($this->device->currentPercent < 30) {
            return 'error';
        }

        return 'info';
    }
}
