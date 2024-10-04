<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewArtistAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alertInfo)
    {
        $this->alertInfo = $alertInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@enterblazecomics.com')
        ->subject($this->alertInfo['alert_title'])
        ->markdown('emails.new-artist', [
            'alertInfo' => $this->alertInfo,
        ]);
    }
}