import React, { useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTimes } from "@fortawesome/free-solid-svg-icons"; // Icône pour fermer

const LoginPage = ({ onClose }) => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Email:", email);
    console.log("Password:", password);
  };

  return (
    <div className="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 backdrop-blur-sm">
      {/* Conteneur de formulaire avec effet de flou */}
      <div className="bg-white p-8 rounded-lg shadow-md w-full max-w-md relative">
        {/* Icône de fermeture */}
        <FontAwesomeIcon
          icon={faTimes}
          style={{ color: "#05a6fb", cursor: "pointer" }}
          className="absolute top-2 right-2 text-2xl"
          onClick={onClose} // Fonction de fermeture
        />
        <h2 className="text-3xl font-semibold text-center text-[#05a6fb] mb-6">Login</h2>
        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <label htmlFor="email" className="block text-sm font-medium text-gray-700">Email</label>
            <input
              type="email"
              id="email"
              className="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#05a6fb] focus:border-[#05a6fb]"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>
          
          <div className="mb-6">
            <label htmlFor="password" className="block text-sm font-medium text-gray-700">Password</label>
            <input
              type="password"
              id="password"
              className="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#05a6fb] focus:border-[#05a6fb]"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>

          <button
            type="submit"
            className="w-full py-2 px-4 bg-[#05a6fb] text-white font-semibold rounded-md hover:bg-[#0391d1] focus:outline-none focus:ring-2 focus:ring-[#0391d1]"
          >
            Login
          </button>
        </form>

        <div className="mt-6 text-center">
          <p className="text-sm text-gray-500">
            <i className="fas fa-arrow-left mr-2"></i> <span>Don't have an account? Sign up</span>
          </p>
        </div>
      </div>
    </div>
  );
};

export default LoginPage;
