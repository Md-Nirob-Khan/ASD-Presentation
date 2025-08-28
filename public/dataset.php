<?php
require_once '../vendor/autoload.php';

use ASDML\MLPipeline;

try {
    $pipeline = new MLPipeline();
    $stats = $pipeline->getDatasetStatistics();
} catch (Exception $e) {
    $stats = ['error' => 'Failed to load pipeline: ' . $e->getMessage()];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dataset Analysis - ASD Classification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .stats-card {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin: 15px 0;
            text-align: center;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .process-step {
            background: rgba(102, 126, 234, 0.1);
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 15px 0;
            border-radius: 0 10px 10px 0;
        }
        .step-number {
            background: #667eea;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 15px;
        }
        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            font-family: monospace;
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
                        <a class="nav-link active" href="dataset.php">Dataset</a>
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

    <div class="container">
        <div class="content-section">
            <h1 class="text-center mb-5">
                <i class="fas fa-database"></i> Dataset Analysis
            </h1>
            
            <!-- Debug Information -->
            <div class="debug-info">
                <strong>Debug Info:</strong><br>
                PHP Version: <?php echo PHP_VERSION; ?><br>
                Script Path: <?php echo $_SERVER['SCRIPT_NAME'] ?? 'Unknown'; ?><br>
                Current Directory: <?php echo getcwd(); ?><br>
                Data Path: <?php echo realpath('../data/'); ?><br>
                Train CSV exists: <?php echo file_exists('../data/train.csv') ? 'Yes' : 'No'; ?><br>
                Test CSV exists: <?php echo file_exists('../data/test.csv') ? 'Yes' : 'No'; ?><br>
                
                <!-- Test direct file loading -->
                <?php
                try {
                    $testData = file_get_contents('../data/train.csv');
                    $testLines = count(explode("\n", $testData));
                    echo "Direct file read test: Success ({$testLines} lines)<br>";
                } catch (Exception $e) {
                    echo "Direct file read test: Failed - " . htmlspecialchars($e->getMessage()) . "<br>";
                }
                ?>
                
                Stats loaded: <?php echo isset($stats['error']) ? 'No' : 'Yes'; ?><br>
                <?php if (isset($stats['error'])): ?>
                    Error: <?php echo htmlspecialchars($stats['error']); ?>
                <?php else: ?>
                    Data structure: <?php echo json_encode(array_keys($stats)); ?>
                <?php endif; ?>
            </div>
            
            <?php if (isset($stats['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error: <?php echo htmlspecialchars($stats['error']); ?>
                </div>
            <?php else: ?>
                <!-- Initial Dataset Statistics -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="mb-4">
                            <i class="fas fa-chart-pie"></i> Initial Dataset Statistics
                        </h3>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number"><?php echo number_format($stats['initial']['total_rows']); ?></div>
                            <div>Total Rows</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number"><?php echo number_format($stats['initial']['features_count']); ?></div>
                            <div>Features Count</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-number"><?php echo count($stats['initial']['class_distribution']); ?></div>
                            <div>Classes</div>
                        </div>
                    </div>
                </div>
                
                <!-- Class Distribution Chart -->
                <div class="chart-container">
                    <h4 class="mb-3">Class Distribution (Initial)</h4>
                    <canvas id="initialClassChart" width="400" height="200"></canvas>
                </div>
                
                <!-- Data Processing Pipeline -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="mb-4">
                            <i class="fas fa-cogs"></i> Data Processing Pipeline
                        </h3>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number"><?php echo number_format($stats['after_cleaning']['total_rows']); ?></div>
                            <div>After Cleaning</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number"><?php echo number_format($stats['after_encoding']['features_count']); ?></div>
                            <div>After Encoding</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number"><?php echo number_format($stats['after_smote']['total_rows']); ?></div>
                            <div>After SMOTE</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-number"><?php echo number_format($stats['after_pca']['features_count']); ?></div>
                            <div>After PCA</div>
                        </div>
                    </div>
                </div>
                
                <!-- Class Distribution Comparison -->
                <div class="chart-container">
                    <h4 class="mb-3">Class Distribution Comparison</h4>
                    <canvas id="comparisonChart" width="400" height="200"></canvas>
                </div>
                
                <!-- Processing Steps -->
                <div class="mt-5">
                    <h3 class="mb-4">
                        <i class="fas fa-list-ol"></i> Processing Steps
                    </h3>
                    
                    <div class="process-step">
                        <span class="step-number">1</span>
                        <strong>Data Loading:</strong> Merged train.csv and test.csv datasets
                    </div>
                    
                    <div class="process-step">
                        <span class="step-number">2</span>
                        <strong>Data Cleaning:</strong> Handled missing values and removed duplicates
                    </div>
                    
                    <div class="process-step">
                        <span class="step-number">3</span>
                        <strong>Categorical Encoding:</strong> Applied one-hot encoding to categorical features
                    </div>
                    
                    <div class="process-step">
                        <span class="step-number">4</span>
                        <strong>SMOTE Balancing:</strong> Applied synthetic minority oversampling technique
                    </div>
                    
                    <div class="process-step">
                        <span class="step-number">5</span>
                        <strong>PCA Reduction:</strong> Reduced dimensions while retaining 95% variance
                    </div>
                </div>
            <?php endif; ?>
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
                if (link.getAttribute('href') === 'dataset.php') {
                    link.classList.add('active');
                }
            });
        });
    </script>
    
    <?php if (!isset($stats['error'])): ?>
    <script>
        console.log('Chart.js loaded:', typeof Chart !== 'undefined');
        console.log('Stats data:', <?php echo json_encode($stats); ?>);
        
        // Initial Class Distribution Chart
        const initialCtx = document.getElementById('initialClassChart');
        if (initialCtx) {
            const initialChart = new Chart(initialCtx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode(array_keys($stats['initial']['class_distribution'])); ?>,
                    datasets: [{
                        data: <?php echo json_encode(array_values($stats['initial']['class_distribution'])); ?>,
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
            console.log('Initial chart created');
        } else {
            console.error('Initial chart canvas not found');
        }
        
        // Comparison Chart
        const comparisonCtx = document.getElementById('comparisonChart');
        if (comparisonCtx) {
            const comparisonChart = new Chart(comparisonCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Initial', 'After SMOTE'],
                    datasets: [{
                        label: 'Class 1',
                        data: [
                            <?php echo $stats['initial']['class_distribution'][array_keys($stats['initial']['class_distribution'])[0]] ?? 0; ?>,
                            <?php echo $stats['after_smote']['class_distribution'][array_keys($stats['after_smote']['class_distribution'])[0]] ?? 0; ?>
                        ],
                        backgroundColor: '#FF6384'
                    }, {
                        label: 'Class 2',
                        data: [
                            <?php echo $stats['initial']['class_distribution'][array_keys($stats['initial']['class_distribution'])[1]] ?? 0; ?>,
                            <?php echo $stats['after_smote']['class_distribution'][array_keys($stats['after_smote']['class_distribution'])[1]] ?? 0; ?>
                        ],
                        backgroundColor: '#36A2EB'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
            console.log('Comparison chart created');
        } else {
            console.error('Comparison chart canvas not found');
        }
    </script>
    <?php endif; ?>
</body>
</html>
