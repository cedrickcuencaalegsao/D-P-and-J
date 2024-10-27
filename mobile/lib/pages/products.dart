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
      body: const Center(
        child: Row(children: [
          ProductCard(
            cardColor: Colors.white,
            title: "test 1",
          ),
          ProductCard(
            cardColor: Colors.white,
            title: "test 2",
          ),
        ]),
        // child: Text(
        //   "Producs",
        // ),
      ),
    );
  }
}
