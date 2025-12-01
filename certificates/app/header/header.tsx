'use client';
import React from 'react';
import Link from 'next/link';

const Header: React.FC = () => {
    return (
        <header className="bg-white shadow-sm sticky top-0 z-50">
            <nav className="container mx-auto px-4 py-4">
                <div className="flex items-center justify-between">
                    {/* Logo Section */}
                    <div className="flex items-center space-x-3">
                        <div className="relative w-10 h-10">
                            {/* Open Book Icon */}
                            <svg className="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            {/* Graduation Cap Icon - Positioned on top of book */}
                            <svg className="absolute -top-2 -right-1 w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                            </svg>
                        </div>
                        <span className="text-lg font-semibold text-gray-800 hidden sm:block">
                            ICBWO
                        </span>
                    </div>

                    {/* Navigation Links - Desktop */}
                    <div className="hidden md:flex items-center space-x-8">
                        <a href="#" className="text-gray-700 hover:text-purple-600 transition-colors font-medium">Home</a>
                        <a href="#" className="text-gray-700 hover:text-purple-600 transition-colors font-medium">About Us</a>
                        <a href="#" className="text-gray-700 hover:text-purple-600 transition-colors font-medium">Programs</a>
                        <a href="#" className="text-gray-700 hover:text-purple-600 transition-colors font-medium">Coaches</a>
                    </div>

                    {/* Right Side - Login Button and Menu */}
                    <div className="flex items-center space-x-4">
                        <Link 
                            href="/admin"
                            className="hidden md:block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors font-medium"
                        >
                            Login
                        </Link>
                        {/* Hamburger Menu Icon */}
                        <button className="md:hidden text-gray-700 hover:text-purple-600 transition-colors">
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
        </header>
    );
}

export default Header;
