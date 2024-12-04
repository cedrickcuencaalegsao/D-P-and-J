import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import '../components/product_card.dart';

class ProductsPage extends StatefulWidget {
  const ProductsPage({super.key});
  @override
  ProductsPageState createState() => ProductsPageState();
}

class ProductsPageState extends State<ProductsPage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: CupertinoColors.white,
        title: const Text(
          "Products",
          style: TextStyle(
            color: CupertinoColors.activeBlue,
            fontWeight: FontWeight.bold,
            fontSize: 20,
          ),
        ),
        leading: IconButton(
          onPressed: () {
            Scaffold.of(context).openDrawer();
          },
          icon: const Icon(
            Icons.menu,
            color: CupertinoColors.activeBlue,
          ),
          splashColor: Colors.grey,
        ),
      ),
      body: Padding(
        padding: const EdgeInsets.all(10),
        child: GridView.builder(
          gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: 2, // 2 cards per row
            crossAxisSpacing: 10, // spacing between columns
            mainAxisSpacing: 10, // spacing between rows
            childAspectRatio:
                0.75, // Aspect ratio of the card (height to width)
          ),
          itemCount: 20, // Infinite product cards
          itemBuilder: (context, index) {
            return ProductCard(
              cardColor: CupertinoColors.white,
              title: "Product ${index + 1}",
              category:
                  "Category ${index + 1}", // Changed description to category
              price: "\$${(index + 1) * 5}",
              imageUrl:
                  "https://example.com/image${index + 1}.jpg", // Example image URL
            );
          },
        ),
      ),
    );
  }
}
