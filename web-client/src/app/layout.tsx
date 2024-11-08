import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: "DP and J",
  description: "Generated by create next app",
  icons: {
    icon: "./favicon.ico", // Update with the actual path
    apple: "./favicon.ico", // Optional for Apple touch icon
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body className="bg-white text-black">{children}</body>
    </html>
  );
}
