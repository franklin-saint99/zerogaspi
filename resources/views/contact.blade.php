<x-app-layout>
<style>
    :root { --vf: #1a5c38; --vv: #27ae60; --vc: #e8f5ee; --vh: #219150; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    .contact-bg { background: #f4f6f4; min-height: 100vh; padding: 3rem 2rem; }
    .contact-wrap { max-width: 600px; margin: 0 auto; }
    .contact-header { text-align: center; margin-bottom: 2rem; }
    .contact-header h1 { font-size: 1.8rem; font-weight: 700; color: #1a1a1a; }
    .contact-header p { color: #6b7280; margin-top: 0.5rem; }
    .contact-card { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 2rem; }
    .f-group { margin-bottom: 1.2rem; }
    .f-group label { display: block; font-size: 0.85rem; font-weight: 500; color: #374151; margin-bottom: 0.4rem; }
    .f-group input, .f-group textarea { width: 100%; padding: 0.7rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.9rem; color: #374151; font-family: inherit; }
    .f-group input:focus, .f-group textarea:focus { outline: none; border-color: var(--vv); box-shadow: 0 0 0 3px rgba(39,174,96,0.15); }
    .error-msg { color: #dc2626; font-size: 0.8rem; margin-top: 0.3rem; }
    .btn-vert { width: 100%; background: var(--vv); color: white; border: none; padding: 0.8rem; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; }
    .btn-vert:hover { background: var(--vh); }
</style>

<div class="contact-bg">
    <div class="contact-wrap">

        <div class="contact-header">
            <h1>Contactez-nous 📩</h1>
            <p>Une question, une suggestion ? Écrivez-nous, on vous répond rapidement.</p>
        </div>

        @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;">
            ✅ {{ session('success') }}
        </div>
        @endif

        <div class="contact-card">
            <form method="POST" action="{{ route('contact.envoyer') }}">
                @csrf

                <div class="f-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Votre nom" required>
                    @error('nom') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="f-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" required>
                    @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="f-group">
                    <label>Sujet</label>
                    <input type="text" name="sujet" value="{{ old('sujet') }}" placeholder="Ex : Question sur une commande" required>
                    @error('sujet') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="f-group">
                    <label>Message</label>
                    <textarea name="message" rows="5" placeholder="Votre message...">{{ old('message') }}</textarea>
                    @error('message') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn-vert">Envoyer le message</button>
            </form>
        </div>

    </div>
</div>
</x-app-layout>