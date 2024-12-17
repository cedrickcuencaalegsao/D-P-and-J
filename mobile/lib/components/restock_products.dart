import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:mobile/Service/api_service.dart';

class RestockProductModal extends StatelessWidget {
  final Map<String, dynamic> product;
  final Function? onComplete;

  const RestockProductModal({
    super.key,
    required this.product,
    this.onComplete,
  });

  static void show(BuildContext context, Map<String, dynamic> product,
      {Function? onComplete}) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => RestockProductModal(
        product: product,
        onComplete: onComplete,
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final quantityController = TextEditingController();
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

    Future<void> handleRestock() async {
      final newQuantity = int.tryParse(quantityController.text) ?? 0;
      if (newQuantity <= 0) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Please enter a valid quantity')),
        );
        return;
      }

      try {
        await ApiService.restock(
          product['product_id'],
          newQuantity,
        );

        if (context.mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Stock updated successfully')),
          );
          Navigator.pop(context);
          onComplete?.call();
        }
      } catch (e) {
        if (context.mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Failed to update stock: $e')),
          );
        }
      }
    }

    return Container(
      height: MediaQuery.of(context).size.height * 0.7,
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.only(
          topLeft: Radius.circular(20),
          topRight: Radius.circular(20),
        ),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Text(
                  'Restock Product',
                  style: TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                    color: CupertinoColors.activeBlue,
                  ),
                ),
                IconButton(
                  onPressed: () => Navigator.pop(context),
                  icon: const Icon(Icons.close),
                ),
              ],
            ),
            const SizedBox(height: 20),
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.grey[100],
                borderRadius: BorderRadius.circular(12),
              ),
              child: Row(
                children: [
                  ClipRRect(
                    borderRadius: BorderRadius.circular(8),
                    child: Image.asset(
                      'Assets/Icons/default.png',
                      width: 80,
                      height: 80,
                      fit: BoxFit.cover,
                    ),
                  ),
                  const SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          product['name'] ?? '',
                          style: const TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                          ),
                          maxLines: 2,
                          overflow: TextOverflow.ellipsis,
                        ),
                        const SizedBox(height: 4),
                        Text(
                          'SKU: ${product['product_id'] ?? ''}',
                          style: TextStyle(
                            color: Colors.grey[600],
                            fontSize: 14,
                          ),
                        ),
                        const SizedBox(height: 8),
                        Container(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 8,
                            vertical: 4,
                          ),
                          decoration: BoxDecoration(
                            color: stockBgColor,
                            borderRadius: BorderRadius.circular(8),
                          ),
                          child: Text(
                            '${product['Stocks']} in stock',
                            style: TextStyle(
                              color: stockTextColor,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),
            Text(
              'Add Stock',
              style: TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.bold,
                color: Colors.grey[800],
              ),
            ),
            const SizedBox(height: 12),
            TextField(
              controller: quantityController,
              keyboardType: TextInputType.number,
              decoration: InputDecoration(
                filled: true,
                fillColor: Colors.grey[100],
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(12),
                  borderSide: BorderSide.none,
                ),
                hintText: 'Enter quantity to add',
                prefixIcon: const Icon(Icons.add_shopping_cart),
              ),
            ),
            const Spacer(),
            SizedBox(
              width: double.infinity,
              height: 50,
              child: ElevatedButton(
                onPressed: handleRestock,
                style: ElevatedButton.styleFrom(
                  backgroundColor: CupertinoColors.activeBlue,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                ),
                child: const Text(
                  'Confirm Restock',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
