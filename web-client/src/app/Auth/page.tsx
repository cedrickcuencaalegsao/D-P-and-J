"use client";
import React, { useState } from "react";
import Image from "next/image";
import { useRouter } from "next/navigation";

export default function AuthPage() {
  const [email, setEmail] = useState<string>("");
  const [password, setPassword] = useState<string>("");
  const router = useRouter();
  const [error, setError] = useState("");

  const handleLogin = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    try {
      const response = await fetch("http://192.168.1.4:8000/api/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Login failed");
      }

      const data = await response.json();
      const roleID = data?.user?.roleID;
      const token = data?.token;
      const token_type = data?.token_type;

      console.log("api_token:", data?.token);

      localStorage.setItem("roleID", roleID.toString());
      localStorage.setItem("token", token);
      localStorage.setItem("token_type", token_type);

      if (roleID === 1) {
        router.push("/Dashboard");
      } else {
        router.push("/Products");
      }
    } catch (err: unknown) {
      if (err instanceof Error) {
        setError(err.message || "An error occurred");
      } else {
        setError("An unknown error occurred");
      }
    }
    console.log(error);
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100 px-4">
      <div className="w-full max-w-md bg-white rounded-lg shadow-lg p-6 space-y-6">
        {/* Centered Logo */}
        <div className="flex justify-center">
          <Image
            src="http://192.168.1.4:8000/api/images/default.jpg"
            alt="Logo"
            width={80}
            height={80}
            className="rounded-full"
          />
        </div>
        {/* Form Title */}
        <h2 className="text-2xl font-semibold text-center text-gray-800">
          Welcome Back
        </h2>
        {/* Error Message Display */}
        {error && (
          <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <span className="block sm:inline">{error}</span>
          </div>
        )}
        {/* Login Form */}
        <form onSubmit={handleLogin} className="space-y-4">
          {/* Email Input */}
          <div className="form-control">
            <label htmlFor="email" className="label">
              <span className="label-text text-gray-600">Email Address</span>
            </label>
            <input
              id="email"
              type="text"
              placeholder="Enter your email"
              className="input input-bordered w-full bg-gray-50 text-gray-800"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              // required
            />
          </div>
          {/* Password Input */}
          <div className="form-control">
            <label htmlFor="password" className="label">
              <span className="label-text text-gray-600">Password</span>
            </label>
            <input
              id="password"
              type="password"
              placeholder="Enter your password"
              className="input input-bordered w-full bg-gray-50 text-gray-800"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              // required
            />
          </div>
          {/* Login Button */}
          <button
            type="submit"
            className="btn btn-primary w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md"
          >
            Login
          </button>
        </form>
        {/* Register Link */}
        <p className="text-center text-sm text-gray-500">
          Don&apos;t have an account?
          <a href="/Register" className="text-blue-600 hover:underline">
            Register here
          </a>
        </p>
      </div>
    </div>
  );
}
