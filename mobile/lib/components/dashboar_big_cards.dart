import 'package:flutter/material.dart';

class DashBoardBigCard extends StatelessWidget {
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
    return GestureDetector(
      onTap: () {},
      child: Card(
        margin: const EdgeInsets.all(12.0),
        elevation: 4,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(20.0),
        ),
        child: Container(
          decoration: BoxDecoration(
            gradient: LinearGradient(
              colors: [
                Colors.blueAccent.shade700,
                Colors.blue.shade400,
              ],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            borderRadius: BorderRadius.circular(20),
            boxShadow: [
              BoxShadow(
                color: Colors.blueAccent.withOpacity(0.3),
                blurRadius: 10,
                spreadRadius: 1,
                offset: const Offset(0, 5),
              ),
            ],
          ),
          child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Icon(
                      cardIcon,
                      size: 50,
                      color: Colors.white,
                    ),
                    Text(
                      title,
                      style: const TextStyle(
                        color: Colors.white,
                        fontWeight: FontWeight.bold,
                        fontSize: 24,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 16),
                _buildIndicatorRow(
                  icon: greenIcon,
                  label: greenIndicator,
                  value: greenValue,
                  color: Colors.greenAccent,
                ),
                const SizedBox(height: 16),
                _buildIndicatorRow(
                  icon: redIcon,
                  label: redIndicator,
                  value: redValue,
                  color: Colors.redAccent,
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildIndicatorRow({
    required IconData icon,
    required String label,
    required String value,
    required Color color,
  }) {
    return Row(
      children: [
        Icon(icon, size: 30, color: color),
        const SizedBox(width: 12),
        Expanded(
          child: Text(
            label,
            style: const TextStyle(
              color: Colors.white,
              fontWeight: FontWeight.w500,
              fontSize: 16,
            ),
          ),
        ),
        Text(
          value,
          style: TextStyle(
            color: color,
            fontWeight: FontWeight.bold,
            fontSize: 20,
          ),
        ),
      ],
    );
  }
}
