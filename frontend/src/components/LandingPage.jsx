import React, { useState } from "react";
import Navbar from "./navbar";
import Header from "./Header";
import LoginPage from "./LoginPage";
import MainPage from "./MainPage";
import ProductsPage from "./products/ProductsPage";


const LandingPage = () => {

  const [showLogin, setShowLogin] = useState(false);

  const handleLoginClick = () => {
    setShowLogin(true);
  };

  const handleCloseLogin = () => {
    setShowLogin(false);
  };

  return (
    <>
    <Navbar />
    <Header  onLoginClick={handleLoginClick} />
    {showLogin && <LoginPage onClose={handleCloseLogin} />}
    <MainPage />
    <ProductsPage />
    </>
  );
};

export default LandingPage;
