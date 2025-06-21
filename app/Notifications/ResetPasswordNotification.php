<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $frontend = config('app.frontend_url'); 
        // .env に FRONTEND_URL=http://localhost:5173 などを入れておく

        $url = "{$frontend}/reset-password?token={$this->token}&email={$notifiable->email}";

        return (new MailMessage)
            ->subject('パスワードリセットのお知らせ')
            ->line('以下のボタンをクリックして、パスワードを再設定してください。')
            ->action('パスワードをリセット', $url)
            ->line('もしこのリクエストに心当たりがない場合は、このメールを破棄してください。');
    }
}