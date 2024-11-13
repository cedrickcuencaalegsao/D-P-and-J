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
import usePostData from "../Hooks/usePostData/usePostData";
import usePutData from "../Hooks/usePutData/usePutData";

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
interface ApiError {
  response?: {
    data?: {
      message?: string;
      errors?: Record<string, string[]>;
    };
  };
  message?: string;
}

export default function ProductsPage() {
  const { getData, error, loading } = useGetData(
    "http://127.0.0.1:8000/api/products"
  );
  const {
    error: postError,
    loading: postLoading,
    postData,
  } = usePostData<Product>("http://127.0.0.1:8000/api/product/add");
  const {
    postData: updateData,
    loading: putLoading,
    error: putError,
  } = usePutData();

  const products: Product[] = Array.isArray(getData?.products)
    ? getData.products
    : [];
  const [selectedCategory, setSelectedCategory] = useState("All");
  const [selectedProduct, setSelectedProduct] = useState<Product | null>(null);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [modalType, setModalType] = useState<"Edit" | "Buy" | "Add">("Add");

  // Loading and error handling
  if (loading || postLoading || putLoading) return <Loading />;
  if (error || postError || putError) {
    const apiError = (error || postError || putError) as ApiError;
    const errorMessage =
      apiError?.response?.data?.message ||
      apiError?.message ||
      "An error occurred";
    const validationErrors = apiError?.response?.data?.errors;
    // Flatten validation errors into an array of strings
    const errorMessages = validationErrors
      ? Object.values(validationErrors).flat()
      : [errorMessage];

    return <Error error={errorMessages} />;
  }

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

  const saveNewData = async (product: Product | BuyProduct): Promise<void> => {
    try {
      const formData = new FormData();
      formData.append("name", product.name);
      formData.append("price", String(product.price));
      formData.append("category", product.category || "");
      formData.append("stock", "0");
      formData.append("item_sold", "0");
      formData.append("total_sale", "0");

      // Only append image if it's a file, otherwise use default
      if (product.image && product.image instanceof File) {
        formData.append("image", product.image);
      } else {
        formData.append("image", "default.jpg");
      }

      // Use the postData hook, passing formData
      await postData(formData);

      // Reload page after success
      window.location.reload();
    } catch (error) {
      console.log("Error in saveModalData:", error);
    }
  };

  // Save edited data.
  const saveEditedData = async (product: Product) => {
    try {
      const formData = new FormData();

      // Append product_id if it exists
      if (product.product_id) {
        formData.append("product_id", product.product_id);
      }

      formData.append("name", product.name);
      formData.append("price", String(product.price));
      formData.append("category", product.category || "");

      if (product.image && product.image instanceof File) {
        formData.append("image", product.image);
      }

      // Update product using API endpoint
      const response = await updateData(
        "http://127.0.0.1:8000/api/product/updates",
        formData
      );
      console.log(response);

      // Reload page after success
      window.location.reload();
    } catch (error) {
      console.log("Error in saveEditedData:", error);
    }
  };

  // Save buy data, and update the quantity.
  const saveBuyData = async (product: BuyProduct) => {
    const response = await updateData(
      "http://127.0.0.1:8000/api/product/buy",
      product
    );
    console.log(response);
  };

  // Save modal data, and call the appropriate function based on the type.
  const saveModalData = (product: Product | BuyProduct, type: string) => {
    if (type === "Add") {
      saveNewData(product as Product);
    } else if (type === "Edit") {
      saveEditedData(product as Product);
    } else if (type === "Buy") {
      saveBuyData(product as BuyProduct);
    } else {
      console.log("Invalid type");
    }
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
                image={product.image ? product.image : "default.jpg"}
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
            // saveModalData as (product: Product | BuyProduct) => Promise<void>
            saveModalData
          }
          initialData={selectedProduct as Product | null}
          mode={modalType}
        />
      )}
    </AppLayout>
  );
}
