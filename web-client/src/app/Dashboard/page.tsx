"use client";
import AppLayout from "../components/Layout/app";

export default function Dashboard() {
  return (
    <AppLayout>
      <h1 className="text-2xl font-bold mb-6">Dashboard</h1>

      {/* Summary Cards */}
      <div className="grid grid-cols-6 gap-4 mb-6">
        <div className="bg-blue-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Users</h2>
          <p className="text-2xl">100</p>
        </div>
        <div className="bg-pink-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Products</h2>
          <p className="text-2xl">20</p>
        </div>
        <div className="bg-green-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Categories</h2>
          <p className="text-2xl">20</p>
        </div>
        <div className="bg-red-600 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Sales</h2>
          <p className="text-2xl">50</p>
        </div>
        <div className="bg-orange-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Stocks</h2>
          <p className="text-2xl">50</p>
        </div>
        <div className="bg-yellow-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Reports</h2>
          <p className="text-2xl">50</p>
        </div>
      </div>

      {/* More details section (single column) */}
      <div className="grid grid-cols-1 gap-4">
        <div className="bg-white border border-gray-300 p-4 rounded-lg shadow-md">
          <h3 className="text-lg font-bold">Products</h3>
          <p>Details about products...</p>
        </div>
        <div className="bg-white border border-gray-300 p-4 rounded-lg shadow-md">
          <h3 className="text-lg font-bold">Reports</h3>
          <p>Details about reports...</p>
        </div>
        <div className="bg-white border border-gray-300 p-4 rounded-lg shadow-md">
          <h3 className="text-lg font-bold">Stocks</h3>
          <p>Details about stocks...</p>
        </div>
        <div className="bg-white border border-gray-300 p-4 rounded-lg shadow-md">
          <h3 className="text-lg font-bold">Stocks</h3>
          <p>Details about stocks...</p>
        </div>
        <div className="bg-white border border-gray-300 p-4 rounded-lg shadow-md">
          <h3 className="text-lg font-bold">Stocks</h3>
          <p>Details about stocks...</p>
        </div>
      </div>
    </AppLayout>
  );
}
