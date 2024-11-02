import React from 'react';
import { FaPlus, FaEdit, FaCog } from 'react-icons/fa';

const FloatingActionButton = () => {
  const handleActionClick = (action) => {
    // Handle the action based on which button is clicked
    console.log(`Clicked on ${action}`);
  };

  return (
    <div className="fixed bottom-5 right-5 flex flex-col space-y-3">
      <button
        className="bg-blue-500 text-white p-3 rounded-full shadow-lg hover:bg-blue-600 transition duration-300"
        onClick={() => handleActionClick('Add')}
        title="Add"
      >
        <FaPlus className="text-xl" />
      </button>
      <button
        className="bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition duration-300"
        onClick={() => handleActionClick('Edit')}
        title="Edit"
      >
        <FaEdit className="text-xl" />
      </button>
      <button
        className="bg-yellow-500 text-white p-3 rounded-full shadow-lg hover:bg-yellow-600 transition duration-300"
        onClick={() => handleActionClick('Settings')}
        title="Settings"
      >
        <FaCog className="text-xl" />
      </button>
    </div>
  );
};

export default FloatingActionButton;
