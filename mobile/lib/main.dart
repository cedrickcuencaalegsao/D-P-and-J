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
<<<<<<< HEAD
      home: HomePage(),
=======
      home: SplashScreen(),
>>>>>>> development
    );
  }
}

<<<<<<< HEAD
class HomePage extends StatefulWidget {
  const HomePage({super.key});
  @override
  HomePageState createState() => HomePageState();
}

class HomePageState extends State<HomePage> {
  String data = '';
  bool isLoading = true;
  String error = '';
=======
// class HomePage extends StatefulWidget {
//   @override
//   _HomePageState createState() => _HomePageState();
// }

// class _HomePageState extends State<HomePage> {
//   String data = '';
//   bool isLoading = true;
//   String error = '';
>>>>>>> development

//   @override
//   void initState() {
//     super.initState();
//     fetchData();
//   }

//   Future<void> fetchData() async {
//     try {
//       final response =
//           await http.get(Uri.parse('http://127.0.0.1:8000/api/hello-world'));

<<<<<<< HEAD
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
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('API Fetch Example'),
      ),
      body: Center(
        child: isLoading
            ? const CircularProgressIndicator()
            : error.isNotEmpty
                ? Text(error)
                : Text('Data: $data'),
      ),
    );
  }
}
=======
//       if (response.statusCode == 200) {
//         setState(() {
//           data = json.decode(response.body); // Decode JSON and update the data
//           isLoading = false;
//         });
//       } else {
//         setState(() {
//           error = 'Error: ${response.statusCode}';
//           isLoading = false;
//         });
//       }
//     } catch (e) {
//       setState(() {
//         error = 'An error occurred';
//         isLoading = false;
//       });
//       print(e);
//     }
//   }

//   @override
//   Widget build(BuildContext context) {
//     return Scaffold(
//       appBar: AppBar(
//         title: Text('API Fetch Example'),
//       ),
//       body: Center(
//         child: isLoading
//             ? CircularProgressIndicator()
//             : error.isNotEmpty
//                 ? Text(error)
//                 : Text('Data: $data'),
//       ),
//     );
//   }
// }
>>>>>>> development