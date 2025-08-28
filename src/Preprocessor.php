<?php

namespace ASDML;

use Phpml\Preprocessing\Normalizer;
use Phpml\Math\Statistic\Mean;
use Phpml\Math\Statistic\StandardDeviation;

class Preprocessor
{
    private array $categoricalColumns = [];
    private array $numericalColumns = [];
    private array $encoders = [];
    
    /**
     * Clean data by handling missing values and removing duplicates
     */
    public function cleanData(array $data): array
    {
        if (empty($data)) {
            return [];
        }
        
        $cleanedData = [];
        $features = array_keys($data[0]);
        
        // Identify column types
        $this->identifyColumnTypes($data, $features);
        
        foreach ($data as $row) {
            $cleanedRow = $this->cleanRow($row);
            if ($cleanedRow !== null) {
                $cleanedData[] = $cleanedRow;
            }
        }
        
        // Remove duplicates
        $cleanedData = $this->removeDuplicates($cleanedData);
        
        return $cleanedData;
    }
    
    /**
     * Identify which columns are categorical vs numerical
     */
    private function identifyColumnTypes(array $data, array $features): void
    {
        foreach ($features as $feature) {
            if ($feature === 'class') {
                continue;
            }
            
            $sampleValues = array_slice(array_column($data, $feature), 0, 10);
            $isCategorical = false;
            
            foreach ($sampleValues as $value) {
                if (!is_numeric($value) || $value == (int)$value) {
                    $isCategorical = true;
                    break;
                }
            }
            
            if ($isCategorical) {
                $this->categoricalColumns[] = $feature;
            } else {
                $this->numericalColumns[] = $feature;
            }
        }
    }
    
    /**
     * Clean individual row
     */
    private function cleanRow(array $row): ?array
    {
        $cleanedRow = [];
        
        foreach ($row as $key => $value) {
            if ($key === 'class') {
                $cleanedRow[$key] = $value;
                continue;
            }
            
            // Handle missing values
            if (empty($value) && $value !== '0') {
                if (in_array($key, $this->numericalColumns)) {
                    $cleanedRow[$key] = 0; // Default for numerical
                } else {
                    $cleanedRow[$key] = 'Unknown'; // Default for categorical
                }
            } else {
                $cleanedRow[$key] = $value;
            }
        }
        
        return $cleanedRow;
    }
    
    /**
     * Remove duplicate rows
     */
    private function removeDuplicates(array $data): array
    {
        $uniqueData = [];
        $seen = [];
        
        foreach ($data as $row) {
            $key = md5(serialize($row));
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $uniqueData[] = $row;
            }
        }
        
