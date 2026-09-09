<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProduitExpire extends Mailable
{
    use Queueable, SerializesModels;

    public Product $produit;

    public function __construct(Product $produit)
    {
        $this->produit = $produit;
    }

    public function build()
    {
        return $this->subject('Un de vos produits a expiré sur Zero Gaspi')
            ->view('emails.produit-expire');
    }
}