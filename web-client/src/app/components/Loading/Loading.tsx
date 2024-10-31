import AppLayout from "../Layout/app";

export default function Loading() {
  return (
    <AppLayout>
      <div className="flex justify-center items-center min-h-screen">
        <span className="loading loading-spinner loading-lg"></span>
      </div>
    </AppLayout>
  );
}
