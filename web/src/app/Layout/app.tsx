import React from "react";
import Link from "next/link";

const AuthLayout: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  return (
    <div>
      <header>
        <h1>DP&J</h1>
        <nav>
          <Link href="/Dashboard" className="mr-4">
            Dashboard
          </Link>
          <Link href="/Products">Products</Link>
          <Link href="/Sales">Sales</Link>
          <Link href="/Reports">Reports</Link>
          <Link href="/Category">Category</Link>
          <Link href="/Stocks">Stocks</Link>
          <Link href="/" className="ml-4">
            Logout
          </Link>
        </nav>
      </header>
      <main>{children}</main>
    </div>
  );
};
export default AuthLayout;
