<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau mot de passe - Zero Gaspi</title>
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
            <h2>Nouveau mot de passe 🔒</h2>
            <p class="sub">Choisissez un nouveau mot de passe pour votre compte.</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="field">
                    <label>Email</label>
                    <div class="input-row">
                        <i class="ti ti-mail"></i>
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                    </div>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Nouveau mot de passe</label>
                    <div class="input-row">
                        <i class="ti ti-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
                    </div>
                    <p style="font-size:0.78rem;color:#6b7280;margin-top:0.35rem;">
                        Minimum 10 caractères, avec une majuscule, une minuscule, un chiffre et un caractère spécial.
                    </p>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Confirmer le mot de passe</label>
                    <div class="input-row">
                        <i class="ti ti-lock-check"></i>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
                    </div>
                </div>

                <button type="submit" class="btn">
                    <i class="ti ti-check"></i>
                    Réinitialiser le mot de passe
                </button>
            </form>
        </div>
    </div>

</div>

</body>
</html>