<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Zero Gaspi</title>
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
            <h2>Bonjour 👋</h2>
            <p class="sub">Connectez-vous à votre espace magasin</p>

            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
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

                <div class="field">
                    <label>Mot de passe</label>
                    <div class="input-row">
                        <i class="ti ti-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required />
                    </div>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="forgot"><a href="{{ route('password.request') }}">Mot de passe oublié ?</a></div>

                <button type="submit" class="btn">
                    <i class="ti ti-login"></i>
                    Se connecter
                </button>
            </form>

            <p class="register">Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
        </div>
    </div>

</div>

</body>
</html>