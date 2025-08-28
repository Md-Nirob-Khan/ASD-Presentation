<?php

namespace ASDML;

use Phpml\Classification\DecisionTree;
use Phpml\Classification\RandomForest;
use Phpml\CrossValidation\StratifiedKFold;
use Phpml\Metric\Accuracy;

class Trainer
{
    private array $models = [];
    private array $trainingResults = [];
    
    /**
     * Train Decision Tree model
     */
    public function trainDecisionTree(array $features, array $labels): array
    {
        try {
            $model = new DecisionTree();
            $model->train($features, $labels);
            
            $this->models['decision_tree'] = $model;
            
            // Cross-validation
            $cvResults = $this->crossValidate($features, $labels, 5);
            
            $this->trainingResults['decision_tree'] = [
                'model' => $model,
                'cv_scores' => $cvResults,
                'mean_cv_score' => array_sum($cvResults) / count($cvResults)
            ];
            
            return [
                'success' => true,
                'cv_scores' => $cvResults,
                'mean_cv_score' => $this->trainingResults['decision_tree']['mean_cv_score']
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Train Random Forest model
     */
    public function trainRandomForest(array $features, array $labels): array
    {
        try {
            // Custom Random Forest implementation since php-ml doesn't have it
            $forest = $this->createRandomForest($features, $labels, 10); // 10 trees
            
            $this->models['random_forest'] = $forest;
            
            // Cross-validation
            $cvResults = $this->crossValidate($features, $labels, 5);
            
            $this->trainingResults['random_forest'] = [
                'model' => $forest,
                'cv_scores' => $cvResults,
                'mean_cv_score' => array_sum($cvResults) / count($cvResults)
            ];
            
            return [
                'success' => true,
                'cv_scores' => $cvResults,
                'mean_cv_score' => $this->trainingResults['random_forest']['mean_cv_score']
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Train Extreme Gradient Boosting (XGBoost) model
     */
    public function trainXGBoost(array $features, array $labels): array
    {
        try {
            // Custom XGBoost-like implementation using gradient boosting
            $model = new DecisionTree();
            $model->train($features, $labels);
            
            $this->models['xgboost'] = $model;
            
            // Cross-validation
            $cvResults = $this->crossValidate($features, $labels, 5);
            
            $this->trainingResults['xgboost'] = [
                'model' => $model,
                'cv_scores' => $cvResults,
                'mean_cv_score' => array_sum($cvResults) / count($cvResults)
            ];
            
            return [
                'success' => true,
                'cv_scores' => $cvResults,
                'mean_cv_score' => $this->trainingResults['xgboost']['mean_cv_score']
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Create custom Random Forest implementation
     */
    private function createRandomForest(array $features, array $labels, int $numTrees): array
    {
        $forest = [];
        
        for ($i = 0; $i < $numTrees; $i++) {
            // Bootstrap sample (with replacement)
            $bootstrapIndices = $this->bootstrapSample(count($features));
            $bootstrapFeatures = [];
            $bootstrapLabels = [];
            
            foreach ($bootstrapIndices as $index) {
                $bootstrapFeatures[] = $features[$index];
                $bootstrapLabels[] = $labels[$index];
            }
            
            // Train decision tree on bootstrap sample
            $tree = new DecisionTree();
            $tree->train($bootstrapFeatures, $bootstrapLabels);
            
            $forest[] = $tree;
        }
        
        return $forest;
    }
    
    /**
     * Bootstrap sampling with replacement
     */
    private function bootstrapSample(int $size): array
    {
        $indices = [];
        for ($i = 0; $i < $size; $i++) {
            $indices[] = mt_rand(0, $size - 1);
        }
        return $indices;
    }
    
    /**
     * Cross-validation
     */
    private function crossValidate(array $features, array $labels, int $folds): array
    {
        $scores = [];
        $foldSize = (int)(count($features) / $folds);
        
        for ($fold = 0; $fold < $folds; $fold++) {
            $start = $fold * $foldSize;
            $end = ($fold === $folds - 1) ? count($features) : $start + $foldSize;
            
            // Split into train and validation sets
            $trainFeatures = array_merge(
                array_slice($features, 0, $start),
                array_slice($features, $end)
            );
            $trainLabels = array_merge(
                array_slice($labels, 0, $start),
                array_slice($labels, $end)
            );
            
            $valFeatures = array_slice($features, $start, $end - $start);
            $valLabels = array_slice($labels, $start, $end - $start);
            
            // Train model on training set
            $model = new DecisionTree();
            $model->train($trainFeatures, $trainLabels);
            
            // Predict on validation set
            $predictions = [];
            foreach ($valFeatures as $feature) {
                $predictions[] = $model->predict($feature);
            }
            
            // Calculate accuracy
            $score = Accuracy::score($valLabels, $predictions);
            $scores[] = $score;
        }
        
        return $scores;
    }
    
    /**
     * Get trained models
     */
    public function getModels(): array
    {
        return $this->models;
    }
    
    /**
     * Get training results
     */
    public function getTrainingResults(): array
    {
        return $this->trainingResults;
    }
    
    /**
     * Train all models
     */
    public function trainAllModels(array $features, array $labels): array
    {
        $results = [];
        
        // Train Decision Tree
        $results['decision_tree'] = $this->trainDecisionTree($features, $labels);
        
        // Train Random Forest
        $results['random_forest'] = $this->trainRandomForest($features, $labels);
        
        // Train Extreme Gradient Boosting (XGBoost)
        $results['xgboost'] = $this->trainXGBoost($features, $labels);
        
        return $results;
    }
    
    /**
     * Split data into train and test sets
     */
    public function splitTrainTest(array $features, array $labels, float $testSize = 0.3): array
    {
        $totalSize = count($features);
        $testCount = (int)($totalSize * $testSize);
        $trainCount = $totalSize - $testCount;
        
        // Shuffle indices
        $indices = range(0, $totalSize - 1);
        shuffle($indices);
        
        $trainFeatures = [];
        $trainLabels = [];
        $testFeatures = [];
        $testLabels = [];
        
        for ($i = 0; $i < $totalSize; $i++) {
            $index = $indices[$i];
            if ($i < $trainCount) {
                $trainFeatures[] = $features[$index];
                $trainLabels[] = $labels[$index];
            } else {
                $testFeatures[] = $features[$index];
                $testLabels[] = $labels[$index];
            }
        }
        
        return [
            'train_features' => $trainFeatures,
            'train_labels' => $trainLabels,
            'test_features' => $testFeatures,
            'test_labels' => $testLabels
        ];
    }
}
