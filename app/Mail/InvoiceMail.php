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
     * Dit zijn alle objecten variables dat nodig zijn om een factuur naar de klant en brouwers contactpersoon te verzenden
     * De funcitie haalt alle objectjen op en gebruikt het voor het verzenden van een factuur
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
     * Deze functie voegt het onderwerp toe in e-mail.
     * Het voegt ook de e-mailadres van de klant in de vak naar wie de e-mail moet worden gestuurd.
     * Het voegt ook de e-mailadres van de Brouwers contactpersoon in de CC:
     *
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            // onderwerp wordt gevoegd
            subject: $this->subject,
// e-mailadres van klant wordt in de ontvanger vak toegevoegd
            to: $this->email,
// e-mailadres van brouwers persoon wordt in de CC: toegevoegd
            cc: $this->bemail,
        );
    }

    /**
     * Deze functie stuurt de gegevens dat in de mail wordt automatisch wordt geschreven.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            // frontend view van de e-mail bericht
            markdown: 'layouts.mails.invoice',
            with: [
            // alle gegevens dat in in de e-mail bericht zal staan, ophalen
                'name' => $this->email,
                'cc' => $this->bemail,
               'maand'=> $this->invoicemaand,
               'from'=> $this->sender,
               'contact'=> $this->ontvanger,

            ]
        );
    }

    /**
     * Deze functie voegt de PDF bestand als bijlage toe in de e-mail bericht dat naar de klant en
     * Brouwers contactpersoon wordt verzonden
     *
     * @return array
     */
    public function attachments()
    {
        return [
         // de gemaakt factuur is in de "PDF" object, dit wordt dat in de mail toegevoegd.
         // ook de object voor de naan van de PDF wordt toegevoegd
            Attachment::fromData(fn () => $this->pdf, $this->sendpdfnaam)
                ->withMime('application/pdf'),
        ];
    }
}
