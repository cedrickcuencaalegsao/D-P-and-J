"use client";
import AppLayout from "../components/Layout/app";
import useGetData from "../Hooks/useGetData/useGetData";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
import Link from "next/link";
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
  BarChart,
  Bar,
} from "recharts";

export default function Dashboard() {
  const { getData, error, loading } = useGetData(
    "http://127.0.0.1:8000/api/alldata"
  );

  // Process sales data for the chart
  const processedSalesData = getData?.data?.sales
    ?.slice(0, 30) // Get last 30 sales
    .map((sale: any) => ({
      date: new Date(sale.created_at).toLocaleDateString(),
      sales: sale.total_sales,
      items: sale.item_sold,
      name: sale.name,
    }))
    .reverse();

  // Process category data for the bar chart
  const categoryData = getData?.data?.categories?.map((category: any) => ({
    name: category.category,
    stock: category.stock,
  }));

  if (loading) return <Loading />;
  if (error) return <Error error={error} />;

  return (
    <AppLayout>
      <h1 className="text-2xl font-bold mb-6">Dashboard</h1>

      {/* Summary Cards */}
      <div className="grid grid-cols-5 gap-4 mb-6">
        <div className="bg-blue-400 text-white p-4 rounded-lg shadow-lg w-full">
          <h2 className="text-xl">Users</h2>
          <p className="text-2xl">{getData?.countData?.users ?? 0}</p>
          <Link
            href="/Dashboard"
            className="mt-4 inline-block bg-white text-blue-400 rounded-md px-4 py-2 hover:bg-blue-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-pink-400 text-white p-4 rounded-lg shadow-lg w-full">
          <h2 className="text-xl">Products</h2>
          <p className="text-2xl">{getData?.countData?.products}</p>
          <Link
            href="/Products"
            className="mt-4 inline-block bg-white text-pink-400 rounded-md px-4 py-2 hover:bg-pink-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-green-400 text-white p-4 rounded-lg shadow-lg w-full">
          <h2 className="text-xl">Categories</h2>
          <p className="text-2xl">{getData?.countData?.categories}</p>
          <Link
            href="/Category"
            className="mt-4 inline-block bg-white text-green-400 rounded-md px-4 py-2 hover:bg-green-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-red-600 text-white p-4 rounded-lg shadow-lg w-full">
          <h2 className="text-xl">Sales</h2>
          <p className="text-2xl">{getData?.countData?.sales}</p>
          <Link
            href="/Sales"
            className="mt-4 inline-block bg-white text-red-600 rounded-md px-4 py-2 hover:bg-red-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-orange-400 text-white p-4 rounded-lg shadow-lg w-full">
          <h2 className="text-xl">Stocks</h2>
          <p className="text-2xl">{getData?.countData?.stocks}</p>
          <Link
            href="/Stocks"
            className="mt-4 inline-block bg-white text-orange-400 rounded-md px-4 py-2 hover:bg-orange-100 transition"
          >
            View All
          </Link>
        </div>
      </div>

      {/* Charts Section */}
      <div className="grid grid-cols-2 gap-6 mb-6">
        {/* Sales Trend Chart */}
        <div className="bg-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl font-bold mb-4">
            Sales Trend (Last 30 Sales)
          </h2>
          <div className="h-[400px]">
            <ResponsiveContainer width="100%" height="100%">
              <LineChart
                data={processedSalesData}
                margin={{
                  top: 5,
                  right: 30,
                  left: 20,
                  bottom: 5,
                }}
              >
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis
                  dataKey="date"
                  angle={-45}
                  textAnchor="end"
                  height={70}
                />
                <YAxis />
                <Tooltip />
                <Legend />
                <Line
                  type="monotone"
                  dataKey="sales"
                  stroke="#8884d8"
                  name="Sales ($)"
                />
                <Line
                  type="monotone"
                  dataKey="items"
                  stroke="#82ca9d"
                  name="Items Sold"
                />
              </LineChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Category Stock Chart */}
        <div className="bg-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl font-bold mb-4">Stock by Category</h2>
          <div className="h-[400px]">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart
                data={categoryData}
                margin={{
                  top: 5,
                  right: 30,
                  left: 20,
                  bottom: 5,
                }}
              >
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis
                  dataKey="name"
                  angle={-45}
                  textAnchor="end"
                  height={70}
                />
                <YAxis />
                <Tooltip />
                <Legend />
                <Bar dataKey="stock" fill="#8884d8" name="Current Stock" />
              </BarChart>
            </ResponsiveContainer>
          </div>
        </div>
      </div>

      {/* Recent Sales Table */}
      <div className="bg-white p-4 rounded-lg shadow-lg">
        <h2 className="text-xl font-bold mb-4">Recent Sales</h2>
        <div className="overflow-x-auto">
          <table className="min-w-full">
            <thead className="bg-gray-50">
              <tr>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Product
                </th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Items Sold
                </th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Total Sales
                </th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date
                </th>
              </tr>
            </thead>
            <tbody className="bg-white divide-y divide-gray-200">
              {getData?.data?.sales?.slice(0, 5).map((sale: any) => (
                <tr key={sale.id}>
                  <td className="px-6 py-4 whitespace-nowrap">{sale.name}</td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    {sale.item_sold}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    ${sale.total_sales}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    {new Date(sale.created_at).toLocaleDateString()}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AppLayout>
  );
}
