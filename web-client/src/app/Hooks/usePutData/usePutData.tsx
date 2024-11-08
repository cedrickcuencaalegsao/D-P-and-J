import { useState } from "react";
import axios from "axios";

interface PutResponse<T> {
  data: T | null;
  error: Error | null;
  loading: boolean;
  initialData?: T;
  putData: (newData: any) => Promise<void>;
}
export default function usePutData<T>(
  url: string,
  initialData?: any
): PutResponse<T> {
  const [data, setData] = useState<T | null>(initialData);
  const [error, setError] = useState<Error | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  console.log(data);

  const putData = async (newData: any) => {
    setLoading(true);
    setError(null);
    try {
      const response = await axios.put(url, newData);
      setData(response.data);
    } catch (error: any) {
      setError(error.response.data);
    } finally {
      setLoading(false);
    }
  };
  return { data, error, loading, putData };
}
