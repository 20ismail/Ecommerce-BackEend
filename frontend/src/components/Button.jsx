import React from "react";

const Button = ({ label }) => {
  return (
    <button className="bg-gray-100 border-lg py-2 px-4 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
      {label}
    </button>
  );
};

export default Button;
