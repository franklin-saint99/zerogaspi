<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function envoyer(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Mail::to('haretmohand033@gmail.com')->send(new ContactMessage(
            $request->nom,
            $request->email,
            $request->sujet,
            $request->message
        ));

        return redirect()->route('contact')->with('success', 'Votre message a bien été envoyé ! Nous vous répondrons rapidement.');
    }
}