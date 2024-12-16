// sales_page.dart
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart';
import '../Service/api_service.dart';

class SalesPage extends StatefulWidget {
  const SalesPage({super.key});

  @override
  SalesPageState createState() => SalesPageState();
}

class SalesPageState extends State<SalesPage> {
  int _currentPage = 0;
  final PageController _pageController = PageController();
  List<dynamic>? salesData;
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadSalesData();
  }

  Future<void> _loadSalesData() async {
    try {
      final response = await ApiService.getSales();
      setState(() {
        salesData = response['data'] as List;
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        isLoading = false;
      });
      print('Error loading sales data: $e');
    }
  }

  double calculateDailyTotal() {
    if (salesData == null) return 0;
    final today = DateTime.now().toString().substring(0, 10);
    return salesData!
        .where((sale) => sale['created_at'].toString().startsWith(today))
        .fold(0, (sum, sale) => sum + (sale['total_sales'] as num));
  }

  double calculateMonthlyTotal() {
    if (salesData == null) return 0;
    final thisMonth = DateTime.now().toString().substring(0, 7);
    return salesData!
        .where((sale) => sale['created_at'].toString().startsWith(thisMonth))
        .fold(0, (sum, sale) => sum + (sale['total_sales'] as num));
  }

  double calculateAnnualTotal() {
    if (salesData == null) return 0;
    final thisYear = DateTime.now().year.toString();
    return salesData!
        .where((sale) => sale['created_at'].toString().startsWith(thisYear))
        .fold(0, (sum, sale) => sum + (sale['total_sales'] as num));
  }

