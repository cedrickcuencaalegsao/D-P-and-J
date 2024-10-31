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
const data = [
  { category: "Electronics", count: 30 },
  { category: "Furniture", count: 15 },
  { category: "Clothing", count: 25 },
  { category: "Toys", count: 10 },
  { category: "Books", count: 20 },
];

export default function StocksPage() {
  return (
    <AppLayout>
      <div className="container mx-auto p-4">
        <h1 className="text-2xl font-bold mb-4 text-center">
          Products per Category
        </h1>

        {/* Bar Chart */}
        <div className="bg-white p-6 rounded shadow-md mb-8">
          <ResponsiveContainer width="100%" height={300}>
            <BarChart data={data}>
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis dataKey="category" />
              <YAxis />
              <Tooltip />
              <Legend />
              <Bar dataKey="count" fill="#8884d8" />
            </BarChart>
          </ResponsiveContainer>
        </div>

        {/* Table */}
        <div className="overflow-x-auto bg-white rounded shadow-md">
          <table className="min-w-full bg-white">
            <thead className="bg-gray-200 text-gray-600">
              <tr>
                <th className="py-2 px-4 border">Category</th>
                <th className="py-2 px-4 border">Number of Products</th>
              </tr>
            </thead>
            <tbody>
              {data.map((item, index) => (
                <tr key={index} className="text-center border-b">
                  <td className="py-2 px-4 border">{item.category}</td>
                  <td className="py-2 px-4 border">{item.count}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AppLayout>
  );
}
