import React from "react";

interface SuggestionButtonsProps {
  products: Array<{ category?: string }>;
  onCategorySelect: (category: string) => void;
  selectedCategory: string;
}

const SuggestionButtons: React.FC<SuggestionButtonsProps> = ({
  products,
  onCategorySelect,
  selectedCategory,
}) => {
  const categories = Array.from(
    new Set(products.map((product) => product.category || "Uncategorized"))
  );

  return (
    <div className="overflow-x-auto sm:overflow-x-visible mb-4 p-2 bg-gray-100 rounded-md">
      <div className="flex flex-nowrap sm:flex-wrap gap-2">
        {/* 'All' button */}
        <button
          className={`btn border-2 ${
            selectedCategory === "All" ? "bg-blue-600 text-white" : "bg-white text-blue-600"
          } border-blue-600`}
          onClick={() => onCategorySelect("All")}
        >
          All
        </button>

        {/* Category buttons */}
        {categories.map((category, index) => (
          <button
            key={index}
            className={`btn border-2 ${
              selectedCategory === category ? "bg-blue-600 text-white" : "bg-white text-blue-600"
            } border-blue-600`}
            onClick={() => onCategorySelect(category)}
          >
            {category}
          </button>
        ))}
      </div>
    </div>
  );
};

export default SuggestionButtons;
