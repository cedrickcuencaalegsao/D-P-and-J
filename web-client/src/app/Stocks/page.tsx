"use client";
import AppLayout from "../components/Layout/app";
import useGetData from "../Hooks/useGetData/useGetData";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
} from "recharts";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
import { MdOutlineUpdate } from "react-icons/md";
import { useState } from "react";
import StockModal from "../components/Modals/StockModal";

interface Stock {
  id: number;
  product_id: string;
  Stocks: number;
  name: string;
  category: string;
  created_at: string;
  updated_at: string;
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

export default function StocksPage() {
  const { getData, error, loading } = useGetData(
    "http://127.0.0.1:8000/api/stocks"
  );
  const [selectedStock, setSelectedStock] = useState<Stock | null>(null);
  const [showModal, setShowModal] = useState<boolean>(false);

  if (loading) return <Loading />;
  if (error) {
    const apiError = error as ApiError;
    const errorMessage =
      apiError?.response?.data?.message ||
      apiError?.message ||
      "An error occurred.";
    const validationErrors = apiError?.response?.data?.errors;
    const errorMessages = validationErrors
      ? Object.values(validationErrors).flat()
      : [errorMessage];
    return <Error error={errorMessages} />;
  }

  const stocks: Stock[] = Array.isArray(getData?.stocks) ? getData.stocks : [];

  const formattedDate = (dateToFormat: string) => {
    const date = new Date(dateToFormat);
    return date.toLocaleString("en-US", {
      year: "numeric",
      month: "long",
      day: "numeric",
      hour: "2-digit",
      minute: "2-digit",
      hour12: true,
    });
  };

  const openRestockModal = (stock: Stock) => {
    setSelectedStock(stock);
    setShowModal(true);
  };

  const closeRestockModal = () => {
    setSelectedStock(null);
    setShowModal(false);
  };

  return (
    <AppLayout>
      <div className="container mx-auto p-6">
        <h1 className="text-3xl font-bold mb-8 text-center text-gray-800">
          Products per Category
        </h1>

        {/* Bar Chart */}
        <div className="bg-white p-6 rounded-lg shadow-lg mb-10">
          <h2 className="text-xl font-semibold text-gray-700 mb-4">
            Stock Chart
          </h2>
          <ResponsiveContainer width="100%" height={300}>
            <BarChart data={stocks}>
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis dataKey="category" />
              <YAxis />
              <Tooltip />
              <Legend />
              <Bar dataKey="Stocks" fill="#4F46E5" />
            </BarChart>
          </ResponsiveContainer>
        </div>

        {/* Table */}
        <div className="overflow-x-auto bg-white rounded-lg shadow-lg">
          <table className="min-w-full bg-white">
            <thead className="bg-gray-100 text-gray-700 border-b">
              <tr>
                <th className="py-3 px-4 text-left font-medium">Category</th>
                <th className="py-3 px-4 text-left font-medium">Name</th>
                <th className="py-3 px-4 text-left font-medium">Stocks</th>
                <th className="py-3 px-4 text-left font-medium">Date added</th>
                <th className="py-3 px-4 text-left font-medium">Last Update</th>
                <th className="py-3 px-4 text-left font-medium">Action</th>
              </tr>
            </thead>
            <tbody>
              {stocks.map((item) => (
                <tr
                  key={item.id}
                  className="text-gray-700 hover:bg-gray-50 border-b"
                >
                  <td className="py-3 px-4">{item.category}</td>
                  <td className="py-3 px-4">{item.name}</td>
                  <td className="py-3 px-4">{item.Stocks}</td>
                  <td className="py-3 px-4">{formattedDate(item.created_at)}</td>
                  <td className="py-3 px-4">{formattedDate(item.updated_at)}</td>
                  <td className="py-3 px-4 flex justify-center">
                    <button
                      className="flex items-center bg-indigo-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-600 transition"
                      onClick={() => openRestockModal(item)}
                    >
                      <MdOutlineUpdate className="mr-2" />
                      Update Stock
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
        {showModal && (
          <StockModal
            stock={selectedStock}
            onClose={closeRestockModal}
          />
        )}
      </div>
    </AppLayout>
  );
}
