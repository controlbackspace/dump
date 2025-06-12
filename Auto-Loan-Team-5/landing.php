<?php
session_start();
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarPlayLater - Turn Your Dream Car into Reality</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles/landing.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="flowing-shape">
        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,0 L100,0 L100,100 Q50,80 0,100 Z" fill="#ff4b4b" opacity="0.1" />
        </svg>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <!-- Logo placeholder -->
            <div class="logo">
                <img src="placeholder-logo.png" alt="CarPlayLater Logo">
            </div>
            <div class="nav-links">
                <a href="#services">Services</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#about">About Us</a>
                <a href="#contact">Contact</a>
                <?php if(isset($_SESSION['email'])): ?>
                <div class="user-menu" id="userMenu">
                    <div class="user-avatar" id="userMenuButton">
                        <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['firstName'].'+'.$_SESSION['lastName']; ?>&background=ff4b4b&color=fff" alt="User Avatar" id="userAvatar">
                        <span class="user-name" id="userName"><?php echo $_SESSION['firstName']; ?></span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="user-menu-content">
                        <a href="profile.html"><i class="fas fa-user"></i> Profile</a>
                        <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <a href="admin.php"><i class="fas fa-user-shield"></i> Admin Panel</a>
                        <?php endif; ?>
                        <a href="#" onclick="handleLogout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
                <?php else: ?>
                <a href="index.php" id="loginButton" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-bg-shape"></div>
    <section class="hero">
        <div class="hero-card">
            <div class="hero-content">
                <h1>Turn Your Dream Car into Reality</h1>
                <p>Apply for a car loan quickly and easily with CarPlayLater. Get approved in minutes and drive your
                    dream car today.</p>
                <a href="#apply" class="cta-button" onclick="handleApplyNow()">Apply Now</a>
            </div>
            <div class="hero-image">
                <div class="slideshow-container">
                    <div class="slide active">
                        <img src="https://images.unsplash.com/photo-1583121274602-3e2820c69888?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Luxury Car">
                    </div>
                    <div class="slide">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Sports Car">
                    </div>
                    <div class="slide">
                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Family Car">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tools & Services Section -->
    <section id="services" class="services">
        <h2>Our Services</h2>
        <div class="services-grid">
            <div class="service-card">
                <i class="fas fa-car"></i>
                <h3>Loan Application</h3>
                <p>Quick and easy online application process</p>
            </div>
            <div class="service-card">
                <i class="fas fa-chart-line"></i>
                <h3>Application Status</h3>
                <p>Real-time tracking of your loan application</p>
            </div>
            <div class="service-card">
                <i class="fas fa-history"></i>
                <h3>Loan History</h3>
                <p>Access your complete loan history anytime</p>
            </div>
            <div class="service-card">
                <i class="fas fa-headset"></i>
                <h3>Customer Support</h3>
                <p>24/7 dedicated customer support</p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works">
        <h2>How It Works</h2>
        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Create Account</h3>
                <p>Sign up and complete your profile</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Apply Online</h3>
                <p>Fill out our simple application form</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Get Approved</h3>
                <p>Quick approval process within minutes</p>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <h3>Drive Away</h3>
                <p>Get your car and start your journey</p>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="about">
        <h2>Why Choose Us</h2>
        <div class="about-content">
            <div class="about-text">
                <h3>Your Trusted Car Loan Partner</h3>
                <p>With years of experience in auto financing, we provide:</p>
                <ul>
                    <li>Competitive interest rates</li>
                    <li>Flexible repayment terms</li>
                    <li>Quick approval process</li>
                    <li>Excellent customer service</li>
                </ul>
            </div>
            <div class="about-stats">
                <div class="stat">
                    <h4>10K+</h4>
                    <p>Happy Customers</p>
                </div>
                <div class="stat">
                    <h4>98%</h4>
                    <p>Approval Rate</p>
                </div>
                <div class="stat">
                    <h4>24/7</h4>
                    <p>Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <h2>Need Help?</h2>
        <div class="contact-container">
            <div class="contact-info">
                <h3>Contact Us</h3>
                <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                <p><i class="fas fa-envelope"></i> support@carplaylater.com</p>
                <p><i class="fas fa-map-marker-alt"></i> PUP A. Mabini Campus Anonas Street, Sta. Mesa, Manila
                    Philippines 1016</p>
            </div>
            <div class="chat-widget">
                <h3>Chat with Us</h3>
                <p>Our AI assistant is ready to help</p>
                <button class="chat-button">Start Chat</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>CarPlayLater</h4>
                <p>Making car ownership dreams come true</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <a href="#services">Services</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#about">About Us</a>
                <a href="#contact">Contact</a>
            </div>
            <div class="footer-section">
                <h4>Legal</h4>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">FAQ</a>
            </div>
            <div class="footer-section">
                <h4>Connect With Us</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 CarPlayLater. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Slideshow functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');

        function showSlide(n) {
            slides.forEach(slide => slide.classList.remove('active'));
            currentSlide = (n + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        setInterval(nextSlide, 5000);

        // User menu functionality
        document.addEventListener('DOMContentLoaded', () => {
            const userMenu = document.getElementById('userMenu');
            const userMenuButton = document.getElementById('userMenuButton');
            
            if(userMenu && userMenuButton) {
                // Toggle dropdown on click
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenu.classList.toggle('active');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', (e) => {
                    if (!userMenu.contains(e.target)) {
                        userMenu.classList.remove('active');
                    }
                });

                // Prevent dropdown from closing when clicking inside
                userMenu.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }

            // Smooth scroll for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Handle logout
        function handleLogout() {
            fetch('logout.php')
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.href = 'landing.php';
                    } else {
                        alert('Error logging out: ' + data.message);
                    }
                });
        }

        // Handle Apply Now button
        function handleApplyNow() {
            <?php if(!isset($_SESSION['email'])): ?>
            // Add source parameter to indicate user came from Apply Now
            window.location.href = 'index.php?source=apply_now';
            <?php else: ?>
            window.location.href = 'loan-form.html';
            <?php endif; ?>
        }
    </script>
</body>

</html>