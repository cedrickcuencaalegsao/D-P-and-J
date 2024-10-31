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
  { id: 7, name: "Action Figure", category: "Toys" },
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
