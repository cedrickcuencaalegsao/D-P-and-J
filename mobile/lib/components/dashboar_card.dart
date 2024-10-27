import 'package:flutter/material.dart';

class DashBoadCardWiggets extends StatelessWidget {
  final String title;
  final String content;
  final String link;
  final Color cardColor;
  final Color fontColor;
  final IconData cardIcon;
  final Color iconColor;
  final String bottomText;
  final String bottomValue;

  const DashBoadCardWiggets({
    super.key,
    required this.title,
    required this.content,
    required this.link,
    required this.cardColor,
    required this.fontColor,
    required this.cardIcon,
    required this.iconColor,
    required this.bottomText,
    required this.bottomValue,
  });

  @override
  Widget build(BuildContext context) {
    return Card(
      color: cardColor,
      margin: const EdgeInsets.all(8.0),
      child: Padding(
        padding: const EdgeInsets.all(8.00),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              title,
              style: TextStyle(
                color: fontColor,
                fontWeight: FontWeight.bold,
                fontSize: 30.00,
              ),
            ),
            const SizedBox(
              height: 5.00,
            ),
            Row(
              children: [
                Icon(cardIcon, color: iconColor, size: 50.00),
                const SizedBox(
                  width: 20.00,
                ),
                Text(
                  content,
                  style: TextStyle(
                      color: fontColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 50),
                )
              ],
            ),
            const SizedBox(
              height: 10,
            ),
            Row(
              children: [
                Text(
                  bottomText,
                  style: TextStyle(
                      color: fontColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 20),
                ),
                const SizedBox(
                  width: 100,
                ),
                Icon(
                  cardIcon,
                  color: fontColor,
                  size: 25,
                ),
                const SizedBox(
                  width: 10,
                ),
                Text(
                  bottomValue,
                  style: TextStyle(
                      color: fontColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 25),
                )
              ],
            )
          ],
        ),
      ),
    );
  }
}
