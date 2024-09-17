<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendReceipt extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName, $candidate, $donationReceipt)
    {
        $this->userName = $userName;
        $this->donationReceipt = $donationReceipt;
        $this->candidate = $candidate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $donation = json_decode($this->candidate->donation_meta, true);
        // dd($this->candidate);
        return $this->from('noreply@enterblazecomics.com')
        ->subject("Donation sent to ". $this->candidate->name)
        ->markdown('events.registrations.send-receipt', [
            'donationReceipt' => $this->donationReceipt,
            'candidate' => $this->candidate,
            'userName' => $this->userName,
            'donation' => $donation
        ]);
    }
}