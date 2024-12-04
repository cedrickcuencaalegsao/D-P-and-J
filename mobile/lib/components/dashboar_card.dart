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
    return GestureDetector(
      onTap: () {},
      child: Card(
        elevation: 8,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(20.0),
        ),
        color: cardColor,
        margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Icon(
                    cardIcon,
                    color: iconColor,
                    size: 40.0,
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: Text(
                      title,
                      style: TextStyle(
                        color: fontColor,
                        fontWeight: FontWeight.bold,
                        fontSize: 18.0,
                      ),
                    ),
                  ),
                ],
              ),
              const Spacer(),
              Center(
                child: Text(
                  content,
                  style: TextStyle(
                    color: fontColor,
                    fontWeight: FontWeight.bold,
                    fontSize: 32.0,
                  ),
                ),
              ),
              const Spacer(),
              const Divider(color: Colors.white70, thickness: 1.0),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text(
                    bottomText,
                    style: TextStyle(
                      color: fontColor.withOpacity(0.9),
                      fontSize: 14.0,
                    ),
                  ),
                  Text(
                    bottomValue,
                    style: TextStyle(
                      color: fontColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 16.0,
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
