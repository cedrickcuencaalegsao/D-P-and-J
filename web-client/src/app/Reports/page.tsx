"use client";
import AppLayout from "../components/Layout/app";
import { useState } from "react";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  Tooltip,
  ResponsiveContainer,
} from "recharts";

const sampleData = [
  { name: "January", sales: 300, profit: 240 },
  { name: "February", sales: 400, profit: 280 },
  { name: "March", sales: 350, profit: 220 },
  { name: "April", sales: 500, profit: 300 },
];

export default function ReportsPage() {
  const [filter, setFilter] = useState("Monthly");
  return (
    <AppLayout>
      <div className="container mx-auto p-4">
        <h1 className="text-3xl font-bold mb-6 text-center">Reports</h1>

        {/* Summary Cards */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <div className="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Total Sales</h2>
            <p className="text-3xl font-bold">₱120,000</p>
          </div>
          <div className="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Total Profit</h2>
            <p className="text-3xl font-bold">₱80,000</p>
          </div>
          <div className="bg-orange-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Total Expenses</h2>
            <p className="text-3xl font-bold">₱40,000</p>
          </div>
        </div>

        {/* Filter Options */}
        <div className="flex justify-center gap-4 mb-8">
          <button
            onClick={() => setFilter("Monthly")}
            className={`px-4 py-2 rounded ${
              filter === "Monthly"
                ? "bg-blue-500 text-white"
                : "bg-gray-200 text-black"
            }`}
          >
            Monthly
          </button>
          <button
            onClick={() => setFilter("Quarterly")}
            className={`px-4 py-2 rounded ${
              filter === "Quarterly"
                ? "bg-blue-500 text-white"
                : "bg-gray-200 text-black"
            }`}
          >
            Quarterly
          </button>
          <button
            onClick={() => setFilter("Yearly")}
            className={`px-4 py-2 rounded ${
              filter === "Yearly"
                ? "bg-blue-500 text-white"
                : "bg-gray-200 text-black"
            }`}
          >
            Yearly
          </button>
        </div>

        {/* Graph Section */}
        <div className="bg-white p-6 rounded-lg shadow-lg mb-8">
          <h2 className="text-2xl font-bold mb-4">Sales & Profit Over Time</h2>
          <ResponsiveContainer width="100%" height={300}>
            <BarChart
              data={sampleData}
              margin={{ top: 20, right: 30, left: 20, bottom: 5 }}
            >
              <XAxis dataKey="name" />
              <YAxis />
              <Tooltip />
              <Bar dataKey="sales" fill="#8884d8" />
              <Bar dataKey="profit" fill="#82ca9d" />
            </BarChart>
          </ResponsiveContainer>
        </div>

        {/* Report Details Table */}
        <div className="bg-white p-6 rounded-lg shadow-lg">
          <h2 className="text-2xl font-bold mb-4">Detailed Reports</h2>
          <table className="w-full border-collapse">
            <thead>
              <tr className="bg-gray-200">
                <th className="p-2 border">Date</th>
                <th className="p-2 border">Description</th>
                <th className="p-2 border">Amount (₱)</th>
                <th className="p-2 border">Category</th>
              </tr>
            </thead>
            <tbody>
              <tr className="text-center">
                <td className="p-2 border">2024-10-01</td>
                <td className="p-2 border">Product Sales</td>
                <td className="p-2 border">30,000</td>
                <td className="p-2 border">Sales</td>
              </tr>
              <tr className="text-center">
                <td className="p-2 border">2024-10-02</td>
                <td className="p-2 border">Ad Expenses</td>
                <td className="p-2 border">5,000</td>
                <td className="p-2 border">Marketing</td>
              </tr>
              <tr className="text-center">
                <td className="p-2 border">2024-10-03</td>
                <td className="p-2 border">Supplier Payment</td>
                <td className="p-2 border">10,000</td>
                <td className="p-2 border">Expenses</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>ax
    </AppLayout>
  );
}
