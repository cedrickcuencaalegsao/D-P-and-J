import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import '../components/dashboar_card.dart';
import '../components/dashboar_big_cards.dart';

class DashBoardPage extends StatefulWidget {
  const DashBoardPage({super.key});

  @override
  DashBoardPageState createState() => DashBoardPageState();
}

class DashBoardPageState extends State<DashBoardPage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
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
        title: Container(
          decoration: BoxDecoration(
            color: CupertinoColors.systemGrey6,
            borderRadius: BorderRadius.circular(25),
          ),
          padding: const EdgeInsets.symmetric(horizontal: 16),
          child: Row(
            children: [
              Expanded(
                child: TextField(
                  decoration: InputDecoration(
                    hintText: 'Search...',
                    hintStyle: TextStyle(color: Colors.grey.shade600),
                    border: InputBorder.none,
                    icon: const Icon(
                      Icons.search,
                      color: CupertinoColors.systemGrey,
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
        automaticallyImplyLeading: false,
        backgroundColor: CupertinoColors.white,
        elevation: 1,
      ),
      body: Column(
        children: [
          const SizedBox(
            height: 200,
            child: DynamicCardList(cardData: {
              'card1': {
                'title': 'Sales',
                'content': '120.00',
                'link': '/sales',
                'color': Colors.red,
                'fontColor': Colors.white,
                'cardIcon': Icons.attach_money,
                'iconColor': Colors.white,
                'bottomText': "Daily Avarage",
                'bottomValue': "1235",
              },
              'card2': {
                'title': 'Products',
                'content': '50',
                'link': '/products',
                'color': Colors.green,
                'fontColor': Colors.white,
                'cardIcon': Icons.shopping_bag,
                'iconColor': Colors.white,
                'bottomText': "Daily Avarage",
                'bottomValue': "857",
              },
              'card3': {
                'title': 'Stocks',
                'content': '50',
                'link': '/stocks',
                'color': Colors.blue,
                'fontColor': Colors.white,
                'cardIcon': Icons.inventory,
                'iconColor': Colors.white,
                'bottomText': "Daily Avarage",
                'bottomValue': "1522",
              },
            }),
          ),
          Expanded(
            child: ListView(
              children: const [
                DashBoardBigCard(
                  title: "Sales",
                  cardIcon: Icons.shop,
                  cardColor: Colors.white,
                  titleColor: Colors.black,
                  greenIcon: Icons.attach_money,
                  greenIndicator: "Annual revenue",
                  greenValue: "75.00",
                  redIcon: Icons.attach_money,
                  redIndicator: "Annual Expences",
                  redValue: "12.00",
                ),
                DashBoardBigCard(
                  title: "Products",
                  cardIcon: Icons.shop,
                  cardColor: Colors.white,
                  titleColor: Colors.black,
                  greenIcon: Icons.shopping_bag,
                  greenIndicator: "Sold",
                  greenValue: "1500",
                  redIcon: Icons.shopping_bag,
                  redIndicator: "Refunded",
                  redValue: "120",
                ),
                DashBoardBigCard(
                  title: "Stocks",
                  cardIcon: Icons.shop,
                  cardColor: Colors.white,
                  titleColor: Colors.black,
                  greenIcon: Icons.inventory,
                  greenIndicator: "Total revenue",
                  greenValue: "75.00",
                  redIcon: Icons.inventory,
                  redIndicator: "Total Expences",
                  redValue: "12.00",
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class DynamicCardList extends StatelessWidget {
  final Map<String, Map<String, dynamic>> cardData;

  const DynamicCardList({
    super.key,
    required this.cardData,
  });

  @override
  Widget build(BuildContext context) {
    return PageView(
      children: cardData.entries.map((entry) {
        return GestureDetector(
          onTap: () {
            Navigator.pushNamed(context, entry.value['link']);
          },
          child: DashBoadCardWiggets(
            title: entry.value['title'],
            content: entry.value['content'],
            link: entry.value['link'],
            cardColor: entry.value['color'],
            fontColor: entry.value['fontColor'],
            cardIcon: entry.value['cardIcon'],
            iconColor: entry.value['iconColor'],
            bottomText: entry.value['bottomText'],
            bottomValue: entry.value['bottomValue'],
          ),
        );
      }).toList(),
    );
  }
}
