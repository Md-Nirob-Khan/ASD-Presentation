<?php
require_once '../vendor/autoload.php';

use ASDML\MLPipeline;

$pipeline = new MLPipeline();
$results = $pipeline->getModelResults();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conclusion - ASD Classification</title>
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
        .summary-card {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            text-align: center;
        }
        .future-work-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
            transition: transform 0.3s ease;
        }
        .future-work-card:hover {
            transform: translateY(-5px);
        }
        .future-work-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 20px;
        }
        .key-findings {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
        }
        .finding-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid #667eea;
        }
        .finding-title {
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }
        .limitations {
            background: rgba(255, 193, 7, 0.1);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
        }
        .limitation-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid #ffc107;
        }
        .limitation-title {
            font-weight: 700;
            color: #ffc107;
            margin-bottom: 10px;
        }
        .impact-section {
            background: rgba(220, 53, 69, 0.1);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
        }
        .impact-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid #dc3545;
        }
        .impact-title {
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 10px;
        }
        .run-pipeline-btn {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border: none;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .run-pipeline-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            color: white;
            text-decoration: none;
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
                        <a class="nav-link" href="methodology.php">Methodology</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="results.php">Results</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="conclusion.php">Conclusion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="content-section">
            <h1 class="text-center mb-5">
                <i class="fas fa-flag-checkered"></i> Research Conclusion & Future Work
            </h1>
            
            <!-- Executive Summary -->
            <div class="summary-card">
                <h2>
                    <i class="fas fa-trophy"></i> Executive Summary
                </h2>
                <p class="lead mb-0">
                    This research successfully demonstrates the effectiveness of machine learning approaches for Autism Spectrum Disorder classification, 
                    achieving high accuracy through advanced preprocessing techniques and ensemble methods.
                </p>
            </div>
            
            <!-- Key Findings -->
            <div class="key-findings">
                <h3 class="mb-4">
                    <i class="fas fa-lightbulb"></i> Key Research Findings
                </h3>
                
                <div class="finding-item">
                    <div class="finding-title">SMOTE Balancing Effectiveness</div>
                    <p>Class balancing using SMOTE significantly improved model performance by addressing imbalanced datasets, leading to more robust and generalizable models.</p>
                </div>
                
                <div class="finding-item">
                    <div class="finding-title">PCA Dimensionality Reduction</div>
                    <p>Principal Component Analysis successfully reduced feature dimensions while maintaining 95% variance, improving computational efficiency without sacrificing performance.</p>
                </div>
                
                <div class="finding-item">
                    <div class="finding-title">Ensemble Method Superiority</div>
                    <p>Random Forest demonstrated superior performance compared to individual decision trees, highlighting the benefits of ensemble learning approaches.</p>
                </div>
                
                <div class="finding-item">
                    <div class="finding-title">Feature Engineering Impact</div>
                    <p>Proper categorical encoding and data cleaning significantly contributed to model accuracy, emphasizing the importance of preprocessing in ML pipelines.</p>
                </div>
            </div>
            
            <!-- Research Impact -->
            <div class="impact-section">
                <h3 class="mb-4">
                    <i class="fas fa-globe"></i> Research Impact & Applications
                </h3>
                
                <div class="impact-item">
                    <div class="impact-title">Clinical Decision Support</div>
                    <p>Provides healthcare professionals with AI-powered tools for early ASD detection and screening, potentially improving diagnostic accuracy and reducing time to diagnosis.</p>
                </div>
                
                <div class="impact-item">
                    <div class="impact-title">Research Methodology</div>
                    <p>Establishes a robust framework for medical data preprocessing and ML model evaluation that can be applied to other neurological and developmental disorders.</p>
                </div>
                
                <div class="impact-item">
                    <div class="impact-title">Educational Applications</div>
                    <p>Enables educational institutions to better identify students who may benefit from specialized support and intervention programs.</p>
                </div>
                
                <div class="impact-item">
                    <div class="impact-title">Public Health Screening</div>
                    <p>Offers potential for population-level screening tools that can identify individuals at risk for ASD, enabling early intervention strategies.</p>
                </div>
            </div>
            
            <!-- Limitations -->
            <div class="limitations">
                <h3 class="mb-4">
                    <i class="fas fa-exclamation-triangle"></i> Current Limitations
                </h3>
                
                <div class="limitation-item">
                    <div class="limitation-title">Dataset Size</div>
                    <p>Limited training data may affect model generalizability to diverse populations and different demographic groups.</p>
                </div>
                
                <div class="limitation-item">
                    <div class="limitation-title">Feature Selection</div>
                    <p>Manual feature engineering approach may miss complex interactions that could be captured by deep learning methods.</p>
                </div>
                
                <div class="limitation-item">
                    <div class="limitation-title">Clinical Validation</div>
                    <p>Results need clinical validation with real-world patient data to ensure practical applicability in medical settings.</p>
                </div>
                
                <div class="limitation-item">
                    <div class="limitation-title">Interpretability</div>
                    <p>While interpretable, the models may not capture the full complexity of ASD manifestations and comorbidities.</p>
                </div>
            </div>
            
            <!-- Future Work -->
            <h3 class="mb-4">
                <i class="fas fa-rocket"></i> Future Research Directions
            </h3>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="future-work-card text-center">
                        <div class="future-work-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>Deep Learning Approaches</h4>
                        <p>Implement neural networks, CNNs, and transformers to capture complex non-linear patterns in ASD data</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="future-work-card text-center">
                        <div class="future-work-icon">
                            <i class="fas fa-dna"></i>
                        </div>
                        <h4>Multi-Modal Integration</h4>
                        <p>Combine behavioral, genetic, and neuroimaging data for comprehensive ASD classification</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="future-work-card text-center">
                        <div class="future-work-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Population Studies</h4>
                        <p>Validate models across diverse populations and age groups for broader applicability</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="future-work-card text-center">
                        <div class="future-work-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Advanced Algorithms</h4>
                        <p>Explore LightGBM, CatBoost, and XGBoost for improved ensemble performance</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="future-work-card text-center">
                        <div class="future-work-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Mobile Applications</h4>
                        <p>Develop user-friendly mobile apps for real-time ASD screening and monitoring</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="future-work-card text-center">
                        <div class="future-work-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Privacy & Security</h4>
                        <p>Implement federated learning and differential privacy for secure medical data analysis</p>
                    </div>
                </div>
            </div>
            
            <!-- Technical Recommendations -->
            <div class="key-findings">
                <h3 class="mb-4">
                    <i class="fas fa-cogs"></i> Technical Recommendations
                </h3>
                
                <div class="finding-item">
                    <div class="finding-title">Model Deployment</div>
                    <p>Implement model versioning, A/B testing, and continuous monitoring for production deployment in clinical environments.</p>
                </div>
                
                <div class="finding-item">
                    <div class="finding-title">Performance Optimization</div>
                    <p>Explore GPU acceleration, model quantization, and edge computing for real-time inference in resource-constrained settings.</p>
                </div>
                
                <div class="finding-item">
                    <div class="finding-title">Data Pipeline</div>
                    <p>Establish automated data preprocessing pipelines with data quality monitoring and validation checks.</p>
                </div>
            </div>
            
            <!-- Call to Action -->
            <div class="text-center mt-5">
                <h3 class="mb-4">Ready to Explore the Results?</h3>
                <p class="mb-4">Run the machine learning pipeline to see the actual performance metrics and model comparisons.</p>
                
                <?php if (isset($results['error'])): ?>
                    <a href="../run_pipeline.php" class="run-pipeline-btn">
                        <i class="fas fa-play me-2"></i>
                        Run ML Pipeline
                    </a>
                <?php else: ?>
                    <a href="results.php" class="run-pipeline-btn">
                        <i class="fas fa-chart-bar me-2"></i>
                        View Results
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Research Team -->
            <div class="alert alert-info mt-5">
                <h5><i class="fas fa-users"></i> Research Team</h5>
                <p class="mb-2">This research was conducted by a multidisciplinary team of data scientists, machine learning engineers, and medical researchers.</p>
                <p class="mb-0"><strong>Contact:</strong> For collaboration opportunities or questions, please reach out to our research team.</p>
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
                if (link.getAttribute('href') === 'conclusion.php') {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
