<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PushJobs extends Notification
{
    use Queueable;

    public function __construct(array $config) {
            $this->config = $config;
    }
    
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->data(['message_id' => $this->config["job_id"], "message_url" => 'https://jobbit.codebuilder.us/job/message/'.$this->config["job_id"]])
            ->title($this->config["title"])
            ->icon($this->config["icon"])
            ->body($this->config["body"])
            ->action('View Message', 'message_action');
    }
    
}