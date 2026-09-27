import 'dart:convert';

import 'package:http/http.dart' as http;

class ApiService {
  // Émulateur Android : 10.0.2.2 désigne le PC.
  // Téléphone réel : mettre l'adresse IP du PC (commande ipconfig), par ex. http://192.168.1.20:8000/api
  static const String baseUrl = 'http://10.0.2.2:8000/api';

  static String? token;
  static Map<String, dynamic>? user;

  static Map<String, String> get _headers => {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        if (token != null) 'Authorization': 'Bearer $token',
      };

  /// Renvoie null si la connexion a réussi, sinon le message d'erreur à afficher.
  static Future<String?> login(String email, String password) async {
    http.Response response;

    try {
      response = await http
          .post(
            Uri.parse('$baseUrl/login'),
            headers: _headers,
            body: jsonEncode({'email': email, 'password': password}),
          )
          .timeout(const Duration(seconds: 10));
    } catch (e) {
      return 'Serveur injoignable. Vérifiez que Laravel est lancé et l\'adresse dans api_service.dart.';
    }

    Map<String, dynamic> data;
    try {
      data = jsonDecode(response.body) as Map<String, dynamic>;
    } catch (e) {
      return 'Réponse inattendue du serveur (code ${response.statusCode}).';
    }

    if (response.statusCode == 200) {
      token = data['token'] as String?;
      user = data['user'] as Map<String, dynamic>?;
      return null;
    }

    return (data['message'] as String?) ?? 'Connexion impossible (code ${response.statusCode}).';
  }

  static Future<void> logout() async {
    try {
      await http
          .post(Uri.parse('$baseUrl/logout'), headers: _headers)
          .timeout(const Duration(seconds: 10));
    } catch (_) {
      // Même si le serveur ne répond pas, on déconnecte localement
    }
    token = null;
    user = null;
  }
}