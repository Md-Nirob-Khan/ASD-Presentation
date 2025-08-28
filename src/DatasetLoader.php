<?php

namespace ASDML;

use League\Csv\Reader;
use League\Csv\Exception;

class DatasetLoader
{
    private string $dataPath;
    
    public function __construct(string $dataPath = null)
    {
        // Auto-detect the correct path relative to the calling script
        if ($dataPath === null) {
            // Check current working directory to determine if we're in public folder
            $currentDir = getcwd();
            if (strpos($currentDir, '/public') !== false || basename($currentDir) === 'public') {
                // Running from public directory, go up one level
                $this->dataPath = '../data/';
            } else {
                // Running from root directory
                $this->dataPath = 'data/';
            }
        } else {
            $this->dataPath = $dataPath;
        }
        
        // Debug output
        error_log("DatasetLoader: Current dir: {$currentDir}, Data path: {$this->dataPath}");
    }
    
    /**
     * Load CSV file and return as array
     */
    public function loadCSV(string $filename): array
    {
        try {
            $fullPath = $this->dataPath . $filename;
            
            // Check if file exists
            if (!file_exists($fullPath)) {
                throw new \RuntimeException("CSV file not found at: {$fullPath}");
            }
            
            $csv = Reader::createFromPath($fullPath, 'r');
            $csv->setHeaderOffset(0);
            
            $records = [];
            foreach ($csv->getRecords() as $record) {
                $records[] = $record;
            }
            
            return $records;
        } catch (Exception $e) {
            throw new \RuntimeException("Error loading CSV file {$filename}: " . $e->getMessage());
        }
    }
    
    /**
     * Merge train and test datasets
     */
    public function mergeDatasets(): array
    {
        $trainData = $this->loadCSV('train.csv');
        $testData = $this->loadCSV('test.csv');
        
        // Combine datasets
        $mergedData = array_merge($trainData, $testData);
        
        return $mergedData;
    }
    
    /**
     * Get dataset statistics
     */
    public function getDatasetStats(array $data): array
    {
        if (empty($data)) {
            return [
                'total_rows' => 0,
                'features_count' => 0,
                'class_distribution' => []
            ];
        }
        
        $features = array_keys($data[0]);
        $featuresCount = count($features);
        
        // Count class distribution
        $classColumn = 'class';
        $classDistribution = [];
        
        foreach ($data as $row) {
            $class = $row[$classColumn] ?? 'Unknown';
            $classDistribution[$class] = ($classDistribution[$class] ?? 0) + 1;
        }
        
        return [
            'total_rows' => count($data),
            'features_count' => $featuresCount,
            'class_distribution' => $classDistribution,
            'features' => $features
        ];
    }
    
    /**
     * Split features and labels
     */
    public function splitFeaturesLabels(array $data): array
    {
        if (empty($data)) {
            return ['features' => [], 'labels' => []];
        }
        
        $features = [];
        $labels = [];
        $classColumn = 'class';
        
        foreach ($data as $row) {
            $rowFeatures = $row;
            unset($rowFeatures[$classColumn]);
            
            $features[] = array_values($rowFeatures);
            $labels[] = $row[$classColumn];
        }
        
        return [
            'features' => $features,
            'labels' => $labels
        ];
    }
}
