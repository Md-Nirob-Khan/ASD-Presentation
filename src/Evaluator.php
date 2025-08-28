<?php

namespace ASDML;

use Phpml\Metric\Accuracy;
use Phpml\Metric\ConfusionMatrix;

class Evaluator
{
    /**
     * Evaluate model metrics
     */
    public function evaluateMetrics(array $trueLabels, array $predictions): array
    {
        if (empty($trueLabels) || empty($predictions)) {
            return [
                'accuracy' => 0,
                'precision' => 0,
                'recall' => 0,
                'f1_score' => 0
            ];
        }
        
        // Calculate accuracy
        $accuracy = Accuracy::score($trueLabels, $predictions);
        
        // Calculate confusion matrix
        $confusionMatrix = $this->confusionMatrix($trueLabels, $predictions);
        
        // Calculate precision, recall, and F1-score
        $metrics = $this->calculateDetailedMetrics($confusionMatrix);
        
        return array_merge(['accuracy' => $accuracy], $metrics);
    }
    
    /**
     * Generate confusion matrix
     */
    public function confusionMatrix(array $trueLabels, array $predictions): array
    {
        if (empty($trueLabels) || empty($predictions)) {
            return [];
        }
        
        // Get unique classes
        $classes = array_unique(array_merge($trueLabels, $predictions));
        sort($classes);
        
        // Initialize confusion matrix
        $matrix = [];
        foreach ($classes as $trueClass) {
            foreach ($classes as $predClass) {
                $matrix[$trueClass][$predClass] = 0;
            }
        }
        
        // Fill confusion matrix
        for ($i = 0; $i < count($trueLabels); $i++) {
            $trueLabel = $trueLabels[$i];
            $prediction = $predictions[$i];
            
            if (isset($matrix[$trueLabel][$prediction])) {
                $matrix[$trueLabel][$prediction]++;
            }
        }
        
        return $matrix;
    }
    
    /**
     * Calculate detailed metrics from confusion matrix
     */
    private function calculateDetailedMetrics(array $confusionMatrix): array
    {
        if (empty($confusionMatrix)) {
            return [
                'precision' => 0,
                'recall' => 0,
                'f1_score' => 0
            ];
        }
        
        $classes = array_keys($confusionMatrix);
        
        if (count($classes) === 2) {
            // Binary classification
            $tp = $confusionMatrix[$classes[0]][$classes[0]] ?? 0;
            $tn = $confusionMatrix[$classes[1]][$classes[1]] ?? 0;
            $fp = $confusionMatrix[$classes[1]][$classes[0]] ?? 0;
            $fn = $confusionMatrix[$classes[0]][$classes[1]] ?? 0;
            
            $precision = ($tp + $fp) > 0 ? $tp / ($tp + $fp) : 0;
            $recall = ($tp + $fn) > 0 ? $tp / ($tp + $fn) : 0;
            $f1Score = ($precision + $recall) > 0 ? 2 * ($precision * $recall) / ($precision + $recall) : 0;
            
            return [
                'precision' => $precision,
                'recall' => $recall,
                'f1_score' => $f1Score,
                'tp' => $tp,
                'tn' => $tn,
                'fp' => $fp,
                'fn' => $fn
            ];
        } else {
            // Multi-class classification - calculate macro averages
            $precisions = [];
            $recalls = [];
            
            foreach ($classes as $class) {
                $tp = $confusionMatrix[$class][$class] ?? 0;
                $fp = 0;
                $fn = 0;
                
                foreach ($classes as $otherClass) {
                    if ($otherClass !== $class) {
                        $fp += $confusionMatrix[$otherClass][$class] ?? 0;
                        $fn += $confusionMatrix[$class][$otherClass] ?? 0;
                    }
                }
                
                $precision = ($tp + $fp) > 0 ? $tp / ($tp + $fp) : 0;
                $recall = ($tp + $fn) > 0 ? $tp / ($tp + $fn) : 0;
                
                $precisions[] = $precision;
                $recalls[] = $recall;
            }
            
            $avgPrecision = array_sum($precisions) / count($precisions);
            $avgRecall = array_sum($recalls) / count($recalls);
            $f1Score = ($avgPrecision + $avgRecall) > 0 ? 2 * ($avgPrecision * $avgRecall) / ($avgPrecision + $avgRecall) : 0;
            
            return [
                'precision' => $avgPrecision,
                'recall' => $avgRecall,
                'f1_score' => $f1Score
            ];
        }
    }
    
