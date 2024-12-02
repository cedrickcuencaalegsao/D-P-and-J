import { useState, useEffect } from "react";

// Define the response data structure
interface ApiResponse<T> {
  data?: T[];
  // Add other possible response fields here
  message?: string;
  status?: string;
}

function useGetData<T>(url: string) {
  const [getData, setGetData] = useState<ApiResponse<T> | undefined>(undefined);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    setLoading(true);
    const fetchData = async () => {
      try {
        const token = localStorage.getItem("token");
        const token_type = localStorage.getItem("token_type");

        if (!token) {
          throw new Error("Authentication token not found");
        }

        const response = await fetch(url, {
          headers: {
            Authorization: `${token_type} ${token}`,
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data: ApiResponse<T> = await response.json();
        setGetData(data);
      } catch (error) {
        if (error instanceof Error) {
          setError(error.message);
        } else {
          setError("An unknown error occurred");
        }
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [url]);
  return { getData, error, loading };
}

export default useGetData;