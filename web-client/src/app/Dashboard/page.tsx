"use client";
import AppLayout from "../components/Layout/app";
import useGetData from "../Hooks/useGetData/useGetData";
import Table from "../components/Tables/Table";

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
  console.log(reports);
  const col_reports = [
    { key: "product_id", label: "Product ID" },
    { key: "reports", label: "Reports" },
    { key: "created_at", label: "Created At" },
    { key: "updated_at", label: "Updated At" },
  ];

  /***
   * Loading screen.
   ***/
  if (loading)
    return (
      <AppLayout>
        <div className="flex justify-center items-center min-h-screen">
          <span className="loading loading-spinner loading-lg"></span>
        </div>
      </AppLayout>
    );

  /**
   * Error handling.
   **/
  if (error)
    return (
      <AppLayout>
        <div className="flex justify-center items-center min-h-screen">
          <div className="bg-red-100 text-red-700 p-6 rounded-lg shadow-lg text-center">
            <h2 className="text-2xl font-bold">Oops! Something went wrong</h2>
            <p>{error}</p>
            <button
              className="mt-4 btn btn-primary"
              onClick={() => window.location.reload()}
            >
              Retry
            </button>
          </div>
        </div>
      </AppLayout>
    );

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
        </div>
        <div className="bg-pink-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Products</h2>
          <p className="text-2xl">{getData?.countData?.products}</p>
        </div>
        <div className="bg-green-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Categories</h2>
          <p className="text-2xl">{getData?.countData?.categories}</p>
        </div>
        <div className="bg-red-600 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Sales</h2>
          <p className="text-2xl">{getData?.countData?.sales}</p>
        </div>
        <div className="bg-orange-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Stocks</h2>
          <p className="text-2xl">{getData?.countData?.stocks}</p>
        </div>
        <div className="bg-yellow-400 text-white p-4 rounded-lg shadow-lg">
          <h2 className="text-xl">Reports</h2>
          <p className="text-2xl">{getData?.countData?.reports}</p>
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
