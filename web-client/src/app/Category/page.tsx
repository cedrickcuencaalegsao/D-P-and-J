"use client";
import AppLayout from "../components/Layout/app";
import { useState } from "react";
import SuggestionButtons from "../components/Button/SuggestionButton";
import useGetData from "../Hooks/useGetData/useGetData";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
import { FaBoxOpen, FaEdit } from "react-icons/fa";
import EditCategory from "../components/Modals/EditCategory";
import usePutData from "../Hooks/usePutData/usePutData";

interface Category {
  id: number;
  product_id: string;
  name: string;
  price: number;
  category: string;
  stock: number;
  created_at: string;
  updated_at: string;
}
interface ApiError {
  respose?: {
    data?: {
      message?: string;
      errors?: Record<string, string[]>;
    };
  };
  message?: string;
}

export default function CategoryPage() {
  const { getData, error, loading } = useGetData(
    "http://127.0.0.1:8000/api/categories"
  );
  const {
    postData: updateData,
    loading: putLoading,
    error: putError,
  } = usePutData();
  console.log(putError);

  const [selectedCategory, setSelectedCategory] = useState<string>("All");
  const [isModalOpen, setIsModalOpen] = useState(false);
  const categories: Category[] = Array.isArray(getData?.categories)
    ? getData.categories
    : [];
  const [selectedCategoryData, setSelectedCategoryData] =
    useState<Category | null>(null);

  // Filter products by selected category
  const filteredCategories =
    selectedCategory === "All"
      ? categories
      : categories.filter(
          (categories) => categories.category === selectedCategory
        );

  const handleCategorySelect = (category: string) => {
    setSelectedCategory(category);
  };

  if (loading || putLoading) return <Loading />;

  if (error || putError) {
    const apiError = error as ApiError;
    const errorMessage =
      apiError?.respose?.data?.message ||
      apiError?.message ||
      "An error occurred";
    const validationErrors = apiError?.respose?.data?.errors;
    const errorMessages = validationErrors
      ? Object.values(validationErrors).flat()
      : [errorMessage];
    return <Error error={errorMessages} />;
  }

  const handleEditCategory = (category: Category) => {
    setSelectedCategoryData(category);
    setIsModalOpen(true);
  };

  const handleSaveCategory = async (data: Category) => {
    const response = await updateData(
      `http://127.0.0.1:8000/api/category/edit/`,
      data
    );
    if (response) {
      window.location.reload();
    }
  };

  return (
    <AppLayout>
      <div className="container mx-auto p-4">
        {/* Category Buttons */}
        <div className="mb-6">
          <SuggestionButtons
            products={categories}
            onCategorySelect={handleCategorySelect}
            selectedCategory={selectedCategory}
          />
        </div>

        {/* Product List */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          {filteredCategories.length > 0 ? (
            filteredCategories.map((items) => (
              <div
                key={items.id}
                className="bg-white p-4 rounded shadow-md relative"
              >
                <button
                  className="tooltip tooltip-bottom absolute top-2 right-2 p-2 text-gray-600 hover:text-blue-600 transition-colors"
                  onClick={() => handleEditCategory(items)}
                  data-tip="Edit Category"
                >
                  <FaEdit className="text-xl" />
                </button>
                <h3 className="text-xl font-semibold">{items.name}</h3>
                <p className="text-gray-600">Category: {items.category}</p>
                <div
                  className={`
            flex items-center gap-2 p-2 rounded
            ${
              !items.stock || items.stock === 0
                ? "bg-red-100 text-red-600"
                : items.stock < 50
                ? "bg-yellow-100 text-yellow-600"
                : "bg-green-100 text-green-600"
            }`}
                >
                  <FaBoxOpen className="text-2xl" />
                  <span className="text-lg font-bold">
                    Stocks:{" "}
                    {!items.stock || items.stock === 0
                      ? "No Stock"
                      : items.stock}
                  </span>
                </div>
              </div>
            ))
          ) : (
            <p className="text-center text-gray-500">
              No products available in this category.
            </p>
          )}
        </div>
      </div>
      {isModalOpen && (
        <EditCategory
          data={selectedCategoryData}
          onClose={() => setIsModalOpen(false)}
          onSave={(data: Category) => handleSaveCategory(data)}
        />
      )}
    </AppLayout>
  );
}
