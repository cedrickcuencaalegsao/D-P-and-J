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
}

export default function StockModal({ stock, onClose }: StockModalProps) {
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
          {/* Add form fields here */}
        </div>
        <div className="mt-6 flex justify-end">
          <button
            onClick={onClose}
            className="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400"
          >
            Cancel
          </button>
          <button className="bg-indigo-500 text-white py-2 px-4 rounded-md ml-2 hover:bg-indigo-600">
            Save
          </button>
        </div>
      </div>
    </div>
  );
}
