<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class VerifyEmailNotification extends Notification
{
    use Queueable;
    
    private $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        /**
     * hash('sha256', 'tony@gmail.com');
     * 
     * 
     * base_url => http://127.0.0.1:8000/email/verify/
     * id => 3/
     * email => 15dac8642c979723cadfc34d81c89fec15db8edd?
     * expiration => expires=1745717786&
     * signature => signature=35654c090a74592869a8c4954f71986a03651694ec41283118bb313088054405
     */

        $email = $this->data['email'];
        $code = $this->data['code'];
        $signature = $this->data['signature'];
        $hashSignature = hash('sha256', $signature);
        $user = $this->data['user'];
        $verification = $this->data['verification'];
        $expiration = strtotime($verification->expires_at);

        $callback_url1 = 'email/verify/'.$user->id.'?email='.$email.'&expires='.$expiration;
        $callback_url = $callback_url1.'&signature='.$hashSignature.'&code='.$code;

        return (new MailMessage)
            ->subject($this->data['subject'])
            ->greeting("Hello {$this->data['name']}!")
            ->line('Your Email has been Registered with Us.')
            ->line($this->data['message'] .$code)
            ->line('Use the Button below to Confirm your Account')
            ->action('Click Here', url($callback_url))
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
            //
        ];
    }
}
