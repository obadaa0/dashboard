<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WarnUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reporter;
    public $reported_person;
    public $post;

    public function __construct(User $reporter,User $reported_person,Post $post)
    {
        $this->reporter = $reporter;
        $this->reported_person = $reported_person;
        $this->post = $post;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Warning post',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.warn',
            with: [
                'reporter' => $this->reporter,
                'reported_person' => $this->reported_person,
                'post' => $this->post
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
