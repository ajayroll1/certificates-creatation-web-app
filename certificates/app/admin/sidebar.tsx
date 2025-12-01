'use client';
import React from 'react';
import { motion } from 'framer-motion';
import { FaCertificate, FaPlusCircle, FaBars, FaTimes, FaHome, FaSignOutAlt } from 'react-icons/fa';
import Link from 'next/link';
import { usePathname } from 'next/navigation';

interface SidebarProps {
    isOpen?: boolean;
    onToggle?: () => void;
}

const Sidebar: React.FC<SidebarProps> = ({ isOpen = true, onToggle }) => {
    const pathname = usePathname();

    const menuItems = [
        {
            id: 'dashboard',
            label: 'Dashboard',
            icon: FaHome,
            href: '/admin',
            color: 'text-purple-600'
        },
        {
            id: 'create',
            label: 'Certificate Creation',
            icon: FaPlusCircle,
            href: '/admin/create',
            color: 'text-purple-600'
        },
        {
            id: 'created',
            label: 'Certificates Created',
            icon: FaCertificate,
            href: '/admin/certificates',
            color: 'text-blue-600'
        }
    ];

    return (
        <>
            {/* Mobile Toggle Button */}
            <button
                onClick={onToggle}
                className="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-colors"
                aria-label="Toggle sidebar"
            >
                {isOpen ? (
                    <FaTimes className="w-6 h-6 text-gray-700" />
                ) : (
                    <FaBars className="w-6 h-6 text-gray-700" />
                )}
            </button>

            {/* Sidebar */}
            <motion.aside
                initial={false}
                animate={{
                    width: isOpen ? '280px' : '0px',
                    opacity: isOpen ? 1 : 0
                }}
                transition={{ duration: 0.3, ease: "easeInOut" }}
                className={`fixed lg:static top-0 left-0 h-screen bg-white shadow-xl z-40 overflow-hidden ${
                    isOpen ? 'block' : 'hidden lg:block'
                }`}
            >
                <div className="h-full flex flex-col">
                    {/* Logo Section */}
                    <Link href="/admin">
                        <div className="p-6 border-b border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div className="flex items-center gap-3">
                                <div className="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                                    <FaCertificate className="w-6 h-6 text-white" />
                                </div>
                                <div>
                                    <h2 className="text-xl font-bold text-gray-800">Admin Panel</h2>
                                    <p className="text-xs text-gray-500">Certificate Management</p>
                                </div>
                            </div>
                        </div>
                    </Link>

                    {/* Navigation Menu */}
                    <nav className="flex-1 p-4 space-y-2 overflow-y-auto">
                        {menuItems.map((item) => {
                            const IconComponent = item.icon;
                            const isActive = pathname === item.href || (item.href !== '/admin' && pathname?.startsWith(item.href));
                            
                            return (
                                <Link
                                    key={item.id}
                                    href={item.href}
                                >
                                    <motion.div
                                        whileHover={{ x: 5, scale: 1.02 }}
                                        whileTap={{ scale: 0.98 }}
                                        className={`
                                            flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-300
                                            ${isActive 
                                                ? 'bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 shadow-md' 
                                                : 'bg-gray-50 hover:bg-gray-100 border-2 border-transparent'
                                            }
                                        `}
                                    >
                                        <div className={`
                                            p-3 rounded-lg transition-colors
                                            ${isActive ? 'bg-gradient-to-br from-purple-600 to-pink-600' : 'bg-gray-200'}
                                        `}>
                                            <IconComponent 
                                                className={`
                                                    w-5 h-5 transition-colors
                                                    ${isActive ? 'text-white' : 'text-gray-600'}
                                                `} 
                                            />
                                        </div>
                                        <span className={`
                                            font-semibold text-base transition-colors
                                            ${isActive ? 'text-purple-700' : 'text-gray-700'}
                                        `}>
                                            {item.label}
                                        </span>
                                    </motion.div>
                                </Link>
                            );
                        })}
                    </nav>

                    {/* Logout Button */}
                    <div className="p-4 border-t border-gray-200">
                        <motion.button
                            whileHover={{ x: 5, scale: 1.02 }}
                            whileTap={{ scale: 0.98 }}
                            onClick={() => {
                                if (window.confirm('Are you sure you want to logout?')) {
                                    window.location.href = '/';
                                }
                            }}
                            className="w-full flex items-center gap-4 p-4 rounded-xl bg-red-50 hover:bg-red-100 border-2 border-red-200 transition-all duration-300"
                        >
                            <div className="p-3 rounded-lg bg-red-500">
                                <FaSignOutAlt className="w-5 h-5 text-white" />
                            </div>
                            <span className="font-semibold text-base text-red-700">
                                Logout
                            </span>
                        </motion.button>
                    </div>

                    {/* Footer Section */}
                    <div className="p-4 border-t border-gray-200">
                        <div className="text-center">
                            <p className="text-xs text-gray-500">Version 1.0.0</p>
                        </div>
                    </div>
                </div>
            </motion.aside>

            {/* Overlay for mobile */}
            {isOpen && (
                <motion.div
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    exit={{ opacity: 0 }}
                    onClick={onToggle}
                    className="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30"
                />
            )}
        </>
    );
};

export default Sidebar;

