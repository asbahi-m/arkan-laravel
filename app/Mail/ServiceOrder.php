<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The content instance.
     *
     * @var string
     */
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.service_order')
                    ->with('content', $this->content)
                    ->subject($this->content['subject'])
                    // ->form('asbahi.mo@gmail.com', 'Name')
                    // ->subject(__('admin.service_order') . ' | ' . $this->content['service'] . ' | ' . $this->content['name'])
                    ;
    }
}
