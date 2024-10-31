import React, { useState } from "react";

type Product = {
  id: number;
  name: string;
  category: string;
};

interface SuggestionButtonsProps {
  products: Product[];
  onCategorySelect: (category: string) => void;
}

const SuggestionButtons: React.FC<SuggestionButtonsProps> = ({
  products,
  onCategorySelect,
}) => {
  const uniqueCategories = Array.from(
    new Set(products.map((product) => product.category))
  );
  const categories = ["All", ...uniqueCategories];

  const [selectedCategory, setSelectedCategory] = useState<string>("All");

  const handleCategoryClick = (category: string) => {
    setSelectedCategory(category);
    onCategorySelect(category); 
  };

  return (
    <div className="flex flex-wrap gap-2 mb-4">
      {categories.map((category) => (
        <button
          key={category}
          className={`px-4 py-2 rounded ${
            selectedCategory === category
              ? "bg-blue-500 text-white"
              : "bg-gray-200 text-black"
          } hover:bg-blue-400 transition`}
          onClick={() => handleCategoryClick(category)}
        >
          {category}
        </button>
      ))}
    </div>
  );
};

export default SuggestionButtons;
