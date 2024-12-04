"use client";
import AppLayout from "../components/Layout/app";
import { useEffect, useState } from "react";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  Tooltip,
  ResponsiveContainer,
} from "recharts";
import useGetData from "../Hooks/useGetData/useGetData";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
import DownloadCart from "../components/DownloadCart/DownloadCart"; // Import the new DownloadCart component
import * as XLSX from 'xlsx';
import jsPDF from 'jspdf';

interface SaleData {
  category: string;
  created_at: string;
  id: number;
  item_sold: number;
  name: string;
  product_id: string;
  retailed_price: number; // Selling price
  retrieve_price: number; // Cost price
  total_sales: number;
  updated_at: string;
}
interface APIResponse {
  sales: SaleData[];
}
interface ChartData {
  name: string;
  sales: number;
  profit: number;
  expenses: number;
}
interface AggregatedSalesData {
  totalSales: number;
  totalProfit: number;
  totalExpenses: number;
}
interface Annual {
  name: string | null;
  totalSales: number;
  totalProfit: number;
  totalExpenses: number;
}

export default function ReportsPage() {
  const { getData, error, loading } = useGetData<APIResponse>(
    "http://127.0.0.1:8000/api/reports"
  );
  const [filter, setFilter] = useState<string>("Monthly");
  const [monthly, setMonthly] = useState<ChartData[]>([]);
  const [quarterly, setQuarterly] = useState<
    Record<string, AggregatedSalesData>
  >({
    Q1: { totalSales: 0, totalProfit: 0, totalExpenses: 0 },
    Q2: { totalSales: 0, totalProfit: 0, totalExpenses: 0 },
    Q3: { totalSales: 0, totalProfit: 0, totalExpenses: 0 },
    Q4: { totalSales: 0, totalProfit: 0, totalExpenses: 0 },
  });

  const [annually, setAnnually] = useState<Annual>({
    name: "",
    totalSales: 0,
    totalProfit: 0,
    totalExpenses: 0,
  });

  const processSalesData = (data: SaleData[]) => {
    const monthlySales: Record<
      string,
      { totalSales: number; totalProfit: number; totalExpenses: number }
    > = {};
    const quarterlySales: Record<
      string,
      { totalSales: number; totalProfit: number; totalExpenses: number }
    > = {
      Q1: { totalSales: 0, totalProfit: 0, totalExpenses: 0 },
      Q2: { totalSales: 0, totalProfit: 0, totalExpenses: 0 },
      Q3: { totalSales: 0, totalProfit: 0, totalExpenses: 0 },
      Q4: { totalSales: 0, totalProfit: 0, totalExpenses: 0 },
    };
    const annualSales = {
      name: "Annual",
      totalSales: 0,
      totalProfit: 0,
      totalExpenses: 0,
    };

    data.forEach((sale) => {
      const date = new Date(sale.created_at);
      const month = date.toLocaleString("default", { month: "long" });
      const quarter =
        date.getMonth() < 3
          ? "Q1"
          : date.getMonth() < 6
          ? "Q2"
          : date.getMonth() < 9
          ? "Q3"
          : "Q4";

      // Calculate monthly totals
      if (!monthlySales[month]) {
        monthlySales[month] = {
          totalSales: 0,
          totalProfit: 0,
          totalExpenses: 0,
        };
      }
      monthlySales[month].totalSales += sale.total_sales;
      monthlySales[month].totalProfit += sale.total_sales - sale.retrieve_price;
      monthlySales[month].totalExpenses += sale.retrieve_price;

      quarterlySales[quarter].totalSales += sale.total_sales;
      quarterlySales[quarter].totalProfit +=
        sale.total_sales - sale.retrieve_price;
      quarterlySales[quarter].totalExpenses += sale.retrieve_price;

      annualSales.totalSales += sale.total_sales;
      annualSales.totalProfit += sale.total_sales - sale.retrieve_price;
      annualSales.totalExpenses += sale.retrieve_price;
    });

    console.log("Annual Sales:", annualSales);

    // Prepare chart data
    const chartData = Object.keys(monthlySales).map((month) => ({
      name: month,
      sales: parseFloat(monthlySales[month].totalSales.toFixed(2)),
      profit: parseFloat(monthlySales[month].totalProfit.toFixed(2)),
      expenses: parseFloat(monthlySales[month].totalExpenses.toFixed(2)),
    }));

    return { chartData, quarterlySales, annualSales };
  };

  useEffect(() => {
    if (getData && getData?.data?.sales) {
      const { chartData, quarterlySales, annualSales } = processSalesData(
        getData?.data?.sales
      );
      setMonthly(chartData);
      setQuarterly(quarterlySales);
      setAnnually(annualSales);
    }
  }, [getData]);

  const quarterlyData = Object.keys(quarterly).map((quarter) => ({
    name: quarter,
    sales: quarterly[quarter].totalSales.toFixed(2),
    profit: quarterly[quarter].totalProfit.toFixed(2),
    expenses: quarterly[quarter].totalExpenses.toFixed(2),
  }));
  const annualData = [
    {
      name: "Annual",
      sales: annually.totalSales.toFixed(2),
      profit: annually.totalProfit.toFixed(2),
      expenses: annually.totalExpenses.toFixed(2),
    },
  ];

  if (loading) return <Loading />;
  if (error) return <Error error={error} />;

  return (
    <AppLayout>
      <div className="container mx-auto p-4 flex flex-col">
        {/* Main Content */}
        <div className="flex-1">
          {/* Summary Cards */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div className="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
              <h2 className="text-xl font-semibold">Total Sales</h2>
              <p className="text-3xl font-bold">
                {`₱ ${annually.totalSales.toFixed(2)}`}
              </p>
            </div>
            <div className="bg-green-500 text-white p-6 rounded-lg shadow-lg">
              <h2 className="text-xl font-semibold">Total Profit</h2>
              <p className="text-3xl font-bold">
                {`₱ ${annually.totalProfit.toFixed(2)}`}
              </p>
            </div>
            <div className="bg-orange-500 text-white p-6 rounded-lg shadow-lg">
              <h2 className="text-xl font-semibold">Total Expenses</h2>
              <p className="text-3xl font-bold">
                {`₱ ${annually.totalExpenses.toFixed(2)}`}
              </p>
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
              onClick={() => setFilter("Annually")}
              className={`px-4 py-2 rounded ${
                filter === "Annually"
                  ? "bg-blue-500 text-white"
                  : "bg-gray-200 text-black"
              }`}
            >
              Annually
            </button>
          </div>

          {/* Graph Section */}
          <div>
            {filter === "Monthly" ? (
              <div className="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h2 className="text-2xl font-bold mb-4">
                  Monthly sales, profit, and expenses
                </h2>
                <ResponsiveContainer width="100%" height={300}>
                  <BarChart
                    data={monthly}
                    margin={{ top: 20, right: 30, left: 20, bottom: 5 }}
                  >
                    <XAxis dataKey="name" />
                    <YAxis />
                    <Tooltip />
                    <Bar dataKey="sales" fill="#8884d8" />
                    <Bar dataKey="profit" fill="#82ca9d" />
                    <Bar dataKey="expenses" fill="#f04747" />
                  </BarChart>
                </ResponsiveContainer>
              </div>
            ) : (
              <div></div>
            )}
            {filter === "Quarterly" ? (
              <div className="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h2 className="text-2xl font-bold mb-4">
                  Quarterly sales, profits, and expenses
                </h2>
                <ResponsiveContainer width="100%" height={300}>
                  <BarChart
                    data={quarterlyData}
                    margin={{ top: 20, right: 30, left: 20, bottom: 5 }}
                  >
                    <XAxis dataKey="name" />
                    <YAxis />
                    <Tooltip />
                    <Bar dataKey="sales" fill="#8884d8" />
                    <Bar dataKey="profit" fill="#82ca9d" />
                    <Bar dataKey="expenses" fill="#f04747" />
                  </BarChart>
                </ResponsiveContainer>
              </div>
            ) : (
              <div></div>
            )}
            {filter === "Annually" ? (
              <div className="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h2 className="text-2xl font-bold mb-4">
                  Annual sales, profits, and expenses
                </h2>
                <ResponsiveContainer width="100%" height={300}>
                  <BarChart
                    data={annualData}
                    margin={{ top: 20, right: 30, left: 20, bottom: 5 }}
                  >
                    <XAxis dataKey="name" />
                    <YAxis />
                    <Tooltip />
                    <Bar dataKey="sales" fill="#8884d8" />
                    <Bar dataKey="profit" fill="#82ca9d" />
                    <Bar dataKey="expenses" fill="#f04747" />
                  </BarChart>
                </ResponsiveContainer>
              </div>
            ) : (
              <div></div>
            )}
          </div>
        </div>

        {/* Download Cart as a single row component */}
        <div className="flex justify-between mt-4">
          <DownloadCart 
            monthlyData={monthly} 
            quarterlyData={quarterlyData} 
            annualData={annualData} 
          />
        </div>
      </div>
    </AppLayout>
  );
}