'use client';
import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { 
    FaCode, 
    FaLaptopCode, 
    FaChartBar, 
    FaPalette, 
    FaChartLine, 
    FaMobileAlt, 
    FaGlobe, 
    FaLock, 
    FaCloud 
} from 'react-icons/fa';

const Banner: React.FC = () => {
    const [searchQuery, setSearchQuery] = useState('');

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        // Handle certificate verification search
        console.log('Searching for:', searchQuery);
        // You can add API call here to verify certificate
    };

    const certificateCategories = [
        { 
            id: 1, 
            name: 'Web Development', 
            color: 'bg-orange-500',
            icon: FaLaptopCode,
            hoverAnimation: { scale: 1.2, rotate: [0, -10, 10, -10, 0], y: -5 }
        },
        { 
            id: 2, 
            name: 'Programming', 
            color: 'bg-red-500',
            icon: FaCode,
            hoverAnimation: { scale: 1.2, rotate: 360 }
        },
        { 
            id: 3, 
            name: 'Data Science', 
            color: 'bg-pink-500',
            icon: FaChartBar,
            hoverAnimation: { scale: 1.2, y: -5 }
        },
        { 
            id: 4, 
            name: 'Design',
            color: 'bg-purple-500',
            icon: FaPalette,
            hoverAnimation: { scale: 1.2, rotate: [0, 10, -10, 0] }
        },
        { 
            id: 5, 
            name: 'Business', 
            color: 'bg-teal-500',
            icon: FaChartLine,
            hoverAnimation: { scale: 1.2, y: -5 }
        },
        { 
            id: 6, 
            name: 'Marketing', 
            color: 'bg-green-500',
            icon: FaMobileAlt,
            hoverAnimation: { scale: 1.2, rotate: [0, -15, 15, 0] }
        },
        { 
            id: 7, 
            name: 'Language', 
            color: 'bg-blue-500',
            icon: FaGlobe,
            hoverAnimation: { scale: 1.2, rotate: 360 }
        },
        { 
            id: 8, 
            name: 'Security', 
            color: 'bg-indigo-500',
            icon: FaLock,
            hoverAnimation: { scale: 1.2, y: -5 }
        },
        { 
            id: 9, 
            name: 'Cloud', 
            color: 'bg-cyan-500',
            icon: FaCloud,
            hoverAnimation: { scale: 1.2, y: -5, x: [0, 5, -5, 0] }
        }
    ];

    return (
        <div className="relative w-full bg-gradient-to-br from-cyan-50 via-purple-50 to-white py-16 px-4">
            <div className="container mx-auto max-w-6xl">
                {/* Header Section - Centered */}
                <div className="flex items-center justify-center mb-8">
                    <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-center text-black">
                        Verify Your Certificate
                    </h1>
                </div>

                {/* Search Bar Section */}
                <div className="mb-12">
                    <form onSubmit={handleSearch} className="relative max-w-4xl mx-auto">
                        <div className="relative bg-white rounded-2xl shadow-xl border-2 border-gray-400 focus-within:border-gray-600 transition-all">
                            <div className="flex items-center px-6 py-4">
                                {/* Input Field */}
                                <input
                                    type="text"
                                    value={searchQuery}
                                    onChange={(e) => setSearchQuery(e.target.value)}
                                    placeholder="Enter certificate ID or verification code to verify your certificate"
                                    className="flex-1 text-lg outline-none text-gray-700 placeholder-gray-400"
                                />
                            </div>
                        </div>
                    </form>
                </div>

                {/* Category Icons Section */}
                <div className="flex flex-wrap justify-center gap-4 md:gap-6">
                    {certificateCategories.map((category) => {
                        const IconComponent = category.icon;
                        return (
                            <motion.button
                                key={category.id}
                                className="flex flex-col items-center gap-2 group"
                                whileHover={{ scale: 1.05 }}
                            >
                                <motion.div 
                                    className={`w-16 h-16 ${category.color} rounded-full flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow`}
                                    whileHover={category.hoverAnimation}
                                    transition={{ duration: 0.3, ease: "easeInOut" }}
                                >
                                    <IconComponent className="w-8 h-8 text-white" />
                                </motion.div>
                                <span className="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                                    {category.name}
                                </span>
                            </motion.button>
                        );
                    })}
                </div>
            </div>
        </div>
    );
};

export default Banner;

