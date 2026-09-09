<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NouvelleCommandeVendeur extends Mailable
{
    use Queueable, SerializesModels;

    public Commande $commande;
    public Collection $produitsVendeur;

    public function __construct(Commande $commande, Collection $produitsVendeur)
    {
        $this->commande = $commande;
        $this->produitsVendeur = $produitsVendeur;
    }

    public function build()
    {
        return $this->subject('Nouvelle commande reçue sur Zero Gaspi')
            ->view('emails.nouvelle-commande-vendeur');
    }
}