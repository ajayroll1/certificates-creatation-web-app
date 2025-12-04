'use client';
import React, { useState } from 'react';
import { motion } from 'framer-motion';
import Sidebar from '../sidebar';
import { FaCertificate, FaSearch, FaFilter, FaDownload, FaEye, FaEdit, FaTrash } from 'react-icons/fa';

interface Certificate {
    id: string;
    studentName: string;
    courseName: string;
    category: string;
    issueDate: string;
    expiryDate: string;
    status: 'Active' | 'Expired' | 'Pending';
}

export default function CertificatesPage() {
    const [sidebarOpen, setSidebarOpen] = useState(true);
    const [searchQuery, setSearchQuery] = useState('');
    const [filterCategory, setFilterCategory] = useState('');

    // Sample data - in real app, this would come from API/database
    const [certificates] = useState<Certificate[]>([
        {
            id: 'CERT-123456',
            studentName: 'John Doe',
            courseName: 'Web Development Masterclass',
            category: 'Web Development',
            issueDate: '2024-01-15',
            expiryDate: '2025-01-15',
            status: 'Active'
        },
        {
            id: 'CERT-123457',
            studentName: 'Jane Smith',
            courseName: 'Data Science Fundamentals',
            category: 'Data Science',
            issueDate: '2024-02-20',
            expiryDate: '',
            status: 'Active'
        },
        {
            id: 'CERT-123458',
            studentName: 'Mike Johnson',
            courseName: 'UI/UX Design Course',
            category: 'Design',
            issueDate: '2023-12-10',
            expiryDate: '2024-12-10',
            status: 'Expired'
        }
    ]);

    const categories = [
        'All Categories',
        'Web Development',
        'Programming',
        'Data Science',
        'Design',
        'Business',
        'Marketing',
        'Language',
        'Security',
        'Cloud'
    ];

    const filteredCertificates = certificates.filter(cert => {
        const matchesSearch = cert.studentName.toLowerCase().includes(searchQuery.toLowerCase()) ||
                             cert.courseName.toLowerCase().includes(searchQuery.toLowerCase()) ||
                             cert.id.toLowerCase().includes(searchQuery.toLowerCase());
        const matchesCategory = filterCategory === '' || filterCategory === 'All Categories' || cert.category === filterCategory;
        return matchesSearch && matchesCategory;
    });

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'Active':
                return 'bg-green-100 text-green-800';
            case 'Expired':
                return 'bg-red-100 text-red-800';
            case 'Pending':
                return 'bg-yellow-100 text-yellow-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    };

    const handleView = (cert: Certificate) => {
        alert(`Viewing Certificate:\n\nID: ${cert.id}\nStudent: ${cert.studentName}\nCourse: ${cert.courseName}\nCategory: ${cert.category}\nIssue Date: ${new Date(cert.issueDate).toLocaleDateString()}\nStatus: ${cert.status}`);
        // In real app, this would open a modal or navigate to view page
    };

    const handleDownload = (cert: Certificate) => {
        // Create a simple text file download (in real app, this would be PDF)
        const content = `Certificate Details\n\nCertificate ID: ${cert.id}\nStudent Name: ${cert.studentName}\nCourse: ${cert.courseName}\nCategory: ${cert.category}\nIssue Date: ${new Date(cert.issueDate).toLocaleDateString()}\nStatus: ${cert.status}`;
        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${cert.id}-${cert.studentName}.txt`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    };

    const handleEdit = (cert: Certificate) => {
        alert(`Edit Certificate: ${cert.id}\n\nThis would open the edit form for this certificate.`);
        // In real app, this would navigate to edit page or open edit modal
    };

    const handleDelete = (cert: Certificate) => {
        if (window.confirm(`Are you sure you want to delete certificate ${cert.id} for ${cert.studentName}?`)) {
            alert(`Certificate ${cert.id} has been deleted.`);
            // In real app, this would call API to delete and update the list
        }
    };

    return (
        <div className="flex h-screen bg-gray-50 overflow-hidden">
            {/* Sidebar */}
            <Sidebar 
                isOpen={sidebarOpen} 
                onToggle={() => setSidebarOpen(!sidebarOpen)} 
            />

            {/* Main Content Area */}
            <main className="flex-1 overflow-y-auto">
                <div className="p-6 md:p-8">
                    {/* Header */}
                    <motion.div
                        initial={{ opacity: 0, y: -20 }}
                        animate={{ opacity: 1, y: 0 }}
                        className="mb-8"
                    >
                        <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h1 className="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                                    Certificates Created
                                </h1>
                                <p className="text-gray-600">
                                    View and manage all created certificates
                                </p>
                            </div>
                            <div className="text-sm text-gray-600">
                                Total: <span className="font-bold text-gray-800">{filteredCertificates.length}</span> certificates
                            </div>
                        </div>
                    </motion.div>

                    {/* Search and Filter Section */}
                    <div className="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-6">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {/* Search Bar */}
                            <div className="relative">
                                <FaSearch className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                                <input
                                    type="text"
                                    value={searchQuery}
                                    onChange={(e) => setSearchQuery(e.target.value)}
                                    placeholder="Search by name, course, or certificate ID..."
                                    className="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                />
                            </div>

                            {/* Category Filter */}
                            <div className="relative">
                                <FaFilter className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                                <select
                                    value={filterCategory}
                                    onChange={(e) => setFilterCategory(e.target.value)}
                                    className="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all appearance-none bg-white"
                                >
                                    {categories.map((cat) => (
                                        <option key={cat} value={cat === 'All Categories' ? '' : cat}>
                                            {cat}
                                        </option>
                                    ))}
                                </select>
                            </div>
                        </div>
                    </div>

                    {/* Certificates Table */}
                    <div className="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                        <div className="overflow-x-auto">
                            <table className="w-full">
                                <thead className="bg-gradient-to-r from-purple-50 to-pink-50">
                                    <tr>
                                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Certificate ID
                                        </th>
                                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Student Name
                                        </th>
                                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Course Name
                                        </th>
                                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Category
                                        </th>
                                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Issue Date
                                        </th>
                                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th className="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {filteredCertificates.length > 0 ? (
                                        filteredCertificates.map((cert, index) => (
                                            <motion.tr
                                                key={cert.id}
                                                initial={{ opacity: 0, y: 20 }}
                                                animate={{ opacity: 1, y: 0 }}
                                                transition={{ delay: index * 0.05 }}
                                                className="hover:bg-gray-50 transition-colors"
                                            >
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="flex items-center gap-2">
                                                        <FaCertificate className="text-purple-600" />
                                                        <span className="text-sm font-medium text-gray-900">
                                                            {cert.id}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="text-sm font-medium text-gray-900">
                                                        {cert.studentName}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4">
                                                    <div className="text-sm text-gray-900">
                                                        {cert.courseName}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <span className="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {cert.category}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="text-sm text-gray-900">
                                                        {new Date(cert.issueDate).toLocaleDateString('en-US', { 
                                                            year: 'numeric', 
                                                            month: 'numeric', 
                                                            day: 'numeric' 
                                                        })}
                                                    </div>
                                                    {cert.expiryDate && (
                                                        <div className="text-xs text-gray-500">
                                                            Expires: {new Date(cert.expiryDate).toLocaleDateString('en-US', { 
                                                                year: 'numeric', 
                                                                month: 'numeric', 
                                                                day: 'numeric' 
                                                            })}
                                                        </div>
                                                    )}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <span className={`px-3 py-1 text-xs font-semibold rounded-full ${getStatusColor(cert.status)}`}>
                                                        {cert.status}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-center">
                                                    <div className="flex items-center justify-center gap-2">
                                                        <motion.button
                                                            whileHover={{ scale: 1.1 }}
                                                            whileTap={{ scale: 0.9 }}
                                                            onClick={() => handleView(cert)}
                                                            className="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                            title="View"
                                                        >
                                                            <FaEye />
                                                        </motion.button>
                                                        <motion.button
                                                            whileHover={{ scale: 1.1 }}
                                                            whileTap={{ scale: 0.9 }}
                                                            onClick={() => handleDownload(cert)}
                                                            className="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                            title="Download"
                                                        >
                                                            <FaDownload />
                                                        </motion.button>
                                                        <motion.button
                                                            whileHover={{ scale: 1.1 }}
                                                            whileTap={{ scale: 0.9 }}
                                                            onClick={() => handleEdit(cert)}
                                                            className="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                                            title="Edit"
                                                        >
                                                            <FaEdit />
                                                        </motion.button>
                                                        <motion.button
                                                            whileHover={{ scale: 1.1 }}
                                                            whileTap={{ scale: 0.9 }}
                                                            onClick={() => handleDelete(cert)}
                                                            className="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                            title="Delete"
                                                        >
                                                            <FaTrash />
                                                        </motion.button>
                                                    </div>
                                                </td>
                                            </motion.tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan={7} className="px-6 py-12 text-center">
                                                <div className="flex flex-col items-center gap-3">
                                                    <FaCertificate className="text-6xl text-gray-300" />
                                                    <p className="text-lg font-medium text-gray-500">
                                                        No certificates found
                                                    </p>
                                                    <p className="text-sm text-gray-400">
                                                        {searchQuery || filterCategory ? 'Try adjusting your search or filter' : 'Create your first certificate to get started'}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {/* Pagination (if needed in future) */}
                    {filteredCertificates.length > 0 && (
                        <div className="mt-6 flex items-center justify-between">
                            <div className="text-sm text-gray-600">
                                Showing <span className="font-medium">1</span> to <span className="font-medium">{filteredCertificates.length}</span> of <span className="font-medium">{filteredCertificates.length}</span> results
                            </div>
                            <div className="flex gap-2">
                                <button className="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    Previous
                                </button>
                                <button className="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    Next
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </main>
        </div>
    );
}

