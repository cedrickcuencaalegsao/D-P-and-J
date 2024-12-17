import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:mobile/components/restock_products.dart';
import 'package:mobile/Service/api_service.dart';

class StockPage extends StatefulWidget {
  const StockPage({super.key});

  @override
  StocksPageState createState() => StocksPageState();
}

class StocksPageState extends State<StockPage> {
  String selectedCategory = 'All';
  String searchQuery = '';
  List<Map<String, dynamic>> allProducts = [];
  bool isLoading = true;
  String? error;

  @override
  void initState() {
    super.initState();
    loadStocks();
  }

  Future<void> loadStocks() async {
    try {
      setState(() => isLoading = true);
      final response = await ApiService.getStocks();
      setState(() {
        allProducts = List<Map<String, dynamic>>.from(response['stocks'] ?? []);
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        error = e.toString();
        isLoading = false;
      });
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Failed to load stocks: $e')),
        );
      }
    }
  }

  List<Map<String, dynamic>> get filteredProducts {
    return allProducts.where((product) {
      final matchesCategory =
          selectedCategory == 'All' || product['category'] == selectedCategory;
      final matchesSearch = product['name']
              .toString()
              .toLowerCase()
              .contains(searchQuery.toLowerCase()) ||
          product['product_id']
              .toString()
              .toLowerCase()
              .contains(searchQuery.toLowerCase());
      return matchesCategory && matchesSearch;
    }).toList();
  }

  void _showSearchDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Search Products'),
        content: TextField(
          onChanged: (value) {
            setState(() {
              searchQuery = value;
            });
          },
          decoration: const InputDecoration(
            hintText: 'Enter product name or SKU',
            prefixIcon: Icon(Icons.search),
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Close'),
          ),
        ],
      ),
    );
  }

  void _showFilterDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Filter by Category'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            ListTile(
              title: const Text('All Products'),
              onTap: () {
                setState(() => selectedCategory = 'All');
                Navigator.pop(context);
              },
            ),
            ListTile(
              title: const Text('School Supplies'),
              onTap: () {
                setState(() => selectedCategory = 'School Supplies');
                Navigator.pop(context);
              },
            ),
            ListTile(
              title: const Text('Office Supplies'),
              onTap: () {
                setState(() => selectedCategory = 'Office Supplies');
                Navigator.pop(context);
              },
            ),
            ListTile(
              title: const Text('Art Supplies'),
              onTap: () {
                setState(() => selectedCategory = 'Art Supplies');
                Navigator.pop(context);
              },
            ),
            ListTile(
              title: const Text('Technology'),
              onTap: () {
                setState(() => selectedCategory = 'Technology');
                Navigator.pop(context);
              },
            ),
            ListTile(
              title: const Text('Stationery'),
              onTap: () {
                setState(() => selectedCategory = 'Stationery');
                Navigator.pop(context);
              },
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    if (isLoading) {
      return const Center(child: CircularProgressIndicator());
    }

    if (error != null) {
      return Center(child: Text('Error: $error'));
    }

    return Scaffold(
      body: RefreshIndicator(
        onRefresh: loadStocks,
        child: ListView.builder(
          itemCount: filteredProducts.length,
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
          itemBuilder: (context, index) {
            final product = filteredProducts[index];
            final int quantity = product['Stocks'] ?? 0;

            Color stockBgColor;
            Color stockTextColor;
            if (quantity == 0) {
              stockBgColor = Colors.red[100]!;
              stockTextColor = Colors.red[900]!;
            } else if (quantity <= 50) {
              stockBgColor = Colors.yellow[100]!;
              stockTextColor = Colors.yellow[900]!;
            } else {
              stockBgColor = Colors.green[100]!;
              stockTextColor = Colors.green[900]!;
            }

            return Center(
              child: SizedBox(
                width: MediaQuery.of(context).size.width * 0.85,
                child: Card(
                  margin: const EdgeInsets.symmetric(vertical: 8),
                  elevation: 2,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Padding(
                    padding: const EdgeInsets.all(12),
                    child: Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Product Image
                        Container(
                          width: 50,
                          height: 50,
                          decoration: BoxDecoration(
                            color: Colors.grey[200],
                            borderRadius: BorderRadius.circular(8),
                            image: const DecorationImage(
                              image: AssetImage('Assets/Icons/default.png'),
                              fit: BoxFit.cover,
                            ),
                          ),
                        ),
                        const SizedBox(width: 12),
                        // Product Details
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              Text(
                                product['name'] ?? 'No Name',
                                style: const TextStyle(
                                  fontWeight: FontWeight.bold,
                                  fontSize: 14,
                                ),
                                maxLines: 1,
                                overflow: TextOverflow.ellipsis,
                              ),
                              const SizedBox(height: 2),
                              Text(
                                'SKU: ${product['product_id'] ?? 'No SKU'}',
                                style: TextStyle(
                                  color: Colors.grey[600],
                                  fontSize: 12,
                                ),
                                maxLines: 1,
                                overflow: TextOverflow.ellipsis,
                              ),
                              const SizedBox(height: 4),
                              Row(
                                children: [
                                  Expanded(
                                    child: Text(
                                      'Category: ${product['category'] ?? 'N/A'}',
                                      style: const TextStyle(
                                        fontSize: 12,
                                      ),
                                      maxLines: 1,
                                      overflow: TextOverflow.ellipsis,
                                    ),
                                  ),
                                  const SizedBox(width: 8),
                                  Container(
                                    decoration: BoxDecoration(
                                      color: Colors.blue[50],
                                      borderRadius: BorderRadius.circular(6),
                                      border: Border.all(
                                        color: Colors.blue,
                                        width: 1,
                                      ),
                                    ),
                                    child: IconButton(
                                      icon: const Icon(
                                        Icons.add_shopping_cart,
                                        color: Colors.blue,
                                        size: 16,
                                      ),
                                      onPressed: () => RestockProductModal.show(
                                        context,
                                        product,
                                        onComplete: loadStocks,
                                      ),
                                      tooltip: 'Restock',
                                      padding: const EdgeInsets.all(4),
                                      constraints: const BoxConstraints(
                                        minWidth: 28,
                                        minHeight: 28,
                                      ),
                                    ),
                                  ),
                                  const SizedBox(width: 8),
                                  Container(
                                    padding: const EdgeInsets.symmetric(
                                      horizontal: 6,
                                      vertical: 3,
                                    ),
                                    decoration: BoxDecoration(
                                      color: stockBgColor,
                                      borderRadius: BorderRadius.circular(12),
                                    ),
                                    child: Text(
                                      '$quantity',
                                      style: TextStyle(
                                        color: stockTextColor,
                                        fontWeight: FontWeight.bold,
                                        fontSize: 12,
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            );
          },
        ),
      ),
    );
  }
}
