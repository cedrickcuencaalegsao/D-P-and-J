import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import '../components/product_card.dart';
import '../Service/api_service.dart';
import '../components/new_product.dart';

class ProductsPage extends StatefulWidget {
  const ProductsPage({super.key});
  @override
  ProductsPageState createState() => ProductsPageState();
}

class ProductsPageState extends State<ProductsPage> {
  List<dynamic> products = [];
  bool isLoading = true;
  String? error;

  @override
  void initState() {
    super.initState();
    loadProducts();
  }

  Future<void> loadProducts() async {
    try {
      // print('=== Loading Products ===');
      final response = await ApiService.getProducts();
      setState(() {
        products = response['data'];
        isLoading = false;
      });
      // print('Products loaded successfully: ${products.length} items');
    } catch (e) {
      // print('=== Error Loading Products ===');
      // print('Error: $e');
      setState(() {
        error = e.toString();
        isLoading = false;
      });
    }
  }

  void _showNewProductModal() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => Padding(
        padding: EdgeInsets.only(
          bottom: MediaQuery.of(context).viewInsets.bottom,
        ),
        child: NewProductModal(
          onSubmit: (name, category, price) async {
            print('=== Submitting New Product ===');
            print('Name: $name');
            print('Category: $category');
            print('Price: $price');
            await loadProducts();
          },
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    if (isLoading) {
      return const Scaffold(
        body: Center(
          child: CircularProgressIndicator(),
        ),
      );
    }

    if (error != null) {
      return Scaffold(
        body: Center(
          child: Text('Error: $error'),
        ),
      );
    }

    return Scaffold(
      body: RefreshIndicator(
        onRefresh: loadProducts,
        child: Padding(
          padding: const EdgeInsets.all(8),
          child: GridView.builder(
            gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
              crossAxisCount: 2,
              crossAxisSpacing: 8,
              mainAxisSpacing: 8,
              childAspectRatio: 0.8,
            ),
            itemCount: products.length,
            itemBuilder: (context, index) {
              final product = products[index];
              return ProductCard(
                cardColor: CupertinoColors.white,
                title: product['name'] ?? 'No Name',
                category: product['category'] ?? 'No Category',
                retailed_price:
                    double.parse(product['retailed_price']?.toString() ?? '0'),
                retrieve_price:
                    double.parse(product['retrieve_price']?.toString() ?? '0'),
                imageUrl:
                    product['image_url'] ?? "https://example.com/default.jpg",
                productId: product['product_id'],
              );
            },
          ),
        ),
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: _showNewProductModal,
        backgroundColor: CupertinoColors.activeBlue,
        child: const Icon(Icons.add),
      ),
    );
  }
}
