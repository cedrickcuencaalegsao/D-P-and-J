"use client";
import AppLayout from "../components/Layout/app";
import Card from "../components/Card/Card";
import useGetData from "../Hooks/useGetData/useGetData";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
import SuggestionButtons from "../components/Button/SuggestionButton";
import { useState } from "react";
import FloatingActionButton from "../components/FloatingButton/FloatingButton";
import Modals from "../components/Modals/Modals";

interface Product {
  id?: string;
  product_id?: string;
  name: string;
  price: number;
  image?: File | null;
  category?: string;
  created_at?: string;
  updated_at?: string;
}

interface BuyProduct extends Product {
  quantity: number;
}

export default function ProductsPage() {
  const { getData, error, loading } = useGetData(
    "http://127.0.0.1:8000/api/products"
  );
  const products: Product[] = Array.isArray(getData?.products)
    ? getData.products
    : [];
  const [selectedCategory, setSelectedCategory] = useState("All");
  const [selectedProduct, setSelectedProduct] = useState<Product | null>(null);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [modalType, setModalType] = useState<"Edit" | "Buy" | "Add">("Add");

  // Loading and error handling
  if (loading) return <Loading />;
  if (error) return <Error error={error} />;

  // Handle card click for Buy/Edit actions
  const handleCardClick = (product: Product, type: "Edit" | "Buy") => {
    setSelectedProduct(product);
    setIsModalOpen(true);
    setModalType(type);
  };

  // Handle modal close
  const closeModal = () => {
    setIsModalOpen(false);
    setSelectedProduct(null);
    setModalType("Add");
  };

  // Handle category selection
  const handleCategorySelect = (category: string) => {
    setSelectedCategory(category);
  };

  // Save data of the modal.
  const saveModalData = async (
    product: Product | BuyProduct
  ): Promise<void> => {
    console.log(product);
  };

  // Filter products by selected category
  const filteredProducts =
    selectedCategory === "All"
      ? products
      : products.filter((product) => product.category === selectedCategory);

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
                key={product.product_id}
                title={product.name}
                price={product.price}
                image={product.image || "default.jpg"}
                buyText="Buy Now"
                editText="Edit"
                category={product.category || "No category"}
                onBuy={() => handleCardClick(product, "Buy")}
                onEdit={() => handleCardClick(product, "Edit")}
              />
            ))
          ) : (
            <p>No products available</p>
          )}
        </div>
      </div>

      {/* Floating Action Button for Adding New Product */}
      <FloatingActionButton
        onAdd={() => {
          setIsModalOpen(true);
          setModalType("Add");
          setSelectedProduct(null);
        }}
      />

      {/* Modal Component */}
      {isModalOpen && (
        <Modals
          isOpen={isModalOpen}
          onClose={closeModal}
          onSave={
            saveModalData as (product: Product | BuyProduct) => Promise<void>
          }
          initialData={selectedProduct as Product | null}
          mode={modalType}
        />
      )}
    </AppLayout>
  );
}
