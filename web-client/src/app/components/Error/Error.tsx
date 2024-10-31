import AppLayout from "../Layout/app";

export default function Error({ error }: { error: string }) {
  return (
    <AppLayout>
      <div className="flex justify-center items-center min-h-screen">
        <div className="bg-red-100 text-red-700 p-6 rounded-lg shadow-lg text-center">
          <h2 className="text-2xl font-bold">Oops! Something went wrong</h2>
          <p>{error}</p>
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
