import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class ProductCard extends StatelessWidget {
  final Color cardColor;
  final String title;
  final String category;
  final String price;
  final String imageUrl;

  const ProductCard({
    super.key,
    required this.cardColor,
    required this.title,
    required this.category,
    required this.price,
    required this.imageUrl,
  });

  void _showProductModal(BuildContext context) {
    // Define a controller for the quantity input
    TextEditingController quantityController = TextEditingController();

    // Show the modal bottom sheet with product details
    showModalBottomSheet(
      context: context,
      isScrollControlled: true, // Allow the modal to adjust height
      builder: (BuildContext context) {
        return Center(
          child: Container(
            padding: const EdgeInsets.all(16.0),
            constraints: BoxConstraints(
              maxWidth: 400, // Maximum width for the modal
              minWidth: 300, // Minimum width for the modal
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                // Product name and price
                Text(
                  title,
                  style: const TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 24,
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  "Price: $price",
                  style: const TextStyle(
                    fontSize: 18,
                  ),
                ),
                const SizedBox(height: 8),
                // Quantity input field
                TextField(
                  controller: quantityController,
                  keyboardType: TextInputType.number,
                  decoration: const InputDecoration(
                    labelText: 'Quantity',
                    border: OutlineInputBorder(),
                  ),
                  maxLength: 3, // Limiting input length to 3 digits
                ),
                const SizedBox(height: 16),
                // Action buttons: Buy Now and Edit
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    // Buy Now Button
                    CupertinoButton(
                      color: CupertinoColors.activeBlue,
                      onPressed: () {
                        String quantity = quantityController.text;
                        // Add your buy now functionality here
                        if (quantity.isNotEmpty) {
                          // Process the buy now action with the entered quantity
                        }
                        Navigator.pop(context); // Close modal
                      },
                      child: const Text(
                        "Buy Now",
                        style: TextStyle(color: CupertinoColors.white),
                      ),
                    ),
                    // Edit Button
                    CupertinoButton(
                      color: CupertinoColors.systemGrey,
                      onPressed: () {
                        // Add your edit functionality here
                        Navigator.pop(context); // Close modal
                      },
                      child: const Text(
                        "Edit",
                        style: TextStyle(color: CupertinoColors.white),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => _showProductModal(context), // Show modal when tapped
      child: Card(
        color: cardColor,
        elevation: 4, // Add shadow for elevation
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(15), // Rounded corners
        ),
        margin: const EdgeInsets.all(10),
        child: Padding(
          padding: const EdgeInsets.all(15),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Product image with a 10x15 aspect ratio (width x height)
              Container(
                width: double
                    .infinity, // Make the image stretch across the card width
                height: 110, // Adjusted for a 10x15 aspect ratio
                decoration: BoxDecoration(
                  image: DecorationImage(
                    image:
                        AssetImage('Assets/Icons/default.png') as ImageProvider,
                    fit: BoxFit.cover, // Ensure the image covers the space
                    alignment: Alignment.center,
                  ),
                  borderRadius: BorderRadius.circular(10),
                ),
              ),
              const SizedBox(height: 10),
              // Product name and price in a row
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  // Product title
                  Text(
                    title,
                    style: const TextStyle(
                      color: CupertinoColors.activeBlue,
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  // Product price styled as a badge
                  Container(
                    padding:
                        const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                    decoration: BoxDecoration(
                      color: CupertinoColors.activeBlue,
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Text(
                      price,
                      style: const TextStyle(
                        color: CupertinoColors.white,
                        fontWeight: FontWeight.bold,
                        fontSize: 14,
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 8),
              // Product category
              Text(
                category, // Now showing category instead of description
                style: const TextStyle(
                  color: CupertinoColors.systemGrey,
                  fontSize: 14,
                ),
                maxLines: 1, // Limit category text to one line
                overflow: TextOverflow.ellipsis,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
