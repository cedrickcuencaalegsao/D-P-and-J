import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import '../app.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  LoginPageState createState() => LoginPageState();
}
// we need the icon here.

class LoginPageState extends State<LoginPage> {
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  final FocusNode _focusNode = FocusNode();
  bool _isFocused = false;
  bool _isValidEmail = false;
  bool _obscurePassword = true;

  String? _validatePassword(String? value) {
    if (value == null || value.isEmpty) {
      return 'Password cannot be empty';
    } else if (value.length < 6) {
      return 'Password must be at least 6 characters long';
    } else if (!RegExp(r'^(?=.*[a-z])(?=.*[A-Z]).+$').hasMatch(value)) {
      return 'Password must contain both lowercase and uppercase letters';
    }
    return null; // Return null if the password is valid
  }

  void login() {
    String email = _emailController.text;
    String password = _passwordController.text;

    print('Email: $email, Password: $password');

    Navigator.of(context).pushReplacement(
      MaterialPageRoute(builder: (_) => const App()),
    );
  }

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

  bool _isEmailValid(String email) {
    final emailRegex =
        RegExp(r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$');
    return emailRegex.hasMatch(email);
  }

  // void _login() {
  //   String email = _emailController.text;
  //   String password = _passwordController.text;
  //   print('Email: $email, Password:$password');
  // }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            SizedBox(
              width: 300.00,
              height: 520.00,
              child: Column(
                children: [
                  const SizedBox(
                    height: 210.00,
                    // child: Text("Login"),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Text(
                          "LOGIN",
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 30,
                            color: CupertinoColors.activeBlue,
                            letterSpacing: 2,
                          ),
                        ),
                        SizedBox(
                          height: 10.00,
                        ),
                        Image(
                          image: AssetImage('Assets/Icons/favicon.ico'),
                          height: 150,
                          width: 150,
                        )
                      ],
                    ),
                  ),
                  const SizedBox(
                    height: 10,
                  ),
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
                  ),
                  const SizedBox(
                    height: 10.00,
                  ),
                  TextField(
                    obscureText: _obscurePassword,
                    controller: _passwordController,
                    onChanged: (value) {
                      _validatePassword(value);
                    },
                    decoration: InputDecoration(
                      labelText: 'Password',
                      prefixIcon: const Icon(Icons.lock),
                      suffixIcon: IconButton(
                        onPressed: () {
                          setState(() {
                            _obscurePassword = !_obscurePassword;
                          });
                        },
                        icon: Icon(_obscurePassword
                            ? Icons.visibility
                            : Icons.visibility_off),
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
                  ),
                  const SizedBox(
                    height: 10.00,
                  ),
                  ElevatedButton(
                    onPressed: login,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: CupertinoColors.activeBlue,
                      minimumSize: const Size(250, 70),
                    ),
                    child: const Center(
                      child: Text(
                        'Login',
                        style: TextStyle(
                          fontSize: 30.00,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                          letterSpacing: 1.5,
                        ),
                      ),
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
