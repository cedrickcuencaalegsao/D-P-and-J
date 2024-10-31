"use client";
import AppLayout from "../components/Layout/app";
import Card from "../components/Card/Card";
import useGetData from "../Hooks/useGetData/useGetData";
import Loading from "../components/Loading/Loading";
import Error from "../components/Error/Error";

export default function ProductsPage() {
  const { getData, error, loading } = useGetData(
    "http://127.0.0.1:8000/api/products"
  );

  // Ensure products is defined and default to an empty array if not
  const products = Array.isArray(getData?.products) ? getData.products : [];

  /***
   * Loading screen.
   ***/
  if (loading) return <Loading />;

  /**
   * Error handling.
   **/
  if (error) return <Error error={error} />;

  console.log(products);

  const handleCardClick = (args: string) => {
    console.log(`Card clicked: ${args}`);
  };

  return (
    <AppLayout>
      <div className="grid grid-cols-4 gap-7">
        {products.length > 0 ? ( // Check if products array is not empty
          products.map((product) => (
            <Card
              key={product.id}
              category={product.category}
              title={product.name}
              price={product.price}
              image={product.image || "default.jpg"}
              buttonText="Buy Now"
              onClick={() => handleCardClick(product.product_id)}
            />
          ))
        ) : (
          <p>No products available</p> // Display message if no products are found
        )}
      </div>
    </AppLayout>
  );
}
