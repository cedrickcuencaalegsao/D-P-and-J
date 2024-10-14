import cn from "classnames";
import React from "react";

export interface AlertProps {
  label: string;
  type: "error" | "warning" | "success" | "info";
  children?: React.ReactNode;
}

export const Alerts = ({ label, type = "info", children }: AlertProps) => {
  return (
    <div
      className={cn("alert shadow-lg", {
        "alert-error": type === "error",
        "alert-infor": type === "info",
        "alert-warning": type === "warning",
        "alert-success": type === "success",
      })}
    >
      {children}
      <span>{label}</span>
    </div>
  );
};
