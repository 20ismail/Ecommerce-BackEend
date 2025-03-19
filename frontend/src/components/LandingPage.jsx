import React, { useState } from "react";
import Navbar from "./navbar";
import Header from "./Header";
import LoginPage from "./LoginPage";



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
    </>
  );
};

export default LandingPage;
