<?php
require_once '../vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Methodology - ASD Classification</title>
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
        .content-section {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .methodology-flow {
            position: relative;
            padding: 40px 0;
        }
        .flow-step {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            text-align: center;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .flow-step::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-top: 15px solid #764ba2;
        }
        .flow-step:last-child::after {
            display: none;
        }
        .step-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ffd93d;
        }
        .step-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .step-description {
            font-size: 1rem;
            opacity: 0.9;
        }
        .technical-details {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
        }
        .detail-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid #667eea;
        }
        .detail-title {
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }
        .algorithm-box {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            text-align: center;
        }
        .algorithm-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .evaluation-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .metric-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            border-top: 4px solid #667eea;
        }
        .metric-title {
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }
        .metric-formula {
            font-family: 'Courier New', monospace;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.9rem;
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dataset.php">Dataset</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="methodology.php">Methodology</a>
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

    <div class="container">
        <div class="content-section">
            <h1 class="text-center mb-5">
                <i class="fas fa-cogs"></i> Research Methodology
            </h1>
            
            <div class="methodology-flow">
                <div class="flow-step">
                    <div class="step-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="step-title">Data Collection & Merging</div>
                    <div class="step-description">
                        Combine train.csv and test.csv datasets into a unified dataset for analysis
                    </div>
                </div>
                
                <div class="flow-step">
                    <div class="step-icon">
                        <i class="fas fa-broom"></i>
                    </div>
                    <div class="step-title">Data Cleaning</div>
                    <div class="step-description">
                        Handle missing values, remove duplicates, and ensure data quality
                    </div>
                </div>
                
                <div class="flow-step">
                    <div class="step-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="step-title">Feature Encoding</div>
                    <div class="step-description">
                        Convert categorical variables to numerical using one-hot encoding
                    </div>
                </div>
                
                <div class="flow-step">
                    <div class="step-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <div class="step-title">Class Balancing</div>
                    <div class="step-description">
                        Apply SMOTE (Synthetic Minority Oversampling Technique) to balance classes
                    </div>
                </div>
                
                <div class="flow-step">
                    <div class="step-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="step-title">Dimensionality Reduction</div>
                    <div class="step-description">
                        Apply PCA to reduce features while retaining 95% variance
                    </div>
                </div>
                
                <div class="flow-step">
                    <div class="step-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="step-title">Model Training</div>
                    <div class="step-description">
                        Train Decision Tree, Random Forest, and Extreme Gradient Boosting (XGBoost) models
                    </div>
                </div>
                
                <div class="flow-step">
                    <div class="step-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="step-title">Model Evaluation</div>
                    <div class="step-description">
                        Evaluate using cross-validation and multiple metrics
                    </div>
                </div>
            </div>
            
            <!-- Technical Details -->
            <div class="technical-details">
                <h3 class="mb-4">
                    <i class="fas fa-info-circle"></i> Technical Implementation Details
                </h3>
                
                <div class="detail-item">
                    <div class="detail-title">SMOTE Implementation</div>
                    <p>Custom SMOTE-like algorithm that generates synthetic samples for minority classes by adding small random noise to existing samples, ensuring balanced class distribution.</p>
                </div>
                
                <div class="detail-item">
                    <div class="detail-title">PCA Algorithm</div>
                    <p>Principal Component Analysis implementation that calculates covariance matrix, eigenvalues, and eigenvectors to reduce dimensions while preserving 95% of the original variance.</p>
                </div>
                
                <div class="detail-item">
                    <div class="detail-title">Cross-Validation</div>
                    <p>Stratified k-fold cross-validation (k=5) to ensure robust model evaluation and prevent overfitting.</p>
                </div>
            </div>
            
            <!-- Machine Learning Algorithms -->
            <h3 class="mb-4">
                <i class="fas fa-robot"></i> Machine Learning Algorithms
            </h3>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="algorithm-box">
                        <div class="algorithm-icon">
                            <i class="fas fa-tree"></i>
                        </div>
                        <h4>Decision Tree (CART)</h4>
                        <p>Classification and Regression Trees algorithm for interpretable decision boundaries</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="algorithm-box">
                        <div class="algorithm-icon">
                            <i class="fas fa-forest"></i>
                        </div>
                        <h4>Random Forest</h4>
                        <p>Ensemble of 10 decision trees with bootstrap sampling and majority voting</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="algorithm-box">
                        <div class="algorithm-icon">
                            <i class="fas fa-vector-square"></i>
                        </div>
                                                  <h4>Extreme Gradient Boosting (XGBoost)</h4>
                        <p>Extreme Gradient Boosting (XGBoost) with optimized hyperparameters for advanced ensemble learning</p>
                    </div>
                </div>
            </div>
            
            <!-- Evaluation Metrics -->
            <h3 class="mb-4">
                <i class="fas fa-chart-line"></i> Evaluation Metrics
            </h3>
            
            <div class="evaluation-metrics">
                <div class="metric-card">
                    <div class="metric-title">Accuracy</div>
                    <div class="metric-formula">(TP + TN) / (TP + TN + FP + FN)</div>
                    <p class="mt-2">Overall correctness of predictions</p>
                </div>
                
                <div class="metric-card">
                    <div class="metric-title">Precision</div>
                    <div class="metric-formula">TP / (TP + FP)</div>
                    <p class="mt-2">Accuracy of positive predictions</p>
                </div>
                
                <div class="metric-card">
                    <div class="metric-title">Recall</div>
                    <div class="metric-formula">TP / (TP + FN)</div>
                    <p class="mt-2">Ability to find all positive cases</p>
                </div>
                
                <div class="metric-card">
                    <div class="metric-title">F1-Score</div>
                    <div class="metric-formula">2 × (P × R) / (P + R)</div>
                    <p class="mt-2">Harmonic mean of precision and recall</p>
                </div>
            </div>
            
            <!-- Data Split Strategy -->
            <div class="technical-details">
                <h3 class="mb-4">
                    <i class="fas fa-percentage"></i> Data Split Strategy
                </h3>
                
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="metric-card">
                            <div class="metric-title">Training Set</div>
                            <div style="font-size: 2rem; color: #667eea; font-weight: 700;">70%</div>
                            <p>Used for model training and parameter optimization</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-center">
                        <div class="metric-card">
                            <div class="metric-title">Test Set</div>
                            <div style="font-size: 2rem; color: #667eea; font-weight: 700;">30%</div>
                            <p>Used for final model evaluation and performance assessment</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-center">
                        <div class="metric-card">
                            <div class="metric-title">Cross-Validation</div>
                            <div style="font-size: 2rem; color: #667eea; font-weight: 700;">5-Fold</div>
                            <p>Ensures robust model validation during training</p>
                        </div>
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
        
        // Active navigation highlighting
        window.addEventListener('scroll', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === 'methodology.php') {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
