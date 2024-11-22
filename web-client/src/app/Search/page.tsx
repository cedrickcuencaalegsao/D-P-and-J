"use client"; // Add this to mark the component as a Client Component

import { useSearchParams } from "next/navigation";
import useGetData from "@/app/Hooks/useGetData/useGetData";
import AppLayout from "../components/Layout/app";
import Image from "next/image";

interface Product {
  id: number;
  product_id: string;
  name: string;
  price: number;
  category: string;
  created_at: string;
  updated_at: string;
  image: string | null;
  retailed_price: number;
}

interface Sale {
  id: number;
  product_id: string;
  item_sold: number;
  retailed_price: number;
  retrieve_price: number;
  total_sales: number;
  name: string;
  category: string;
  created_at: string;
  updated_at: string;
}

interface Stock {
  id: number;
  product_id: string;
  Stocks: number;
  name: string;
  category: string;
  created_at: string;
  updated_at: string;
}

interface Report {
  id: number;
  product_id: string;
  reports: string;
  created_at: string;
  updated_at: string;
}

const SearchPage = () => {
  const searchParams = useSearchParams();
  const query = searchParams.get("query");

  const { getData, error, loading } = useGetData(
    `http://127.0.0.1:8000/api/search?searched=${query}`
  );

  if (loading) return <div>Loading...</div>;

  if (error) return <div>An error occurred: {error}</div>;
  console.log(getData?.result?.Products?.match);
  console.log(getData?.result?.Products?.related);

  return (
    <AppLayout>
      <div className="modal-container p-6 bg-white rounded-lg shadow-lg max-w-4xl mx-auto">
        <h1 className="text-2xl font-semibold mb-6">Search Results</h1>

        {/* Products Section */}
        <div className="category-section mb-8">
          <h2 className="text-xl font-medium text-gray-800 mb-4">Products</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            {/*Product Exact Match.*/}
            {getData?.result.Products?.match?.length ? (
              getData.result.Products.match.map((product: Product) => (
                <div
                  key={product.id}
                  className="card bg-white text-black shadow-md"
                >
                  <figure className="relative w-full h-48">
                    <Image
                      src={`http://127.0.0.1:8000/api/images/${
                        product.image ? product.image : "default.jpg"
                      }`}
                      alt={product.name}
                      layout="fill"
                      objectFit="cover"
                      className="rounded-t-lg"
                    />
                  </figure>
                  <div className="card-body">
                    <h2 className="card-title text-lg font-semibold">
                      {product.name}
                      <span className="ml-2 px-3 py-1 bg-blue-600 text-white rounded-md text-sm font-semibold">
                        ₱{product.price.toFixed(2)}
                      </span>
                    </h2>
                    <p>{product.category || "No category"}</p>
                  </div>
                </div>
              ))
            ) : (
              <p className="col-span-full text-center text-gray-500">
                No exact match of the search products found.
              </p>
            )}
            {getData?.result.Products?.related?.length ? (
              getData.result.Products.related.map((product: Product) => (
                <div
                  key={product.id}
                  className="card bg-white text-black shadow-md"
                >
                  <figure className="relative w-full h-48">
                    <Image
                      src={`http://127.0.0.1:8000/api/images/${
                        product.image ? product.image : "default.jpg"
                      }`}
                      alt={product.name}
                      layout="fill"
                      objectFit="cover"
                      className="rounded-t-lg"
                    />
                  </figure>
                  <div className="card-body">
                    <h2 className="card-title text-lg font-semibold">
                      {product.name}
                      <span className="ml-2 px-3 py-1 bg-blue-600 text-white rounded-md text-sm font-semibold">
                        ₱{product.price.toFixed(2)}
                      </span>
                    </h2>
                    <p>{product.category || "No category"}</p>
                  </div>
                </div>
              ))
            ) : (
              <p className="col-span-full text-center text-gray-500">
                No related products found.
              </p>
            )}
          </div>
        </div>

        {/* Sales Section */}
        <div className="category-section mb-8">
          <h2 className="text-xl font-medium text-gray-800 mb-4">Sales</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            {getData?.result.Sales?.related?.length ? (
              getData.result.Sales.related.map((sale: Sale) => (
                <div
                  key={sale.id}
                  className="result-card bg-gray-100 p-4 rounded-lg shadow-sm"
                >
                  <h3 className="font-semibold text-lg text-gray-700">
                    {sale.name}
                  </h3>
                  <p className="text-sm text-gray-500">
                    Category: {sale.category}
                  </p>
                  <p className="text-sm text-gray-600">
                    Total Sales: ${sale.total_sales}
                  </p>
                  <p className="text-sm text-gray-600">
                    Item Sold: {sale.item_sold}
                  </p>
                </div>
              ))
            ) : (
              <p className="col-span-full text-center text-gray-500">
                No sales found.
              </p>
            )}
          </div>
        </div>

        {/* Stocks Section */}
        <div className="category-section mb-8">
          <h2 className="text-xl font-medium text-gray-800 mb-4">Stocks</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            {getData?.result.Stocks?.related?.length ? (
              getData.result.Stocks.related.map((stock: Stock) => (
                <div
                  key={stock.id}
                  className="result-card bg-gray-100 p-4 rounded-lg shadow-sm"
                >
                  <h3 className="font-semibold text-lg text-gray-700">
                    {stock.name}
                  </h3>
                  <p className="text-sm text-gray-500">
                    Category: {stock.category}
                  </p>
                  <p className="text-sm text-gray-600">
                    Stock Quantity: {stock.Stocks}
                  </p>
                </div>
              ))
            ) : (
              <p className="col-span-full text-center text-gray-500">
                No stocks found.
              </p>
            )}
          </div>
        </div>

        {/* Reports Section */}
        <div className="category-section mb-8">
          <h2 className="text-xl font-medium text-gray-800 mb-4">Reports</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            {getData?.result.Report?.related?.length ? (
              getData.result.Report.related.map((report: Report) => (
                <div
                  key={report.id}
                  className="result-card bg-gray-100 p-4 rounded-lg shadow-sm"
                >
                  <h3 className="font-semibold text-lg text-gray-700">
                    {report.reports}
                  </h3>
                  <p className="text-sm text-gray-500">
                    Created At: {report.created_at}
                  </p>
                </div>
              ))
            ) : (
              <p className="col-span-full text-center text-gray-500">
                No reports found.
              </p>
            )}
          </div>
        </div>
      </div>
    </AppLayout>
  );
};

export default SearchPage;
