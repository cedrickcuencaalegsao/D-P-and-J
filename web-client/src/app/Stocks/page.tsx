"use client";
import AppLayout from "../components/Layout/app";
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
import useGetData from "../Hooks/useGetData/useGetData";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
import { FaPlus } from "react-icons/fa";

interface Stock {
  id?: number;
  product_id?: string;
  Stock?: number;
  name?: string;
  category?: string;
  created_at?: string;
  updated_at?: string;
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

  const stock: Stock[] = Array.isArray(getData?.stocks) ? getData.stocks : [];

  console.log(stock);

  if (loading) <Loading />;
  if (error) {
    const apiError = error as ApiError;
    const errorMessage =
      apiError?.response?.data?.message ||
      apiError?.message ||
      "An error occured";
    const validationErrors = apiError?.response?.data?.errors;
    const errorMessages = validationErrors
      ? Object.values(validationErrors).flat()
      : [errorMessage];

    return <Error error={errorMessages} />;
  }

  return (
    <AppLayout>
      <div className="container mx-auto p-4">
        <h1 className="text-2xl font-bold mb-4 text-center">
          Products per Category
        </h1>

        {/* Bar Chart */}
        <div className="bg-white p-6 rounded shadow-md mb-8">
          <ResponsiveContainer width="100%" height={300}>
            <BarChart data={stock}>
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis dataKey="category" />
              <YAxis />
              <Tooltip />
              <Legend />
              <Bar dataKey="Stock" fill="#8884d8" />
            </BarChart>
          </ResponsiveContainer>
        </div>

        {/* Table */}
        <div className="overflow-x-auto bg-white rounded shadow-md">
          <table className="min-w-full bg-white">
            <thead className="bg-gray-200 text-gray-600">
              <tr>
                <th className="py-2 px-4 border">Name</th>
                <th className="py-2 px-4 border">Category</th>
                <th className="py-2 px-4 border">Stocks</th>
                <th className="py-2 px-4 border">Action</th>
              </tr>
            </thead>
            <tbody>
              {stock.length > 0 ? (
                stock.map((item, index) => (
                  <tr key={index} className="text-center border-b">
                    <td className="py-2 px-4 border">{item.category}</td>
                    <td className="py-2 px-4 border">{item.name}</td>
                    <td className="py-2 px-4 border">{item.Stock}</td>
                    <td className=" flex justify-center">
                      <button className="flex items-center bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 transition">
                        <FaPlus className="mr-2" /> Restock
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr className="text-center border-b">
                  <td className="py-2 px-4 border">no data.</td>
                  <td className="py-2 px-4 border">no data.</td>
                  <td className="py-2 px-4 border">no data.</td>
                  <td className="py-2 px-4 border">no data.</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </AppLayout>
  );
}
