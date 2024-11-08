import AppLayout from "../Layout/app";

interface ErrorProps {
  error: string | string[];
}

export default function Error({ error }: ErrorProps) {
  const errorMessage = Array.isArray(error) ? error : [error];
  return (
    <AppLayout>
      <div className="flex justify-center items-center min-h-screen">
        <div className="bg-red-100 text-red-700 p-6 rounded-lg shadow-lg text-center">
          <h2 className="text-2xl font-bold">Oops! Something went wrong</h2>
          {errorMessage.map((msg, idx) => (
            <p key={idx}>{msg}</p>
          ))}
          <button
            className="mt-4 btn btn-primary"
            onClick={() => window.location.reload()}
          >
            Retry
          </button>
        </div>
      </div>
    </AppLayout>
  );
}
