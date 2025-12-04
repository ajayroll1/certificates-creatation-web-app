'use client';
import React from 'react';
import { motion } from 'framer-motion';
import { FaStar, FaQuoteLeft } from 'react-icons/fa';
import Image from 'next/image';

interface Review {
    id: number;
    studentName: string;
    courseName: string;
    rating: number;
    review: string;
    avatar: string;
    date: string;
}

const Feedback: React.FC = () => {
    const reviews: Review[] = [
        {
            id: 1,
            studentName: 'Sarah Johnson',
            courseName: 'Web Development',
            rating: 5,
            review: 'This course completely transformed my understanding of web development. The instructors are amazing and the hands-on projects really helped me build a strong portfolio. Highly recommended!',
            avatar: 'https://i.pravatar.cc/150?img=1',
            date: '2 weeks ago'
        },
        {
            id: 2,
            studentName: 'Michael Chen',
            courseName: 'Data Science',
            rating: 5,
            review: 'Excellent course structure and comprehensive content. I learned Python, machine learning, and data visualization. The real-world projects were challenging but very rewarding.',
            avatar: 'https://i.pravatar.cc/150?img=12',
            date: '1 month ago'
        },
        {
            id: 3,
            studentName: 'Emily Rodriguez',
            courseName: 'UI/UX Design',
            rating: 5,
            review: 'As a beginner in design, this course was perfect. The step-by-step approach and practical exercises helped me create beautiful designs. The feedback from instructors was invaluable.',
            avatar: 'https://i.pravatar.cc/150?img=5',
            date: '3 weeks ago'
        },
        {
            id: 4,
            studentName: 'David Kumar',
            courseName: 'Programming Fundamentals',
            rating: 5,
            review: 'Great foundation course! The concepts are explained clearly and the coding exercises are well-designed. I feel confident to move on to advanced topics now.',
            avatar: 'https://i.pravatar.cc/150?img=33',
            date: '1 week ago'
        },
        {
            id: 5,
            studentName: 'Lisa Anderson',
            courseName: 'Digital Marketing',
            rating: 5,
            review: 'Practical and up-to-date content. I learned SEO, social media marketing, and analytics. The case studies were real-world examples that I could apply immediately.',
            avatar: 'https://i.pravatar.cc/150?img=47',
            date: '2 months ago'
        },
        {
            id: 6,
            studentName: 'James Wilson',
            courseName: 'Business Management',
            rating: 5,
            review: 'Outstanding course! The business strategies and management principles are taught with real examples. I\'ve already applied many concepts in my current role.',
            avatar: 'https://i.pravatar.cc/150?img=20',
            date: '3 weeks ago'
        }
    ];

    const containerVariants = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: {
                staggerChildren: 0.1
            }
        }
    };

    const cardVariants = {
        hidden: { 
            opacity: 0, 
            y: 50,
            scale: 0.9
        },
        visible: { 
            opacity: 1, 
            y: 0,
            scale: 1,
            transition: {
                duration: 0.5,
                ease: "easeOut" as const
            }
        }
    };

    return (
        <section className="relative w-full bg-gradient-to-br from-gray-50 via-white to-purple-50 py-20 px-4 overflow-hidden">
            {/* Background Decorative Elements */}
            <div className="absolute inset-0 overflow-hidden pointer-events-none">
                <div className="absolute top-20 right-10 w-72 h-72 bg-purple-200 rounded-full opacity-20 blur-3xl"></div>
                <div className="absolute bottom-20 left-10 w-96 h-96 bg-cyan-200 rounded-full opacity-15 blur-3xl"></div>
            </div>

            <div className="container mx-auto max-w-7xl relative z-10">
                {/* Header Section */}
                <motion.div
                    initial={{ opacity: 0, y: -30 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.6 }}
                    className="text-center mb-16"
                >
                    <h2 className="text-4xl md:text-5xl font-bold mb-4 text-black">
                        Student Reviews
                    </h2>
                    <p className="text-lg text-gray-600 max-w-2xl mx-auto">
                        See what our students have to say about their learning journey with us
                    </p>
                </motion.div>

                {/* Reviews Grid */}
                <motion.div
                    variants={containerVariants}
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-100px" }}
                    className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8"
                >
                    {reviews.map((review) => (
                        <motion.div
                            key={review.id}
                            variants={cardVariants}
                            whileHover={{ 
                                y: -10,
                                scale: 1.02,
                                transition: { duration: 0.3 }
                            }}
                            className="group relative"
                        >
                            <div className="relative h-full bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 overflow-hidden">
                                {/* Decorative Gradient Background */}
                                <div className="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-100 to-pink-100 rounded-bl-full opacity-50 group-hover:opacity-75 transition-opacity"></div>
                                
                                {/* Quote Icon */}
                                <div className="absolute top-4 right-4 text-purple-200 group-hover:text-purple-300 transition-colors">
                                    <FaQuoteLeft className="w-8 h-8" />
                                </div>

                                {/* Rating Stars */}
                                <div className="flex items-center gap-1 mb-4 relative z-10">
                                    {[...Array(5)].map((_, i) => (
                                        <motion.div
                                            key={i}
                                            initial={{ opacity: 0, scale: 0 }}
                                            animate={{ opacity: 1, scale: 1 }}
                                            transition={{ delay: i * 0.1, duration: 0.3 }}
                                        >
                                            <FaStar className="w-5 h-5 text-yellow-400 fill-current" />
                                        </motion.div>
                                    ))}
                                </div>

                                {/* Review Text */}
                                <p className="text-gray-700 mb-6 leading-relaxed relative z-10 line-clamp-4">
                                    {review.review}
                                </p>

                                {/* Course Badge */}
                                <div className="mb-4 relative z-10">
                                    <span className="inline-block px-3 py-1 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 text-sm font-semibold rounded-full">
                                        {review.courseName}
                                    </span>
                                </div>

                                {/* Student Info */}
                                <div className="flex items-center gap-4 relative z-10">
                                    <motion.div
                                        whileHover={{ scale: 1.1, rotate: 5 }}
                                        className="relative"
                                    >
                                        <div className="w-12 h-12 rounded-full overflow-hidden border-2 border-purple-200 group-hover:border-purple-400 transition-colors relative">
                                            <Image 
                                                src={review.avatar} 
                                                alt={review.studentName}
                                                fill
                                                className="object-cover"
                                                sizes="48px"
                                                unoptimized
                                            />
                                        </div>
                                        <div className="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                                    </motion.div>
                                    <div className="flex-1">
                                        <h4 className="font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                                            {review.studentName}
                                        </h4>
                                        <p className="text-sm text-gray-500">{review.date}</p>
                                    </div>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </motion.div>

                {/* View More Button */}
                <motion.div
                    initial={{ opacity: 0 }}
                    whileInView={{ opacity: 1 }}
                    viewport={{ once: true }}
                    transition={{ delay: 0.5, duration: 0.6 }}
                    className="text-center mt-12"
                >
                    <motion.button
                        whileHover={{ scale: 1.05 }}
                        whileTap={{ scale: 0.95 }}
                        className="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300"
                    >
                        View All Reviews
                    </motion.button>
                </motion.div>
            </div>
        </section>
    );
};

export default Feedback;

