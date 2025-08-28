<?php
require_once 'vendor/autoload.php';

use ASDML\MLPipeline;

echo "🚀 Starting Machine Learning Pipeline for ASD Classification\n";
echo "============================================================\n\n";

try {
    // Check if data files exist
    if (!file_exists('data/train.csv') || !file_exists('data/test.csv')) {
        echo "❌ Error: Data files not found!\n";
        echo "Please ensure you have the following files in the 'data/' directory:\n";
        echo "- train.csv\n";
        echo "- test.csv\n\n";
        echo "You can create sample data files or download the actual ASD datasets.\n";
        exit(1);
    }
    
    // Initialize and run the pipeline
    $pipeline = new MLPipeline();
    
    echo "📊 Running complete ML pipeline...\n";
    echo "This may take a few minutes depending on dataset size.\n\n";
    
    $startTime = microtime(true);
    $results = $pipeline->run();
    $endTime = microtime(true);
    
    $executionTime = round($endTime - $startTime, 2);
    
    if ($results['success']) {
        echo "\n✅ Pipeline completed successfully!\n";
        echo "⏱️  Total execution time: {$executionTime} seconds\n\n";
        
        echo "📈 Summary of Results:\n";
        echo "- Initial dataset: " . number_format($results['initial_stats']['total_rows']) . " rows\n";
        echo "- After preprocessing: " . number_format($results['after_smote']['total_rows']) . " rows\n";
        echo "- PCA features: " . $results['pca_features'] . " components\n";
        echo "- Models trained: Decision Tree, Random Forest, Extreme Gradient Boosting (XGBoost)\n\n";
        
        echo "🎯 Model Performance Summary:\n";
        foreach ($results['evaluation_results'] as $modelName => $result) {
            $metrics = $result['metrics'];
            echo "- " . ucfirst(str_replace('_', ' ', $modelName)) . ":\n";
            echo "  Accuracy: " . number_format($metrics['accuracy'] * 100, 2) . "%\n";
            echo "  F1-Score: " . number_format($metrics['f1_score'] * 100, 2) . "%\n";
        }
        
        echo "\n💾 Results saved to:\n";
        echo "- results/metrics.json\n";
        echo "- results/confusion.json\n\n";
        
        echo "🌐 You can now view the results in your web browser:\n";
        echo "- Open: http://localhost/your-project/public/results.php\n";
        echo "- Or navigate through the web interface starting from: http://localhost/your-project/public/\n\n";
        
    } else {
        echo "❌ Pipeline failed with error: " . $results['error'] . "\n";
        exit(1);
    }
    
} catch (Exception $e) {
    echo "❌ Fatal error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

echo "🎉 Pipeline execution completed!\n";
echo "Check the 'results/' directory for generated files.\n";
?>
