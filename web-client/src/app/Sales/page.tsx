"use client";
import React from "react";
import AppLayout from "../components/Layout/app";
import {
  BarChart,
  Bar,
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
} from "recharts";

const salesData = [
  { name: "Jan", sales: 4000, revenue: 2400 },
  { name: "Feb", sales: 3000, revenue: 2210 },
  { name: "Mar", sales: 5000, revenue: 2290 },
  { name: "Apr", sales: 4780, revenue: 2000 },
  { name: "May", sales: 5890, revenue: 2181 },
  { name: "Jun", sales: 4390, revenue: 2500 },
];

export default function SalesPage() {
  return (
    <AppLayout>
      <div className="min-h-screen bg-gray-100 p-8">
        <h1 className="text-3xl font-bold text-center mb-6">Sales Dashboard</h1>

        {/* Summary Cards */}
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
          <div className="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Total Sales</h2>
            <p className="text-3xl font-bold">₱500,000</p>
          </div>
          <div className="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Revenue</h2>
            <p className="text-3xl font-bold">₱750,000</p>
          </div>
          <div className="bg-orange-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Orders</h2>
            <p className="text-3xl font-bold">250</p>
          </div>
        </div>

        {/* Sales Graphs */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          {/* Sales Bar Chart */}
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold mb-4">Monthly Sales</h2>
            <ResponsiveContainer width="100%" height={300}>
              <BarChart data={salesData}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="name" />
                <YAxis />
                <Tooltip />
                <Legend />
                <Bar dataKey="sales" fill="#8884d8" />
              </BarChart>
            </ResponsiveContainer>
          </div>

          {/* Revenue Line Chart */}
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold mb-4">Monthly Revenue</h2>
            <ResponsiveContainer width="100%" height={300}>
              <LineChart data={salesData}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="name" />
                <YAxis />
                <Tooltip />
                <Legend />
                <Line type="monotone" dataKey="revenue" stroke="#82ca9d" />
              </LineChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Sales Table */}
        <div className="bg-white p-6 rounded-lg shadow-lg overflow-hidden">
          <h2 className="text-xl font-semibold mb-4">Recent Sales</h2>
          <table className="w-full text-left border-collapse">
            <thead>
              <tr>
                <th className="border-b py-2 px-4">Date</th>
                <th className="border-b py-2 px-4">Product</th>
                <th className="border-b py-2 px-4">Category</th>
                <th className="border-b py-2 px-4">Quantity</th>
                <th className="border-b py-2 px-4">Amount (₱)</th>
              </tr>
            </thead>
            <tbody>
              {/* Example Sales Rows */}
              <tr className="hover:bg-gray-50">
                <td className="border-b py-2 px-4">2024-10-15</td>
                <td className="border-b py-2 px-4">Product A</td>
                <td className="border-b py-2 px-4">Electronics</td>
                <td className="border-b py-2 px-4">2</td>
                <td className="border-b py-2 px-4">₱10,000</td>
              </tr>
              <tr className="hover:bg-gray-50">
                <td className="border-b py-2 px-4">2024-10-14</td>
                <td className="border-b py-2 px-4">Product B</td>
                <td className="border-b py-2 px-4">Home</td>
                <td className="border-b py-2 px-4">1</td>
                <td className="border-b py-2 px-4">₱5,000</td>
              </tr>
              {/* Add more rows as needed */}
            </tbody>
          </table>
        </div>
      </div>
    </AppLayout>
  );
}
