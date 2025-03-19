import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBars, faSearch, faUser, faShoppingCart } from "@fortawesome/free-solid-svg-icons";

const Header = ({ onLoginClick }) => {
    return (
        <div className="bg-white shadow-md p-4 flex justify-between items-center">
            {/* Logo & Menu */}
            <div className="flex items-center space-x-2 " style={{color:"#05a6fb"}}>
                <FontAwesomeIcon icon={faBars} className="text-xl cursor-pointer" />
                <p className="text-xl font-bold" >MegaMart</p>
            </div>

            {/* Search Bar */}
            <div className="flex items-center  bg-gray-100 rounded-lg px-2 py-1 w-1/3">
                <FontAwesomeIcon icon={faSearch} style={{color:"#05a6fb"}} />
                <input
                    type="text"
                    placeholder="Search for products"
                    className="outline-none ml-2 w-full"
                />
            </div>

            {/* User & Cart Section */}
            <div className="flex items-center space-x-6">
            <div className="flex items-center space-x-2 cursor-pointer" onClick={onLoginClick}>
                <FontAwesomeIcon icon={faUser} style={{ color: "#05a6fb" }} className="text-lg" />
                <p className="font-bold text-gray-600">Sign Up / Sign In</p>
            </div>
                <div className="flex items-center space-x-2 cursor-pointer">
                    <FontAwesomeIcon icon={faShoppingCart} style={{color:"#05a6fb"}} className=" text-lg" />
                    <p  className="text-gray-600 font-bold">Cart</p>
                </div>
            </div>
        </div>
    );
};

export default Header;