<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
///////////mail wordt naar de klant en brouwers gestuurd wanneer er een vacature word aangemaakt////////////
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        private $email,
        private $bemail,
        public $subject,
        private $sendpdfnaam,
        private $invoicemaand,
        private $sender,
        private $ontvanger,
        private $pdf,
    )
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
//            subject: 'test',
            to: $this->email,
///////////Mail van brouwers moet hier te staan///////////
            cc: $this->bemail,
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
            markdown: 'layouts.mails.invoice',
            with: [
                'name' => $this->email,
                'cc' => $this->bemail,
               'maand'=> $this->invoicemaand,
               'from'=> $this->sender,
               'contact'=> $this->ontvanger,

            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            Attachment::fromData(fn () => $this->pdf, $this->sendpdfnaam)
                ->withMime('application/pdf'),
        ];
    }
}
