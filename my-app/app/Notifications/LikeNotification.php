<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

class LikeNotification extends Notification
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('あなたの投稿にいいねがありました')
            ->line('あなたの投稿にいいねがつきました！')
            ->action('投稿を確認する', route('posts.show', $this->post->id))
            ->line('ご利用ありがとうございます。');
    }

    public function toArray(object $notifiable): array
    {
        return [
            // 今後データベース通知を追加したい場合ここに
        ];
    }
}
