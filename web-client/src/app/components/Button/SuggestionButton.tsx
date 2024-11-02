import React from "react";

interface SuggestionButtonsProps {
  products: Array<{ category: string }>;
  onCategorySelect: (category: string) => void;
  selectedCategory: string; // New prop to track the selected category
}

const SuggestionButtons: React.FC<SuggestionButtonsProps> = ({ products, onCategorySelect, selectedCategory }) => {
  // Extract unique categories from products
  const categories = Array.from(new Set(products.map(product => product.category)));

  return (
    <div className="flex space-x-2 mb-4">
      {/* Add All button */}
      <button
        className={`btn border-2 ${selectedCategory === "All" ? 'bg-blue-600 text-white' : 'bg-white text-blue-600'} border-blue-600`}
        onClick={() => onCategorySelect("All")}
      >
        All
      </button>

      {categories.map((category, index) => (
        <button
          key={index}
          className={`btn border-2 ${selectedCategory === category ? 'bg-blue-600 text-white' : 'bg-white text-blue-600'} border-blue-600`}
          onClick={() => onCategorySelect(category)}
        >
          {category}
        </button>
      ))}
    </div>
  );
};

export default SuggestionButtons;
