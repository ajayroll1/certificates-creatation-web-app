'use client';
import React, { useState } from 'react';
import { motion } from 'framer-motion';
import Sidebar from '../sidebar';
import { FaCertificate, FaUser, FaBook, FaCalendarAlt, FaFileAlt, FaTag } from 'react-icons/fa';

export default function CreateCertificatePage() {
    const [sidebarOpen, setSidebarOpen] = useState(true);
    const [formData, setFormData] = useState({
        studentName: '',
        courseName: '',
        certificateId: '',
        issueDate: '',
        expiryDate: '',
        category: '',
        description: '',
        grade: '',
        instructor: ''
    });

    const categories = [
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

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const generateCertificateId = () => {
        const prefix = 'CERT';
        const randomNum = Math.floor(100000 + Math.random() * 900000);
        const newId = `${prefix}-${randomNum}`;
        setFormData(prev => ({ ...prev, certificateId: newId }));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        console.log('Certificate Data:', formData);
        // Here you would typically send data to your backend API
        alert('Certificate created successfully!');
        // Reset form
        setFormData({
            studentName: '',
            courseName: '',
            certificateId: '',
            issueDate: '',
            expiryDate: '',
            category: '',
            description: '',
            grade: '',
            instructor: ''
        });
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
                    {/* Header Section */}
                    <motion.div
                        initial={{ opacity: 0, y: -20 }}
                        animate={{ opacity: 1, y: 0 }}
                        className="mb-8"
                    >
                        <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h1 className="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                                    Create New Certificate
                                </h1>
                                <p className="text-gray-600">
                                    Fill in the details below to generate a new certificate
                                </p>
                            </div>
                        </div>
                    </motion.div>

                    {/* Certificate Creation Form */}
                    <form onSubmit={handleSubmit}>
                        <div className="bg-white rounded-xl shadow-lg border border-gray-200 p-6 md:p-8">
                            {/* Student Information Section */}
                            <div className="mb-8">
                                <h2 className="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                    <FaUser className="text-purple-600" />
                                    Student Information
                                </h2>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label className="block text-sm font-semibold text-gray-700 mb-2">
                                            Student Name <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            name="studentName"
                                            value={formData.studentName}
                                            onChange={handleChange}
                                            required
                                            className="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                            placeholder="Enter student full name"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-semibold text-gray-700 mb-2">
                                            Certificate ID <span className="text-red-500">*</span>
                                        </label>
                                        <div className="flex gap-2">
                                            <input
                                                type="text"
                                                name="certificateId"
                                                value={formData.certificateId}
                                                onChange={handleChange}
                                                required
                                                className="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                                placeholder="CERT-123456"
                                            />
                                            <button
                                                type="button"
                                                onClick={generateCertificateId}
                                                className="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors"
                                            >
                                                Generate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Course Information Section */}
                            <div className="mb-8">
                                <h2 className="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                    <FaBook className="text-blue-600" />
                                    Course Information
                                </h2>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label className="block text-sm font-semibold text-gray-700 mb-2">
                                            Course Name <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            name="courseName"
                                            value={formData.courseName}
                                            onChange={handleChange}
                                            required
                                            className="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                            placeholder="e.g., Web Development Masterclass"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-semibold text-gray-700 mb-2">
                                            Category <span className="text-red-500">*</span>
                                        </label>
                                        <div className="relative">
                                            <FaTag className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                                            <select
                                                name="category"
                                                value={formData.category}
                                                onChange={handleChange}
                                                required
                                                className="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all appearance-none bg-white"
                                            >
                                                <option value="">Select Category</option>
                                                {categories.map((cat) => (
                                                    <option key={cat} value={cat}>{cat}</option>
                                                ))}
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-semibold text-gray-700 mb-2">
                                            Grade/Score
                                        </label>
                                        <input
                                            type="text"
                                            name="grade"
                                            value={formData.grade}
                                            onChange={handleChange}
                                            className="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                            placeholder="e.g., A+, 95%, Excellent"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-semibold text-gray-700 mb-2">
                                            Instructor Name
                                        </label>
                                        <input
                                            type="text"
                                            name="instructor"
                                            value={formData.instructor}
                                            onChange={handleChange}
                                            className="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                            placeholder="Enter instructor name"
                                        />
                                    </div>
                                </div>
                            </div>

                            {/* Date Information Section */}
                            <div className="mb-8">
                                <h2 className="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                    <FaCalendarAlt className="text-green-600" />
                                    Date Information
                                </h2>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label className="block text-sm font-semibold text-gray-700 mb-2">
                                            Issue Date <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="date"
                                            name="issueDate"
                                            value={formData.issueDate}
                                            onChange={handleChange}
                                            required
                                            className="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-semibold text-gray-700 mb-2">
                                            Expiry Date (Optional)
                                        </label>
                                        <input
                                            type="date"
                                            name="expiryDate"
                                            value={formData.expiryDate}
                                            onChange={handleChange}
                                            className="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                        />
                                    </div>
                                </div>
                            </div>

                            {/* Additional Information Section */}
                            <div className="mb-8">
                                <h2 className="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                    <FaFileAlt className="text-orange-600" />
                                    Additional Information
                                </h2>
                                <div>
                                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                                        Description / Notes
                                    </label>
                                    <textarea
                                        name="description"
                                        value={formData.description}
                                        onChange={handleChange}
                                        rows={4}
                                        className="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all resize-none"
                                        placeholder="Add any additional notes or description about the certificate..."
                                    />
                                </div>
                            </div>

                            {/* Form Actions */}
                            <div className="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                                <motion.button
                                    type="submit"
                                    whileHover={{ scale: 1.02 }}
                                    whileTap={{ scale: 0.98 }}
                                    className="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg hover:shadow-xl"
                                >
                                    <FaCertificate className="inline mr-2" />
                                    Create Certificate
                                </motion.button>
                                <motion.button
                                    type="button"
                                    whileHover={{ scale: 1.02 }}
                                    whileTap={{ scale: 0.98 }}
                                    onClick={() => setFormData({
                                        studentName: '',
                                        courseName: '',
                                        certificateId: '',
                                        issueDate: '',
                                        expiryDate: '',
                                        category: '',
                                        description: '',
                                        grade: '',
                                        instructor: ''
                                    })}
                                    className="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all"
                                >
                                    Reset Form
                                </motion.button>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    );
}
