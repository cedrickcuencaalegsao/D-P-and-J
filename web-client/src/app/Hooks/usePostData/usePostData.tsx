import { useState } from "react";
import axios from "axios";

interface PostResponse<T> {
  data: T | null;
  error: Error | null;
  loading: boolean;
  postData: (newData?: any) => Promise<void>;
}

export default function usePostData<T>(
  url: string,
  initialData?: any
): PostResponse<T> {
  const [data, setData] = useState<T | null>(null);
  const [error, setError] = useState<Error | null>(null);
  const [loading, setLoading] = useState<boolean>(false);
  console.log(initialData);

  const postData = async (newData?: any) => {
    try {
      setLoading(true);
      setError(null);
      const dataToPost = newData ?? initialData;
      const response = await axios.post(url, dataToPost);
      console.log(response.data);
      setData(response.data);
    } catch (err) {
      setError(err instanceof Error ? err : new Error("An error occurred"));
      throw err;
    } finally {
      setLoading(false);
    }
  };

  return { data, error, loading, postData };
}
