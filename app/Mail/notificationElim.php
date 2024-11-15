<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notificationElim extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('SIREB - Notificación de exclusión en evento')
        ->attach(public_path('Icons/ambiente1.jpg'), [
            'as' => 'nombre_personalizado.jpg',
            'mime' => 'image/jpeg',
        ])->view('SIRB/correos/correoeliminar');
    }
}
