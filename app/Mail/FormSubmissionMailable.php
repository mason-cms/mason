<?php

namespace App\Mail;

use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormSubmissionMailable extends Mailable
{
    use Queueable, SerializesModels;

    public FormSubmission $submission;

    public function __construct(FormSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->submission->form->title,
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'mail.form-submission',
        );
    }

    public function attachments()
    {
        return [];
    }
}