    /**
     * Cross-validation evaluation
     */
    public function crossValidation(array $features, array $labels, int $folds = 5): array
    {
        $foldSize = (int)(count($features) / $folds);
        $scores = [];
        
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
            
            // Train a simple model for cross-validation
            $model = new \Phpml\Classification\DecisionTree();
            $model->train($trainFeatures, $trainLabels);
            
            // Predict on validation set
            $predictions = [];
            foreach ($valFeatures as $feature) {
                $predictions[] = $model->predict($feature);
            }
            
            // Calculate metrics
            $metrics = $this->evaluateMetrics($valLabels, $predictions);
            $scores[] = $metrics;
        }
        
        // Calculate average scores
        $avgScores = [
            'accuracy' => 0,
            'precision' => 0,
            'recall' => 0,
            'f1_score' => 0
        ];
        
        foreach ($scores as $score) {
            foreach ($avgScores as $metric => $value) {
                $avgScores[$metric] += $score[$metric];
            }
        }
        
        foreach ($avgScores as $metric => $value) {
            $avgScores[$metric] /= count($scores);
        }
        
        return [
            'fold_scores' => $scores,
            'average_scores' => $avgScores
        ];
    }
    
    /**
     * Evaluate all models
     */
    public function evaluateAllModels(array $models, array $testFeatures, array $testLabels): array
    {
        $results = [];
        
        foreach ($models as $modelName => $model) {
            if ($modelName === 'random_forest') {
                // Random Forest prediction (ensemble voting)
                $predictions = $this->predictRandomForest($model, $testFeatures);
            } else {
                // Single model prediction
                $predictions = [];
                foreach ($testFeatures as $feature) {
                    $predictions[] = $model->predict($feature);
                }
            }
            
            $metrics = $this->evaluateMetrics($testLabels, $predictions);
            $confusionMatrix = $this->confusionMatrix($testLabels, $predictions);
            
            $results[$modelName] = [
                'metrics' => $metrics,
                'confusion_matrix' => $confusionMatrix
            ];
        }
        
        return $results;
    }
    
    /**
     * Predict using Random Forest (ensemble voting)
     */
    private function predictRandomForest(array $forest, array $features): array
    {
        $predictions = [];
        
        foreach ($features as $feature) {
            $votes = [];
            
            // Get predictions from all trees
            foreach ($forest as $tree) {
                $prediction = $tree->predict($feature);
                $votes[$prediction] = ($votes[$prediction] ?? 0) + 1;
            }
            
            // Majority vote
            $maxVotes = max($votes);
            $predictedClass = array_search($maxVotes, $votes);
            
            $predictions[] = $predictedClass;
        }
        
        return $predictions;
    }
    
    /**
     * Save results to JSON files
     */
    public function saveResults(array $results, string $resultsPath = 'results/'): bool
    {
        if (!is_dir($resultsPath)) {
            mkdir($resultsPath, 0755, true);
        }
        
        // Save metrics
        $metrics = [];
        foreach ($results as $modelName => $result) {
            $metrics[$modelName] = $result['metrics'];
        }
        
        $metricsJson = json_encode($metrics, JSON_PRETTY_PRINT);
        file_put_contents($resultsPath . 'metrics.json', $metricsJson);
        
        // Save confusion matrices
        $confusion = [];
        foreach ($results as $modelName => $result) {
            $confusion[$modelName] = $result['confusion_matrix'];
        }
        
        $confusionJson = json_encode($confusion, JSON_PRETTY_PRINT);
        file_put_contents($resultsPath . 'confusion.json', $confusionJson);
        
        return true;
    }
}
