<?php
require_once '../vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASD Classification Research</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 80px; /* Add padding for fixed navbar */
            scroll-behavior: smooth; /* Smooth scrolling */
        }
        .navbar {
            background: rgba(255,255,255,0.1) !important;
            backdrop-filter: blur(10px);
            position: fixed !important;
            top: 0;
            width: 100%;
            z-index: 1030;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .navbar.scrolled {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        .navbar.scrolled .navbar-brand,
        .navbar.scrolled .nav-link {
            color: #333 !important;
        }
        .navbar.scrolled .nav-link:hover {
            color: #667eea !important;
        }
        .navbar.scrolled .nav-link.active {
            color: #ffd93d !important;
        }
        .navbar-brand {
            color: white !important;
            font-weight: 700;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }
        .nav-link:hover {
            color: white !important;
        }
        .nav-link.active {
            color: #ffd93d !important;
            font-weight: 600;
        }
        .hero-section {
            padding: 100px 0;
            color: white;
            text-align: center;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }
        .start-btn {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border: none;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .start-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            color: white;
            text-decoration: none;
        }
        .authors {
            margin-top: 60px;
            padding: 30px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        .author-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .author-list li {
            display: inline-block;
            margin: 0 15px;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .author-info, .affiliations, .contact-info {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 20px;
            margin: 15px 0;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .author-text {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 0;
        }
        .affiliation-text {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 0;
            opacity: 0.9;
        }
        .email-text {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 0;
        }
        .email-text a {
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .email-text a:hover {
            color: #ffd93d !important;
            text-decoration: underline;
        }
        .text-warning {
            color: #ffd93d !important;
        }
        .features {
            margin-top: 80px;
            padding: 40px 0;
        }
        .feature-card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #ffd93d;
        }
        .stats-section {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .stat-card {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin: 15px 0;
            text-align: center;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-brain"></i> ASD Classification Research
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dataset.php">Dataset</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="methodology.php">Methodology</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="results.php">Results</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="conclusion.php">Conclusion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="hero-section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">
                        <i class="fas fa-brain"></i><br>
                        Machine Learning-Based Classification<br>
                        <span style="color: #ffd93d;">of Autism Spectrum Disorder</span>
                    </h1>
                    
                    <p class="hero-subtitle">
                        Advanced classification using Decision Trees, Random Forest, and SVM with PCA dimensionality reduction and SMOTE balancing
                    </p>
                    
                    <a href="dataset.php" class="start-btn">
                        <i class="fas fa-play me-2"></i>
                        Start Presentation
                    </a>
                    
                    <div class="authors">
                        <h3 class="text-center mb-4">
                            <i class="fas fa-users"></i> Research Team
                        </h3>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="author-info text-center mb-4">
                                    <h5 class="text-white mb-3">Authors</h5>
                                    <p class="author-text">
                                        <strong>Md. Nirob Khan<sup>1</sup></strong>, 
                                        <strong>Kohbalan Moorthy<sup>1*</sup></strong>, 
                                        <strong>Mohd Arfian Ismail<sup>1</sup></strong>, 
                                        <strong>Chan Weng Howe<sup>2</sup></strong>
                                    </p>
                                </div>
                                
                                <div class="affiliations text-center mb-4">
                                    <h6 class="text-white mb-2">Affiliations</h6>
                                    <p class="affiliation-text">
                                        <sup>1</sup>Faculty of Computing, Universiti Malaysia Pahang Al-Sultan Abdullah, Pekan 26600, Malaysia.<br>
                                        <sup>2</sup>Faculty of Computing, Universiti Teknologi Malaysia, 81310 Skudai, Johor, Malaysia.
                                    </p>
                                </div>
                                
                                <div class="contact-info text-center">
                                    <h6 class="text-white mb-2">Contact Information</h6>
                                    <p class="email-text">
                                        <i class="fas fa-envelope me-2"></i>
                                        <a href="mailto:CB21127@adab.umpsa.edu.my" class="text-warning">CB21127@adab.umpsa.edu.my</a><sup>1</sup>, 
                                        <a href="mailto:kohbalan@umpsa.edu.my" class="text-warning">kohbalan@umpsa.edu.my</a><sup>1*</sup>, 
                                        <a href="mailto:arfian@umpsa.edu.my" class="text-warning">arfian@umpsa.edu.my</a><sup>1</sup>, 
                                        <a href="mailto:cwenghowe@utm.my" class="text-warning">cwenghowe@utm.my</a><sup>2</sup>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="features">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="text-center text-white mb-5">
                        <i class="fas fa-cogs"></i> Research Methodology
                    </h2>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-database"></i>
                                </div>
                                <h4>Data Preprocessing</h4>
                                <p>Cleaning, encoding, and balancing with SMOTE</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4>Dimensionality Reduction</h4>
                                <p>PCA to retain 95% variance</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <h4>ML Models</h4>
                                <p>Decision Tree, Random Forest, SVM</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h4>Evaluation</h4>
                                <p>Accuracy, Precision, Recall, F1-Score</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Results Summary Section -->
        <div class="container">
            <div class="stats-section">
                <h2 class="text-center mb-5">
                    <i class="fas fa-trophy"></i> Research Results Summary
                </h2>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="stat-card">
                            <div class="stat-number">83.33%</div>
                            <div>Best Model Accuracy</div>
                            <small>Random Forest Performance</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="stat-card">
                            <div class="stat-number">88.89%</div>
                            <div>Best F1-Score</div>
                            <small>Random Forest Model</small>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-number">2</div>
                            <div>Models Trained</div>
                            <small>Decision Tree & Random Forest</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-number">8</div>
                            <div>PCA Features</div>
                            <small>95% Variance Retained</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-number">20</div>
                            <div>Balanced Dataset</div>
                            <small>After SMOTE Processing</small>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="mb-4">
                            <i class="fas fa-chart-line"></i> Key Findings
                        </h3>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-check-circle text-success"></i> Successful Achievements</h5>
                                <ul>
                                    <li><strong>Random Forest</strong> achieved highest performance (83.33% accuracy)</li>
                                    <li><strong>SMOTE balancing</strong> successfully addressed class imbalance</li>
                                    <li><strong>PCA reduction</strong> maintained 95% variance with 8 features</li>
                                    <li><strong>Data preprocessing</strong> pipeline working effectively</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-lightbulb text-warning"></i> Research Insights</h5>
                                <ul>
                                    <li><strong>Ensemble methods</strong> outperform single decision trees</li>
                                    <li><strong>Feature engineering</strong> significantly impacts model performance</li>
                                    <li><strong>Class balancing</strong> crucial for medical datasets</li>
                                    <li><strong>Dimensionality reduction</strong> improves computational efficiency</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="results.php" class="btn btn-primary btn-lg">
                                <i class="fas fa-chart-bar me-2"></i>
                                View Detailed Results
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Project Overview Section -->
        <div class="container">
            <div class="stats-section">
                <h2 class="text-center mb-5">
                    <i class="fas fa-chart-pie"></i> Project Overview
                </h2>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number">3</div>
                            <div>ML Models</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number">5</div>
                            <div>Processing Steps</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number">95%</div>
                            <div>Variance Retained</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number">4</div>
                            <div>Evaluation Metrics</div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="mb-4">
                            <i class="fas fa-info-circle"></i> About This Research
                        </h3>
                        <p class="lead">
                            This research demonstrates the effectiveness of machine learning approaches for Autism Spectrum Disorder classification. 
                            The study implements advanced preprocessing techniques including SMOTE balancing and PCA dimensionality reduction, 
                            followed by training and evaluation of multiple ML models.
                        </p>
                        
                        <h4 class="mt-4 mb-3">Key Features:</h4>
                        <ul>
                            <li><strong>Data Preprocessing:</strong> Comprehensive cleaning, encoding, and balancing pipeline</li>
                            <li><strong>Advanced Algorithms:</strong> Decision Tree, Random Forest, and Support Vector Machine</li>
                            <li><strong>Performance Evaluation:</strong> Multiple metrics including accuracy, precision, recall, and F1-score</li>
                            <li><strong>Visualization:</strong> Interactive charts and confusion matrices</li>
                            <li><strong>Research Ready:</strong> Conference presentation interface with detailed methodology</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sticky Header JavaScript -->
    <script>
        // Sticky header effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling for navigation links
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
        
        // Active navigation highlighting
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section, .content-section');
            const navLinks = document.querySelectorAll('.nav-link');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (window.scrollY >= sectionTop - 100) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === current || 
                    (current === '' && link.getAttribute('href') === 'index.php')) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
