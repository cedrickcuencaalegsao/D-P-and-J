// Card Component
import React from "react";

interface CardProps {
  title: string;
  price: number; // price as number
  image: string;
  buttonText: string;
  category: string;
  onClick: () => void;
}

export default function Card({
  title,
  price,
  image,
  buttonText,
  category,
  onClick,
}: CardProps) {
  return (
    <div className="card bg-white text-black shadow-md">
      <figure>
        <img
          src={`http://127.0.0.1:8000/api/images/${image}`}
          alt={title}
          className="w-full h-50 object-cover"
        />
      </figure>
      <div className="card-body">
        <h2 className="card-title">
          {title}
          <div className="badge badge-primary">₱ {price.toFixed(2)}</div>
        </h2>
        <p>{category || "No category"}</p>
        <div className="card-actions justify-end">
          <button
            className="btn border-2 border-blue-600 bg-blue-600 text-white hover:bg-white hover:text-blue-600"
            onClick={onClick}
          >
            {buttonText}
          </button>
          {/* <button className="btn border-2 border-blue-600 bg-white text-blue-600 hover:bg-blue-600 hover:text-white mr-2">
            Add to Cart
          </button> */}
        </div>
      </div>
    </div>
  );
}
