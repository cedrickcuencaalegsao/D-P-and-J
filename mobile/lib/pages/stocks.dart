import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class StockPage extends StatefulWidget {
  const StockPage({super.key});

  @override
  StocksPageState createState() => StocksPageState();
}

class StocksPageState extends State<StockPage> {
  String selectedCategory = 'All';
  String searchQuery = '';

  // Mock inventory data
  final List<Map<String, dynamic>> allProducts = [
    {
      'name': 'T-Shirt Black',
      'sku': 'TS-BLK-001',
      'category': 'Apparel',
      'quantity': 150,
      'reorderPoint': 20,
      'price': 29.99,
    },
    {
      'name': 'Running Shoes',
      'sku': 'SH-RUN-002',
      'category': 'Footwear',
      'quantity': 8,
      'reorderPoint': 10,
      'price': 89.99,
    },
    // Add more products as needed
  ];

  List<Map<String, dynamic>> get filteredProducts {
    return allProducts.where((product) {
      final matchesCategory =
          selectedCategory == 'All' || product['category'] == selectedCategory;
      final matchesSearch =
          product['name'].toLowerCase().contains(searchQuery.toLowerCase()) ||
              product['sku'].toLowerCase().contains(searchQuery.toLowerCase());
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
            onPressed: () {
              Navigator.pop(context);
            },
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
        title: const Text('Filter by Stock Status'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            ListTile(
              title: const Text('All Products'),
              onTap: () {
                setState(() {
                  selectedCategory = 'All';
                });
                Navigator.pop(context);
              },
            ),
            ListTile(
              title: const Text('Low Stock'),
              onTap: () {
                setState(() {
                  // Filter products with quantity <= reorderPoint
                  allProducts
                      .where((product) =>
                          product['quantity'] <= product['reorderPoint'])
                      .toList();
                });
                Navigator.pop(context);
              },
            ),
            ListTile(
              title: const Text('Out of Stock'),
              onTap: () {
                setState(() {
                  // Filter products with quantity = 0
                  allProducts
                      .where((product) => product['quantity'] == 0)
                      .toList();
                });
                Navigator.pop(context);
              },
            ),
          ],
        ),
      ),
    );
  }

  void _showAddProductDialog() {
    final nameController = TextEditingController();
    final skuController = TextEditingController();
    final quantityController = TextEditingController();
    final priceController = TextEditingController();
    final reorderPointController = TextEditingController();
    String selectedCategory = 'Apparel';

    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Add New Product'),
        content: SingleChildScrollView(
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              TextField(
                controller: nameController,
                decoration: const InputDecoration(labelText: 'Product Name'),
              ),
              TextField(
                controller: skuController,
                decoration: const InputDecoration(labelText: 'SKU'),
              ),
              TextField(
                controller: quantityController,
                decoration: const InputDecoration(labelText: 'Quantity'),
                keyboardType: TextInputType.number,
              ),
              TextField(
                controller: priceController,
                decoration: const InputDecoration(labelText: 'Price'),
                keyboardType: TextInputType.number,
              ),
              TextField(
                controller: reorderPointController,
                decoration: const InputDecoration(labelText: 'Reorder Point'),
                keyboardType: TextInputType.number,
              ),
              DropdownButtonFormField<String>(
                value: selectedCategory,
                items: ['Apparel', 'Footwear', 'Accessories', 'Electronics']
                    .map((category) => DropdownMenuItem(
                          value: category,
                          child: Text(category),
                        ))
                    .toList(),
                onChanged: (value) {
                  selectedCategory = value!;
                },
                decoration: const InputDecoration(labelText: 'Category'),
              ),
            ],
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          TextButton(
            onPressed: () {
              setState(() {
                allProducts.add({
                  'name': nameController.text,
                  'sku': skuController.text,
                  'category': selectedCategory,
                  'quantity': int.parse(quantityController.text),
                  'reorderPoint': int.parse(reorderPointController.text),
                  'price': double.parse(priceController.text),
                });
              });
              Navigator.pop(context);
            },
            child: const Text('Add'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          // Inventory Summary Cards
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Row(
              children: [
                _buildSummaryCard(
                  'Total Items',
                  allProducts.length.toString(),
                  Icons.inventory,
                  Colors.blue,
                ),
                const SizedBox(width: 16),
                _buildSummaryCard(
                  'Low Stock',
                  allProducts
                      .where((p) => p['quantity'] <= p['reorderPoint'])
                      .length
                      .toString(),
                  Icons.warning,
                  Colors.orange,
                ),
                const SizedBox(width: 16),
                _buildSummaryCard(
                  'Out of Stock',
                  allProducts
                      .where((p) => p['quantity'] == 0)
                      .length
                      .toString(),
                  Icons.error,
                  Colors.red,
                ),
              ],
            ),
          ),

          // Category Filter Chips
          SingleChildScrollView(
            scrollDirection: Axis.horizontal,
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Row(
              children: [
                _buildFilterChip('All'),
                _buildFilterChip('Apparel'),
                _buildFilterChip('Footwear'),
                _buildFilterChip('Accessories'),
                _buildFilterChip('Electronics'),
              ],
            ),
          ),

          const SizedBox(height: 16),

          // Products List
          Expanded(
            child: ListView.builder(
              itemCount: filteredProducts.length,
              padding: const EdgeInsets.all(16),
              itemBuilder: (context, index) {
                final product = filteredProducts[index];
                final bool isLowStock =
                    product['quantity'] <= product['reorderPoint'];

                return Card(
                  margin: const EdgeInsets.only(bottom: 16),
                  child: Padding(
                    padding: const EdgeInsets.all(16),
                    child: Row(
                      children: [
                        // Product Image
                        Container(
                          width: 80,
                          height: 80,
                          decoration: BoxDecoration(
                            color: Colors.grey[200],
                            borderRadius: BorderRadius.circular(8),
                            image: const DecorationImage(
                              image: AssetImage('Assets/Icons/default.png'),
                              fit: BoxFit.cover,
                            ),
                          ),
                        ),
                        const SizedBox(width: 16),
                        // Product Details
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                product['name'],
                                style: const TextStyle(
                                  fontWeight: FontWeight.bold,
                                  fontSize: 16,
                                ),
                              ),
                              const SizedBox(height: 4),
                              Text(
                                'SKU: ${product['sku']}',
                                style: TextStyle(
                                  color: Colors.grey[600],
                                  fontSize: 14,
                                ),
                              ),
                              const SizedBox(height: 8),
                              Row(
                                mainAxisAlignment:
                                    MainAxisAlignment.spaceBetween,
                                children: [
                                  Text(
                                    '\$${product['price']}',
                                    style: const TextStyle(
                                      fontWeight: FontWeight.bold,
                                      fontSize: 16,
                                    ),
                                  ),
                                  Container(
                                    padding: const EdgeInsets.symmetric(
                                      horizontal: 8,
                                      vertical: 4,
                                    ),
                                    decoration: BoxDecoration(
                                      color: isLowStock
                                          ? Colors.red[100]
                                          : Colors.green[100],
                                      borderRadius: BorderRadius.circular(12),
                                    ),
                                    child: Text(
                                      '${product['quantity']} in stock',
                                      style: TextStyle(
                                        color: isLowStock
                                            ? Colors.red[900]
                                            : Colors.green[900],
                                        fontWeight: FontWeight.bold,
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
                );
              },
            ),
          ),
        ],
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: _showAddProductDialog,
        child: const Icon(Icons.add),
      ),
    );
  }

  Widget _buildSummaryCard(
      String title, String value, IconData icon, Color color) {
    return Expanded(
      child: Card(
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            children: [
              Icon(icon, color: color),
              const SizedBox(height: 8),
              Text(
                value,
                style: const TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              Text(
                title,
                style: TextStyle(
                  color: Colors.grey[600],
                  fontSize: 12,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildFilterChip(String label) {
    return Padding(
      padding: const EdgeInsets.only(right: 8),
      child: FilterChip(
        selected: selectedCategory == label,
        label: Text(label),
        onSelected: (bool selected) {
          setState(() {
            selectedCategory = selected ? label : 'All';
          });
        },
      ),
    );
  }
}
