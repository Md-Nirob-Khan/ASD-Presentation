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
        
        /* Introduction Section Styles */
        .introduction-section {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .introduction-content {
            text-align: justify;
        }
        
        .introduction-text {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #333;
            text-align: justify;
        }
        
        .introduction-text:last-child {
            margin-bottom: 0;
        }
        
        /* Comparison Table Styles */
        .comparison-section {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .comparison-table {
            font-size: 0.9rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .comparison-table th {
            background: linear-gradient(45deg, #667eea, #764ba2) !important;
            color: white !important;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
            padding: 15px 8px;
            border: none;
        }
        
        .comparison-table td {
            padding: 12px 8px;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }
        
        .comparison-table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
            transition: background-color 0.3s ease;
        }
        
        .proposed-research {
            background: linear-gradient(45deg, rgba(255, 215, 61, 0.1), rgba(255, 215, 61, 0.05));
            border-left: 4px solid #ffd93d;
        }
        
        .proposed-research:hover {
            background: linear-gradient(45deg, rgba(255, 215, 61, 0.2), rgba(255, 215, 61, 0.1));
        }
        
        .accuracy-high {
            color: #28a745;
            font-weight: 600;
        }
        
        .accuracy-medium {
            color: #ffc107;
            font-weight: 600;
        }
        
        .accuracy-unknown {
            color: #6c757d;
            font-style: italic;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        @media (max-width: 768px) {
            .comparison-table {
                font-size: 0.8rem;
            }
            
            .comparison-table th,
            .comparison-table td {
                padding: 8px 4px;
            }
        }
        
        /* Pipeline Flowchart Styles */
        .pipeline-container {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .pipeline-phase {
            margin-bottom: 50px;
        }
        
        .phase-title {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 1.3rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .pipeline-flow {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        
        .flow-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            min-width: 200px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .flow-step:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .flow-step i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: white;
        }
        
        .flow-step span {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1.3;
        }
        
        /* Step Type Styles */
        .start-step, .end-step {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: 3px solid #fff;
        }
        
        .data-step {
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
            border: 3px solid #fff;
        }
        
        .decision-step {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            border: 3px solid #fff;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            min-width: 180px;
            min-height: 120px;
        }
        
        .smote-step {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: 3px solid #fff;
        }
        
        .skip-step {
            background: linear-gradient(45deg, #6c757d, #495057);
            border: 3px solid #fff;
        }
        
        .feature-step {
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
            border: 3px solid #fff;
        }
        
        .model-step {
            background: linear-gradient(45deg, #dc3545, #e83e8c);
            border: 3px solid #fff;
        }
        
        .cv-step {
            background: linear-gradient(45deg, #fd7e14, #ffc107);
            border: 3px solid #fff;
        }
        
        .evaluation-step {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
            border: 3px solid #fff;
        }
        
        .metrics-step {
            background: linear-gradient(45deg, #20c997, #17a2b8);
            border: 3px solid #fff;
        }
        
        .analysis-step {
            background: linear-gradient(45deg, #fd7e14, #ffc107);
            border: 3px solid #fff;
        }
        
        .flow-arrow {
            font-size: 2rem;
            color: #667eea;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .flow-branch {
            display: flex;
            gap: 40px;
            margin: 20px 0;
        }
        
        .branch-yes, .branch-no {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        
        .branch-label {
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .models-parallel {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .model-branch {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .metrics-list {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-top: 10px;
            font-size: 0.8rem;
        }
        
        .metrics-list span {
            background: rgba(255,255,255,0.2);
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .pipeline-container {
                padding: 20px;
            }
            
            .flow-step {
                min-width: 150px;
                padding: 15px;
            }
            
            .flow-step span {
                font-size: 0.8rem;
            }
            
            .models-parallel {
                flex-direction: column;
                gap: 15px;
            }
            
            .flow-branch {
                flex-direction: column;
                gap: 20px;
            }
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
                        Advanced classification using Decision Trees, Random Forest, and Extreme Gradient Boosting (XGBoost) with PCA dimensionality reduction and SMOTE balancing
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
        
        <!-- Introduction Section -->
        <div class="container">
            <div class="introduction-section">
                <h2 class="text-center mb-5">
                    <i class="fas fa-info-circle"></i> Introduction
                </h2>
                
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="introduction-content">
                            <p class="introduction-text">
                                Autism Spectrum Disorder (ASD) is a neurodevelopmental disorder that affects communication, social interactions, and behavior. Its rising prevalence and significant social impact have drawn increasing attention from researchers, healthcare professionals, and policymakers. Early diagnosis and intervention are crucial, as behavioral therapies are most effective when started early, yet children are often diagnosed much later than ideal.
                            </p>
                            
                            <p class="introduction-text">
                                Machine learning (ML) offers promising tools to improve ASD detection. Algorithms like Support Vector Machines, Neural Networks, and Deep Learning can analyze behavioral and neuroimaging data to identify subtle patterns, speeding up and improving diagnostic accuracy.
                            </p>
                            
                            <p class="introduction-text">
                                This research proposes a lightweight ML framework using behavioral questionnaire data. By applying PCA for feature selection and SMOTE for class balancing, optimized classifiers such as Decision Trees, Random Forests, and XGBoost are evaluated to provide a reliable, cost-effective approach for early ASD detection, suitable for telemedicine applications.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Comparison Table Section -->
        <div class="container">
            <div class="comparison-section">
                <h2 class="text-center mb-5">
                    <i class="fas fa-table"></i> Comparison of Different ML Approaches for ASD Detection
                </h2>
                
                <div class="table-responsive">
                    <table class="table table-striped comparison-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Author(s) / Year</th>
                                <th>Detection Method</th>
                                <th>ML Algorithms Used</th>
                                <th>Datasets / Age Groups</th>
                                <th>Accuracy</th>
                                <th>Key Features</th>
                                <th>Summary of Challenges and Solutions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="proposed-research">
                                <td><strong>Proposed Research</strong></td>
                                <td>ML-based ASD detection</td>
                                <td>RF (Random Forest), DT (Decision Tree), XGBoost (Extreme Gradient Boosting)</td>
                                <td>ASD datasets across various age groups (children, adults, toddlers)</td>
                                <td><span class="accuracy-high">90-95%</span></td>
                                <td>Feature selection (PCA, SMOTE), dataset balancing, optimized model selection</td>
                                <td>This study optimizes feature selection, balances datasets with SMOTE, and enhances model performance, ensuring better generalization across different age groups.</td>
                            </tr>
                            <tr>
                                <td><strong>Xu et al. [1]</strong></td>
                                <td>ML in brain imaging for ASD detection</td>
                                <td>SVM (Support Vector Machine), Neural Networks, Deep Learning</td>
                                <td>Brain imaging data (fMRI, structural MRI)</td>
                                <td><span class="accuracy-medium">85-90%</span></td>
                                <td>Utilized high-dimensional fMRI and MRI data</td>
                                <td>This study suffered from dataset biases and dependence on high-quality neuroimaging data, whereas the proposed research uses structured datasets from diverse age groups, reducing dependency on expensive neuroimaging techniques.</td>
                            </tr>
                            <tr>
                                <td><strong>Asmetha Jeyarani & Senthilkumar [2] [6]</strong></td>
                                <td>Eye tracking with ML/DL for ASD detection</td>
                                <td>SVM, CNN (Convolutional Neural Network), RF, KNN (K-Nearest Neighbors), DT, Neural Networks</td>
                                <td>Eye movement data from ASD and TD (Typically Developing) children</td>
                                <td><span class="accuracy-medium">83%</span></td>
                                <td>Eye-tracking data, sentiment analysis with BERT, ChatGPT</td>
                                <td>Their approach struggled with aggregation-type sentences and required labeled data, but the proposed study avoids these issues by focusing on structured, preprocessed datasets with well-defined features.</td>
                            </tr>
                            <tr>
                                <td><strong>Rownak Ara, Rasul et al. [3]</strong></td>
                                <td>ML models for early ASD detection</td>
                                <td>LR (Logistic Regression), SVM, KNN, RF, DT, ANN (Artificial Neural Network), XGB (XGBoost)</td>
                                <td>ASD datasets across children and adults</td>
                                <td><span class="accuracy-high">100% (children), 97.14% (adults), 94.28% (combined dataset)</span></td>
                                <td>Supervised learning, hyperparameter tuning</td>
                                <td>This research faced challenges with unbalanced datasets and label prediction issues, which the proposed study overcomes using SMOTE for balancing and refining model generalization across all age groups.</td>
                            </tr>
                            <tr>
                                <td><strong>Mukherjee et al. [4]</strong></td>
                                <td>Language models (BERT, ChatGPT) for ASD detection</td>
                                <td>BERT, ChatGPT</td>
                                <td>Parent dialogues (natural language)</td>
                                <td><span class="accuracy-medium">83%</span></td>
                                <td>Sentiment analysis, cosine similarity between sentences</td>
                                <td>This study was limited by data quality and inefficiency in analyzing complex sentence structures, whereas the proposed research avoids NLP-based diagnosis and instead focuses on structured numerical features for better reliability.</td>
                            </tr>
                            <tr>
                                <td><strong>Tamizhmalar et al. [5]</strong></td>
                                <td>Deep learning for ASD detection using multimodal data</td>
                                <td>CNN, RNN (Recurrent Neural Network)</td>
                                <td>Neuroimaging, facial expressions, vocal patterns</td>
                                <td><span class="accuracy-unknown">Not specified</span></td>
                                <td>Multimodal data integration (neuroimaging, facial expressions, vocal patterns)</td>
                                <td>Their approach faced complexity issues and required large datasets, but the proposed research achieves high accuracy with a simpler single-modality approach, making it more practical and scalable.</td>
                            </tr>
                            <tr>
                                <td><strong>Vanil Kumar et al. [6]</strong></td>
                                <td>ML for ASD detection with feature scaling</td>
                                <td>AB (AdaBoost), RF, DT, KNN, GNB (Gaussian Naive Bayes), LR, SVM, LDA (Linear Discriminant Analysis)</td>
                                <td>ASD datasets across toddlers, children, adolescents, and adults</td>
                                <td><span class="accuracy-high">99.25% (toddlers), 97.95% (children), 97.12% (adolescents), 99.03% (adults)</span></td>
                                <td>Feature scaling techniques (QT, PT, Normalizer, MAS)</td>
                                <td>This study faced challenges with feature scaling optimization and dataset quality, but the proposed study improves feature selection techniques and ensures better dataset optimization for higher accuracy.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="features">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="text-center text-white mb-5">
                        <i class="fas fa-cogs"></i> Research Methodology
                    </h2>
                    
                    <!-- Phase 1: Data Preparation Cards -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-center text-white mb-4">Phase 1: Data Preparation</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-database"></i>
                                </div>
                                <h4>Data Loading</h4>
                                <p>Load and merge training/testing datasets, handle missing values, and perform initial data cleaning</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <h4>Data Processing</h4>
                                <p>Clean data, encode categorical features, and prepare for machine learning algorithms</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-balance-scale"></i>
                                </div>
                                <h4>Class Balancing</h4>
                                <p>Apply SMOTE technique to address class imbalance and ensure fair model training</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phase 2: Feature Selection & Model Training Cards -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-center text-white mb-4">Phase 2: Feature Selection & Model Training</h4>
                        </div>
                        <div class="col-md-3">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4>PCA Reduction</h4>
                                <p>Principal Component Analysis to reduce dimensionality while retaining 95% variance</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-tree"></i>
                                </div>
                                <h4>Random Forest</h4>
                                <p>Ensemble method with 10 decision trees for robust classification performance</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <h4>XGBoost</h4>
                                <p>Extreme Gradient Boosting for advanced ensemble learning and high accuracy</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-sitemap"></i>
                                </div>
                                <h4>Decision Tree</h4>
                                <p>Classic CART algorithm for interpretable decision-making and baseline performance</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phase 3: Evaluation & Analysis Cards -->
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-center text-white mb-4">Phase 3: Evaluation & Analysis</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-check-double"></i>
                                </div>
                                <h4>Cross-Validation</h4>
                                <p>3-Fold, 5-Fold, and 10-Fold stratified cross-validation for robust model evaluation</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h4>Performance Metrics</h4>
                                <p>Comprehensive evaluation using Accuracy, Precision, Recall, F1-Score, Confusion Matrix, and ROC Curve</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card text-center text-white">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <h4>Result Analysis</h4>
                                <p>Visualize performance, interpret results, and identify optimal model configurations</p>
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
                            <li><strong>Advanced Algorithms:</strong> Decision Tree, Random Forest, and Extreme Gradient Boosting (XGBoost)</li>
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

