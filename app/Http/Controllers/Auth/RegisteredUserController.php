<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:vendeur,acheteur'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'required_if:role,vendeur', 'string', 'max:255'],
            'siret' => [
                'nullable',
                'required_if:role,vendeur',
                'digits:14',
                function ($attribute, $value, $fail) {
                    if (!$value) {
                        return;
                    }
                    if (!$this->siretEstValide($value)) {
                        $fail('Le numéro SIRET renseigné n\'est pas valide.');
                    }
                },
            ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::min(10)->mixedCase()->numbers()->symbols()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'address' => $request->address,
            'siret' => $request->siret,
            'actif' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Vérifie la validité d'un numéro SIRET via la clé de Luhn.
     * Un SIRET est valide si la somme calculée est un multiple de 10.
     */
    private function siretEstValide(string $siret): bool
    {
        $somme = 0;
        $chiffres = array_reverse(str_split($siret));

        foreach ($chiffres as $index => $chiffre) {
            $n = (int) $chiffre;

            if ($index % 2 === 1) {
                $n *= 2;
                if ($n > 9) {
                    $n -= 9;
                }
            }

            $somme += $n;
        }

        return $somme % 10 === 0;
    }
}