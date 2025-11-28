<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICBWO - International Certificate Board of World Organization | Certificate Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #2563eb;
            --gold-color: #f59e0b;
            --dark-blue: #1e3a8a;
            --light-blue: #dbeafe;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --white: #ffffff;
            --gradient-primary: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            --gradient-gold: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 25px 80px rgba(0, 0, 0, 0.2);
        }
        
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: var(--text-dark);
            overflow-x: hidden;
        }
        
        /* Header/Navigation */
        .navbar {
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand i {
            color: var(--gold-color);
            font-size: 1.8rem;
        }
        
        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        /* Hero Section */
        .hero-section {
            background: var(--gradient-primary);
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            color: var(--white);
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 300;
            margin-bottom: 40px;
            opacity: 0.95;
        }
        
        .company-name {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--gold-color);
            margin-bottom: 10px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
        }
        
        /* Verification Card */
        .verification-card {
            background: var(--white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-xl);
            margin-top: 40px;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-title i {
            color: var(--gold-color);
            font-size: 2rem;
        }
        
        .card-subtitle {
            color: var(--text-light);
            margin-bottom: 30px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
            font-size: 1rem;
        }
        
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
            outline: none;
        }
        
        .btn-verify {
            background: var(--gradient-primary);
            border: none;
            border-radius: 12px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--white);
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(30, 64, 175, 0.4);
            margin-top: 10px;
        }
        
        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.5);
            color: var(--white);
        }
        
        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: var(--white);
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        .section-subtitle {
            text-align: center;
            color: var(--text-light);
            font-size: 1.1rem;
            margin-bottom: 60px;
        }
        
        .feature-card {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            height: 100%;
            border: 2px solid transparent;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-color);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--white);
            box-shadow: 0 5px 15px rgba(30, 64, 175, 0.3);
        }
        
        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .feature-description {
            color: var(--text-light);
            line-height: 1.6;
        }
        
        /* About Section */
        .about-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
        }
        
        .about-content {
            background: var(--white);
            border-radius: 20px;
            padding: 50px;
            box-shadow: var(--shadow-lg);
        }
        
        .about-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        .about-text {
            color: var(--text-light);
            line-height: 1.8;
            font-size: 1.05rem;
            margin-bottom: 20px;
        }
        
        .highlight {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 60px 0;
            background: var(--gradient-primary);
            color: var(--white);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Footer */
        .footer {
            background: var(--dark-blue);
            color: var(--white);
            padding: 40px 0 20px;
        }
        
        .footer-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .footer-text {
            opacity: 0.8;
            line-height: 1.8;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: var(--white);
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s;
        }
        
        .footer-links a:hover {
            opacity: 1;
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
        }
        
        /* Loading Animation */
        .loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .company-name {
                font-size: 1.4rem;
            }
            
            .verification-card {
                padding: 30px 20px;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .about-content {
                padding: 30px 20px;
            }
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-certificate"></i>
                <span>ICBWO</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#verify">Verify</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/" style="color: var(--primary-color) !important; font-weight: 600;">
                            <i class="fas fa-user-shield me-1"></i>Admin Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="fas fa-shield-alt me-2"></i>Official Verification Portal
                        </div>
                        <div class="company-name">International Certificate Board of World Organization</div>
                        <h1 class="hero-title">Verify Your Certificate</h1>
                        <p class="hero-subtitle">Instantly verify the authenticity of your professional certificates issued by ICBWO. Our secure verification system ensures 100% accuracy and reliability.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="verification-card" id="verify">
                        <h2 class="card-title">
                            <i class="fas fa-search"></i>
                            Certificate Verification
                        </h2>
                        <p class="card-subtitle">Enter your certificate number to verify its authenticity</p>
                        <form id="verifyForm" action="verify.php" method="GET">
                            <div class="mb-3">
                                <label for="certificateNumber" class="form-label">
                                    Certificate Number
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="certificateNumber" 
                                    name="number" 
                                    placeholder="Enter certificate number (e.g., CERT-2025-00123)"
                                    required
                                    autocomplete="off"
                                >
                            </div>
                            <button type="submit" class="btn btn-verify">
                                <i class="fas fa-search me-2"></i>Verify Certificate
                            </button>
                            <div class="loading" id="loading">
                                <div class="spinner"></div>
                                <p class="mt-2 text-muted">Verifying certificate...</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose ICBWO?</h2>
            <p class="section-subtitle">Trusted by professionals worldwide for authentic certification</p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Secure & Verified</h3>
                        <p class="feature-description">All certificates are encrypted and stored securely. Our verification system ensures 100% authenticity.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="feature-title">Instant Verification</h3>
                        <p class="feature-description">Get instant results within seconds. No waiting time, no delays. Verify your certificate immediately.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3 class="feature-title">Global Recognition</h3>
                        <p class="feature-description">ICBWO certificates are recognized worldwide. Your achievements are validated internationally.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="feature-title">100% Accurate</h3>
                        <p class="feature-description">Our database is regularly updated and maintained to ensure complete accuracy of all records.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3 class="feature-title">Privacy Protected</h3>
                        <p class="feature-description">Your personal information is protected. We follow strict privacy policies and data security standards.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3 class="feature-title">Professional Standards</h3>
                        <p class="feature-description">ICBWO maintains the highest professional standards in certification and verification processes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="about-content">
                        <h2 class="about-title">About International Certificate Board of World Organization (ICBWO)</h2>
                        <p class="about-text">
                            The <span class="highlight">International Certificate Board of World Organization (ICBWO)</span> is a globally recognized authority dedicated to providing authentic, verifiable professional certifications. We serve professionals, organizations, and institutions worldwide, ensuring that every certificate issued meets the highest standards of quality and authenticity.
                        </p>
                        <p class="about-text">
                            Our mission is to bridge the gap between professional achievements and global recognition. Through our advanced verification system, employers, educational institutions, and organizations can instantly verify the authenticity of certificates, fostering trust and transparency in professional credentials.
                        </p>
                        <p class="about-text">
                            With a commitment to excellence, security, and innovation, ICBWO continues to set the benchmark for certificate verification systems worldwide. Every certificate in our database is encrypted, secure, and instantly verifiable, providing peace of mind to both certificate holders and verifiers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">100K+</div>
                        <div class="stat-label">Certificates Issued</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Countries Served</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">99.9%</div>
                        <div class="stat-label">Accuracy Rate</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Verification Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h3 class="footer-title">
                        <i class="fas fa-certificate me-2"></i>ICBWO
                    </h3>
                    <p class="footer-text">
                        International Certificate Board of World Organization - Your trusted partner in professional certification and verification.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#home"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                        <li><a href="#verify"><i class="fas fa-chevron-right me-2"></i>Verify Certificate</a></li>
                        <li><a href="#about"><i class="fas fa-chevron-right me-2"></i>About Us</a></li>
                        <li><a href="#features"><i class="fas fa-chevron-right me-2"></i>Features</a></li>
                        <li><a href="admin/"><i class="fas fa-chevron-right me-2"></i>Admin Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h3 class="footer-title">Contact</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope me-2"></i>info@icbwo.org</li>
                        <li><i class="fas fa-phone me-2"></i>+1 (555) 123-4567</li>
                        <li><i class="fas fa-globe me-2"></i>www.icbwo.org</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> International Certificate Board of World Organization (ICBWO). All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form submission handling
        document.getElementById('verifyForm').addEventListener('submit', function(e) {
            const loading = document.getElementById('loading');
            const btn = document.querySelector('.btn-verify');
            const input = document.getElementById('certificateNumber');
            
            if (input.value.trim() === '') {
                e.preventDefault();
                alert('Please enter a certificate number');
                return;
            }
            
            loading.style.display = 'block';
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
        });

        // Smooth scrolling
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
    </script>
</body>
</html>
