<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnquiryAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($enquiry)
    {
        $this->enquiry = $enquiry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('New enquiry received at ')
            ->line($this->enquiry->created_at)
            ->line('Enquiry from: ')
            ->line($this->enquiry->first_name . ' ' . $this->enquiry->last_name)
            ->line('Who is interested in: ')
            ->line($this->enquiry->enquiry_type)
            ->line('Contact email: '.$this->enquiry->email)
            ->line('Contact phone: '.$this->enquiry->phone_number)
            ->line('Enquiry is ')
            ->line($this->enquiry->enquiry);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
