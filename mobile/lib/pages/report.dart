import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart';
import '../Service/api_service.dart'; // Import the ApiService

class ReportPage extends StatefulWidget {
  const ReportPage({super.key});

  @override
  ReportPageState createState() => ReportPageState();
}

class ReportPageState extends State<ReportPage> {
  double totalSales = 0.0;
  int totalItemsSold = 0;
  int totalSalesCount = 0;
  List<Map<String, dynamic>> salesData = [];

  @override
  void initState() {
    super.initState();
    _fetchReportData();
  }

  Future<void> _fetchReportData() async {
    try {
      final response = await ApiService.getReports();
      final sales = response['data']['sales'] as List<dynamic>;

      // Calculate total sales and total items sold
      totalSales = sales.fold(0.0, (sum, item) => sum + item['total_sales']);
      totalItemsSold =
          sales.fold(0, (sum, item) => sum + item['item_sold'] as int);

      // Store sales data for further use
      salesData = sales.map((item) => item as Map<String, dynamic>).toList();

      totalSalesCount = salesData.length;

      setState(() {});
    } catch (e) {
      // Handle error
      print('Error fetching report data: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Overview Cards
              GridView.count(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                crossAxisCount: 2,
                crossAxisSpacing: 16,
                mainAxisSpacing: 16,
                children: [
                  _buildOverviewCard(
                    "Total Sales",
                    "\$${totalSales.toStringAsFixed(2)}",
                    Icons.monetization_on,
                    Colors.green,
                  ),
                  _buildOverviewCard(
                    "Total Items Sold",
                    "$totalItemsSold items",
                    Icons.shopping_cart,
                    Colors.blue,
                  ),
                  _buildOverviewCard(
                    "Production",
                    "$totalSalesCount sales",
                    Icons.factory,
                    Colors.blue,
                  ),
                  _buildOverviewCard(
                    "Distribution",
                    "$totalSalesCount centers",
                    Icons.local_shipping,
                    Colors.orange,
                  ),
                ],
              ),

              const SizedBox(height: 24),

              // Sales Chart
              _buildSectionTitle("Sales Performance"),
              Container(
                height: 200,
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.grey.withOpacity(0.1),
                      spreadRadius: 2,
                      blurRadius: 4,
                    ),
                  ],
                ),
                child: LineChart(
                  _getSalesData(),
                ),
              ),

              const SizedBox(height: 24),

              // Product Performance
              _buildSectionTitle("Product Performance"),
              _buildProductList(),

              const SizedBox(height: 24),

              // Recent Activities
              _buildSectionTitle("Recent Activities"),
              _buildActivityList(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildOverviewCard(
      String title, String value, IconData icon, Color color) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 2,
            blurRadius: 4,
          ),
        ],
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(icon, size: 32, color: color),
          const SizedBox(height: 8),
          Text(
            title,
            style: const TextStyle(
              fontSize: 14,
              color: Colors.grey,
            ),
          ),
          const SizedBox(height: 4),
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

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: Text(
        title,
        style: const TextStyle(
          fontSize: 18,
          fontWeight: FontWeight.bold,
        ),
      ),
    );
  }

  Widget _buildProductList() {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 2,
            blurRadius: 4,
          ),
        ],
      ),
      child: ListView.builder(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        itemCount: salesData.length,
        itemBuilder: (context, index) {
          final sale = salesData[index];
          return ListTile(
            leading: CircleAvatar(
              backgroundColor: Colors.blue.withOpacity(0.1),
              child: const Icon(Icons.inventory, color: Colors.blue),
            ),
            title: Text(sale['name']),
            subtitle: Text("Sales: ${sale['item_sold']} units"),
            trailing: Text("\$${sale['total_sales'].toStringAsFixed(2)}"),
          );
        },
      ),
    );
  }

  Widget _buildActivityList() {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 2,
            blurRadius: 4,
          ),
        ],
      ),
      child: ListView.builder(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        itemCount: salesData.length,
        itemBuilder: (context, index) {
          final sale = salesData[index];
          return ListTile(
            leading: CircleAvatar(
              backgroundColor: Colors.green.withOpacity(0.1),
              child: const Icon(Icons.check_circle, color: Colors.green),
            ),
            title: Text(sale['name']),
            subtitle: Text(sale['created_at']),
          );
        },
      ),
    );
  }

  LineChartData _getSalesData() {
    // Convert salesData to FlSpot list
    List<FlSpot> spots = salesData.asMap().entries.map((entry) {
      final index = entry.key.toDouble();
      final sale = entry.value;
      // Ensure total_sales is treated as a double
      final totalSales = (sale['total_sales'] as num).toDouble();
      return FlSpot(index, totalSales);
    }).toList();

    return LineChartData(
      gridData: FlGridData(show: false),
      titlesData: FlTitlesData(show: false),
      borderData: FlBorderData(show: false),
      lineBarsData: [
        LineChartBarData(
          spots: spots,
          isCurved: true,
          color: Colors.blue,
          barWidth: 3,
          dotData: FlDotData(show: false),
          belowBarData: BarAreaData(
            show: true,
            color: Colors.blue.withOpacity(0.1),
          ),
        ),
      ],
    );
  }
}
