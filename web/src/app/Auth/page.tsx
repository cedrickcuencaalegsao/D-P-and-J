"use client";

import axios from "axios";
import { useEffect, useState } from "react";

export default function AuthPage() {
  const [data, setData] = useState<string>("");
  const [error, setError] = useState<string | null>(null);
  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          "http://127.0.0.1:8000/api/hello-world"
        );
        setData(response.data);
      } catch (err) {
        setError("error");
        console.log(err);
      }
    };
    fetchData();
  }, []);
  return (
    <div>
      <h1>login</h1>
      <h1>{data}</h1>
      <p>{error}</p>
    </div>
  );
}
  
