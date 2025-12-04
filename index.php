<?php
// Simple PHP for dynamic content
$siteName = "International Certificate Board of World Organization";
$siteNameShort = "ICBWO";
$tagline = "Global Certification Authority - Verifying Excellence Worldwide";
$totalCourses = 5000;
$totalStudents = 100000;
$totalInstructors = 500;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteNameShort; ?> - International Certificate Board</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            padding: 1rem 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #5624d0;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #5624d0;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login {
            background: transparent;
            color: #5624d0;
            border: 1px solid #5624d0;
        }

        .btn-login:hover {
            background: #5624d0;
            color: #fff;
        }

        .btn-signup {
            background: #5624d0;
            color: #fff;
        }

        .btn-signup:hover {
            background: #4a1fb8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(86, 36, 208, 0.3);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.85) 0%, rgba(118, 75, 162, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1920&q=90') center/cover no-repeat;
            color: #fff;
            padding: 150px 2rem 100px;
            text-align: center;
            margin-top: 70px;
            position: relative;
            background-attachment: fixed;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            animation: fadeInUp 1s;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: fadeInUp 1s 0.2s both;
        }

        .search-box {
            max-width: 600px;
            margin: 2rem auto;
            display: flex;
            background: #fff;
            border-radius: 50px;
            padding: 0.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            animation: fadeInUp 1s 0.4s both;
        }

        .search-box input {
            flex: 1;
            border: none;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            outline: none;
            border-radius: 50px;
        }

        .search-box button {
            background: #5624d0;
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-box button:hover {
            background: #4a1fb8;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
            animation: fadeInUp 1s 0.6s both;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Features Section */
        .features {
            padding: 80px 2rem;
            background: #f7f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #1c1d1f;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #1c1d1f;
        }

        .feature-card p {
            color: #6a6f73;
            line-height: 1.8;
        }

        /* Courses Section */
        .courses {
            padding: 80px 2rem;
            background: #fff;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .course-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .course-image {
            width: 100%;
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .course-card:hover .course-image img {
            transform: scale(1.1);
        }

        .course-image img[loading="lazy"] {
            opacity: 0;
            animation: fadeIn 0.5s ease-in forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .course-content {
            padding: 1.5rem;
        }

        .course-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1c1d1f;
        }

        .course-instructor {
            color: #6a6f73;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .stars {
            color: #f3ca8c;
        }

        .course-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #5624d0;
        }

        /* Testimonials */
        .testimonials {
            padding: 80px 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .testimonial-text {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            margin-bottom: 0.2rem;
        }

        .author-info p {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        /* Footer */
        footer {
            background: #1c1d1f;
            color: #fff;
            padding: 60px 2rem 50px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-section h3 {
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
        }

        .footer-section a {
            color: #cec0fc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #fff;
        }

        .footer-bottom {
            text-align: center;
            padding: 2rem 0 1rem;
            border-top: 1px solid #3e4143;
            color: #cec0fc;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1rem;
            }

            .nav-links {
                display: none;
            }

            .nav-buttons {
                gap: 0.5rem;
            }

            .nav-buttons .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .logo {
                font-size: 1.5rem;
            }

            .hero {
                padding: 120px 1rem 60px;
                margin-top: 60px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 1.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .search-box {
                flex-direction: column;
                border-radius: 8px;
                margin: 1.5rem auto;
            }

            .search-box input {
                padding: 0.875rem 1rem;
                font-size: 0.95rem;
            }

            .search-box button {
                border-radius: 8px;
                padding: 0.875rem 1.5rem;
                width: 100%;
            }

            .section-title {
                font-size: 1.75rem;
                margin-bottom: 2rem;
            }

            .features {
                padding: 60px 1rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .courses {
                padding: 60px 1rem;
            }

            .courses-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .testimonials {
                padding: 60px 1rem;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            footer {
                padding: 40px 1rem 40px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            /* Hide popup on mobile */
            .verify-modal {
                display: none !important;
            }

            .verify-modal.active {
                display: none !important;
            }

            .verify-content {
                max-width: calc(100% - 30px);
                width: 100%;
                margin: 0 auto;
                position: relative;
                left: auto;
                right: auto;
                transform: none;
            }

            .verify-header {
                padding: 1.25rem 1.5rem 1rem;
            }

            .verify-header h2 {
                font-size: 1.25rem;
            }

            .verify-icon {
                width: 60px;
                height: 60px;
                line-height: 60px;
                font-size: 2.5rem;
                margin-bottom: 0.5rem;
            }

            .verify-body {
                padding: 1.25rem 1.5rem;
            }

            .verify-info-row {
                flex-direction: column;
                gap: 0.5rem;
                padding: 1rem;
            }

            .verify-label {
                font-size: 0.85rem;
            }

            .verify-value {
                text-align: left;
                font-size: 0.9rem;
            }

            .verify-footer {
                padding: 1rem 1.5rem 1.25rem;
            }

            .close-verify {
                width: 100%;
                padding: 0.875rem;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                padding: 0 0.75rem;
            }

            .nav-buttons {
                flex-direction: row;
                width: auto;
                margin-top: 0;
                gap: 0.4rem;
            }

            .nav-buttons .btn {
                width: auto;
                padding: 0.35rem 0.7rem;
                font-size: 0.75rem;
                text-align: center;
            }

            .hero {
                padding: 100px 0.75rem 50px;
            }

            .hero h1 {
                font-size: 1.75rem;
            }

            .hero p {
                font-size: 0.95rem;
            }

            .stat-number {
                font-size: 1.75rem;
            }

            .stat-label {
                font-size: 0.85rem;
            }

            .section-title {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .course-card {
                margin-bottom: 1rem;
            }

            /* Hide popup on mobile */
            .verify-modal {
                display: none !important;
            }

            .verify-modal.active {
                display: none !important;
            }
        }

        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s, transform 0.6s;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Certificate Verification Modal */
        .verify-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.85);
            backdrop-filter: blur(4px);
            overflow-y: auto;
            padding: 20px;
        }

        .verify-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .verify-content {
            background: #ffffff;
            max-width: 580px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.1);
            position: relative;
            animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .verify-header {
            padding: 1.5rem 2rem 1.25rem;
            text-align: center;
            background: #2563eb;
            color: #ffffff;
        }

        .verify-header.verified {
            background: #2563eb;
            color: #ffffff;
        }

        .verify-header.not-found {
            background: #2563eb;
            color: #ffffff;
        }

        .verify-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .verify-icon {
            font-size: 3rem;
            margin-bottom: 0.75rem;
            display: inline-block;
            width: 70px;
            height: 70px;
            line-height: 70px;
            border-radius: 50%;
            background: #ffffff;
            animation: tickAnimation 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes tickAnimation {
            0% {
                transform: scale(0) rotate(-45deg);
                opacity: 0;
            }
            50% {
                transform: scale(1.2) rotate(5deg);
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        .verify-header.verified .verify-icon {
            background: #ffffff;
            color: #28a745;
        }

        .verify-header.not-found .verify-icon {
            background: #ffffff;
            color: #dc3545;
        }

        .verify-body {
            padding: 1.5rem 2rem;
            background: #ffffff;
        }

        .verify-info {
            margin-bottom: 1.25rem;
        }

        .verify-info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.875rem 1.25rem;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .verify-info-row:hover {
            background: #f1f3f5;
            border-color: #dee2e6;
        }

        .verify-label {
            font-weight: 500;
            color: #6a6f73;
            font-size: 0.9rem;
            letter-spacing: 0.2px;
        }

        .verify-value {
            color: #1c1d1f;
            text-align: right;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .verify-badge {
            background: #2563eb;
            padding: 0.875rem 1.5rem;
            border-radius: 8px;
            text-align: center;
            color: #ffffff;
            font-weight: 500;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            margin-top: 0.25rem;
        }

        .verify-badge.verified {
            background: #2563eb;
            color: #ffffff;
        }

        .verify-badge.verified::before {
            content: "✓ ";
            color: #28a745;
            font-weight: 700;
            margin-right: 0.5rem;
        }

        .verify-footer {
            padding: 1.25rem 2rem 1.5rem;
            border-top: 1px solid #e9ecef;
            text-align: center;
            background: #ffffff;
        }

        .close-verify {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
            min-width: 120px;
        }

        .close-verify:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .close-verify:active {
            transform: translateY(0);
        }

        .not-found-message {
            text-align: center;
            padding: 1.5rem 0;
            color: #6a6f73;
        }

        .not-found-message h3 {
            color: #1c1d1f;
            margin-bottom: 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .not-found-message p {
            color: #6a6f73;
            line-height: 1.6;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Learn without limits</h1>
            <p><?php echo $tagline; ?></p>
            <div class="search-box">
                <input type="text" placeholder="Enter Certificate Number to Verify (e.g., CERT-XXXXX)" id="searchInput">
                <button onclick="handleSearch()">Verify Certificate</button>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format($totalCourses); ?>+</span>
                    <span class="stat-label">Courses</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format($totalStudents); ?>+</span>
                    <span class="stat-label">Students</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format($totalInstructors); ?>+</span>
                    <span class="stat-label">Instructors</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose Us?</h2>
            <div class="features-grid">
                <div class="feature-card fade-in">
                    <div class="feature-icon">🎓</div>
                    <h3>Expert Instructors</h3>
                    <p>Learn from industry experts and professionals who bring real-world experience to every course.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">⏱️</div>
                    <h3>Learn at Your Pace</h3>
                    <p>Study on your own schedule with lifetime access to course materials and resources.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">💼</div>
                    <h3>Career-Focused</h3>
                    <p>Get job-ready skills with courses designed to help you advance in your career.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">📱</div>
                    <h3>Learn Anywhere</h3>
                    <p>Access courses on any device - desktop, tablet, or mobile - wherever you are.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">🏆</div>
                    <h3>Certificates</h3>
                    <p>Earn certificates of completion to showcase your new skills to employers.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">💬</div>
                    <h3>Community Support</h3>
                    <p>Join a community of learners and get help from instructors and peers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="courses" id="courses">
        <div class="container">
            <h2 class="section-title">Popular Courses</h2>
            <div class="courses-grid">
                <div class="course-card fade-in">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80" alt="Web Development" loading="lazy">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Complete Web Development Bootcamp</h3>
                        <p class="course-instructor">By John Smith</p>
                        <div class="course-rating">
                            <span class="stars">★★★★★</span>
                            <span>4.8 (12,345)</span>
                        </div>
                        <div class="course-price">$89.99</div>
                    </div>
                </div>
                <div class="course-card fade-in">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80" alt="Data Science" loading="lazy">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Data Science & Machine Learning</h3>
                        <p class="course-instructor">By Sarah Johnson</p>
                        <div class="course-rating">
                            <span class="stars">★★★★★</span>
                            <span>4.9 (8,234)</span>
                        </div>
                        <div class="course-price">$94.99</div>
                    </div>
                </div>
                <div class="course-card fade-in">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&q=80" alt="UI/UX Design" loading="lazy">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">UI/UX Design Masterclass</h3>
                        <p class="course-instructor">By Emily Davis</p>
                        <div class="course-rating">
                            <span class="stars">★★★★☆</span>
                            <span>4.7 (6,789)</span>
                        </div>
                        <div class="course-price">$79.99</div>
                    </div>
                </div>
                <div class="course-card fade-in">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80" alt="Mobile App Development" loading="lazy">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Mobile App Development</h3>
                        <p class="course-instructor">By Michael Brown</p>
                        <div class="course-rating">
                            <span class="stars">★★★★★</span>
                            <span>4.8 (9,876)</span>
                        </div>
                        <div class="course-price">$84.99</div>
                    </div>
                </div>
                <div class="course-card fade-in">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&q=80" alt="Cybersecurity" loading="lazy">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Cybersecurity Fundamentals</h3>
                        <p class="course-instructor">By David Wilson</p>
                        <div class="course-rating">
                            <span class="stars">★★★★★</span>
                            <span>4.9 (5,432)</span>
                        </div>
                        <div class="course-price">$99.99</div>
                    </div>
                </div>
                <div class="course-card fade-in">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&q=80" alt="Cloud Computing" loading="lazy">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Cloud Computing & AWS</h3>
                        <p class="course-instructor">By Lisa Anderson</p>
                        <div class="course-rating">
                            <span class="stars">★★★★☆</span>
                            <span>4.7 (7,654)</span>
                        </div>
                        <div class="course-price">$89.99</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <h2 class="section-title" style="color: #fff;">What Our Students Say</h2>
            <div class="testimonials-grid">
                <div class="testimonial-card fade-in">
                    <p class="testimonial-text">"This platform changed my career completely. The courses are well-structured and the instructors are amazing!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80" alt="Rajesh Kumar" loading="lazy">
                        </div>
                        <div class="author-info">
                            <h4>Rajesh Kumar</h4>
                            <p>Software Engineer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card fade-in">
                    <p class="testimonial-text">"I've learned so much in just a few months. The flexibility to learn at my own pace is perfect for my schedule."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&q=80" alt="Priya Sharma" loading="lazy">
                        </div>
                        <div class="author-info">
                            <h4>Priya Sharma</h4>
                            <p>Data Analyst</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card fade-in">
                    <p class="testimonial-text">"Best investment I've made in my education. The quality of content is outstanding and worth every penny."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80" alt="Amit Verma" loading="lazy">
                        </div>
                        <div class="author-info">
                            <h4>Amit Verma</h4>
                            <p>Web Developer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Certificate Verification Modal -->
    <div id="verifyModal" class="verify-modal">
        <div class="verify-content">
            <div id="verifyHeader" class="verify-header"></div>
            <div id="verifyBody" class="verify-body"></div>
            <div id="verifyFooter" class="verify-footer"></div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Certificate Verification functionality
        function handleSearch() {
            const searchInput = document.getElementById('searchInput');
            const certificateId = searchInput.value.trim().toUpperCase();
            
            if (!certificateId) {
                alert('Please enter a certificate number');
                return;
            }

            // Show loading
            showVerifyModal('loading', null);

            // Fetch certificate data
            fetch(`api/verify_certificate.php?certificate_id=${encodeURIComponent(certificateId)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.verified) {
                        showVerifyModal('verified', data.data);
                    } else {
                        showVerifyModal('not-found', null);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showVerifyModal('not-found', null);
                });
        }

        function showVerifyModal(type, data) {
            const modal = document.getElementById('verifyModal');
            const header = document.getElementById('verifyHeader');
            const body = document.getElementById('verifyBody');
            const footer = document.getElementById('verifyFooter');

            modal.classList.add('active');

            if (type === 'loading') {
                header.className = 'verify-header';
                header.innerHTML = '<div class="verify-icon">⏳</div><h2>Verifying Certificate</h2>';
                body.innerHTML = '<div style="text-align: center; padding: 2.5rem; color: #6a6f73; font-size: 0.95rem;">Please wait while we verify your certificate...</div>';
                footer.innerHTML = '';
                return;
            }

            if (type === 'verified' && data) {
                header.className = 'verify-header verified';
                header.innerHTML = '<div class="verify-icon">✓</div><h2>Certificate Verified</h2>';

                const startDate = new Date(data.starting_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                const completionDate = new Date(data.completion_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                const issueDate = new Date(data.issue_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                body.innerHTML = `
                    <div class="verify-info">
                        <div class="verify-info-row">
                            <span class="verify-label">Certificate Number</span>
                            <span class="verify-value">${data.certificate_id}</span>
                        </div>
                        <div class="verify-info-row">
                            <span class="verify-label">Student Name</span>
                            <span class="verify-value">${data.student_name}</span>
                        </div>
                        <div class="verify-info-row">
                            <span class="verify-label">Course Name</span>
                            <span class="verify-value">${data.course_name}</span>
                        </div>
                        <div class="verify-info-row">
                            <span class="verify-label">Course Duration</span>
                            <span class="verify-value">${startDate} to ${completionDate}</span>
                        </div>
                        <div class="verify-info-row">
                            <span class="verify-label">Issue Date</span>
                            <span class="verify-value">${issueDate}</span>
                        </div>
                    </div>
                    <div class="verify-badge verified">
                        This certificate is verified and authentic
                    </div>
                `;

                footer.innerHTML = '<button class="close-verify" onclick="closeVerifyModal()">Close</button>';
            } else if (type === 'not-found') {
                header.className = 'verify-header not-found';
                header.innerHTML = '<div class="verify-icon">✗</div><h2>Certificate Not Found</h2>';

                body.innerHTML = `
                    <div class="not-found-message">
                        <h3>Certificate Not Verified</h3>
                        <p>The certificate number you entered does not exist in our database.</p>
                        <p style="color: #6a6f73; margin-top: 1rem;">Please check the certificate number and try again.</p>
                    </div>
                `;

                footer.innerHTML = '<button class="close-verify" onclick="closeVerifyModal()">Close</button>';
            }
        }

        function closeVerifyModal() {
            document.getElementById('verifyModal').classList.remove('active');
            document.getElementById('searchInput').value = '';
        }

        // Enter key search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleSearch();
            }
        });

        // Close modal on outside click
        window.onclick = function(event) {
            const modal = document.getElementById('verifyModal');
            if (event.target == modal) {
                closeVerifyModal();
            }
        }

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Navbar scroll effect
        let lastScroll = 0;
        const nav = document.querySelector('nav');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
            } else {
                nav.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
            
            lastScroll = currentScroll;
        });

        // Course card click handler
        document.querySelectorAll('.course-card').forEach(card => {
            card.addEventListener('click', function() {
                const courseTitle = this.querySelector('.course-title').textContent;
                alert('You clicked on: ' + courseTitle);
                // You can add navigation to course detail page here
            });
        });

        // Button hover effects
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Stats counter animation
        function animateCounter(element, target, duration = 2000) {
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = Math.floor(target).toLocaleString() + '+';
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString() + '+';
                }
            }, 16);
        }

        // Animate stats when hero section is visible
        const statsObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const target = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
                        animateCounter(stat, target);
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const heroStats = document.querySelector('.hero-stats');
        if (heroStats) {
            statsObserver.observe(heroStats);
        }
    </script>
</body>
</html>

