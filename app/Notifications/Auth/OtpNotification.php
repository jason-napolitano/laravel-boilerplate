<?php

namespace App\Notifications\Auth {


    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;
    use Illuminate\Bus\Queueable;

    class OtpNotification extends Notification
    {
        use Queueable;

        public function __construct(public string $code)
        {
            // ...
        }

        public function via(object $notifiable): array
        {
            return ['mail'];
        }

        public function toMail(object $notifiable): MailMessage
        {
            return (new MailMessage())
                ->subject('Your Login Verification Code')
                ->greeting('Hello '.$notifiable->name.',')
                ->line('You requested to sign in to your account.')
                ->line('Your verification code is:')
                ->line('**'.$this->code.'**')
                ->line('This code expires in 5 minutes.')
                ->line('If you did not attempt to sign in, you can safely ignore this email.');
        }
    }
}
