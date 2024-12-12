import React, { useEffect, useState } from "react";

interface Product {
  id?: string;
  product_id?: string;
  name: string;
  retrieve_price: number;
  retailed_price: number;
  image?: File | null;
  category?: string;
  created_at?: string;
  updated_at?: string;
}

interface BuyProduct extends Product {
  quantity: number;
}

interface ModalProps {
  isOpen: boolean;
  onClose: () => void;
  // onSave: (product: Product | BuyProduct) => Promise<void> | void;
  onSave: (product: Product | BuyProduct, type: string) => Promise<void> | void;
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
  const [formData, setFormData] = useState<Product>({
    name: "",
    retrieve_price: 0.0,
    retailed_price: 0.0,
    category: "",
    image: undefined,
  });
  const [quantity, setQuantity] = useState<number>(0);

  useEffect(() => {
    if (initialData) {
      setFormData({
        ...initialData,
        image: undefined,
      });
    } else {
      setFormData({
        name: "",
        retrieve_price: 0.0,
        retailed_price: 0.0,
        category: "",
        image: undefined,
      });
    }
  }, [initialData]);

  // handle input change
  const handelChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, type } = e.target;
    if (type === "number") {
      setFormData((prev) => ({
        ...prev,
        [name]: parseFloat(value) || 0,
      }));
    } else {
      setFormData((prev) => ({
        ...prev,
        [name]: value,
      }));
    }
  };

  // handle image change
  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setFormData((prev) => ({
        ...prev,
        image: file,
      }));
    }
  };

  // handle save
  const handleSave = () => {
    if (mode === "Buy") {
      onSave(
        {
          ...formData,
          quantity: quantity,
        },
        mode
      );
    } else {
      onSave(formData, mode);
    }
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
        <div>
          <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700">
              Product Name
            </label>
            <input
              type="text"
              name="name"
              className="input input-bordered w-full bg-transparent text-black border border-gray-300"
              onChange={handelChange}
              value={formData.name}
            />
          </div>

          <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700">
              Category
            </label>
            <input
              type="text"
              name="category"
              className="input input-bordered w-full bg-transparent text-black border border-gray-300"
              onChange={handelChange}
              value={formData.category}
            />
          </div>
          {mode === "Buy" && (
            <div>
              <div className="mb-4">
                <label className="block text-sm font-medium text-gray-700">
                  Price
                </label>
                <input
                  type="number"
                  name="price"
                  className="input input-bordered w-full bg-transparent text-black border border-gray-300"
                  onChange={handelChange}
                  value={formData.retailed_price}
                />
              </div>
              <div className="mb-4">
                <label className="block text-sm font-medium text-gray-700">
                  Quantity
                </label>
                <input
                  type="number"
                  name="quantity"
                  className="input input-bordered w-full bg-transparent text-black border border-gray-300"
                  onChange={(e) => setQuantity(Number(e.target.value))}
                  value={quantity}
                />
              </div>
            </div>
          )}
          {mode !== "Buy" && (
            <div>
              <div className="mb-4">
                <label className="block text-sm font-medium text-gray-700">
                  Price
                </label>
                <input
                  type="number"
                  name="retrieve_price"
                  className="input input-bordered w-full bg-transparent text-black border border-gray-300"
                  onChange={handelChange}
                  value={formData.retrieve_price}
                />
              </div>
              <div className="mb-4">
                <label className="block text-sm font-medium text-gray-700">
                  Upload Image
                </label>
                <input
                  type="file"
                  accept="image/*"
                  onChange={handleImageChange}
                />
                {formData.image && (
                  <p className="text-sm text-gray-500 mt-2">
                    Selected: {formData.image.name}
                  </p>
                )}
              </div>
            </div>
          )}
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
            {mode === "Add"
              ? "Add"
              : mode === "Edit"
              ? "Save Changes"
              : "Buy Now"}
          </button>
        </div>
      </div>
    </div>
  );
}
