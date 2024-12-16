import React from "react";
import Image from "next/image";

interface CardProps {
  title: string;
  price: number;
  image: string | File | null;
  buyText: string;
  editText: string;
  category: string;
  onBuy: () => void;
  onEdit: () => void;
}

export default function Card({
  title,
  price,
  image,
  buyText,
  editText,
  category,
  onBuy,
  onEdit,
}: CardProps) {
  return (
    <div className="card bg-white text-black shadow-md">
      <figure className="relative w-full h-48">
        <Image
          src={`http://192.168.1.4:8000/api/images/${image}`}
          alt={title}
          layout="fill"
          objectFit="cover"
          className="rounded-t-lg"
        />
      </figure>
      <div className="card-body">
        <h2 className="card-title text-lg font-semibold">
          {title}
          <span className="ml-2 px-3 py-1 bg-blue-600 text-white rounded-md text-sm font-semibold">
            ₱{price?.toFixed(2)}
          </span>
        </h2>
        <p>{category || "No category"}</p>
        <div className="card-actions justify-end">
          <button
            className="btn border-2 border-blue-600 bg-white text-blue-600 hover:bg-blue-600 hover:text-white mr-2"
            onClick={onEdit}
          >
            {editText}
          </button>
          <button
            className="btn border-2 border-blue-600 bg-blue-600 text-white hover:bg-white hover:text-blue-600"
            onClick={onBuy}
          >
            {buyText}
          </button>
        </div>
      </div>
    </div>
  );
}
