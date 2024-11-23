"use client";
import React, { useState } from "react";
import Image from "next/image";
import { useRouter } from "next/navigation";

export default function AuthPage() {
  const [email, setEmail] = useState<string>("");
  const [password, setPassword] = useState<string>("");
  const router = useRouter();

  const handleLogin = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    console.log(email, password);
    router.push("/Dashboard");
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100 px-4">
      <div className="w-full max-w-md bg-white rounded-lg shadow-lg p-6 space-y-6">
        {/* Centered Logo */}
        <div className="flex justify-center">
          <Image
            src="http://127.0.0.1:8000/api/images/default.jpg"
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
              required
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
              required
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
