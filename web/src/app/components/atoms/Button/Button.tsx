import React from "react";
import classNames from "classnames";

export interface IButtonProps {
  children: React.ReactNode;
  className?: string;
  id?: string;
  theme?:
    | "primary"
    | "secondary"
    | "accent"
    | "ghost"
    | "success"
    | "error"
    | "link";

  size?: "large" | "medium" | "small" | "xsmall";
  outline?: boolean;
  type?: "submit" | "button" | "reset";
  disable?: boolean;
  onClick?: React.MouseEventHandler<HTMLButtonElement>;
}

const buttonAppearanceType = {
  primary: "btn-primary",
  secondary: "btn-secondary",
  accent: "btn-accent",
  ghost: "btn-ghost",
  success: "btn-success",
  error: "btn-error",
  link: "btn-link",
};

const buttonSize = {
  large: "btn-lg",
  medium: "btn-md",
  small: "btn-sm",
  xsmall: "btn-xs",
};

export const Button = ({
  children,
  className = "",
  theme = "primary",
  size = "medium",
  outline = false,
  ...props
}: IButtonProps) => {
  const buttonClass = classNames(
    "btn",
    buttonAppearanceType[theme],
    buttonSize[size],
    { "btn-outline": outline },
    className
  );
  return (
    <button className={buttonClass} {...props}>
      {children}
    </button>
  );
};
