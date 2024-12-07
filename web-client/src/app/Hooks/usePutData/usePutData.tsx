import { useState } from "react";

interface ApiError {
  message?: string;
  details?: Record<string, string[]>; // Detailed error information (e.g., validation errors)
}

interface UsePutDataResponse<T> {
  postData: (url: string, data: BodyInit) => Promise<T | null>;
  loading: boolean;
  error: ApiError | null;
}

export default function usePutData<T>(): UsePutDataResponse<T> {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<ApiError | null>(null);

  const postData = async (url: string, data: BodyInit): Promise<T | null> => {
    try {
      setLoading(true);
      setError(null);

      const token = localStorage.getItem("token");
      const token_type = localStorage.getItem("token_type");

      const headers: HeadersInit = {};

      // Add Authorization header if token exists
      if (token && token_type) {
        headers["Authorization"] = `${token_type} ${token}`;
      }

      const bodyContent =
        data instanceof FormData ? data : JSON.stringify(data);

      const response = await fetch(url, {
        method: "POST",
        headers,
        body: bodyContent,
      });

      if (!response.ok) {
        const responseData = await response.json();
        setError({
          message: responseData.message || "Failed to update data.",
          details: responseData.errors || {},
        });
        throw new Error(responseData.message || "Failed to update data.");
      }

      const responseData: T = await response.json();
      return responseData;
    } catch (err: unknown) {
      // Handle errors and provide more descriptive messages
      if (err instanceof Error) {
        setError({
          message: err.message || "An error occurred.",
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
