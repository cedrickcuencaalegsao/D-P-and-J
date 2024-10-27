import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class FloatingBotton extends StatefulWidget {
  const FloatingBotton({super.key});

  @override
  FloatingBottonState createState() => FloatingBottonState();
}

class FloatingBottonState extends State<FloatingBotton> {
  String _selectedValue = 'Option 1';
  final TextEditingController _productNameController = TextEditingController();
  final TextEditingController _productPriceController = TextEditingController();

  void _saveProduct() {
    String productName = _productNameController.text;
    String productPrice = _productPriceController.text;
    String category = _selectedValue;

    print(
        'product name: $productName, category: $category, productprice: $productPrice');
  }

  @override
  Widget build(BuildContext context) {
    return FloatingActionButton(
      onPressed: () {
        // show modal dialog for the option of which one to add.
        showDialog(
            context: context,
            builder: (BuildContext context) {
              return AlertDialog(
                title: const Center(child: Text("Add new product")),
                actions: <Widget>[
                  SizedBox(
                    width: double.infinity,
                    child: Column(
                      children: [
                        TextField(
                          controller: _productNameController,
                          decoration: const InputDecoration(
                            labelText: "Product Name",
                            border: OutlineInputBorder(),
                          ),
                        ),
                        const SizedBox(
                          height: 10.00,
                        ),
                        DropdownButtonFormField(
                          value: _selectedValue,
                          items: <String>['Option 1', 'Option 2', 'Option 3']
                              .map((String value) {
                            return DropdownMenuItem<String>(
                              value: value,
                              child: Text(value),
                            );
                          }).toList(),
                          onChanged: (String? newValue) {
                            setState(() {
                              _selectedValue = newValue!;
                            });
                          },
                          decoration: const InputDecoration(
                              labelText: 'Category',
                              border: OutlineInputBorder()),
                        ),
                        const SizedBox(
                          height: 10.00,
                        ),
                        TextField(
                          controller: _productPriceController,
                          decoration: const InputDecoration(
                            labelText: "Price",
                            border: OutlineInputBorder(),
                          ),
                        ),
                        const SizedBox(
                          height: 20.00,
                        ),
                        Row(
                          children: [
                            TextButton(
                                onPressed: _saveProduct,
                                child: const Text("Save Product")),
                            const Spacer(),
                            TextButton(
                                onPressed: () {
                                  Navigator.of(context).pop();
                                },
                                child: const Text("Cancel"))
                          ],
                        )
                      ],
                    ),
                  )
                ],
              );
            });
      },
      tooltip: 'New Product',
      backgroundColor: CupertinoColors.activeBlue,
      splashColor: CupertinoColors.activeGreen,
      child: const Icon(
        Icons.add,
        color: Colors.white,
        size: 30.00,
      ),
    );
  }
}
