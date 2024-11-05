import React, { useEffect, useState } from "react";

interface Product {
  id?: string;
  name: string;
  price: number;
  image?: string;
  category?: string;
  created_at?: string;
  updated_at?: string;
}

interface ModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSave: (product: Product) => void;
  initialData?: Product | null;
  mode: string;
}

export default function Modals({
  isOpen,
  onClose,
  onSave,
  initialData,
  mode,
}: ModalProps) {
  const [name, setName] = useState("");
  const [price, setPrice] = useState<number>(0.0);
  const [category, setCategory] = useState<string>("");

  console.log(`Initial Data: ${initialData}, Mode: ${mode}`);

  useEffect(() => {
    if (initialData) {
      setName(initialData.name);
      setPrice(initialData.price);
    } else {
      setName("");
      setPrice(0.0);
    }
  }, [initialData]);
  const handleSave = () => {
    onSave({ name, price, category });
    onClose();
  };
  if (!isOpen) return null;
  return (
    <div className="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
      <div className="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 className="text-2xl font-bold mb-4">
          {mode === "Add"
            ? "Add Product"
            : mode === "Edit"
            ? "Edit Product"
            : "Buy Product"}
        </h2>
        {(mode === "Edit" || mode === "Buy") && (
          <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700">
              Product Name
            </label>
            <input
              type="text"
              className="w-full border border-gray-300 rounded-md p-2"
              onChange={(e) => setName(e.target.value)}
              value={name}
            />
          </div>
        )}
        {(mode === "Edit" || mode === "Buy") && (
          <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700">
              Price
            </label>
            <input
              type="number"
              className="w-full border border-gray-300 rounded-md p-2"
              onChange={(e) => setPrice(Number(e.target.value))}
              value={price}
            />
          </div>
        )}
        {mode === "Edit" ? (
          <div className="flex justify-end space-x-2">
            <button
              onClick={onClose}
              className="px-4 py-2 bg-gray-200 rounded-md"
            >
              Cancel
            </button>
            <button
              onClick={handleSave}
              className="px-4 py-2 bg-blue-500 text-white rounded-md"
            >
              Save Changes
            </button>
          </div>
        ) : mode === "Buy" ? (
          <div className="flex justify-end space-x-2">
            <button
              onClick={onClose}
              className="px-4 py-2 bg-gray-200 rounded-md"
            >
              Cancel
            </button>
            <button
              onClick={handleSave}
              className="px-4 py-2 bg-blue-500 text-white rounded-md"
            >
              Buy Now
            </button>
          </div>
        ) : (
          <div>
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700">
                Product Name
              </label>
              <input
                type="text"
                className="w-full border border-gray-300 rounded-md p-2"
                onChange={(e) => setName(e.target.value)}
                value={name}
              />
            </div>
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700">
                Product Category
              </label>
              <input
                type="text"
                className="w-full border border-gray-300 rounded-md p-2"
                onChange={(e) => setCategory(e.target.value)}
                value={category}
              />
            </div>
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700">
                Product Price
              </label>
              <input
                type="number"
                step="0.01"
                className="w-full border border-gray-300 rounded-md p-2"
                onChange={(e) => setPrice(Number(e.target.value))}
                value={price}
              />
            </div>
            <div className="flex justify-end space-x-2">
              <button
                onClick={onClose}
                className="px-4 py-2 bg-gray-200 rounded-md"
              >
                Cancel
              </button>
              <button
                onClick={handleSave}
                className="px-4 py-2 bg-blue-500 text-white rounded-md"
              >
                Add
              </button>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
