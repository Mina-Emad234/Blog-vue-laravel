<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyOwner extends Notification
{
    use Queueable;
    protected $comment_owner;
    protected $commented_at;
    protected $post;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment,$post)
    {
        $this->comment_owner = $comment->user;
        $this->commented_at = $comment->created_at;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'comment_owner'=>$this->comment_owner,
            'commented_at'=>$this->commented_at,
            'post'=>$this->post,
        ];
    }

    public function toBroadcast ($notifiable)
    {
        return new BroadcastMessage([
            "data"=>[
                "comment_owner"=>$this->comment_owner,
                "commented_at"=>$this->commented_at,
                "post"=>$this->post
            ],
        ]);
    }

}
