"use client";
import AppLayout from "../components/Layout/app";
import Card from "../components/Card/Card";
import useGetData from "../Hooks/useGetData/useGetData";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
import SuggestionButtons from "../components/Button/SuggestionButton";
import { useState } from "react";

export default function ProductsPage() {
  const { getData, error, loading } = useGetData(
    "http://127.0.0.1:8000/api/products"
  );
  const products = Array.isArray(getData?.products) ? getData.products : [];
  const [selectedCategory, setSelectedCategory] = useState("All");

  /***
   * Loading screen.
   ***/
  if (loading) return <Loading />;

  /**
   * Error handling.
   **/
  if (error) return <Error error={error} />;

  console.log(products);

  const handleCardClick = (args: string) => {
    console.log(`Card clicked: ${args}`);
  };

  const filteredProducts =
    selectedCategory === "All"
      ? products
      : products.filter((product) => product.category === selectedCategory);

  const handleCategorySelect = (category: string) => {
    setSelectedCategory(category);
  };
  return (
    <AppLayout>
      <div className="container mx-auto p-4">
        {/* Suggestion Buttons */}
        <div className="mb-8">
          <SuggestionButtons
            products={products}
            onCategorySelect={handleCategorySelect}
            selectedCategory={selectedCategory}
          />
        </div>

        {/* Product Cards */}
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          {filteredProducts.length > 0 ? (
            filteredProducts.map((product) => (
              <Card
                key={product.id}
                category={product.category}
                title={product.name}
                price={product.price}
                image={product.image || "default.jpg"}
                buttonText="Buy Now"
                onClick={() => handleCardClick(product.product_id)}
              />
            ))
          ) : (
            <p>No products available</p>
          )}
        </div>
      </div>
    </AppLayout>
  );
}
