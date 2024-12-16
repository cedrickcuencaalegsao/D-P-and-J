import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class CategoryPage extends StatefulWidget {
  const CategoryPage({super.key});
  @override
  CategoryPageState createState() => CategoryPageState();
}

class CategoryPageState extends State<CategoryPage> {
  // Sample category data - replace with your actual data
  final List<Map<String, dynamic>> categories = [
    {
      'name': 'Electronics',
      'icon': Icons.devices,
      'color': Colors.blue,
      'items': '245 items'
    },
    {
      'name': 'Fashion',
      'icon': Icons.shopping_bag,
      'color': Colors.pink,
      'items': '156 items'
    },
    {
      'name': 'Home & Garden',
      'icon': Icons.home,
      'color': Colors.green,
      'items': '325 items'
    },
    {
      'name': 'Sports',
      'icon': Icons.sports_basketball,
      'color': Colors.orange,
      'items': '148 items'
    },
    {
      'name': 'Books',
      'icon': Icons.book,
      'color': Colors.purple,
      'items': '213 items'
    },
    {
      'name': 'Beauty',
      'icon': Icons.face,
      'color': Colors.red,
      'items': '184 items'
    },
    {
      'name': 'Toys',
      'icon': Icons.toys,
      'color': Colors.amber,
      'items': '95 items'
    },
    {
      'name': 'Automotive',
      'icon': Icons.directions_car,
      'color': Colors.indigo,
      'items': '120 items'
    },
    {
      'name': 'Groceries',
      'icon': Icons.shopping_cart,
      'color': Colors.teal,
      'items': '425 items'
    },
    {
      'name': 'Health',
      'icon': Icons.health_and_safety,
      'color': Colors.lightGreen,
      'items': '165 items'
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          // Search Bar
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: TextField(
              decoration: InputDecoration(
                hintText: 'Search categories...',
                prefixIcon: const Icon(Icons.search),
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(30),
                  borderSide: BorderSide.none,
                ),
                filled: true,
                fillColor: Colors.grey[200],
              ),
            ),
          ),
          // Categories Grid
          Expanded(
            child: Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0),
              child: GridView.builder(
                gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 2,
                  childAspectRatio: 1.1,
                  crossAxisSpacing: 16,
                  mainAxisSpacing: 16,
                ),
                itemCount: categories.length,
                itemBuilder: (context, index) {
                  return Card(
                    elevation: 4,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(15),
                    ),
                    child: InkWell(
                      onTap: () {
                        // Handle category tap
                        // You can navigate to a new page or show more details
                        ScaffoldMessenger.of(context).showSnackBar(
                          SnackBar(
                            content:
                                Text('Selected: ${categories[index]['name']}'),
                            duration: const Duration(seconds: 1),
                          ),
                        );
                      },
                      borderRadius: BorderRadius.circular(15),
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Container(
                            padding: const EdgeInsets.all(12),
                            decoration: BoxDecoration(
                              color:
                                  categories[index]['color'].withOpacity(0.1),
                              shape: BoxShape.circle,
                            ),
                            child: Icon(
                              categories[index]['icon'],
                              size: 40,
                              color: categories[index]['color'],
                            ),
                          ),
                          const SizedBox(height: 12),
                          Text(
                            categories[index]['name'],
                            style: const TextStyle(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          const SizedBox(height: 4),
                          Text(
                            categories[index]['items'],
                            style: TextStyle(
                              fontSize: 12,
                              color: Colors.grey[600],
                            ),
                          ),
                        ],
                      ),
                    ),
                  );
                },
              ),
            ),
          ),
        ],
      ),
    );
  }
}
