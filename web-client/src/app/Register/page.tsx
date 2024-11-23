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
  const router = useRouter();

  const handleRegister = () => {
    // e.preventDefault(); e: React.FormEvent<HTMLFormElement>
    if (password !== confirmPassword) {
      alert("Passwords do not match!");
      return;
    }
    console.log({ firstName, lastName, email, password });
    router.push("/Dashboard");
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
                required
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
                required
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
                required
              />
            </div>
          </div>
        </form>
        {/* Register Button */}
        <button
          type="submit"
          className="btn btn-primary w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md mt-6"
          onClick={() => handleRegister()}
        >
          Register
        </button>
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
