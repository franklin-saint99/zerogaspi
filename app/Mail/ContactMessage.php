<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $emailExpediteur;
    public $sujet;
    public $messageContenu;

    public function __construct($nom, $emailExpediteur, $sujet, $messageContenu)
    {
        $this->nom = $nom;
        $this->emailExpediteur = $emailExpediteur;
        $this->sujet = $sujet;
        $this->messageContenu = $messageContenu;
    }

    public function build()
    {
        return $this->subject('Nouveau message de contact : ' . $this->sujet)
            ->replyTo($this->emailExpediteur, $this->nom)
            ->view('emails.contact');
    }
}