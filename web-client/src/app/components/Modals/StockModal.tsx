import React, { useEffect, useState } from "react";

interface Stock {
  id: number;
  product_id: string;
  Stocks: number;
  name: string;
  category: string;
  created_at: string;
  updated_at: string;
}
interface StockModalProps {
  stock: Stock | null;
  onClose: () => void;
  onSave: (stock: Stock | null) => void;
}

export default function StockModal({
  stock,
  onClose,
  onSave,
}: StockModalProps) {
  const [updateStock, setUpdateStock] = useState<Stock | null>(stock);
  useEffect(() => {
    setUpdateStock(stock);
  }, [stock]);
  const handleInputChage = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    if (updateStock) {
      setUpdateStock({
        ...updateStock,
        [name]: name === "Stocks" ? Number(value) : value,
      });
    }
  };
  const handleSave = () => {
    if (updateStock) {
      onSave(updateStock);
    }
  };
  return (
    <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div className="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
        <div className="flex justify-between items-center border-b pb-4">
          <h2 className="text-lg font-semibold text-gray-700">
            Update Stock: {stock?.name}
          </h2>
          <button
            onClick={onClose}
            className="text-gray-500 hover:text-gray-700"
          >
            X
          </button>
        </div>
        <div className="mt-4">
          <p>Modify stock details here for: {stock?.name}</p>

          <div className="mb-4">
            <label className="block text-gray-700">Stocks</label>
            <input
              type="number"
              name="Stocks"
              value={updateStock?.Stocks || ""}
              onChange={handleInputChage}
              className="input input-bordered w-full bg-transparent text-black border border-gray-300"
              placeholder="Enter stock quantity"
            />
          </div>
          <div className="mb-4">
            <label className="block text-gray-700">Name</label>
            <input
              type="text"
              value={updateStock?.name || ""}
              className="input input-bordered w-full bg-transparent text-black border border-gray-300"
              placeholder="Enter product name"
            />
          </div>
          <div className="mb-4">
            <label className="block text-gray-700">Category</label>
            <input
              type="text"
              value={updateStock?.category || ""}
              className="input input-bordered w-full bg-transparent text-black border border-gray-300"
              placeholder="Enter product category"
            />
          </div>
          <div className="mt-6 flex justify-end">
            <button
              onClick={onClose}
              className="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400"
            >
              Cancel
            </button>
            <button
              onClick={handleSave}
              className="bg-indigo-500 text-white py-2 px-4 rounded-md ml-2 hover:bg-indigo-600"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
