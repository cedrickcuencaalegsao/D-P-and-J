import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'pages/dashboard.dart';
import 'pages/category.dart';
import 'pages/sales.dart';
import 'pages/products.dart';
import 'pages/stocks.dart';
import 'pages/report.dart';
import 'Service/api_service.dart';
import 'Auth/login.dart';

class App extends StatefulWidget {
  const App({super.key});

  @override
  AppState createState() => AppState();
}

class AppState extends State<App> {
  int _selectedPageIndex = 0;

  // Modern Blue Theme Colors
  static const Color primaryColor = Color(0xFF1A73E8); // Google Blue
  static const Color accentColor = Color(0xFF66B2FF); // Light Blue
  static const Color backgroundColor = Color(0xFFFFFFFF); // White
  static const Color textColor = Color(0xFF202124); // Dark Gray
  static const Color secondaryTextColor = Color(0xFF5F6368); // Medium Gray
  static const Color selectedBgColor =
      Color(0xFFE8F0FE); // Light Blue Background

  final List<Widget> _page = [
    const DashBoardPage(),
    const SalesPage(),
    const ProductsPage(),
    const StockPage(),
    const CategoryPage(),
    const ReportPage(),
  ];

  void _selectPage(int index) {
    setState(() {
      _selectedPageIndex = index;
    });
    Future.delayed(const Duration(milliseconds: 300), () {
      if (mounted) {
        Navigator.pop(context);
      }
    });
  }

  void _logout() async {
    try {
      await ApiService.logout();
      if (mounted) {
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => const LoginPage()),
        );
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Logout failed: $e')),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Theme(
      data: ThemeData(
        primaryColor: primaryColor,
        scaffoldBackgroundColor: backgroundColor,
        fontFamily: 'Poppins',
        appBarTheme: const AppBarTheme(
          backgroundColor: primaryColor,
          elevation: 0,
          iconTheme: IconThemeData(color: Colors.white),
          titleTextStyle: TextStyle(
            color: Colors.white,
            fontSize: 20,
            fontWeight: FontWeight.w600,
            fontFamily: 'Poppins',
          ),
        ),
      ),
      child: Scaffold(
        appBar: AppBar(
          title: Text(_getAppBarTitle()),
          actions: [
            IconButton(
              icon: const Icon(Icons.notifications_outlined),
              onPressed: () {},
            ),
            const SizedBox(width: 8),
          ],
        ),
        body: _page[_selectedPageIndex],
        drawer: Drawer(
          elevation: 0,
          child: Container(
            color: backgroundColor,
            child: ListView(
              padding: EdgeInsets.zero,
              children: [
                DrawerHeader(
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                      colors: [
                        primaryColor,
                        accentColor,
                      ],
                    ),
                    boxShadow: [
                      BoxShadow(
                        color: primaryColor.withOpacity(0.2),
                        blurRadius: 10,
                        offset: const Offset(0, 5),
                      ),
                    ],
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Container(
                        padding: const EdgeInsets.all(2),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          shape: BoxShape.circle,
                          boxShadow: [
                            BoxShadow(
                              color: primaryColor.withOpacity(0.2),
                              blurRadius: 8,
                              offset: const Offset(0, 3),
                            ),
                          ],
                        ),
                        child: const CircleAvatar(
                          radius: 30,
                          backgroundColor: Colors.white,
                          child: Icon(
                            Icons.person,
                            color: primaryColor,
                            size: 35,
                          ),
                        ),
                      ),
                      const SizedBox(height: 12),
                      const Text(
                        "Welcome, User!",
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      Text(
                        "user@example.com",
                        style: TextStyle(
                          color: Colors.white.withOpacity(0.9),
                          fontSize: 14,
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 8),
                _buildDrawerTile(
                  icon: Icons.dashboard_rounded,
                  title: 'Dashboard',
                  onTap: () => _selectPage(0),
                  isSelected: _selectedPageIndex == 0,
                ),
                _buildDrawerTile(
                  icon: Icons.attach_money_rounded,
                  title: 'Sales',
                  onTap: () => _selectPage(1),
                  isSelected: _selectedPageIndex == 1,
                ),
                _buildDrawerTile(
                  icon: Icons.shopping_bag_rounded,
                  title: 'Products',
                  onTap: () => _selectPage(2),
                  isSelected: _selectedPageIndex == 2,
                ),
                _buildDrawerTile(
                  icon: Icons.inventory_rounded,
                  title: 'Stocks',
                  onTap: () => _selectPage(3),
                  isSelected: _selectedPageIndex == 3,
                ),
                _buildDrawerTile(
                  icon: Icons.category_rounded,
                  title: 'Categories',
                  onTap: () => _selectPage(4),
                  isSelected: _selectedPageIndex == 4,
                ),
                _buildDrawerTile(
                  icon: Icons.bar_chart_rounded,
                  title: 'Reports',
                  onTap: () => _selectPage(5),
                  isSelected: _selectedPageIndex == 5,
                ),
                const Divider(
                  thickness: 1,
                  height: 32,
                  indent: 16,
                  endIndent: 16,
                ),
                _buildDrawerTile(
                  icon: Icons.logout_rounded,
                  title: 'Logout',
                  onTap: _logout,
                  isLogout: true,
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  String _getAppBarTitle() {
    switch (_selectedPageIndex) {
      case 0:
        return 'Dashboard';
      case 1:
        return 'Sales';
      case 2:
        return 'Products';
      case 3:
        return 'Stocks';
      case 4:
        return 'Categories';
      case 5:
        return 'Reports';
      default:
        return 'Dashboard';
    }
  }

  Widget _buildDrawerTile({
    required IconData icon,
    required String title,
    required VoidCallback onTap,
    bool isSelected = false,
    bool isLogout = false,
  }) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        color: isSelected ? selectedBgColor : Colors.transparent,
      ),
      child: ListTile(
        leading: Icon(
          icon,
          color: isLogout
              ? Colors.red
              : isSelected
                  ? primaryColor
                  : secondaryTextColor,
          size: 24,
        ),
        title: Text(
          title,
          style: TextStyle(
            color: isLogout
                ? Colors.red
                : isSelected
                    ? primaryColor
                    : textColor,
            fontWeight: isSelected ? FontWeight.w600 : FontWeight.w500,
            fontSize: 15,
          ),
        ),
        onTap: onTap,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        selectedTileColor: selectedBgColor,
        minLeadingWidth: 20,
        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
      ),
    );
  }
}
