"use client";
import AppLayout from "../components/Layout/app";
import useGetData from "../Hooks/useGetData/useGetData";
import Table from "../components/Tables/Table";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";
import Link from "next/link";

export default function Dashboard() {
  const { getData, error, loading } = useGetData(
    "http://127.0.0.1:8000/api/alldata"
  );

  /**
   * Products Table.
   **/
  const products = getData?.data?.products || [];
  const col_products = [
    { key: "product_id", label: "Product ID" },
    { key: "name", label: "Name" },
    { key: "price", label: "Price" },
    { key: "created_at", label: "Created At" },
    { key: "updated_at", label: "Updated At" },
  ];
  /**
   * Sales Table.
   **/
  const sales = getData?.data?.sales || [];
  const col_sales = [
    { key: "product_id", label: "Product ID" },
    { key: "item_sold", label: "Item Sold" },
    { key: "total_sales", label: "Total Sales" },
    { key: "created_at", label: "Created At" },
  ];
  /**
   * Categories Table.
   **/
  const categories = getData?.data?.categories || [];
  const col_categories = [
    { key: "product_id", label: "Product ID" },
    { key: "category", label: "Category" },
    { key: "created_at", label: "Created At" },
    { key: "updated_at", label: "Updated At" },
  ];

  /**
   * Stocks Table.
   **/
  const stocks = getData?.data?.stocks || [];
  const col_stocks = [
    { key: "product_id", label: "Product ID" },
    { key: "stock", label: "Stock" },
    { key: "created_at", label: "Created At" },
    { key: "updated_at", label: "Updated At" },
  ];

  /**
   * Reports Table.
   **/
  const reports = getData?.data?.reports || [];
  const col_reports = [
    { key: "product_id", label: "Product ID" },
    { key: "reports", label: "Reports" },
    { key: "created_at", label: "Created At" },
    { key: "updated_at", label: "Updated At" },
  ];

  /***
   * Loading screen.
   ***/
  if (loading) return <Loading />;

  /**
   * Error handling.
   **/
  if (error) return <Error error={error} />;

  /**
   * Dashboard Page.
   **/
  return (
    <AppLayout>
      <h1 className="text-2xl font-bold mb-6">Dashboard</h1>

      {/* Summary Cards */}
      <div className="grid grid-cols-6 gap-4 mb-6">
        <div className="bg-blue-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Users</h2>
          <p className="text-2xl">{getData?.countData?.users ?? 0}</p>
          <Link
            href="/Dashboard"
            className="mt-4 inline-block bg-white text-blue-400 rounded-md px-4 py-2 hover:bg-blue-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-pink-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Products</h2>
          <p className="text-2xl">{getData?.countData?.products}</p>
          <Link
            href="/Products"
            className="mt-4 inline-block bg-white text-pink-400 rounded-md px-4 py-2 hover:bg-pink-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-green-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Categories</h2>
          <p className="text-2xl">{getData?.countData?.categories}</p>
          <Link
            href="/Category"
            className="mt-4 inline-block bg-white text-green-400 rounded-md px-4 py-2 hover:bg-green-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-red-600 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Sales</h2>
          <p className="text-2xl">{getData?.countData?.sales}</p>
          <Link
            href="/Sales"
            className="mt-4 inline-block bg-white text-red-600 rounded-md px-4 py-2 hover:bg-red-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-orange-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Stocks</h2>
          <p className="text-2xl">{getData?.countData?.stocks}</p>
          <Link
            href="/Stocks"
            className="mt-4 inline-block bg-white text-orange-400 rounded-md px-4 py-2 hover:bg-orange-100 transition"
          >
            View All
          </Link>
        </div>
        <div className="bg-yellow-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Reports</h2>
          <p className="text-2xl">{getData?.countData?.reports}</p>
          <Link
            href="/Reports"
            className="mt-4 inline-block bg-white text-yellow-400 rounded-md px-4 py-2 hover:bg-yellow-100 transition"
          >
            View All
          </Link>
        </div>
      </div>

      {/* More details section (single column) */}
      <div className="grid grid-cols-1 gap-4">
        {/* Products Table */}
        <Table title="Products" data={products} columns={col_products} />

        {/* Sales Table*/}
        <Table title="Sales" data={sales} columns={col_sales} />

        {/* Categories Table*/}
        <Table title="Categories" data={categories} columns={col_categories} />

        {/* Stocks Table*/}
        <Table title="Stocks" data={stocks} columns={col_stocks} />

        {/* Reports Table*/}
        <Table title="Reports" data={reports} columns={col_reports} />
      </div>
    </AppLayout>
  );
}
