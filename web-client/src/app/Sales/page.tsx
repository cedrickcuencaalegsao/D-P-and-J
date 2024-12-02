"use client";
import React, { useMemo } from "react";
import AppLayout from "../components/Layout/app";
import useGetData from "../Hooks/useGetData/useGetData";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
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
import SuggestionButtons from "../components/Button/SuggestionButton";

interface Sales {
  id: number;
  product_id: string;
  name: string;
  category: string;
  item_sold: number;
  retailed_price: number;
  retrieve_price: number;
  total_sales: number;
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

export default function SalesPage() {
  const {
    getData: getData,
    loading: getLoading,
    error: getError,
  } = useGetData<Sales>("http://127.0.0.1:8000/api/sales");

  const [selectedCategory, setSelectedCategory] = React.useState<string>("All");

  const filteredSales = useMemo(() => {
    const salesArray = getData?.data || [];
    return selectedCategory === "All"
      ? salesArray
      : salesArray.filter((sale) => sale.category === selectedCategory);
  }, [getData, selectedCategory]);

  // Total sales Calculation.
  const totalSales = useMemo(() => {
    const salesArray = getData?.data || []; // Access data property
    return salesArray.reduce(
      (acc: number, sale: { total_sales: number }) => acc + sale.total_sales,
      0
    );
  }, [getData]);

  // Total Product sold.
  const totalProductSold = useMemo(() => {
    const salesArray = getData?.data || [];
    const totalSoldItems = salesArray.reduce(
      (acc: number, sale: { item_sold: number }) => acc + sale.item_sold,
      0
    );
    return totalSoldItems;
  }, [getData]);

  // Total Revenue Calculation.
  const totalRevenue = useMemo(() => {
    const salesArray = getData?.data || [];
    return salesArray.reduce(
      (acc: number, sale: { retrieve_price: number; item_sold: number }) =>
        acc + sale.retrieve_price * sale.item_sold,
      0
    );
  }, [getData]);

  // Monthly sales Calculation.
  const monthlySales = useMemo(() => {
    const salesArray = getData?.data || [];
    const salesByMonth: Record<string, { Sales: number; Revenue: number }> = {};
    salesArray.forEach((sale: Sales) => {
      const month = new Date(sale.created_at).toLocaleString("default", {
        month: "long",
      });
      if (!salesByMonth[month]) {
        salesByMonth[month] = { Sales: 0, Revenue: 0 };
      }
      // salesByMonth[month] = (salesByMonth[month] || 0) + sale.total_sales;
      salesByMonth[month].Sales += sale.total_sales;
      salesByMonth[month].Revenue += sale.retrieve_price * sale.item_sold;
    });
    // return salesByMonth;
    return Object.entries(salesByMonth).map(([Month, { Sales, Revenue }]) => ({
      Month,
      Sales,
      Revenue,
    }));
  }, [getData]);

  // Error and Loading.
  if (getLoading) return <Loading />;
  if (getError) {
    const apiError = getError as ApiError;
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

  return (
    <AppLayout>
      <div className="min-h-screen bg-gray-100 p-8">
        {/* Summary Cards */}
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
          <div className="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Total Sales</h2>
            <p className="text-3xl font-bold">{`₱ ${totalSales.toFixed(2)}`}</p>
          </div>
          <div className="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Total Revenue</h2>
            <p className="text-3xl font-bold">{`₱ ${totalRevenue.toFixed(
              2
            )}`}</p>
          </div>
          <div className="bg-orange-500 text-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold">Total Product Sold</h2>
            <p className="text-3xl font-bold">{totalProductSold}</p>
          </div>
        </div>

        {/* Sales Graphs */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          {/* Sales Bar Chart */}
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold mb-4">Monthly Sales</h2>
            <ResponsiveContainer width="100%" height={300}>
              <BarChart data={monthlySales}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="Month" />
                <YAxis
                  tickFormatter={(value) =>
                    typeof value === "number" ? value.toFixed(2) : value
                  }
                />
                <Tooltip
                  formatter={(value) =>
                    typeof value === "number" ? value.toFixed(2) : value
                  }
                />
                <Legend />
                <Bar dataKey="Sales" fill="#8884d8" />
              </BarChart>
            </ResponsiveContainer>
          </div>

          {/* Revenue Line Chart */}
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold mb-4">Monthly Revenue</h2>
            <ResponsiveContainer width="100%" height={300}>
              <LineChart data={monthlySales}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="Month" />
                <YAxis />
                <Tooltip />
                <Legend />
                <Line type="monotone" dataKey="Revenue" stroke="#82ca9d" />
              </LineChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Suggestion Buttons for category selection */}
        <SuggestionButtons
          products={getData?.data || []}
          onCategorySelect={setSelectedCategory}
          selectedCategory={selectedCategory}
        />

        {/* Sales Cards */}
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
          {filteredSales.map((sale) => (
            <div key={sale.id} className="bg-white p-6 rounded-lg shadow-lg">
              <h3 className="text-lg font-semibold">{sale.name}</h3>
              <p className="text-gray-600">Category: {sale.category}</p>
              <p className="text-gray-600">Date: {sale.created_at}</p>
              <p className="text-gray-600">Quantity Sold: {sale.item_sold}</p>
              <p className="text-gray-600">{`Total Sales: ₱ ${sale.total_sales}`}</p>
              <p className="text-gray-600">{`Retailed Price: ₱ ${sale.retailed_price}`}</p>
              <p className="text-gray-600">{`Retrieve Price: ₱ ${sale.retrieve_price}`}</p>
            </div>
          ))}
        </div>
      </div>
    </AppLayout>
  );
}
