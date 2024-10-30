import React from "react";
import Link from "next/link";
import { useState } from "react";
import { useRouter, usePathname } from "next/navigation";
import { FiSearch, FiLogOut } from "react-icons/fi";
import { MdSpaceDashboard, MdOutlineSpaceDashboard } from "react-icons/md";
import { AiOutlineProduct, AiFillProduct } from "react-icons/ai";
import { BiSolidCategoryAlt, BiCategoryAlt } from "react-icons/bi";
import { MdOutlineInventory2, MdInventory2 } from "react-icons/md";
import { BiDollarCircle, BiSolidDollarCircle } from "react-icons/bi";
import { HiOutlineDocumentReport, HiDocumentReport } from "react-icons/hi";

interface LayoutProps {
  children: React.ReactNode;
}

export default function AppLayout({ children }: LayoutProps) {
  const [searchQuery, setSearchQuery] = useState<string | null>(null);
  const router = useRouter();
  const currentPath = usePathname();

  const handleSearch = () => {
    router.push("/Dashboard");
  };

  const handleLogout = () => {
    router.push("/Auth");
  };
  return (
    <div className="flex flex-col min-h-screen">
      {/* Header */}
      <header className="bg-blue-600 text-white p-4 shadow-md">
        <div className="container mx-auto flex justify-between items-center">
          <Link href="/Dashboard" className="text-2xl font-bold">
            DP and J
          </Link>
          <div className="flex items-center space-x-4">
            {/* Dynamic Navigation Icons */}
            <nav className="space-x-4 flex items-center relative">
              <Link href="/Dashboard" className="relative group">
                <div
                  className={`p-4 rounded-lg transition duration-200 ease-in-out ${
                    currentPath === "/Dashboard"
                      ? "bg-gray-800 bg-opacity-70 text-white"
                      : "bg-gray-700 bg-opacity-30 text-gray-400"
                  }`}
                >
                  {currentPath === "/Dashboard" ? (
                    <MdSpaceDashboard size={24} />
                  ) : (
                    <MdOutlineSpaceDashboard size={24} />
                  )}
                </div>
                {/* Tooltip */}
                <span className="absolute left-1/2 transform -translate-x-1/2 -translate-y-6 mb-1 w-max bg-gray-800 text-white text-xs rounded-md p-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                  Dashboard
                </span>
              </Link>

              <Link href="/Products" className="relative group">
                <div
                  className={`p-4 rounded-lg transition duration-200 ease-in-out ${
                    currentPath === "/Products"
                      ? "bg-gray-800 bg-opacity-70 text-white"
                      : "bg-gray-700 bg-opacity-30 text-gray-400"
                  }`}
                >
                  {currentPath === "/Products" ? (
                    <AiFillProduct size={24} />
                  ) : (
                    <AiOutlineProduct size={24} />
                  )}
                </div>
                {/* Tooltip */}
                <span className="absolute left-1/2 transform -translate-x-1/2 -translate-y-6 mb-1 w-max bg-gray-800 text-white text-xs rounded-md p-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                  Products
                </span>
              </Link>

              <Link href="/Sales" className="relative group">
                <div
                  className={`p-4 rounded-lg transition duration-200 ease-in-out ${
                    currentPath === "/Sales"
                      ? "bg-gray-800 bg-opacity-70 text-white"
                      : "bg-gray-700 bg-opacity-30 text-gray-400"
                  }`}
                >
                  {currentPath === "/Sales" ? (
                    <BiSolidDollarCircle size={24} />
                  ) : (
                    <BiDollarCircle size={24} />
                  )}
                </div>
                {/* Tooltip */}
                <span className="absolute left-1/2 transform -translate-x-1/2 -translate-y-6 mb-1 w-max bg-gray-800 text-white text-xs rounded-md p-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                  Sales
                </span>
              </Link>

              <Link href="/Category" className="relative group">
                <div
                  className={`p-4 rounded-lg transition duration-200 ease-in-out ${
                    currentPath === "/Category"
                      ? "bg-gray-800 bg-opacity-70 text-white"
                      : "bg-gray-700 bg-opacity-30 text-gray-400"
                  }`}
                >
                  {currentPath === "/Category" ? (
                    <BiSolidCategoryAlt size={24} />
                  ) : (
                    <BiCategoryAlt size={24} />
                  )}
                </div>
                {/* Tooltip */}
                <span className="absolute left-1/2 transform -translate-x-1/2 -translate-y-6 mb-1 w-max bg-gray-800 text-white text-xs rounded-md p-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                  Category
                </span>
              </Link>

              <Link href="/Stocks" className="relative group">
                <div
                  className={`p-4 rounded-lg transition duration-200 ease-in-out ${
                    currentPath === "/Stocks"
                      ? "bg-gray-800 bg-opacity-70 text-white"
                      : "bg-gray-700 bg-opacity-30 text-gray-400"
                  }`}
                >
                  {currentPath === "/Stocks" ? (
                    <MdInventory2 size={24} />
                  ) : (
                    <MdOutlineInventory2 size={24} />
                  )}
                </div>
                {/* Tooltip */}
                <span className="absolute left-1/2 transform -translate-x-1/2 -translate-y-6 mb-1 w-max bg-gray-800 text-white text-xs rounded-md p-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                  Stocks
                </span>
              </Link>

              <Link href="/Reports" className="relative group">
                <div
                  className={`p-4 rounded-lg transition duration-200 ease-in-out ${
                    currentPath === "/Reports"
                      ? "bg-gray-800 bg-opacity-70 text-white"
                      : "bg-gray-700 bg-opacity-30 text-gray-400"
                  }`}
                >
                  {currentPath === "/Reports" ? (
                    <HiDocumentReport size={24} />
                  ) : (
                    <HiOutlineDocumentReport size={24} />
                  )}
                </div>
                {/* Tooltip */}
                <span className="absolute left-1/2 transform -translate-x-1/2 -translate-y-6 mb-1 w-max bg-gray-800 text-white text-xs rounded-md p-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                  Reports
                </span>
              </Link>
            </nav>

            {/* Search Bar with Icon Inside */}
            <form
              onSubmit={handleSearch}
              className="flex items-center space-x-4"
            >
              <div className="relative">
                <span className="absolute inset-y-0 left-0 flex items-center pl-3">
                  <FiSearch className="text-gray-400" size={20} />
                </span>
                <input
                  type="text"
                  className="input w-48 md:w-64 bg-gray-800 bg-opacity-50 text-white font-bold placeholder-gray-400 rounded-full pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Search..."
                  value={searchQuery || ""}
                  onChange={(e) => setSearchQuery(e.target.value)}
                />
              </div>
            </form>
            {/* Logout Icon */}
            <button onClick={handleLogout} className="btn btn-ghost text-white">
              <FiLogOut size={20} />
            </button>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="flex-grow container mx-auto p-4">{children}</main>
    </div>
  );
}
