import 'package:flutter/material.dart';

import 'screens/login_screen.dart';

void main() {
  runApp(const ZeroGaspiApp());
}

class ZeroGaspiApp extends StatelessWidget {
  const ZeroGaspiApp({super.key});

  static const vertFonce = Color(0xFF1A5C38);
  static const vert = Color(0xFF27AE60);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Zéro Gaspi',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: vert, primary: vertFonce),
        scaffoldBackgroundColor: const Color(0xFFF4F6F4),
        useMaterial3: true,
      ),
      home: const LoginScreen(),
    );
  }
}