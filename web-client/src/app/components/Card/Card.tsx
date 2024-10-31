import React from "react";

interface Cardprops {
  title: string;
  price: string;
  imageUrl: string;
  buttonText: string;
  category: string;
  onClick: () => void;
}

export default function Card({
  title,
  price,
  imageUrl,
  buttonText,
  category,
  onClick,
}: Cardprops) {
  return (
    <div className="card bg-white text-black shadow-xl">
      <figure>
        <img src={imageUrl} alt={title} className="w-full h-48 object-cover" />
      </figure>
      <div className="card-body">
        <h2 className="card-title">
          {title}
          <div className="badge badge-primary"> ₱ {price}</div>
        </h2>
        <p>{category}</p>
        <div className="card-actions justify-end">
          <button
            className="btn border-2 border-blue-600 bg-blue-600 text-white hover:bg-white hover:text-blue-600"
            onClick={onClick}
          >
            {buttonText} {/* "Buy Now" button */}
          </button>
          <button className="btn border-2 border-blue-600 bg-white text-blue-600 hover:bg-blue-600 hover:text-white mr-2">
            Add to Cart {/* "Add to Cart" button */}
          </button>
        </div>
      </div>
    </div>
  );
}
