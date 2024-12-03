"use client";
import React, { useState } from "react";
import Image from "next/image";
import { useRouter } from "next/navigation";

export default function RegisterPage() {
  const [firstName, setFirstName] = useState<string>("");
  const [lastName, setLastName] = useState<string>("");
  const [email, setEmail] = useState<string>("");
  const [password, setPassword] = useState<string>("");
  const [confirmPassword, setConfirmPassword] = useState<string>("");
  const [loading, setLoading] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);
  const router = useRouter();

  const handleRegister = async (e: React.FormEvent) => {
    e.preventDefault();

    const userData = {
      firstname: firstName,
      lastname: lastName,
      email: email,
      password: password,
      c_password: confirmPassword,
    };

    setLoading(true);
    setError(null); // Reset previous errors

    try {
      const response = await fetch("http://127.0.0.1:8000/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(userData),
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || "Registration failed");
      }

      // Store roleID, token, and token_type in localStorage
      const { roleID, token, token_type } = data.user;
      localStorage.setItem("roleID", roleID.toString());
      localStorage.setItem("token", token);
      localStorage.setItem("token_type", token_type);

      // Redirect based on roleID
      if (roleID === 1) {
        router.push("/Dashboard");
      } else if (roleID === 2) {
        router.push("/Products");
      }
    } catch (error) {
      setError(error instanceof Error ? error.message : "An error occurred");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100 px-4">
      <div className="w-full max-w-4xl bg-white rounded-lg shadow-lg p-6 space-y-6">
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
        <h2 className="text-2xl font-semibold text-center text-gray-800 mt-4">
          Create an Account
        </h2>
        {/* Register Form with grid layout */}
        <form
          onSubmit={handleRegister}
          className="grid grid-cols-2 gap-x-8 mt-6"
        >
          {/* Left Side: First Name and Last Name */}
          <div className="space-y-4">
            {/* First Name Input */}
            <div className="form-control">
              <label htmlFor="firstName" className="label">
                <span className="label-text text-gray-600">First Name</span>
              </label>
              <input
                id="firstName"
                type="text"
                placeholder="Enter your first name"
                className="input input-bordered w-full bg-gray-50 text-gray-800"
                value={firstName}
                onChange={(e) => setFirstName(e.target.value)}
              />
            </div>
            {/* Last Name Input */}
            <div className="form-control">
              <label htmlFor="lastName" className="label">
                <span className="label-text text-gray-600">Last Name</span>
              </label>
              <input
                id="lastName"
                type="text"
                placeholder="Enter your last name"
                className="input input-bordered w-full bg-gray-50 text-gray-800"
                value={lastName}
                onChange={(e) => setLastName(e.target.value)}
              />
            </div>
          </div>

          {/* Right Side: Email, Password, Confirm Password */}
          <div className="space-y-4">
            {/* Email Input */}
            <div className="form-control">
              <label htmlFor="email" className="label">
                <span className="label-text text-gray-600">Email Address</span>
              </label>
              <input
                id="email"
                type="email"
                placeholder="Enter your email"
                className="input input-bordered w-full bg-gray-50 text-gray-800"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
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
              />
            </div>
            {/* Confirm Password Input */}
            <div className="form-control">
              <label htmlFor="confirmPassword" className="label">
                <span className="label-text text-gray-600">
                  Confirm Password
                </span>
              </label>
              <input
                id="confirmPassword"
                type="password"
                placeholder="Confirm your password"
                className="input input-bordered w-full bg-gray-50 text-gray-800"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
              />
            </div>
          </div>
          {/* Error Message */}
          {error && <p className="text-red-600 text-center mt-4">{error}</p>}

          {/* Register Button */}
          <button
            type="submit"
            className={`btn btn-primary w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md mt-6 ${
              loading ? "cursor-wait" : ""
            }`}
            disabled={loading}
          >
            {loading ? "Registering..." : "Register"}
          </button>
        </form>

        {/* Login Link */}
        <p className="text-center text-sm text-gray-500 mt-4">
          Already have an account?{" "}
          <a href="/Auth" className="text-blue-600 hover:underline">
            Login here
          </a>
        </p>
      </div>
    </div>
  );
}
