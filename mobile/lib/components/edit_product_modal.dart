import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import '../Service/api_service.dart';

class EditProductModal extends StatefulWidget {
  final String productId;
  final String title;
  final String category;
  final double retailed_price;
  final double retrieve_price;
  final String? imageUrl;

  const EditProductModal({
    super.key,
    required this.productId,
    required this.title,
    required this.category,
    required this.retailed_price,
    required this.retrieve_price,
    required this.imageUrl,
  });

  static void show(
    BuildContext context, {
    required String productId,
    required String title,
    required String category,
    required double retailed_price,
    required double retrieve_price,
    required String imageUrl,
  }) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => Padding(
        padding: EdgeInsets.only(
          bottom: MediaQuery.of(context).viewInsets.bottom,
        ),
        child: EditProductModal(
          productId: productId,
          title: title,
          category: category,
          retailed_price: retailed_price,
          retrieve_price: retrieve_price,
          imageUrl: null,
        ),
      ),
    );
  }

  @override
  State<EditProductModal> createState() => _EditProductModalState();
}

class _EditProductModalState extends State<EditProductModal> {
  late TextEditingController nameController;
  late TextEditingController categoryController;
  late TextEditingController retrieve_priceController;
  bool isLoading = false;
  String? errorMessage;

  @override
  void initState() {
    super.initState();
    nameController = TextEditingController(text: widget.title);
    categoryController = TextEditingController(text: widget.category);
    retrieve_priceController =
        TextEditingController(text: widget.retrieve_price.toString());
  }

  @override
  void dispose() {
    nameController.dispose();
    categoryController.dispose();
    retrieve_priceController.dispose();
    super.dispose();
  }

  Future<void> updateProduct() async {
    setState(() {
      isLoading = true;
      errorMessage = null;
    });

    try {
      Map<String, dynamic> response = await ApiService.updateProduct(
        // Add this type
        widget.productId,
        nameController.text,
        categoryController.text,
        double.parse(retrieve_priceController.text),
        widget.imageUrl,
      );

      if (mounted) {
        Navigator.pop(context);
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Product updated successfully')),
        );
      }
    } catch (e) {
      print('Update Product Error: $e');
      setState(() {
        errorMessage = e.toString();
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      height: MediaQuery.of(context).size.height * 0.85,
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.only(
          topLeft: Radius.circular(20),
          topRight: Radius.circular(20),
        ),
      ),
      child: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Header
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text(
                    'Edit Product',
                    style: TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                      color: CupertinoColors.activeBlue,
                    ),
                  ),
                  IconButton(
                    onPressed: () => Navigator.pop(context),
                    icon: const Icon(Icons.close),
                  ),
                ],
              ),
              const SizedBox(height: 20),

              // Image Section
              Center(
                child: Container(
                  width: double.infinity,
                  height: 200,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(12),
                    border: Border.all(color: Colors.grey[300]!),
                  ),
                  child: Stack(
                    children: [
                      ClipRRect(
                        borderRadius: BorderRadius.circular(12),
                        child: widget.imageUrl?.startsWith('http') ?? false
                            ? Image.network(
                                widget.imageUrl!,
                                width: double.infinity,
                                height: 200,
                                fit: BoxFit.cover,
                                errorBuilder: (context, error, stackTrace) {
                                  return Image.asset(
                                    'Assets/Icons/default.png',
                                    width: double.infinity,
                                    height: 200,
                                    fit: BoxFit.cover,
                                  );
                                },
                              )
                            : Image.asset(
                                widget.imageUrl ?? 'Assets/Icons/default.png',
                                width: double.infinity,
                                height: 200,
                                fit: BoxFit.cover,
                              ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 20),

              // Form Fields
              TextField(
                controller: nameController,
                decoration: const InputDecoration(
                  labelText: 'Product Name',
                  border: OutlineInputBorder(),
                  focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: CupertinoColors.activeBlue),
                  ),
                ),
              ),
              const SizedBox(height: 16),

              TextField(
                controller: categoryController,
                decoration: const InputDecoration(
                  labelText: 'Category',
                  border: OutlineInputBorder(),
                  focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: CupertinoColors.activeBlue),
                  ),
                ),
              ),
              const SizedBox(height: 16),

              TextField(
                controller: retrieve_priceController,
                keyboardType: TextInputType.number,
                decoration: const InputDecoration(
                  labelText: 'Retrieve Price',
                  border: OutlineInputBorder(),
                  focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: CupertinoColors.activeBlue),
                  ),
                ),
              ),
              const SizedBox(height: 24),

              // Error Message
              if (errorMessage != null)
                Padding(
                  padding: const EdgeInsets.only(bottom: 8.0),
                  child: Text(
                    errorMessage!,
                    style: const TextStyle(color: Colors.red),
                  ),
                ),

              // Save Button
              SizedBox(
                width: double.infinity,
                height: 50,
                child: ElevatedButton(
                  onPressed: isLoading ? null : updateProduct,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: CupertinoColors.activeBlue,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                  ),
                  child: isLoading
                      ? const SizedBox(
                          width: 24,
                          height: 24,
                          child: CircularProgressIndicator(
                            color: Colors.white,
                            strokeWidth: 2,
                          ),
                        )
                      : const Text(
                          'Save Changes',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
