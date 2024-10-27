import 'package:flutter/material.dart';

class DashBoardBigCard extends StatelessWidget {
  // initiate prameters
  final String title;
  final IconData cardIcon;
  final Color cardColor;
  final Color titleColor;
  final IconData greenIcon;
  final String greenIndicator;
  final String greenValue;
  final IconData redIcon;
  final String redIndicator;
  final String redValue;

  const DashBoardBigCard({
    super.key,
    required this.title,
    required this.cardIcon,
    required this.cardColor,
    required this.titleColor,
    required this.greenIcon,
    required this.greenIndicator,
    required this.greenValue,
    required this.redIcon,
    required this.redIndicator,
    required this.redValue,
  });

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.all(8.00),
      elevation: 0,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(10.00),
      ),
      child: Container(
        decoration: BoxDecoration(
            color: cardColor,
            borderRadius: BorderRadius.circular(10),
            boxShadow: [
              BoxShadow(
                color: Colors.grey.withOpacity(0.7),
                spreadRadius: 1,
                blurRadius: 10,
                offset: const Offset(0, 0),
              )
            ]),
        child: Padding(
          padding: const EdgeInsets.all(8.0),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: TextStyle(
                    color: titleColor,
                    fontWeight: FontWeight.bold,
                    fontSize: 30.00),
              ),
              const SizedBox(
                height: 10,
              ),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    greenIndicator,
                    style: const TextStyle(
                      color: Colors.green,
                      fontWeight: FontWeight.bold,
                      fontSize: 18.00,
                    ),
                  ),
                  Row(
                    children: [
                      Icon(
                        greenIcon,
                        color: Colors.green,
                        size: 40,
                      ),
                      Text(
                        greenValue,
                        style: const TextStyle(
                          color: Colors.green,
                          fontWeight: FontWeight.bold,
                          fontSize: 25,
                        ),
                      )
                    ],
                  )
                ],
              ),
              const SizedBox(
                height: 5,
              ),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    redIndicator,
                    style: const TextStyle(
                        color: Colors.red,
                        fontWeight: FontWeight.bold,
                        fontSize: 18.00),
                  ),
                  Row(
                    children: [
                      Icon(
                        redIcon,
                        color: Colors.red,
                        size: 40,
                      ),
                      Text(
                        redValue,
                        style: const TextStyle(
                          color: Colors.red,
                          fontWeight: FontWeight.bold,
                          fontSize: 25,
                        ),
                      )
                    ],
                  )
                ],
              )
            ],
          ),
        ),
      ),
    );
  }
}
