import React from 'react';

const ProductCard = ({ image, price, stars, onAddToCart }) => {
  return (
    <div className="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
      {/* Image du produit */}
      <img src={image} alt="Product" className="w-full h-64 object-cover rounded-lg" />

      {/* Détails du produit */}
      <div className="mt-4">
        {/* Afficher le prix */}
        <p className="text-xl font-semibold text-[#05a6fb]">${price}</p>

        {/* Afficher les étoiles */}
        <div className="flex mt-1">
          {Array.from({ length: 5 }, (_, index) => (
            <svg
              key={index}
              xmlns="http://www.w3.org/2000/svg"
              fill={index < stars ? '#ffc107' : '#e4e5e9'}
              viewBox="0 0 24 24"
              width="20"
              height="20"
              className="mr-1"
            >
              <path d="M12 .587l3.668 7.431 8.181 1.194-5.924 5.799 1.396 8.146-7.421-3.901-7.421 3.901 1.396-8.146-5.924-5.799 8.181-1.194z" />
            </svg>
          ))}
        </div>

        {/* Bouton Ajouter au panier */}
        <button
          onClick={onAddToCart}
          className="w-full mt-4 py-2 px-4 bg-[#05a6fb] text-white font-semibold rounded-md hover:bg-[#0391d1] focus:outline-none focus:ring-2 focus:ring-[#0391d1]"
        >
          Add to Cart
        </button>
      </div>
    </div>
  );
};

export default ProductCard;
