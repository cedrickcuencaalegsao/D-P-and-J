import 'package:flutter/material.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  LoginPageState createState() => LoginPageState();
}

class LoginPageState extends State<LoginPage> {
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  final FocusNode _focusNode = FocusNode();
  bool _isFocused = false;
  bool _isValidEmail = false;

  @override
  void initState() {
    super.initState();
    _focusNode.addListener(() {
      setState(() {
        _isFocused = _focusNode.hasFocus;
      });
    });
  }

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    _focusNode.dispose();
    super.dispose();
  }

  // void _validateEmail() {
  //   final email = _emailController.text;
  //   setState(() {
  //     _isValidEmail = _isEmailValid(email);
  //   });
  // }

  bool _isEmailValid(String email) {
    final emailRegex =
        RegExp(r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$');
    return emailRegex.hasMatch(email);
  }

  void _login() {
    String email = _emailController.text;
    String password = _passwordController.text;
    print('Email: $email, Password:$password');
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Center(
          child: Text("Login"),
        ),
        automaticallyImplyLeading: false,
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            SizedBox(
              width: 300.00,
              height: 150.00,
              child: Column(
                children: [
                  TextField(
                    controller: _emailController,
                    focusNode: _focusNode,
                    keyboardType: TextInputType.emailAddress,
                    onChanged: (value) {
                      setState(() {
                        _isValidEmail = _isEmailValid(value);
                      });
                    },
                    decoration: InputDecoration(
                      labelText: _isFocused ? "Your Email" : "Email",
                      labelStyle: TextStyle(
                        color: _isFocused ? Colors.blue : Colors.grey,
                      ),
                      hintText: 'example@email.com',
                      hintStyle: const TextStyle(
                        color: Colors.grey,
                      ),
                      prefixIcon: Icon(
                        // Icons.email,
                        // color: Colors.blue,
                        !_isFocused
                            ? Icons.email
                            : _isValidEmail
                                ? Icons.check_circle
                                : Icons.cancel,
                        color: !_isFocused
                            ? Colors.grey
                            : _isValidEmail
                                ? Colors.green
                                : Colors.red,
                      ),
                      border: const OutlineInputBorder(
                          borderSide: BorderSide(
                        color: Colors.grey,
                      )),
                      focusedBorder: const OutlineInputBorder(
                          borderSide: BorderSide(
                        color: Colors.blue,
                      )),
                      enabledBorder: const OutlineInputBorder(
                          borderSide: BorderSide(
                        color: Colors.grey,
                      )),
                    ),
                  )
                ],
              ),
            )
          ],
        ),
      ),
    );
  }
}
