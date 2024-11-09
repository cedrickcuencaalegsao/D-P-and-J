import { useState } from "react";
import axios from "axios";

interface UsePutDataResponse<T> {
  postData: (url: string, data: T) => Promise<T>;
  loading: boolean;
  error: any;
}

export default function usePutData<T>(): UsePutDataResponse<T> {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<any>(null);

  const postData = async (url: string, data: any): Promise<T> => {
    try {
      setLoading(true);
      setError(null);
      const response = await axios.post<T>(url, data);
      console.log(response.data);
      
      return response.data;
    } catch (err) {
      setError(err);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  return { postData, loading, error };
}
