import { useState } from "react";

interface ApiError {
  message?: string;
  details?: Record<string, string[]>;
}

interface UsePutDataResponse<T> {
  postData: (url: string, data: BodyInit) => Promise<T | null>; // Change T to BodyInit
  loading: boolean;
  error: ApiError | null;
}

export default function usePutData<T>(): UsePutDataResponse<T> {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<ApiError | null>(null);

  const postData = async (url: string, data: BodyInit): Promise<T | null> => {
    // Change T to BodyInit
    try {
      setLoading(true);
      setError(null);

      const token = localStorage.getItem("token");
      const token_type = localStorage.getItem("token_type");

      const headers: HeadersInit = {
        // Do not set Content-Type for FormData
      };

      // Add Authorization header if token exists
      if (token && token_type) {
        headers["Authorization"] = `${token_type} ${token}`;
      }

      const response = await fetch(url, {
        method: "POST", // Use PUT method for updating data
        headers,
        body: data, // Send FormData directly
      });

      if (!response.ok) {
        const responseData = await response.json();
        throw new Error(responseData.message || "Failed to update data.");
      }

      const responseData: T = await response.json();
      return responseData;
    } catch (err: unknown) {
      if (err instanceof Error) {
        setError({
          message: "Failed to update data.",
          details: { error: [err.message] },
        });
      } else {
        setError({
          message: "An unknown error occurred.",
        });
      }
      return null;
    } finally {
      setLoading(false);
    }
  };

  return { postData, loading, error };
}
