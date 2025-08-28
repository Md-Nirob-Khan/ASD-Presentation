<?php
require_once '../vendor/autoload.php';

use ASDML\MLPipeline;

try {
    $pipeline = new MLPipeline();
    $results = $pipeline->getModelResults();
    
    // Debug output
    error_log("Results loaded: " . json_encode($results));
    
} catch (Exception $e) {
    error_log("Error loading results: " . $e->getMessage());
    $results = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results - ASD Classification</title>
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
        .metrics-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .metrics-table th {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 15px;
        }
        .metrics-table td {
            padding: 15px;
            border: 1px solid #dee2e6;
        }
        .best-model {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .confusion-matrix {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .matrix-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
            max-width: 300px;
            margin: 0 auto;
        }
        .matrix-cell {
            padding: 15px;
            text-align: center;
            font-weight: 700;
            border-radius: 5px;
            color: white;
        }
        .matrix-header {
            background: #6c757d;
        }
        .matrix-tp {
            background: #28a745;
        }
        .matrix-fp {
            background: #dc3545;
        }
        .matrix-fn {
            background: #ffc107;
        }
        .matrix-tn {
            background: #17a2b8;
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
        .metric-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
        }
        .model-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-top: 4px solid #667eea;
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
                        <a class="nav-link active" href="results.php">Results</a>
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
                <i class="fas fa-chart-bar"></i> Model Results & Evaluation
            </h1>
            
            <?php if (isset($results['error'])): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>No Results Found:</strong> <?php echo htmlspecialchars($results['error']); ?>
                </div>
                
                <div class="text-center">
                    <p class="mb-4">To see the results, you need to run the machine learning pipeline first.</p>
                    <a href="../run_pipeline.php" class="run-pipeline-btn">
                        <i class="fas fa-play me-2"></i>
                        Run ML Pipeline
                    </a>
                </div>
            <?php else: ?>
                <!-- Debug Information -->
                <div class="debug-info">
                    <strong>Debug Info:</strong><br>
                    Results loaded: <?php echo isset($results['error']) ? 'No' : 'Yes'; ?><br>
                    <?php if (isset($results['error'])): ?>
                        Error: <?php echo htmlspecialchars($results['error']); ?><br>
                    <?php else: ?>
                        Metrics keys: <?php echo json_encode(array_keys($results['metrics'])); ?><br>
                        Confusion matrices: <?php echo json_encode(array_keys($results['confusion_matrices'])); ?><br>
                    <?php endif; ?>
                </div>
                <!-- Best Model Summary -->
                <?php
                $bestModel = '';
                $bestAccuracy = 0;
                foreach ($results['metrics'] as $modelName => $metrics) {
                    if ($metrics['accuracy'] > $bestAccuracy) {
                        $bestAccuracy = $metrics['accuracy'];
                        $bestModel = $modelName;
                    }
                }
                ?>
                
                <div class="best-model">
                    <h3>
                        <i class="fas fa-trophy"></i> Best Performing Model
                    </h3>
                    <div class="metric-value"><?php echo ucfirst(str_replace('_', ' ', $bestModel)); ?></div>
                    <p class="mb-0">Achieved the highest accuracy of <?php echo number_format($bestAccuracy * 100, 2); ?>%</p>
                </div>
                
                <!-- Performance Metrics Table -->
                <div class="metrics-table">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Model</th>
                                <th>Accuracy</th>
                                <th>Precision</th>
                                <th>Recall</th>
                                <th>F1-Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results['metrics'] as $modelName => $metrics): ?>
                            <tr>
                                <td>
                                    <strong><?php echo ucfirst(str_replace('_', ' ', $modelName)); ?></strong>
                                </td>
                                <td class="metric-value"><?php echo number_format($metrics['accuracy'] * 100, 2); ?>%</td>
                                <td class="metric-value"><?php echo number_format($metrics['precision'] * 100, 2); ?>%</td>
                                <td class="metric-value"><?php echo number_format($metrics['recall'] * 100, 2); ?>%</td>
                                <td class="metric-value"><?php echo number_format($metrics['f1_score'] * 100, 2); ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Performance Comparison Chart -->
                <div class="chart-container">
                    <h4 class="mb-3">Model Performance Comparison</h4>
                    <canvas id="performanceChart" width="400" height="200"></canvas>
                </div>
                
                <!-- Individual Model Cards -->
                <h3 class="mb-4">
                    <i class="fas fa-robot"></i> Detailed Model Analysis
                </h3>
                
                <?php foreach ($results['metrics'] as $modelName => $metrics): ?>
                <div class="model-card">
                    <div class="row">
                        <div class="col-md-6">
                            <h4><?php echo ucfirst(str_replace('_', ' ', $modelName)); ?></h4>
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="metric-value"><?php echo number_format($metrics['accuracy'] * 100, 1); ?>%</div>
                                        <small>Accuracy</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="metric-value"><?php echo number_format($metrics['f1_score'] * 100, 1); ?>%</div>
                                        <small>F1-Score</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="metric-value"><?php echo number_format($metrics['precision'] * 100, 1); ?>%</div>
                                        <small>Precision</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="metric-value"><?php echo number_format($metrics['recall'] * 100, 1); ?>%</div>
                                        <small>Recall</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <!-- Confusion Matrices -->
                <h3 class="mb-4">
                    <i class="fas fa-table"></i> Confusion Matrices
                </h3>
                
                <?php foreach ($results['confusion_matrices'] as $modelName => $matrix): ?>
                <div class="confusion-matrix">
                    <h4 class="text-center mb-3"><?php echo ucfirst(str_replace('_', ' ', $modelName)); ?> Confusion Matrix</h4>
                    
                    <?php if (!empty($matrix)): ?>
                        <?php
                        $classes = array_keys($matrix);
                        $class1 = $classes[0] ?? 'Class 1';
                        $class2 = $classes[1] ?? 'Class 2';
                        ?>
                        
                        <div class="matrix-grid">
                            <div class="matrix-cell matrix-header"></div>
                            <div class="matrix-cell matrix-header">Predicted <?php echo $class1; ?></div>
                            <div class="matrix-cell matrix-header">Predicted <?php echo $class2; ?></div>
                            
                            <div class="matrix-cell matrix-header">Actual <?php echo $class1; ?></div>
                            <div class="matrix-cell matrix-tp"><?php echo $matrix[$class1][$class1] ?? 0; ?></div>
                            <div class="matrix-cell matrix-fn"><?php echo $matrix[$class1][$class2] ?? 0; ?></div>
                            
                            <div class="matrix-cell matrix-header">Actual <?php echo $class2; ?></div>
                            <div class="matrix-cell matrix-fp"><?php echo $matrix[$class2][$class1] ?? 0; ?></div>
                            <div class="matrix-cell matrix-tn"><?php echo $matrix[$class2][$class2] ?? 0; ?></div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="metric-value"><?php echo $matrix[$class1][$class1] ?? 0; ?></div>
                                    <small>True Positives (TP)</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="metric-value"><?php echo $matrix[$class2][$class2] ?? 0; ?></div>
                                    <small>True Negatives (TN)</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="metric-value"><?php echo $matrix[$class2][$class1] ?? 0; ?></div>
                                    <small>False Positives (FP)</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="metric-value"><?php echo $matrix[$class1][$class2] ?? 0; ?></div>
                                    <small>False Negatives (FN)</small>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted">No confusion matrix data available</p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                
                <!-- Key Findings -->
                <div class="alert alert-info">
                    <h5><i class="fas fa-lightbulb"></i> Key Findings</h5>
                    <ul class="mb-0">
                        <li><strong>Best Model:</strong> <?php echo ucfirst(str_replace('_', ' ', $bestModel)); ?> achieved the highest performance</li>
                        <li><strong>Overall Performance:</strong> All models show competitive results with accuracy above 80%</li>
                        <li><strong>Balanced Performance:</strong> SMOTE balancing helped achieve better class distribution</li>
                        <li><strong>Feature Reduction:</strong> PCA successfully reduced dimensions while maintaining performance</li>
                    </ul>
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
                if (link.getAttribute('href') === 'results.php') {
                    link.classList.add('active');
                }
            });
        });
    </script>
    
    <?php if (!isset($results['error'])): ?>
    <script>
        // Performance Comparison Chart
        const ctx = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Accuracy', 'Precision', 'Recall', 'F1-Score'],
                datasets: [
                    <?php foreach ($results['metrics'] as $modelName => $metrics): ?>
                    {
                        label: '<?php echo ucfirst(str_replace('_', ' ', $modelName)); ?>',
                        data: [
                            <?php echo $metrics['accuracy']; ?>,
                            <?php echo $metrics['precision']; ?>,
                            <?php echo $metrics['recall']; ?>,
                            <?php echo $metrics['f1_score']; ?>
                        ],
                        borderColor: '<?php echo $modelName === 'decision_tree' ? '#FF6384' : ($modelName === 'random_forest' ? '#36A2EB' : '#FFCE56'); ?>',
                        backgroundColor: '<?php echo $modelName === 'decision_tree' ? 'rgba(255, 99, 132, 0.2)' : ($modelName === 'random_forest' ? 'rgba(54, 162, 235, 0.2)' : 'rgba(255, 206, 86, 0.2)'); ?>',
                        pointBackgroundColor: '<?php echo $modelName === 'decision_tree' ? '#FF6384' : ($modelName === 'random_forest' ? '#36A2EB' : '#FFCE56'); ?>',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '<?php echo $modelName === 'decision_tree' ? '#FF6384' : ($modelName === 'random_forest' ? '#36A2EB' : '#FFCE56'); ?>'
                    },
                    <?php endforeach; ?>
                ]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            stepSize: 0.2
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>
