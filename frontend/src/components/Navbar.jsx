import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faLocationPin, faTruck, faTag } from "@fortawesome/free-solid-svg-icons";

const Navbar = () => {
    return (
        <div className="flex justify-between items-center bg-gray-200 p-2">
            <p className="text-gray-500">Welcome to worldwide Megamart!</p>
            <div className="flex space-x-4 items-center">
                <div className="flex items-center space-x-1">
                    <FontAwesomeIcon icon={faLocationPin} style={{color:"#05a6fb"}} />
                    <p className="text-gray-500">Deliver to 34556</p>
                </div>
                <div className="flex items-center space-x-1">
                    <FontAwesomeIcon icon={faTruck} style={{color:"#05a6fb"}} />
                    <p className="text-gray-500">Track your order</p>
                </div>
                <div className="flex items-center space-x-1">
                    <FontAwesomeIcon icon={faTag} style={{color:"#05a6fb"}} />
                    <p className="text-gray-500">All Offers</p>
                </div>
            </div>
        </div>
    );
};

export default Navbar;
