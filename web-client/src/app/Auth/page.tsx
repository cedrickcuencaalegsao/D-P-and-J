"use client";
import React, { useState } from "react";
import { useRouter } from "next/navigation";
import { FaEnvelope, FaEye, FaEyeSlash } from "react-icons/fa"; // Importing icons

export default function AuthPage() {
  const [email, setEmail] = useState<string | null>(null);
  const [password, setPassword] = useState<string | null>(null);
  const [passwordVisible, setPasswordVisible] = useState(false); // State for password visibility
  const router = useRouter();

  const handleLogin = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    console.log(email, password);
    router.push("/Dashboard");
  };

  const togglePasswordVisibility = () => {
    setPasswordVisible(!passwordVisible);
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="w-full max-w-md p-6 space-y-4 bg-white rounded shadow-md">
        <h2 className="text-2xl font-bold text-center">Login</h2>
        <form onSubmit={handleLogin} className="space-y-4">
          <div className="form-control w-full">
            <label className="label flex items-center">
              <span className="label-text">
                <FaEnvelope className="mr-2" /> Email
              </span>
            </label>
            <input
              type="email"
              className="input input-bordered w-full bg-transparent text-black border border-gray-300"
              value={email || ""}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>
          <div className="form-control w-full">
            <label className="label flex items-center">
              <span className="label-text">Password</span>
              <button
                type="button"
                onClick={togglePasswordVisibility}
                className="ml-2"
              >
                {passwordVisible ? <FaEyeSlash /> : <FaEye />}
              </button>
            </label>
            <input
              type={passwordVisible ? "text" : "password"}
              className="input input-bordered w-full bg-transparent text-black border border-gray-300"
              value={password || ""}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>
          <button
            type="submit"
            className="btn btn-primary w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white"
          >
            Login
          </button>
        </form>
      </div>
    </div>
  );
}
