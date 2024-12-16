import 'package:http/http.dart' as http;
import 'dart:convert';
import 'dart:io' show Platform;
import 'session_manager.dart';

class ApiService {
  static String get baseUrl {
    if (Platform.isAndroid) {
      if (bool.fromEnvironment('dart.vm.product')) {
        // Release mode
        return 'http://192.168.1.4:8000/api'; // Your computer's IP
      } else {
        // Debug mode - Android emulator
        return 'http://192.168.1.4:8000/api'; // Your computer's IP
      }
    }
    // For web or other platforms
    return 'http://192.168.1.4:8000/api';
  }

  static Future<Map<String, dynamic>> login(
      String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'email': email,
          'password': password,
        }),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        await SessionManager.saveSession(
          data['token'],
          data['user']['id'].toString(),
        );
        return data;
      } else {
        throw Exception('Failed to login: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<bool> logout() async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.post(
        Uri.parse('$baseUrl/logout'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        await SessionManager.clearSession();
        return true;
      } else {
        throw Exception('Failed to logout: ${response.body}');
      }
    } catch (e) {
      await SessionManager.clearSession();
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> getCategories() async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.get(
        Uri.parse('$baseUrl/categories'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      print('Categories Response Status Code: ${response.statusCode}');
      print('Categories Response Body: ${response.body}');

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load categories: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> getStocks() async {
    try {
      print('Fetching stocks');
      print('Using base URL: $baseUrl');

      final token = await SessionManager.getToken();
      final response = await http.get(
        Uri.parse('$baseUrl/stocks'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      print('Stocks Response Status Code: ${response.statusCode}');
      print('Stocks Response Body: ${response.body}');

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load stocks: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> getSales() async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.get(
        Uri.parse('$baseUrl/sales'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load sales: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> getReports() async {
    try {
      print('Fetching reports');
      print('Using base URL: $baseUrl');

      final token = await SessionManager.getToken();
      final response = await http.get(
        Uri.parse('$baseUrl/reports'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      print('Reports Response Status Code: ${response.statusCode}');
      print('Reports Response Body: ${response.body}');

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load reports: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> getAllData() async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.get(
        Uri.parse('$baseUrl/alldata'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load data: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> getProducts() async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.get(
        Uri.parse('$baseUrl/products'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load products: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> addProduct(
      String name, String category, double price, String? image) async {
    try {
      final token = await SessionManager.getToken();

      final requestBody = {
        'name': name,
        'category': category,
        'price': price,
        'stock': 0,
        'image': image ?? 'default.jpg',
      };

      final response = await http.post(
        Uri.parse('$baseUrl/product/add'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
          'Accept': 'application/json',
        },
        body: jsonEncode(requestBody),
      );

      if (response.statusCode == 200 || response.statusCode == 201) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to add product: ${response.body}');
      }
    } catch (e) {
      rethrow;
    }
  }

  static Future<Map<String, dynamic>> buyProduct(String productId,
      double retailedPrice, double retrievePrice, int quantity) async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.post(
        Uri.parse('$baseUrl/product/buy'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode({
          'product_id': productId,
          'retailed_price': retailedPrice,
          'retrieve_price': retrievePrice,
          'quantity': quantity,
        }),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to buy product: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> updateProduct(String productId,
      String name, String category, double price, String? image) async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.post(
        Uri.parse('$baseUrl/product/updates'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode({
          'product_id': productId,
          'name': name,
          'category': category,
          'retrieve_price': price,
          'image': image,
        }),
      );

      if (response.statusCode == 200) {
        // Handle boolean response from Laravel
        final dynamic responseData = jsonDecode(response.body);
        if (responseData is bool) {
          return {'success': responseData};
        }
        return responseData;
      } else {
        throw Exception('Failed to update product: ${response.body}');
      }
    } catch (e) {
      print('Update Product Error: $e');
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> restock(
      String productId, int quantity) async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.post(
        Uri.parse('$baseUrl/restock'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode({
          'product_id': productId,
          'quantity': quantity,
        }),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to restock: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }

  static Future<Map<String, dynamic>> search(String query) async {
    try {
      final token = await SessionManager.getToken();
      final response = await http.get(
        Uri.parse('$baseUrl/search?q=$query'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );
      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to search: ${response.body}');
      }
    } catch (e) {
      throw Exception('Failed to connect to the server: $e');
    }
  }
}
