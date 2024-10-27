// import 'dart:math';
import 'package:flutter/material.dart';

class SalesBigCards extends StatelessWidget {
  final String cardTitle;
  final Color cardColor;
  final IconData cardIcon;
  final String content;

  const SalesBigCards({
    super.key,
    required this.cardTitle,
    required this.cardColor,
    required this.cardIcon,
    required this.content,
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
            Row(
              children: [
                Text(
                  cardTitle,
                  style: const TextStyle(
                    fontWeight: FontWeight.bold,
                    color: Colors.white,
                    fontSize: 30,
                  ),
                ),
                const Spacer(),
                Icon(
                  cardIcon,
                  color: Colors.white,
                  size: 30,
                ),
              ],
            ),
            const SizedBox(
              height: 5,
            ),
            Expanded(
              child: ListView(
                children: [
                  Container(
                    height: 300,
                    margin: const EdgeInsets.all(5),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.all(10),
                      child: Text(content),
                    ),
                  ),
                  Container(
                    height: 300,
                    margin: const EdgeInsets.all(5),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.all(10),
                      child: Text(content),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
