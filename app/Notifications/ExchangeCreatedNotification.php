<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExchangeCreatedNotification extends Notification
{
    use Queueable;

    public $exchange;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($exchange, $message = null)
    {
        $this->exchange = $exchange;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailmessage = (new MailMessage)
                    ->subject('Someone is interested')
                    ->greeting("{$this->exchange->source_user->name} has expressed interest in {$this->exchange->proposal->title}");

        if($this->message) {
            $mailmessage->line("{$this->message->content}");
        }

        $mailmessage->action('Review and confirm', route('proposal.show', ['proposal' => $this->exchange->proposal ]));


        return $mailmessage;
                    
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
            //
        ];
    }
}
