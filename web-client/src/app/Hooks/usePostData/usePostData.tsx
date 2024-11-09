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
  postData: (newData?: any) => Promise<void>;
}

export default function usePostData<T>(
  url: string,
  initialData?: any
): PostResponse<T> {
  const [data, setData] = useState<T | null>(null);
  const [error, setError] = useState<ApiError | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  const postData = async (newData?: any) => {
    try {
      setLoading(true);
      setError(null);
      const dataToPost = newData ?? initialData;
      const response = await axios.post(url, dataToPost);
      console.log(response.data);
      setData(response.data);
    } catch (err: any) {
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
    } finally {
      setLoading(false);
    }
  };

  return { data, error, loading, postData };
}