import 'package:flutter/material.dart';

import '../services/api_service.dart';
import 'login_screen.dart';

class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  Future<void> _seDeconnecter(BuildContext context) async {
    await ApiService.logout();
    if (!context.mounted) return;
    Navigator.of(context).pushReplacement(
      MaterialPageRoute(builder: (_) => const LoginScreen()),
    );
  }

  @override
  Widget build(BuildContext context) {
    final user = ApiService.user ?? {};
    final nom = user['name'] ?? '';
    final email = user['email'] ?? '';
    final role = user['role'] ?? '';

    return Scaffold(
      appBar: AppBar(
        title: const Text('Zéro Gaspi'),
        backgroundColor: const Color(0xFF1A5C38),
        foregroundColor: Colors.white,
        actions: [
          IconButton(
            tooltip: 'Se déconnecter',
            icon: const Icon(Icons.logout),
            onPressed: () => _seDeconnecter(context),
          ),
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(24),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Bonjour $nom 👋', style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold)),
            const SizedBox(height: 8),
            const Text('Vous êtes connecté.', style: TextStyle(color: Colors.black54)),
            const SizedBox(height: 24),
            Card(
              color: Colors.white,
              child: ListTile(
                leading: const Icon(Icons.person_outline, color: Color(0xFF27AE60)),
                title: Text(email),
                subtitle: Text('Rôle : $role'),
              ),
            ),
          ],
        ),
      ),
    );
  }
}