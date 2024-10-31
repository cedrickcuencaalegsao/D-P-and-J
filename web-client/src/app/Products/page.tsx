"use client";
import AppLayout from "../components/Layout/app";
import Card from "../components/Card/Card";

export default function ProductsPage() {
  const handleCardClick = (title: string) => {
    console.log(`Card clicked: ${title}`);
  };
  return (
    <AppLayout>
      <div className="grid grid-cols-4 gap-7">
        <Card
          category="Small"
          title="Small Card"
          price="100"
          imageUrl="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
          buttonText="Click Me"
          onClick={() => handleCardClick("Small Card")}
        />
        <Card
          category="Small"
          title="Medium Card"
          price="100"
          imageUrl="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
          buttonText="By Now"
          onClick={() => handleCardClick("Medium Card")}
        />
        <Card
          category="Large"
          title="Large Card"
          price="100"
          imageUrl="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
          buttonText="By Now"
          onClick={() => handleCardClick("Large Card")}
        />
        <Card
          category="Large"
          title="Large Card"
          price="100"
          imageUrl="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
          buttonText="By Now"
          onClick={() => handleCardClick("Large Card")}
        />
        <Card
          category="Large"
          title="Large Card"
          price="100"
          imageUrl="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
          buttonText="By Now"
          onClick={() => handleCardClick("Large Card")}
        />
        <Card
          category="Large"
          title="Large Card"
          price="100"
          imageUrl="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
          buttonText="By Now"
          onClick={() => handleCardClick("Large Card")}
        />
        <Card
          category="Large"
          title="Large Card"
          price="100"
          imageUrl="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
          buttonText="By Now"
          onClick={() => handleCardClick("Large Card")}
        />
        <Card
          category="Large"
          title="Large Card"
          price="100"
          imageUrl="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
          buttonText="By Now"
          onClick={() => handleCardClick("Large Card")}
        />
      </div>
    </AppLayout>
  );
}
