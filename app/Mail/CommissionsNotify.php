<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommissionsNotify extends Mailable
{
    use Queueable, SerializesModels;

    protected $commissionsInfo;

    public function __construct($commissionsInfo)
    {
        $this->commissionsInfo = $commissionsInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.commissions')
            ->with('commissionsInfo', $this->commissionsInfo);
    }
}
