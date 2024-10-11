import 'package:flutter/material.dart';
import 'package:http/http.dart' as http; // Import the http package
import 'dart:convert'; // Import for JSON decoding

void main() {
  runApp(const MainApp());
}

class MainApp extends StatelessWidget {
  const MainApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: HomePage(),
    );
  }
}

class HomePage extends StatefulWidget {
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  String data = '';
  bool isLoading = true;
  String error = '';

  @override
  void initState() {
    super.initState();
    fetchData();
  }

  Future<void> fetchData() async {
    try {
      final response =
          await http.get(Uri.parse('http://127.0.0.1:8000/api/hello-world'));

      if (response.statusCode == 200) {
        setState(() {
          data = json.decode(response.body); // Decode JSON and update the data
          isLoading = false;
        });
      } else {
        setState(() {
          error = 'Error: ${response.statusCode}';
          isLoading = false;
        });
      }
    } catch (e) {
      setState(() {
        error = 'An error occurred';
        isLoading = false;
      });
      print(e);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('API Fetch Example'),
      ),
      body: Center(
        child: isLoading
            ? CircularProgressIndicator()
            : error.isNotEmpty
                ? Text(error)
                : Text('Data: $data'),
      ),
    );
  }
}
