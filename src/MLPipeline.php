<?php

namespace ASDML;

class MLPipeline
{
    private DatasetLoader $datasetLoader;
    private Preprocessor $preprocessor;
    private Trainer $trainer;
    private Evaluator $evaluator;
    
    public function __construct()
    {
        // Determine the correct data path based on execution context
        $dataPath = null;
        if (php_sapi_name() === 'cli') {
            // Running from command line, use relative path from project root
            $dataPath = 'data/';
        } else {
            // Running from web, let DatasetLoader auto-detect
            $dataPath = null;
        }
        
        $this->datasetLoader = new DatasetLoader($dataPath);
        $this->preprocessor = new Preprocessor();
        $this->trainer = new Trainer();
        $this->evaluator = new Evaluator();
    }
    
    /**
     * Run the complete ML pipeline
     */
    public function run(): array
    {
        try {
            // Step 1: Load and merge datasets
            echo "Loading and merging datasets...\n";
            $mergedData = $this->datasetLoader->mergeDatasets();
            $initialStats = $this->datasetLoader->getDatasetStats($mergedData);
            
            echo "Initial dataset stats:\n";
            echo "- Total rows: " . $initialStats['total_rows'] . "\n";
            echo "- Features count: " . $initialStats['features_count'] . "\n";
            echo "- Class distribution: " . json_encode($initialStats['class_distribution']) . "\n\n";
            
            // Step 2: Clean data
            echo "Cleaning data...\n";
            $cleanedData = $this->preprocessor->cleanData($mergedData);
            echo "Cleaned data rows: " . count($cleanedData) . "\n\n";
            
            // Step 3: Encode categorical features
            echo "Encoding categorical features...\n";
            $encodedData = $this->preprocessor->encodeCategorical($cleanedData);
            echo "Encoded data rows: " . count($encodedData) . "\n\n";
            
            // Step 4: Apply SMOTE balancing
            echo "Applying SMOTE balancing...\n";
            $balancedData = $this->preprocessor->applySMOTE($encodedData);
            $balancedStats = $this->datasetLoader->getDatasetStats($balancedData);
            
            echo "After SMOTE balancing:\n";
            echo "- Total rows: " . $balancedStats['total_rows'] . "\n";
            echo "- Class distribution: " . json_encode($balancedStats['class_distribution']) . "\n\n";
            
            // Step 5: Apply PCA
            echo "Applying PCA dimensionality reduction...\n";
            $reducedData = $this->preprocessor->applyPCA($balancedData, 0.95);
            echo "PCA reduced data rows: " . count($reducedData) . "\n";
            echo "PCA features: " . (count($reducedData[0]) - 1) . " (excluding class)\n\n";
            
            // Step 6: Split features and labels
            echo "Splitting features and labels...\n";
            $splitData = $this->datasetLoader->splitFeaturesLabels($reducedData);
            $features = $splitData['features'];
            $labels = $splitData['labels'];
            
            echo "Features shape: " . count($features) . " x " . count($features[0]) . "\n";
            echo "Labels count: " . count($labels) . "\n\n";
            
            // Step 7: Split into train and test sets
            echo "Splitting into train and test sets...\n";
            $splitResult = $this->trainer->splitTrainTest($features, $labels, 0.3);
            $trainFeatures = $splitResult['train_features'];
            $trainLabels = $splitResult['train_labels'];
            $testFeatures = $splitResult['test_features'];
            $testLabels = $splitResult['test_labels'];
            
            echo "Training set: " . count($trainFeatures) . " samples\n";
            echo "Test set: " . count($testFeatures) . " samples\n\n";
            
            // Step 8: Train all models
            echo "Training models...\n";
            $trainingResults = $this->trainer->trainAllModels($trainFeatures, $trainLabels);
            
            foreach ($trainingResults as $modelName => $result) {
                if ($result['success']) {
                    echo "- {$modelName}: CV Score = " . number_format($result['mean_cv_score'], 4) . "\n";
                } else {
                    echo "- {$modelName}: Error - " . $result['error'] . "\n";
                }
            }
            echo "\n";
            
            // Step 9: Get trained models
            $models = $this->trainer->getModels();
            
            // Step 10: Evaluate models
            echo "Evaluating models...\n";
            $evaluationResults = $this->evaluator->evaluateAllModels($models, $testFeatures, $testLabels);
            
            foreach ($evaluationResults as $modelName => $result) {
                $metrics = $result['metrics'];
                echo "- {$modelName}:\n";
                echo "  Accuracy: " . number_format($metrics['accuracy'], 4) . "\n";
                echo "  Precision: " . number_format($metrics['precision'], 4) . "\n";
                echo "  Recall: " . number_format($metrics['recall'], 4) . "\n";
                echo "  F1-Score: " . number_format($metrics['f1_score'], 4) . "\n";
            }
            echo "\n";
            
            // Step 11: Save results
            echo "Saving results...\n";
            $this->evaluator->saveResults($evaluationResults);
            echo "Results saved to results/ directory\n\n";
            
            // Return summary
            return [
                'success' => true,
                'initial_stats' => $initialStats,
                'balanced_stats' => $balancedStats,
                'training_results' => $trainingResults,
                'evaluation_results' => $evaluationResults,
                'pca_features' => count($features[0])
            ];
            
        } catch (\Exception $e) {
            echo "Error in ML pipeline: " . $e->getMessage() . "\n";
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Get dataset statistics for web display
     */
    public function getDatasetStatistics(): array
    {
        try {
            $mergedData = $this->datasetLoader->mergeDatasets();
            $initialStats = $this->datasetLoader->getDatasetStats($mergedData);
            
            $cleanedData = $this->preprocessor->cleanData($mergedData);
            $encodedData = $this->preprocessor->encodeCategorical($cleanedData);
            $balancedData = $this->preprocessor->applySMOTE($encodedData);
            $balancedStats = $this->datasetLoader->getDatasetStats($balancedData);
            
            $reducedData = $this->preprocessor->applyPCA($balancedData, 0.95);
            $reducedStats = $this->datasetLoader->getDatasetStats($reducedData);
            
            return [
                'initial' => $initialStats,
                'after_cleaning' => [
                    'total_rows' => count($cleanedData),
                    'features_count' => count(array_keys($cleanedData[0] ?? []))
                ],
                'after_encoding' => [
                    'total_rows' => count($encodedData),
                    'features_count' => count(array_keys($encodedData[0] ?? []))
                ],
                'after_smote' => $balancedStats,
                'after_pca' => $reducedStats
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Get model results for web display
     */
    public function getModelResults(): array
    {
        try {
            // Determine the correct path for results files
            $resultsPath = '';
            if (php_sapi_name() === 'cli') {
                // Running from command line, use relative path from project root
                $resultsPath = 'results/';
            } else {
                // Running from web, go up one level to project root
                $resultsPath = '../results/';
            }
            
            // Check if results exist
            $metricsFile = $resultsPath . 'metrics.json';
            $confusionFile = $resultsPath . 'confusion.json';
            
            if (!file_exists($metricsFile) || !file_exists($confusionFile)) {
                return ['error' => 'Results not found. Please run the pipeline first.'];
            }
            
            $metrics = json_decode(file_get_contents($metricsFile), true);
            $confusion = json_decode(file_get_contents($confusionFile), true);
            
            return [
                'metrics' => $metrics,
                'confusion_matrices' => $confusion
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
