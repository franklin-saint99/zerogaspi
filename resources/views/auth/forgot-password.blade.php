<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié - Zero Gaspi</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
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
            <h1>Moins de gaspi,<br><em>plus d'impact.</em></h1>
            <p>Rejoignez des milliers de magasins qui agissent chaque jour contre le gaspillage alimentaire.</p>
            <div class="stat-grid">
                <div class="stat-box">
                    <div class="num">2 400+</div>
                    <div class="lbl">Magasins</div>
                </div>
                <div class="stat-box">
                    <div class="num">18 t</div>
                    <div class="lbl">Économisées</div>
                </div>
                <div class="stat-box">
                    <div class="num">96%</div>
                    <div class="lbl">Satisfaits</div>
                </div>
            </div>
        </div>

        <div class="left-foot">© 2026 Zero Gaspi</div>
    </div>

    <div class="right">
        <div class="form-wrap">
            <h2>Mot de passe oublié 🔑</h2>
            <p class="sub">Pas de panique, indiquez votre email et nous vous enverrons un lien de réinitialisation.</p>

            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="field">
                    <label>Email</label>
                    <div class="input-row">
                        <i class="ti ti-mail"></i>
                        <input type="email" name="email" placeholder="votre@magasin.fr" value="{{ old('email') }}" required autofocus />
                    </div>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn">
                    <i class="ti ti-send"></i>
                    Envoyer le lien de réinitialisation
                </button>
            </form>

            <p class="register"><a href="{{ route('login') }}">← Retour à la connexion</a></p>
        </div>
    </div>

</div>

</body>
</html>