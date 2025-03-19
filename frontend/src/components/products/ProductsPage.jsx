import React, { useState } from 'react';
import ProductCard from './ProductCard';

const ProductsPage = () => {
  const [cart, setCart] = useState([]);

  const handleAddToCart = (product) => {
    setCart([...cart, product]);
    console.log('Product added to cart:', product);
  };

  const products = [
    {
      image: 'https://demothemesky-be87.kxcdn.com/ecomall/wp-content/uploads/2023/03/17-400x400.jpg',
      price: 29.99,
      stars: 4,
      id: 1
    },
    {
      image: 'https://demothemesky-be87.kxcdn.com/ecomall/wp-content/uploads/2023/03/17-400x400.jpg',
      price: 49.99,
      stars: 5,
      id: 2
    },
    {
      image: 'https://demothemesky-be87.kxcdn.com/ecomall/wp-content/uploads/2023/03/17-400x400.jpg',
      price: 19.99,
      stars: 3,
      id: 3
    }
  ];

  return (
    <div className="container mx-auto p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      {products.map((product) => (
        <ProductCard
          key={product.id}
          image={product.image}
          price={product.price}
          stars={product.stars}
          onAddToCart={() => handleAddToCart(product)}
        />
      ))}
    </div>
  );
};

export default ProductsPage;