        return $uniqueData;
    }
    
    /**
     * Encode categorical features using one-hot encoding
     */
    public function encodeCategorical(array $data): array
    {
        if (empty($data)) {
            return [];
        }
        
        $encodedData = [];
        
        foreach ($data as $row) {
            $encodedRow = [];
            
            foreach ($row as $key => $value) {
                if ($key === 'class') {
                    $encodedRow[$key] = $value;
                    continue;
                }
                
                if (in_array($key, $this->categoricalColumns)) {
                    // One-hot encoding for categorical features
                    $encodedRow[$key . '_' . $value] = 1;
                } else {
                    // Keep numerical features as is
                    $encodedRow[$key] = (float)$value;
                }
            }
            
            $encodedData[] = $encodedRow;
        }
        
        return $encodedData;
    }
    
    /**
     * Apply SMOTE-like oversampling to balance classes
     */
    public function applySMOTE(array $data): array
    {
        if (empty($data)) {
            return [];
        }
        
        // Count class distribution
        $classCounts = [];
        foreach ($data as $row) {
            $class = $row['class'];
            $classCounts[$class] = ($classCounts[$class] ?? 0) + 1;
        }
        
        // Find majority and minority classes
        $majorityClass = array_keys($classCounts, max($classCounts))[0];
        $minorityClass = array_keys($classCounts, min($classCounts))[0];
        
        $majorityCount = $classCounts[$majorityClass];
        $minorityCount = $classCounts[$minorityClass];
        
        // Calculate how many samples to generate
        $samplesToGenerate = $majorityCount - $minorityCount;
        
        // Get minority class samples
        $minoritySamples = array_filter($data, function($row) use ($minorityClass) {
            return $row['class'] === $minorityClass;
        });
        
        $minoritySamples = array_values($minoritySamples);
        
        // Generate synthetic samples
        $syntheticSamples = [];
        for ($i = 0; $i < $samplesToGenerate; $i++) {
            $randomIndex = array_rand($minoritySamples);
            $baseSample = $minoritySamples[$randomIndex];
            
            $syntheticSample = $this->generateSyntheticSample($baseSample, $minoritySamples);
            $syntheticSamples[] = $syntheticSample;
        }
        
        // Combine original data with synthetic samples
        return array_merge($data, $syntheticSamples);
    }
    
    /**
     * Generate synthetic sample using SMOTE-like approach
     */
    private function generateSyntheticSample(array $baseSample, array $minoritySamples): array
    {
        $syntheticSample = $baseSample;
        
        // Add small random noise to numerical features
        foreach ($syntheticSample as $key => $value) {
            if ($key !== 'class' && is_numeric($value)) {
                $noise = (mt_rand(-100, 100) / 1000); // Small random noise
                $syntheticSample[$key] = $value + $noise;
            }
        }
        
        return $syntheticSample;
    }
    
    /**
     * Apply PCA for dimensionality reduction
     */
    public function applyPCA(array $data, float $varianceThreshold = 0.95): array
    {
        if (empty($data)) {
            return [];
        }
        
        // Extract features (exclude class column)
        $features = [];
        $labels = [];
        
        foreach ($data as $row) {
            $rowFeatures = $row;
            unset($rowFeatures['class']);
            $features[] = array_values($rowFeatures);
            $labels[] = $row['class'];
        }
        
        // Simple normalization (z-score)
        $normalizedFeatures = $this->normalizeFeatures($features);
        
        // Calculate covariance matrix
        $covMatrix = $this->calculateCovarianceMatrix($normalizedFeatures);
        
        // Calculate eigenvalues and eigenvectors
        $eigenvalues = $this->calculateEigenvalues($covMatrix);
        $eigenvectors = $this->calculateEigenvectors($covMatrix);
        
        // Sort by eigenvalues (descending)
        arsort($eigenvalues);
        
        // Determine number of components to retain variance threshold
        $totalVariance = array_sum($eigenvalues);
        $cumulativeVariance = 0;
        $componentsToKeep = 0;
        
        foreach ($eigenvalues as $index => $eigenvalue) {
            $cumulativeVariance += $eigenvalue / $totalVariance;
            $componentsToKeep++;
            
            if ($cumulativeVariance >= $varianceThreshold) {
                break;
            }
        }
        
        // Ensure we keep at least 2 components
        $componentsToKeep = max(2, $componentsToKeep);
        
        // Project data onto principal components
        $reducedFeatures = [];
        for ($i = 0; $i < count($normalizedFeatures); $i++) {
            $reducedRow = [];
            for ($j = 0; $j < $componentsToKeep; $j++) {
                $projection = 0;
                for ($k = 0; $k < count($normalizedFeatures[$i]); $k++) {
                    $projection += $normalizedFeatures[$i][$k] * $eigenvectors[$k][$j];
                }
                $reducedRow[] = $projection;
            }
            $reducedFeatures[] = $reducedRow;
        }
        
        // Reconstruct data with reduced features
        $reducedData = [];
        for ($i = 0; $i < count($reducedFeatures); $i++) {
            $row = ['class' => $labels[$i]];
            for ($j = 0; $j < count($reducedFeatures[$i]); $j++) {
                $row["PC" . ($j + 1)] = $reducedFeatures[$i][$j];
            }
            $reducedData[] = $row;
        }
        
        return $reducedData;
    }
    
    /**
     * Calculate covariance matrix
     */
    private function calculateCovarianceMatrix(array $features): array
    {
        $n = count($features);
        $p = count($features[0]);
        
        $covMatrix = array_fill(0, $p, array_fill(0, $p, 0));
        
        for ($i = 0; $i < $p; $i++) {
            for ($j = 0; $j < $p; $j++) {
                $sum = 0;
                for ($k = 0; $k < $n; $k++) {
                    $sum += $features[$k][$i] * $features[$k][$j];
                }
                $covMatrix[$i][$j] = $sum / $n;
            }
        }
        
        return $covMatrix;
    }
    
    /**
     * Calculate eigenvalues (simplified)
     */
    private function calculateEigenvalues(array $matrix): array
    {
        // Simplified eigenvalue calculation
        $eigenvalues = [];
        for ($i = 0; $i < count($matrix); $i++) {
            $eigenvalues[$i] = $matrix[$i][$i]; // Diagonal elements as approximation
        }
        return $eigenvalues;
    }
    
    /**
     * Calculate eigenvectors (simplified)
     */
    private function calculateEigenvectors(array $matrix): array
    {
        // Simplified eigenvector calculation
        $eigenvectors = [];
        for ($i = 0; $i < count($matrix); $i++) {
            for ($j = 0; $j < count($matrix); $j++) {
                $eigenvectors[$i][$j] = ($i === $j) ? 1 : 0;
            }
        }
        return $eigenvectors;
    }

    /**
     * Simple feature normalization (z-score)
     */
    private function normalizeFeatures(array $features): array
    {
        if (empty($features) || empty($features[0])) {
            return $features;
        }
        
        $numFeatures = count($features[0]);
        $numSamples = count($features);
        
        $normalized = [];
        
        for ($j = 0; $j < $numFeatures; $j++) {
            // Calculate mean for this feature
            $sum = 0;
            for ($i = 0; $i < $numSamples; $i++) {
                $sum += $features[$i][$j];
            }
            $mean = $sum / $numSamples;
            
            // Calculate standard deviation for this feature
            $sumSq = 0;
            for ($i = 0; $i < $numSamples; $i++) {
                $sumSq += pow($features[$i][$j] - $mean, 2);
            }
            $std = sqrt($sumSq / $numSamples);
            
            // Normalize (avoid division by zero)
            if ($std > 0.0001) {
                for ($i = 0; $i < $numSamples; $i++) {
                    $normalized[$i][$j] = ($features[$i][$j] - $mean) / $std;
                }
            } else {
                for ($i = 0; $i < $numSamples; $i++) {
                    $normalized[$i][$j] = 0;
                }
            }
        }
        
        return $normalized;
    }
}
