import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart';
import '../Service/api_service.dart';
import 'dart:math' show max;

class DashBoardPage extends StatefulWidget {
  const DashBoardPage({super.key});

  @override
  DashBoardPageState createState() => DashBoardPageState();
}

class DashBoardPageState extends State<DashBoardPage> {
  Map<String, dynamic>? dashboardData;
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    fetchDashboardData();
  }

  Future<void> fetchDashboardData() async {
    try {
      final data = await ApiService.getAllData();
      setState(() {
        dashboardData = data;
        isLoading = false;
      }); // For debugging
    } catch (e) {
      setState(() {
        isLoading = false;
      });
    }
  }

  // Helper function to calculate the maximum Y value
  double calculateMaxY(List<FlSpot> spots) {
    if (spots.isEmpty) return 100;
    double maxY = spots.map((spot) => spot.y).reduce(max);
    return maxY + (maxY * 0.1); // Add 10% padding
  }

  // Helper function to calculate appropriate interval for Y axis
  double calculateInterval(List<FlSpot> spots) {
    if (spots.isEmpty) return 20;
    double maxY = spots.map((spot) => spot.y).reduce(max);
    return maxY / 5; // Divide the range into 5 parts
  }

  @override
  Widget build(BuildContext context) {
    if (isLoading) {
      return const Scaffold(
        body: Center(child: CircularProgressIndicator()),
      );
    }

    return Scaffold(
      body: RefreshIndicator(
        onRefresh: fetchDashboardData,
        child: SingleChildScrollView(
          child: Column(
            children: [
              _buildQuickStats(),
              const SizedBox(height: 16),
              _buildRevenueChart(),
              const SizedBox(height: 16),
              _buildDetailedStats(),
              const SizedBox(height: 16),
              _buildRecentActivities(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildQuickStats() {
    final countData = dashboardData?['countData'] ?? {};

    return SizedBox(
      height: 180,
      child: ListView(
        scrollDirection: Axis.horizontal,
        children: [
          _buildStatCard(
            "Total Users",
            "${countData['users'] ?? 0}",
            "+${countData['users'] ?? 0}%",
            Icons.people,
            Colors.blue,
          ),
          _buildStatCard(
            "Products",
            "${countData['products'] ?? 0}",
            "+${countData['products'] ?? 0}%",
            Icons.shopping_cart,
            Colors.green,
          ),
          _buildStatCard(
            "Categories",
            "${countData['categories'] ?? 0}",
            "+${countData['categories'] ?? 0}%",
            Icons.category,
            Colors.orange,
          ),
          _buildStatCard(
            "Sales",
            "${countData['sales'] ?? 0}",
            "+${countData['sales'] ?? 0}%",
            Icons.attach_money,
            Colors.red,
          ),
          _buildStatCard(
            "Stocks",
            "${countData['stocks'] ?? 0}",
            "+${countData['stocks'] ?? 0}%",
            Icons.inventory,
            Colors.purple,
          ),
        ],
      ),
    );
  }

  Widget _buildStatCard(
      String title, String value, String change, IconData icon, Color color) {
    return Container(
      width: 200,
      margin: const EdgeInsets.only(right: 16),
      padding: const EdgeInsets.all(16),
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
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Icon(icon, color: color, size: 30),
          const SizedBox(height: 16),
          Text(
            title,
            style: TextStyle(
              color: Colors.grey[600],
              fontSize: 14,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            value,
            style: const TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
            ),
          ),
          Row(
            children: [
              Icon(
                Icons.arrow_upward,
                color: Colors.green[400],
                size: 16,
              ),
              Text(
                change,
                style: TextStyle(
                  color: Colors.green[400],
                  fontWeight: FontWeight.bold,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildRevenueChart() {
    final salesData =
        (dashboardData?['data']?['sales'] as List<dynamic>?) ?? [];

    // Process sales data for the chart
    final spots = salesData.asMap().entries.map((entry) {
      final sale = entry.value as Map<String, dynamic>;
      return FlSpot(
        entry.key.toDouble(),
        (sale['total_sales'] as num).toDouble(),
      );
    }).toList();

    return Container(
      margin: const EdgeInsets.all(16),
      padding: const EdgeInsets.all(16),
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
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            "Revenue Overview",
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 24),
          SingleChildScrollView(
            scrollDirection: Axis.horizontal,
            child: SizedBox(
              width: max(
                  MediaQuery.of(context).size.width * 2, spots.length * 50.0),
              height: 200,
              child: LineChart(
                LineChartData(
                  gridData: FlGridData(
                    show: true,
                    drawVerticalLine: true,
                    horizontalInterval: 1,
                    verticalInterval: 1,
                    getDrawingHorizontalLine: (value) {
                      return FlLine(
                        color: Colors.grey.withOpacity(0.3),
                        strokeWidth: 1,
                      );
                    },
                    getDrawingVerticalLine: (value) {
                      return FlLine(
                        color: Colors.grey.withOpacity(0.3),
                        strokeWidth: 1,
                      );
                    },
                  ),
                  titlesData: FlTitlesData(
                    show: true,
                    rightTitles: AxisTitles(
                      sideTitles: SideTitles(showTitles: false),
                    ),
                    topTitles: AxisTitles(
                      sideTitles: SideTitles(showTitles: false),
                    ),
                    bottomTitles: AxisTitles(
                      sideTitles: SideTitles(
                        showTitles: true,
                        reservedSize: 30,
                        interval: 1,
                        getTitlesWidget: (value, meta) {
                          if (value.toInt() >= 0 &&
                              value.toInt() < salesData.length) {
                            final sale = salesData[value.toInt()];
                            return Text(
                              sale['created_at']?.toString().substring(5, 10) ??
                                  '',
                              style: const TextStyle(fontSize: 10),
                            );
                          }
                          return const Text('');
                        },
                      ),
                    ),
                    leftTitles: AxisTitles(
                      sideTitles: SideTitles(
                        showTitles: true,
                        interval: calculateInterval(spots),
                        reservedSize: 42,
                        getTitlesWidget: (value, meta) {
                          return Text(
                            '\$${value.toInt()}',
                            style: const TextStyle(fontSize: 10),
                          );
                        },
                      ),
                    ),
                  ),
                  borderData: FlBorderData(
                    show: true,
                    border: Border.all(color: Colors.grey.withOpacity(0.3)),
                  ),
                  minX: 0,
                  maxX: (spots.length - 1).toDouble(),
                  minY: 0,
                  maxY: calculateMaxY(spots),
                  lineBarsData: [
                    LineChartBarData(
                      spots: spots.isEmpty ? [const FlSpot(0, 0)] : spots,
                      isCurved: true,
                      color: CupertinoColors.activeBlue,
                      barWidth: 3,
                      dotData: FlDotData(
                        show: true,
                        getDotPainter: (spot, percent, barData, index) {
                          return FlDotCirclePainter(
                            radius: 4,
                            color: CupertinoColors.activeBlue,
                            strokeWidth: 2,
                            strokeColor: Colors.white,
                          );
                        },
                      ),
                      belowBarData: BarAreaData(
                        show: true,
                        color: CupertinoColors.activeBlue.withOpacity(0.1),
                      ),
                    ),
                  ],
                  lineTouchData: LineTouchData(
                    touchTooltipData: LineTouchTooltipData(
                      tooltipBgColor: Colors.blueAccent,
                      getTooltipItems: (List<LineBarSpot> touchedBarSpots) {
                        return touchedBarSpots.map((barSpot) {
                          final index = barSpot.x.toInt();
                          if (index >= 0 && index < salesData.length) {
                            final sale = salesData[index];
                            return LineTooltipItem(
                              '\$${barSpot.y.toStringAsFixed(2)}\n${sale['created_at']}',
                              const TextStyle(color: Colors.white),
                            );
                          }
                          return null;
                        }).toList();
                      },
                    ),
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildDetailedStats() {
    final salesData =
        (dashboardData?['data']?['sales'] as List<dynamic>?) ?? [];

    // Calculate total revenue
    double totalRevenue = 0;
    for (var sale in salesData) {
      totalRevenue += (sale['total_sales'] as num).toDouble();
    }

    return Container(
      margin: const EdgeInsets.all(16),
      child: Column(
        children: [
          _buildDetailedStatRow(
            "Total Revenue",
            "\$${totalRevenue.toStringAsFixed(2)}",
            "Monthly Target: \$${(totalRevenue * 1.2).toStringAsFixed(2)}",
            totalRevenue / (totalRevenue * 1.2),
            Colors.blue,
          ),
          _buildDetailedStatRow(
            "Total Orders",
            "${salesData.length}",
            "Monthly Target: ${(salesData.length * 1.2).round()}",
            salesData.length / (salesData.length * 1.2),
            Colors.green,
          ),
          _buildDetailedStatRow(
            "Average Order Value",
            "\$${salesData.isEmpty ? 0 : (totalRevenue / salesData.length).toStringAsFixed(2)}",
            "Target: \$${(totalRevenue / (salesData.isEmpty ? 1 : salesData.length) * 1.2).toStringAsFixed(2)}",
            0.84,
            Colors.orange,
          ),
        ],
      ),
    );
  }

  Widget _buildDetailedStatRow(
    String title,
    String value,
    String target,
    double progress,
    Color color,
  ) {
    return Container(
      margin: const EdgeInsets.only(bottom: 16),
      padding: const EdgeInsets.all(16),
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
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                title,
                style: const TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                ),
              ),
              Text(
                value,
                style: const TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ],
          ),
          const SizedBox(height: 8),
          Text(
            target,
            style: TextStyle(
              color: Colors.grey[600],
              fontSize: 14,
            ),
          ),
          const SizedBox(height: 8),
          LinearProgressIndicator(
            value: progress.clamp(0.0, 1.0),
            backgroundColor: color.withOpacity(0.1),
            valueColor: AlwaysStoppedAnimation<Color>(color),
          ),
        ],
      ),
    );
  }

  Widget _buildRecentActivities() {
    final salesData =
        (dashboardData?['data']?['sales'] as List<dynamic>?) ?? [];
    final recentSales = salesData.take(4).toList();

    return Container(
      margin: const EdgeInsets.all(16),
      padding: const EdgeInsets.all(16),
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
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            "Recent Activities",
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 16),
          ...recentSales.map((sale) => _buildActivityItem(
                "Sale #${sale['id']}",
                "\$${sale['total_sales']}",
                Icons.shopping_cart,
                Colors.blue,
              )),
        ],
      ),
    );
  }

  Widget _buildActivityItem(
      String title, String time, IconData icon, Color color) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              color: color.withOpacity(0.1),
              borderRadius: BorderRadius.circular(8),
            ),
            child: Icon(icon, color: color),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    fontWeight: FontWeight.bold,
                  ),
                ),
                Text(
                  time,
                  style: TextStyle(
                    color: Colors.grey[600],
                    fontSize: 12,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
