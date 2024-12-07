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
      0; // Default value is set to zero to view the dashboard after logging in.

  // ArrayList of Pages
  final List<Widget> _page = [
    const DashBoardPage(),
    const SalesPage(),
    const ProductsPage(),
    const StockPage(),
    const CategoryPage(),
    const ReportPage(),
  ];

  // Change page index each tap on the drawer.
  void _selectPage(int index) {
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
      body: _page[_selectedPageIndex], // Display the selected page
      drawer: Drawer(
        backgroundColor: Colors.white,
        child: ListView(
          padding: EdgeInsets.zero,
          children: [
            const UserAccountsDrawerHeader(
              accountName: Text(
                "Welcome, User!",
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  color: CupertinoColors.activeBlue,
                ),
              ),
              accountEmail: Text(
                "user@example.com",
                style: TextStyle(color: CupertinoColors.systemGrey),
              ),
              currentAccountPicture: CircleAvatar(
                backgroundColor: CupertinoColors.activeBlue,
                child: Icon(
                  Icons.person,
                  color: Colors.white,
                  size: 40,
                ),
              ),
              decoration: BoxDecoration(
                color: CupertinoColors.systemGroupedBackground,
                borderRadius:
                    BorderRadius.vertical(bottom: Radius.circular(20)),
              ),
            ),
            _buildDrawerTile(
              icon: Icons.dashboard,
              title: 'Dashboard',
              onTap: () => _selectPage(0),
            ),
            _buildDrawerTile(
              icon: Icons.attach_money,
              title: 'Sales',
              onTap: () => _selectPage(1),
            ),
            _buildDrawerTile(
              icon: Icons.shopping_bag,
              title: 'Products',
              onTap: () => _selectPage(2),
            ),
            _buildDrawerTile(
              icon: Icons.inventory,
              title: 'Stocks',
              onTap: () => _selectPage(3),
            ),
            _buildDrawerTile(
              icon: Icons.category,
              title: 'Categories',
              onTap: () => _selectPage(4),
            ),
            _buildDrawerTile(
              icon: Icons.bar_chart,
              title: 'Reports',
              onTap: () => _selectPage(5),
            ),
            const Divider(),
            _buildDrawerTile(
              icon: Icons.logout,
              title: 'Logout',
              onTap: _logout,
              iconColor: CupertinoColors.systemRed,
              textColor: CupertinoColors.systemRed,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildDrawerTile({
    required IconData icon,
    required String title,
    required VoidCallback onTap,
    Color iconColor = CupertinoColors.activeBlue,
    Color textColor = CupertinoColors.activeBlue,
  }) {
    return ListTile(
      leading: Icon(
        icon,
        color: iconColor,
        size: 25,
      ),
      title: Text(
        title,
        style: TextStyle(
          color: textColor,
          fontWeight: FontWeight.bold,
          fontSize: 20,
        ),
      ),
      onTap: onTap,
      splashColor: Colors.grey,
    );
  }
}
