import 'package:flutter/material.dart';
// import 'package:http/http.dart' as http; // Import the http package
// import 'dart:convert'; // Import for JSON decoding
// import 'Auth/login.dart';
import 'splashscreen.dart';

void main() {
  runApp(const MainApp());
}

class MainApp extends StatelessWidget {
  const MainApp({super.key});

  @override
  Widget build(BuildContext context) {
    return const MaterialApp(
      home: SplashScreen(),
    );
  }
}
