import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'pages/dashboard.dart';
import 'pages/category.dart';
import 'pages/sales.dart';
import 'pages/products.dart';
import 'pages/stocks.dart';
import 'pages/report.dart';

class App extends StatefulWidget {
  const App({super.key});

  @override
  AppState createState() => AppState();
}

class AppState extends State<App> {
  int _selectedPageIndex =
      0; // default value is set to zero, to view the dashboad after logging in.

  // ArryList of Pages.
  final List<Widget> _page = [
    const DashBoardPage(),
    const SalesPage(),
    const ProductsPage(),
    const StockPage(),
    const CategoryPage(),
    const ReportPage(),
  ];

  // change page index each tap on the drawer.
  void _seletePage(int index) {
    setState(() {
      _selectedPageIndex = index;
    });

    // Delay the drawer closing animation slightly
    Future.delayed(const Duration(milliseconds: 300), () {
      if (mounted) {
        Navigator.pop(context); // Close the drawer after the delay
      }
    });
  }

  void _logout() {
    Future.delayed(const Duration(milliseconds: 300), () {
      if (mounted) {
        Navigator.pushNamed(context, '/login-page');
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _page[_selectedPageIndex], // Display the seleted page.
      drawer: Drawer(
        child: ListView(
          padding: EdgeInsets.zero,
          children: [
            const DrawerHeader(child: Text("Drawer Header.")),
            ListTile(
              leading: const Icon(
                Icons.dashboard,
                color: CupertinoColors.activeBlue,
                size: 25,
              ),
              title: const Text("Dashboard",
                  style: TextStyle(
                    color: CupertinoColors.activeBlue,
                    fontWeight: FontWeight.bold,
                    fontSize: 20,
                  )),
              onTap: () => _seletePage(0),
              splashColor: Colors.grey,
            ),
            ListTile(
              leading: const Icon(
                Icons.attach_money,
                color: CupertinoColors.activeBlue,
                size: 25,
              ),
              title: const Text("Sales",
                  style: TextStyle(
                    color: CupertinoColors.activeBlue,
                    fontWeight: FontWeight.bold,
                    fontSize: 20,
                  )),
              onTap: () => _seletePage(1),
              splashColor: Colors.grey,
            ),
            ListTile(
              leading: const Icon(
                Icons.shopping_bag,
                color: CupertinoColors.activeBlue,
                size: 25,
              ),
              title: const Text("Products",
                  style: TextStyle(
                    color: CupertinoColors.activeBlue,
                    fontWeight: FontWeight.bold,
                    fontSize: 20,
                  )),
              onTap: () => _seletePage(2),
              splashColor: Colors.grey,
            ),
            ListTile(
              leading: const Icon(
                Icons.inventory,
                color: CupertinoColors.activeBlue,
                size: 25,
              ),
              title: const Text(
                "Stocks",
                style: TextStyle(
                  color: CupertinoColors.activeBlue,
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              onTap: () => _seletePage(3),
              splashColor: Colors.grey,
            ),
            ListTile(
              leading: const Icon(
                Icons.category,
                color: CupertinoColors.activeBlue,
              ),
              title: const Text(
                "Categories",
                style: TextStyle(
                  color: CupertinoColors.activeBlue,
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              onTap: () => _seletePage(4),
              splashColor: Colors.grey,
            ),
            ListTile(
              leading: const Icon(
                Icons.bar_chart,
                color: CupertinoColors.activeBlue,
              ),
              title: const Text(
                "Reports",
                style: TextStyle(
                  color: CupertinoColors.activeBlue,
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              onTap: () => _seletePage(5),
              splashColor: Colors.grey,
            ),
            ListTile(
              leading: const Icon(
                Icons.logout,
                color: CupertinoColors.systemRed,
                size: 25,
              ),
              title: const Text(
                "Logout",
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                  color: CupertinoColors.systemRed,
                ),
              ),
              onTap: () {
                _logout();
              },
              splashColor: Colors.grey,
            ),
          ],
        ),
      ),
    );
  }
}
