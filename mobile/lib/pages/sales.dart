import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import '../components/sales_big_cards.dart';

class SalesPage extends StatefulWidget {
  const SalesPage({super.key});

  @override
  SalesPageState createState() => SalesPageState();
}

class SalesPageState extends State<SalesPage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text(
          "Sales",
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
        automaticallyImplyLeading: false,
      ),
      body: PageView(
        children: const [
          SalesBigCards(
            cardTitle: "Daily Sales",
            cardColor: CupertinoColors.activeBlue,
            cardIcon: Icons.attach_money,
            content: "daily sales",
          ),
          SalesBigCards(
            cardTitle: "Monthly Sales",
            cardColor: CupertinoColors.activeBlue,
            cardIcon: Icons.attach_money,
            content: "Monthly Sales",
          ),
          SalesBigCards(
            cardTitle: "Annual Sales",
            cardColor: CupertinoColors.activeBlue,
            cardIcon: Icons.attach_money,
            content: "annual Sales",
          ),
        ],
      ),
    );
  }
}
