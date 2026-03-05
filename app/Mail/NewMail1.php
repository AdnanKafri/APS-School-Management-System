<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMail1 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $details,$footer;

    public function __construct($details,$footer){

        $this->details = $details;
         $this->footer = $footer;
        

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){

        return $this->subject('Important')
                    ->view('admin.responsive');
    }
}
