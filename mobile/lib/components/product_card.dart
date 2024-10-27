import 'package:flutter/material.dart';

class ProductCard extends StatelessWidget {
  final Color cardColor;
  final String title;
  const ProductCard({
    super.key,
    required this.cardColor,
    required this.title,
  });

  @override
  Widget build(BuildContext context) {
    return Card(
      color: cardColor,
      margin: const EdgeInsets.all(10),
      child: Padding(
        padding: const EdgeInsets.all(10),
        child: Column(
          children: [
            Container(
              child: Row(
                children: [Text(title)],
              ),
            )
          ],
        ),
      ),
    );
  }
}
