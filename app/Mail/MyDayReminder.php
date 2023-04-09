<?php

namespace App\Mail;

use App\Models\MyDay;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MyDayReminder extends Mailable
{
    use Queueable, SerializesModels;

    protected $myDay;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MyDay $myDay)
    {
        $this->myDay = $myDay;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Doodies Reminder',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mail.my-day-reminder',
            with: [
                'name' => $this->myDay->name,
                'due_date' => $this->myDay->reminder
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
