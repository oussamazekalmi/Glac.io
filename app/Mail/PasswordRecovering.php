<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordRecovering extends Mailable
{
    use Queueable, SerializesModels;

    protected $id;
    protected $password;
    protected $created_at;

    /**
     * Create a new message instance.
     */
    public function __construct($id, $password, $created_at)
    {
        $this->id = $id;
        $this->password = $password;
        $this->created_at = $created_at;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Récupération de mot de passe',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        $hashedChain = $this->id.''.$this->password.''.$this->created_at;
        $url = route('verify.password', ['hash' => base64_encode($this->id.'$$'.$this->password.'$$'.$this->created_at)]);
        return (new Content())->view('mail.recover_password')->with([ 'link' => $url, 'hash' => $hashedChain]);
    }
    

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachements( ) {
        return [];
  }

}