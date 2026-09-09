<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Zero Gaspi</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        .role-switch { display: flex; gap: 0.75rem; margin-bottom: 1.5rem; }
        .role-option { flex: 1; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0.9rem; text-align: center; cursor: pointer; transition: all 0.2s; }
        .role-option.active { border-color: #27ae60; background: #e8f5ee; }
        .role-option i { font-size: 1.4rem; display: block; margin-bottom: 0.3rem; color: #1a5c38; }
        .role-option span { font-size: 0.85rem; font-weight: 600; color: #374151; }
        .field-hidden { display: none; }
    </style>
</head>
<body>
<div class="page">
    <div class="left">
        <div class="blob1"></div>
        <div class="blob2"></div>
        <div class="logo">
            <div class="logo-box"><i class="ti ti-leaf"></i></div>
            <span class="logo-name">Zero Gaspi</span>
        </div>
        <div class="left-mid">
            <h1>Zéro gaspi,<em>100% impact.</em></h1>
            <p>Ensemble, réduisons le gaspillage alimentaire.</p>
        </div>
        <div class="left-foot">© 2026 Zero Gaspi</div>
    </div>
    <div class="right">
        <div class="form-wrap">
            <h2>Créer un compte</h2>
            <p class="sub">Choisissez votre profil pour commencer</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'acheteur') }}">

                <div class="role-switch">
                    <div class="role-option {{ old('role', 'acheteur') === 'acheteur' ? 'active' : '' }}" id="optAcheteur" onclick="choisirRole('acheteur')">
                        <i class="ti ti-shopping-cart"></i>
                        <span>Je suis acheteur</span>
                    </div>
                    <div class="role-option {{ old('role') === 'vendeur' ? 'active' : '' }}" id="optVendeur" onclick="choisirRole('vendeur')">
                        <i class="ti ti-building-store"></i>
                        <span>Je suis un magasin</span>
                    </div>
                </div>
                @error('role')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div class="field">
                    <label id="labelName">Nom complet</label>
                    <div class="input-row">
                        <i class="ti ti-user"></i>
                        <input type="text" name="name" id="inputName" placeholder="Votre nom" value="{{ old('name') }}" required autofocus />
                    </div>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field {{ old('role') === 'vendeur' ? '' : 'field-hidden' }}" id="fieldAddress">
                    <label>Adresse du magasin</label>
                    <div class="input-row">
                        <i class="ti ti-map-pin"></i>
                        <input type="text" name="address" placeholder="Ex : 15 rue Victor Hugo, Paris" value="{{ old('address') }}" />
                    </div>
                    @error('address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field {{ old('role') === 'vendeur' ? '' : 'field-hidden' }}" id="fieldSiret">
                    <label>Numéro SIRET</label>
                    <div class="input-row">
                        <i class="ti ti-building-store"></i>
                        <input type="text" name="siret" id="inputSiret" placeholder="14 chiffres, ex : 12345678900012" maxlength="14" value="{{ old('siret') }}" />
                    </div>
                    <p style="font-size:0.78rem;color:#6b7280;margin-top:0.35rem;">
                        Nécessaire pour vérifier qu'il s'agit d'un commerce réellement enregistré.
                    </p>
                    @error('siret')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Email</label>
                    <div class="input-row">
                        <i class="ti ti-mail"></i>
                        <input type="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required />
                    </div>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Mot de passe</label>
                    <div class="input-row">
                        <i class="ti ti-lock"></i>
                        <input type="password" name="password" id="passwordInput" placeholder="••••••••" required />
                        <i class="ti ti-eye" id="togglePassword" style="cursor:pointer;"></i>
                    </div>
                    <p style="font-size:0.78rem;color:#6b7280;margin-top:0.35rem;">
                        Minimum 10 caractères, avec une majuscule, une minuscule, un chiffre et un caractère spécial (ex: <strong>!</strong>, <strong>@</strong>, <strong>#</strong>).
                    </p>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Confirmer le mot de passe</label>
                    <div class="input-row">
                        <i class="ti ti-lock-check"></i>
                        <input type="password" name="password_confirmation" id="passwordConfirmInput" placeholder="••••••••" required />
                        <i class="ti ti-eye" id="togglePasswordConfirm" style="cursor:pointer;"></i>
                    </div>
                </div>

                <button type="submit" class="btn">
                    <i class="ti ti-user-plus"></i>
                    S'inscrire
                </button>
            </form>
            <p class="login-line">Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
        </div>
    </div>
</div>

<script>
    function choisirRole(role) {
        document.getElementById('roleInput').value = role;

        document.getElementById('optAcheteur').classList.toggle('active', role === 'acheteur');
        document.getElementById('optVendeur').classList.toggle('active', role === 'vendeur');

        const fieldAddress = document.getElementById('fieldAddress');
        const fieldSiret = document.getElementById('fieldSiret');
        const labelName = document.getElementById('labelName');
        const inputName = document.getElementById('inputName');

        if (role === 'vendeur') {
            fieldAddress.classList.remove('field-hidden');
            fieldSiret.classList.remove('field-hidden');
            labelName.textContent = 'Nom du magasin';
            inputName.placeholder = 'Ex : Carrefour Paris';
        } else {
            fieldAddress.classList.add('field-hidden');
            fieldSiret.classList.add('field-hidden');
            labelName.textContent = 'Nom complet';
            inputName.placeholder = 'Votre nom';
        }
    }

    // Réappliquer le bon état si erreur de validation (old('role'))
    document.addEventListener('DOMContentLoaded', function () {
        const currentRole = document.getElementById('roleInput').value;
        choisirRole(currentRole);
    });

    function initTogglePassword(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        toggle.addEventListener('click', function () {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            toggle.classList.toggle('ti-eye', !isHidden);
            toggle.classList.toggle('ti-eye-off', isHidden);
        });
    }
    initTogglePassword('togglePassword', 'passwordInput');
    initTogglePassword('togglePasswordConfirm', 'passwordConfirmInput');
</script>

</body>
</html>