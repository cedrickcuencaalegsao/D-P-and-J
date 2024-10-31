import { useState, useEffect } from "react";
import axios from "axios";

function useGetData(url: string) {
  const [getData, setGetData] = useState<any>();
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    setLoading(true);
    const fetchData = async () => {
      try {
        const response = await axios.get(url);
        setGetData(response.data);
      } catch (error) {
        setError(error as string);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [url]);
  return { getData, error, loading };
}
export default useGetData;
