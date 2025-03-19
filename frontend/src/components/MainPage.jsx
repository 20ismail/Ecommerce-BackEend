import React from "react";
import Button from "./Button"; // Importer le composant Button
import landingImage from "../assets/mains.png";

const MainPage = () => {
  return (
    <div className="container mx-auto p-6">
      {/* Conteneur pour les boutons */}
      <div className="flex justify-between space-x-4 mb-8">
        <Button label="Groceries" />
        <Button label="Electronics" />
        <Button label="Premium fruits" />
        <Button label="Home & Kitchen" />
        <Button label="Fashion" />
        <Button label="Beauty & Personal Care" />
        <Button label="Sports & Fitness" />
        <Button label="Home Improvement" />
      </div>

      <div className="flex justify-center">
        <img src={landingImage} alt="Landing Page" className="w-full h-auto" />
      </div>

    </div>
  );
};

export default MainPage;
