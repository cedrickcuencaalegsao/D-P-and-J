import React from "react";
import { FaPlus } from "react-icons/fa";

interface FloatingActionButtonProps {
  onAdd: () => void;
}

const FloatingActionButton: React.FC<FloatingActionButtonProps> = ({
  onAdd,
}) => {
  return (
    <div className="fixed bottom-5 right-5 flex flex-col space-y-3">
      <button
        className="bg-blue-500 text-white p-3 rounded-full shadow-lg hover:bg-blue-600 transition duration-300"
        onClick={onAdd}
        title="Add"
      >
        <FaPlus className="text-xl" />
      </button>
    </div>
  );
};

export default FloatingActionButton;
