'use client';
import React, { useState, useEffect } from 'react';
import Image from 'next/image';

const Counter: React.FC<{ target: number; duration?: number }> = ({ target, duration = 2000 }) => {
    const [count, setCount] = useState(0);

    useEffect(() => {
        let startTime: number;
        let animationFrame: number;

        const animate = (currentTime: number) => {
            if (!startTime) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            
            // Easing function for smooth animation
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const currentCount = Math.floor(easeOutQuart * target);
            
            setCount(currentCount);

            if (progress < 1) {
                animationFrame = requestAnimationFrame(animate);
            } else {
                setCount(target);
            }
        };

        animationFrame = requestAnimationFrame(animate);

        return () => {
            if (animationFrame) {
                cancelAnimationFrame(animationFrame);
            }
        };
    }, [target, duration]);

    return <span>{count}+</span>;
};

const Hero: React.FC = () => {
    return (
        <section className="relative min-h-[70vh] bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 overflow-hidden">
            {/* Background Wavy Shapes */}
            <div className="absolute inset-0 overflow-hidden">
                <div className="absolute top-20 left-10 w-96 h-96 bg-lime-400 rounded-full opacity-20 blur-3xl"></div>
                <div className="absolute bottom-20 right-10 w-96 h-96 bg-purple-400 rounded-full opacity-30 blur-3xl"></div>
                <div className="absolute top-1/2 left-1/4 w-72 h-72 bg-lime-300 rounded-full opacity-15 blur-2xl"></div>
            </div>

            <div className="container mx-auto px-4 pt-7 pb-20 relative z-10">
                <div className="grid md:grid-cols-2 gap-12 items-center">
                    {/* Left Content */}
                    <div className="text-white space-y-8 -mt-[10px]">
                        <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                            International Certificate{' '}
                            <span className="relative inline-block">
                                Board
                                <svg className="absolute -bottom-2 left-0 w-full h-4 text-lime-400" viewBox="0 0 200 20" preserveAspectRatio="none">
                                    <path d="M0,15 Q50,5 100,10 T200,8" stroke="currentColor" strokeWidth="3" fill="none" strokeLinecap="round"/>
                                </svg>
                            </span>
                        </h1>
                        <h2 className="text-4xl md:text-5xl font-bold">
                            of World Organization
                        </h2>
                        <p className="text-lg md:text-xl text-purple-100 leading-relaxed max-w-lg">
                            Get globally recognized certificates that validate your skills and achievements, making every opportunity easier and more accessible.
                        </p>
                        
                        {/* Call to Action Buttons */}
                        <div className="flex items-center gap-4">
                            <button className="bg-lime-400 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-lime-300 transition-colors shadow-lg">
                                Read more
                            </button>
                            <button className="w-14 h-14 bg-purple-500 rounded-full flex items-center justify-center hover:bg-purple-400 transition-colors shadow-lg">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {/* Right Content - Image and Statistics */}
                    <div className="relative">
                        {/* Large Green Circle Background */}
                        <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-lime-400 rounded-full opacity-30 blur-2xl"></div>
                        
                        {/* Statistics Card */}
                        <div className="absolute top-10 left-0 bg-white/90 backdrop-blur-md rounded-2xl p-6 shadow-2xl z-20 max-w-xs">
                            <div className="text-lime-600 text-5xl font-bold mb-2">
                                <Counter target={489} duration={2000} />
                            </div>
                            <p className="text-gray-700 text-sm mb-4">
                                More than 489 students have been trained at our organization.
                            </p>
                            <div className="flex -space-x-3">
                                <div className="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white"></div>
                                <div className="w-10 h-10 rounded-full bg-gradient-to-br from-lime-400 to-lime-600 border-2 border-white"></div>
                                <div className="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-white"></div>
                            </div>
                        </div>

                        {/* Pinterest Style Grid with Scroll */}
                        <div className="relative z-10 mt-20">
                            <div className="bg-white/10 backdrop-blur-sm rounded-3xl p-4 border border-white/20 shadow-2xl">
                                <div className="relative h-[600px] overflow-hidden rounded-2xl">
                                    {/* Fade overlay at top */}
                                    <div className="absolute top-0 left-0 right-0 h-20 bg-gradient-to-b from-purple-700/80 to-transparent z-30 pointer-events-none"></div>
                                    
                                    {/* Fade overlay at bottom */}
                                    <div className="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-purple-700/80 to-transparent z-30 pointer-events-none"></div>
                                    
                                    {/* Scrolling Pinterest Grid */}
                                    <div className="absolute inset-0 overflow-hidden">
                                        <div className="flex gap-3 animate-scroll-up h-[200%]" style={{ width: '100%' }}>
                                            {/* Column 1 */}
                                            <div className="flex flex-col gap-3 flex-1">
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[3/4]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=600&fit=crop&q=80"
                                                            alt="Education Course 1"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[4/5]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=500&fit=crop&q=80"
                                                            alt="Education Course 4"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[3/4]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=400&h=600&fit=crop&q=80"
                                                            alt="Education Course 5"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[4/5]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=500&fit=crop&q=80"
                                                            alt="Education Course 2"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {/* Column 2 */}
                                            <div className="flex flex-col gap-3 flex-1">
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[4/5]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=500&fit=crop&q=80"
                                                            alt="Education Course 2"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[3/4]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=600&fit=crop&q=80"
                                                            alt="Education Course 3"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[4/5]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=500&fit=crop&q=80"
                                                            alt="Education Course 1"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[3/4]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=600&fit=crop&q=80"
                                                            alt="Education Course 4"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {/* Column 3 */}
                                            <div className="flex flex-col gap-3 flex-1">
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[3/4]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=600&fit=crop&q=80"
                                                            alt="Education Course 4"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[4/5]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=500&fit=crop&q=80"
                                                            alt="Education Course 2"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[3/4]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=600&fit=crop&q=80"
                                                            alt="Education Course 3"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                                
                                                <div className="relative rounded-2xl overflow-hidden">
                                                    <div className="relative aspect-[4/5]">
                                                        <Image
                                                            src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=400&h=500&fit=crop&q=80"
                                                            alt="Education Course 5"
                                                            fill
                                                            className="object-cover rounded-2xl hover:scale-105 transition-transform duration-300"
                                                            sizes="(max-width: 768px) 33vw, 200px"
                                                            unoptimized
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default Hero;