int calculateTotalOrders() {
  if (salesData == null) return 0;
  return salesData!
      .fold<int>(0, (sum, sale) => sum + (sale['item_sold'] as num).toInt());
}

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(8.0),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: List.generate(
                3,
                (index) => Padding(
                  padding: const EdgeInsets.all(4.0),
                  child: AnimatedContainer(
                    duration: const Duration(milliseconds: 300),
                    height: 8,
                    width: _currentPage == index ? 24 : 8,
                    decoration: BoxDecoration(
                      color: _currentPage == index
                          ? CupertinoColors.activeBlue
                          : Colors.grey,
                      borderRadius: BorderRadius.circular(4),
                    ),
                  ),
                ),
              ),
            ),
          ),
          Expanded(
            child: PageView(
              controller: _pageController,
              onPageChanged: (index) {
                setState(() {
                  _currentPage = index;
                });
              },
              children: [
                SalesBigCards(
                  cardTitle: "Daily Sales",
                  cardColor: CupertinoColors.activeBlue,
                  cardIcon: Icons.today,
                  content: _buildDailySalesContent(),
                ),
                SalesBigCards(
                  cardTitle: "Monthly Sales",
                  cardColor: CupertinoColors.systemGreen,
                  cardIcon: Icons.calendar_month,
                  content: _buildMonthlySalesContent(),
                ),
                SalesBigCards(
                  cardTitle: "Annual Sales",
                  cardColor: CupertinoColors.systemIndigo,
                  cardIcon: Icons.calendar_today,
                  content: _buildAnnualSalesContent(),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildDailySalesContent() {
    if (isLoading) {
      return const Center(child: CircularProgressIndicator());
    }

    final dailyTotal = calculateDailyTotal();
    final dailyOrders = salesData
            ?.where((sale) => sale['created_at']
                .toString()
                .startsWith(DateTime.now().toString().substring(0, 10)))
            .length ??
        0;

    return SingleChildScrollView(
      child: Column(
        children: [
          _buildSalesMetric(
              "Today's Revenue", "\$${dailyTotal.toStringAsFixed(2)}"),
          _buildSalesMetric("Orders", "$dailyOrders"),
          _buildSalesMetric(
            "Average Order Value",
            "\$${dailyOrders > 0 ? (dailyTotal / dailyOrders).toStringAsFixed(2) : '0'}",
          ),
          const SizedBox(height: 20),
          _buildChart(),
          const SizedBox(height: 20),
          _buildRecentTransactions(),
        ],
      ),
    );
  }

  Widget _buildMonthlySalesContent() {
    if (isLoading) {
      return const Center(child: CircularProgressIndicator());
    }

    final monthlyTotal = calculateMonthlyTotal();
    final monthlyOrders = salesData
            ?.where((sale) => sale['created_at']
                .toString()
                .startsWith(DateTime.now().toString().substring(0, 7)))
            .length ??
        0;

    return SingleChildScrollView(
      child: Column(
        children: [
          _buildSalesMetric(
              "Monthly Revenue", "\$${monthlyTotal.toStringAsFixed(2)}"),
          _buildSalesMetric("Total Orders", "$monthlyOrders"),
          _buildSalesMetric(
            "Average Order Value",
            "\$${monthlyOrders > 0 ? (monthlyTotal / monthlyOrders).toStringAsFixed(2) : '0'}",
          ),
          const SizedBox(height: 20),
          _buildChart(),
          const SizedBox(height: 20),
          _buildTopProducts(),
        ],
      ),
    );
  }

  Widget _buildAnnualSalesContent() {
    if (isLoading) {
      return const Center(child: CircularProgressIndicator());
    }

    final annualTotal = calculateAnnualTotal();
    final annualOrders = salesData
            ?.where((sale) => sale['created_at']
                .toString()
                .startsWith(DateTime.now().year.toString()))
            .length ??
        0;

    return SingleChildScrollView(
      child: Column(
        children: [
          _buildSalesMetric(
              "Annual Revenue", "\$${annualTotal.toStringAsFixed(2)}"),
          _buildSalesMetric("Total Orders", "$annualOrders"),
          _buildSalesMetric(
            "Average Order Value",
            "\$${annualOrders > 0 ? (annualTotal / annualOrders).toStringAsFixed(2) : '0'}",
          ),
          const SizedBox(height: 20),
          _buildChart(),
          const SizedBox(height: 20),
          _buildYearlyComparison(),
        ],
      ),
    );
  }

  Widget _buildSalesMetric(String label, String value) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 16.0),
      margin: const EdgeInsets.symmetric(vertical: 4.0, horizontal: 8.0),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 2,
            offset: const Offset(0, 1),
          ),
        ],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            label,
            style: const TextStyle(
              fontSize: 16,
              color: Colors.grey,
            ),
          ),
          Text(
            value,
            style: const TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildChart() {
    if (salesData == null) return Container();

    // Group sales by date and calculate daily totals
    final dailyTotals = <DateTime, double>{};
    for (var sale in salesData!) {
      final date = DateTime.parse(sale['created_at']);
      final totalSales = sale['total_sales'] as num;
      final dateKey = DateTime(date.year, date.month, date.day);
      dailyTotals[dateKey] = (dailyTotals[dateKey] ?? 0) + totalSales;
    }

    // Convert to list of spots for the chart
    final spots = dailyTotals.entries
        .map((entry) => FlSpot(
              entry.key.millisecondsSinceEpoch.toDouble(),
              entry.value,
            ))
        .toList();

    return Container(
      height: 200,
      padding: const EdgeInsets.all(16),
      margin: const EdgeInsets.symmetric(horizontal: 8),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 2,
            offset: const Offset(0, 1),
          ),
        ],
      ),
      child: LineChart(
        LineChartData(
          gridData: FlGridData(show: false),
          titlesData: FlTitlesData(show: false),
          borderData: FlBorderData(show: false),
          lineBarsData: [
            LineChartBarData(
              spots: spots,
              isCurved: true,
              color: CupertinoColors.activeBlue,
              barWidth: 3,
              dotData: FlDotData(show: false),
              belowBarData: BarAreaData(
                show: true,
                color: CupertinoColors.activeBlue.withOpacity(0.1),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildRecentTransactions() {
    if (salesData == null) return Container();

    final recentSales = salesData!.take(5).toList(); // Show last 5 transactions

    return Container(
      margin: const EdgeInsets.all(8),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 2,
            offset: const Offset(0, 1),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            "Recent Transactions",
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 16),
          ...recentSales.map((sale) => _buildTransactionItem(
                "${sale['name']}",
                "\$${sale['total_sales'].toStringAsFixed(2)}",
                sale['created_at'].toString().substring(11, 16),
              )),
        ],
      ),
    );
  }

  Widget _buildTransactionItem(String name, String amount, String time) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(name),
          Column(
            crossAxisAlignment: CrossAxisAlignment.end,
            children: [
              Text(
                amount,
                style: const TextStyle(fontWeight: FontWeight.bold),
              ),
              Text(
                time,
                style: const TextStyle(color: Colors.grey, fontSize: 12),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildTopProducts() {
    if (salesData == null) return Container();

    // Group sales by product and calculate total sales
    final productTotals = <String, double>{};
    for (var sale in salesData!) {
      final productName = sale['name'] as String;
      final totalSales = sale['total_sales'] as num;
      productTotals[productName] =
          (productTotals[productName] ?? 0) + totalSales;
    }

    // Sort products by total sales
    final sortedProducts = productTotals.entries.toList()
      ..sort((a, b) => b.value.compareTo(a.value));

    return Container(
      margin: const EdgeInsets.all(8),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 2,
            offset: const Offset(0, 1),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            "Top Products",
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 16),
          ...sortedProducts.take(5).map((entry) => ListTile(
                title: Text(entry.key),
                trailing: Text("\$${entry.value.toStringAsFixed(2)}"),
              )),
        ],
      ),
    );
  }

  Widget _buildYearlyComparison() {
    if (salesData == null) return Container();

    // Group sales by year
    final yearlyTotals = <int, double>{};
    for (var sale in salesData!) {
      final date = DateTime.parse(sale['created_at']);
      final totalSales = sale['total_sales'] as num;
      yearlyTotals[date.year] = (yearlyTotals[date.year] ?? 0) + totalSales;
    }

    return Container(
      margin: const EdgeInsets.all(8),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 2,
            offset: const Offset(0, 1),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            "Yearly Comparison",
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 16),
          ...yearlyTotals.entries.map((entry) => ListTile(
                title: Text(entry.key.toString()),
                trailing: Text("\$${entry.value.toStringAsFixed(2)}"),
              )),
        ],
      ),
    );
  }
}

class SalesBigCards extends StatelessWidget {
  final String cardTitle;
  final Color cardColor;
  final IconData cardIcon;
  final Widget content;

  const SalesBigCards({
    Key? key,
    required this.cardTitle,
    required this.cardColor,
    required this.cardIcon,
    required this.content,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 2,
            blurRadius: 4,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Column(
        children: [
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: cardColor.withOpacity(0.1),
              borderRadius: const BorderRadius.only(
                topLeft: Radius.circular(16),
                topRight: Radius.circular(16),
              ),
            ),
            child: Row(
              children: [
                Icon(cardIcon, color: cardColor),
                const SizedBox(width: 8),
                Text(
                  cardTitle,
                  style: TextStyle(
                    color: cardColor,
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ],
            ),
          ),
          Expanded(
            child: content,
          ),
        ],
      ),
    );
  }
}