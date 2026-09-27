import 'package:flutter/material.dart';

import '../services/api_service.dart';
import 'home_screen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  bool _chargement = false;
  bool _masquerMotDePasse = true;
  String? _erreur;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _seConnecter() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() {
      _chargement = true;
      _erreur = null;
    });

    final erreur = await ApiService.login(
      _emailController.text.trim(),
      _passwordController.text,
    );

    if (!mounted) return;

    setState(() => _chargement = false);

    if (erreur != null) {
      setState(() => _erreur = erreur);
      return;
    }

    Navigator.of(context).pushReplacement(
      MaterialPageRoute(builder: (_) => const HomeScreen()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.all(24),
            child: Form(
              key: _formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  const Text('🥦', textAlign: TextAlign.center, style: TextStyle(fontSize: 56)),
                  const SizedBox(height: 8),
                  const Text(
                    'Zéro Gaspi',
                    textAlign: TextAlign.center,
                    style: TextStyle(fontSize: 28, fontWeight: FontWeight.bold, color: Color(0xFF1A5C38)),
                  ),
                  const SizedBox(height: 4),
                  const Text(
                    'Connectez-vous à votre compte',
                    textAlign: TextAlign.center,
                    style: TextStyle(color: Colors.black54),
                  ),
                  const SizedBox(height: 32),
                  TextFormField(
                    controller: _emailController,
                    keyboardType: TextInputType.emailAddress,
                    autocorrect: false,
                    decoration: const InputDecoration(
                      labelText: 'Email',
                      prefixIcon: Icon(Icons.email_outlined),
                      border: OutlineInputBorder(),
                      filled: true,
                      fillColor: Colors.white,
                    ),
                    validator: (valeur) {
                      if (valeur == null || valeur.trim().isEmpty) return 'Saisissez votre email';
                      if (!valeur.contains('@')) return 'Cet email n\'est pas valide';
                      return null;
                    },
                  ),
                  const SizedBox(height: 16),
                  TextFormField(
                    controller: _passwordController,
                    obscureText: _masquerMotDePasse,
                    decoration: InputDecoration(
                      labelText: 'Mot de passe',
                      prefixIcon: const Icon(Icons.lock_outline),
                      border: const OutlineInputBorder(),
                      filled: true,
                      fillColor: Colors.white,
                      suffixIcon: IconButton(
                        icon: Icon(_masquerMotDePasse ? Icons.visibility_outlined : Icons.visibility_off_outlined),
                        onPressed: () => setState(() => _masquerMotDePasse = !_masquerMotDePasse),
                      ),
                    ),
                    validator: (valeur) =>
                        (valeur == null || valeur.isEmpty) ? 'Saisissez votre mot de passe' : null,
                    onFieldSubmitted: (_) => _seConnecter(),
                  ),
                  if (_erreur != null) ...[
                    const SizedBox(height: 16),
                    Container(
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        color: const Color(0xFFFEE2E2),
                        borderRadius: BorderRadius.circular(8),
                      ),
                      child: Text(_erreur!, style: const TextStyle(color: Color(0xFF991B1B))),
                    ),
                  ],
                  const SizedBox(height: 24),
                  SizedBox(
                    height: 50,
                    child: FilledButton(
                      style: FilledButton.styleFrom(backgroundColor: const Color(0xFF27AE60)),
                      onPressed: _chargement ? null : _seConnecter,
                      child: _chargement
                          ? const SizedBox(
                              width: 22,
                              height: 22,
                              child: CircularProgressIndicator(strokeWidth: 2.5, color: Colors.white),
                            )
                          : const Text('Se connecter', style: TextStyle(fontSize: 16)),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}