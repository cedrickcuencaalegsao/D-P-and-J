"use client";
import AppLayout from "../components/Layout/app";
import { useState } from "react";
import CategoryButtons from "../components/Button/SuggestionButton";

const products = [
  { id: 1, name: "Laptop", category: "Electronics" },
  { id: 2, name: "Desk Chair", category: "Furniture" },
  { id: 3, name: "Smartphone", category: "Electronics" },
  { id: 4, name: "T-shirt", category: "Clothing" },
  { id: 5, name: "Bookshelf", category: "Furniture" },
  { id: 6, name: "Jeans", category: "Clothing" },
  { id: 7, name: "Paint Brush", category: "Art Supplies" },
  { id: 8, name: "Action Figure", category: "Toys" },
  { id: 9, name: "Ink Cartridge", category: "Office Supplies" },
  { id: 10, name: "Desk Lamp", category: "Furniture" },
  { id: 11, name: "Wireless Mouse", category: "Electronics" },
  { id: 12, name: "Notebook", category: "Stationery" },
  { id: 13, name: "Canvas", category: "Art Supplies" },
  { id: 14, name: "Gaming Console", category: "Electronics" },
  { id: 15, name: "Sofa", category: "Furniture" },
  { id: 16, name: "Water Bottle", category: "Accessories" },
  { id: 17, name: "Yoga Mat", category: "Fitness" },
  { id: 18, name: "Bluetooth Speaker", category: "Electronics" },
  { id: 19, name: "Running Shoes", category: "Clothing" },
  { id: 20, name: "Board Game", category: "Toys" },
  // Additional 10 products
  { id: 21, name: "Smartwatch", category: "Electronics" },
  { id: 22, name: "Pillow", category: "Bedding" },
  { id: 23, name: "Tea Kettle", category: "Kitchen" },
  { id: 24, name: "Easel", category: "Art Supplies" },
  { id: 25, name: "Mini Fridge", category: "Appliances" },
  { id: 26, name: "Tent", category: "Camping" },
  { id: 27, name: "Bicycle", category: "Sports" },
  { id: 28, name: "Laptop Stand", category: "Office Supplies" },
  { id: 29, name: "Travel Backpack", category: "Accessories" },
  { id: 30, name: "Portable Heater", category: "Appliances" },
];

export default function CategoryPage() {
  const [selectedCategory, setSelectedCategory] = useState<string>("All");

  // Filter products by selected category
  const filteredProducts =
    selectedCategory === "All"
      ? products
      : products.filter((product) => product.category === selectedCategory);

  return (
    <AppLayout>
      <div className="container mx-auto p-4">
        {/* Category Buttons */}
        <div className="mb-6">
          <CategoryButtons
            products={products}
            onCategorySelect={(category) => setSelectedCategory(category)}
            selectedCategory={selectedCategory}
          />
        </div>

        {/* Product List */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          {filteredProducts.length > 0 ? (
            filteredProducts.map((product) => (
              <div key={product.id} className="bg-white p-4 rounded shadow-md">
                <h3 className="text-xl font-semibold">{product.name}</h3>
                <p className="text-gray-600">Category: {product.category}</p>
              </div>
            ))
          ) : (
            <p className="text-center text-gray-500">
              No products available in this category.
            </p>
          )}
        </div>
      </div>
    </AppLayout>
  );
}
