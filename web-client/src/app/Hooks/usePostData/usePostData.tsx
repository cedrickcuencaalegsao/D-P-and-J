import { useState } from "react";
import axios from "axios";

interface ApiError {
  message?: string;
  details?: Record<string, string[]>;
}

interface PostResponse<T> {
  data: T | null;
  error: ApiError | null;
  loading: boolean;
  postData: (newData?: T | FormData) => Promise<T | null>;
}

type AuthToken = string | null;

export default function usePostData<T>(
  url: string,
  initialData?: T
): PostResponse<T> {
  const [data, setData] = useState<T | null>(null);
  const [error, setError] = useState<ApiError | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  const postData = async (newData?: T): Promise<T | null> => {
    try {
      setLoading(true);
      setError(null);
      const dataToPost = newData ?? initialData;

      const token: AuthToken = localStorage.getItem("token");
      const token_type = localStorage.getItem("token_type");
      const headers: HeadersInit = {};

      // Add Authorization header if token exists
      if (token && token_type) {
        headers["Authorization"] = `${token_type} ${token}`;
      }

      // Don't set Content-Type for FormData - browser will set it automatically
      if (!(dataToPost instanceof FormData)) {
        headers["Content-Type"] = "application/json";
      }

      const response = await fetch(url, {
        method: "POST",
        headers,
        body:
          dataToPost instanceof FormData
            ? dataToPost
            : JSON.stringify(dataToPost),
      });

      const responseData = await response.json();

      if (!response.ok) {
        throw {
          response: {
            data: responseData,
          },
        };
      }

      setData(responseData);
      return responseData;
    } catch (err: unknown) {
      if (axios.isAxiosError(err) && err.response?.data) {
        const serverError = err.response.data;
        setError({
          message: "Failed to post data.",
          details: serverError,
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

  return {
    data,
    error,
    loading,
    postData: postData as (
      newData?: FormData | T | undefined
    ) => Promise<T | null>,
  };
}
