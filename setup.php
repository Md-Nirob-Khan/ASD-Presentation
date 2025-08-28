<?php
echo "🔧 ASD Classification Research - Setup Script\n";
echo "=============================================\n\n";

// Check PHP version
echo "📋 System Requirements Check:\n";
echo "PHP Version: " . PHP_VERSION . "\n";
if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
    echo "✅ PHP version is compatible\n";
} else {
    echo "❌ PHP version must be 8.0.0 or higher\n";
    exit(1);
}

// Check Composer
echo "\n📦 Checking Composer:\n";
if (file_exists('composer.json')) {
    echo "✅ composer.json found\n";
} else {
    echo "❌ composer.json not found\n";
    exit(1);
}

// Check if vendor directory exists
if (is_dir('vendor')) {
    echo "✅ Dependencies already installed\n";
} else {
    echo "⚠️  Dependencies not installed. Please run: composer install\n";
}

// Check directories
echo "\n📁 Directory Structure Check:\n";
$directories = ['data', 'results', 'src', 'public'];
foreach ($directories as $dir) {
    if (is_dir($dir)) {
        echo "✅ {$dir}/ directory exists\n";
    } else {
        echo "❌ {$dir}/ directory missing\n";
    }
}

// Check data files
echo "\n📊 Data Files Check:\n";
$dataFiles = [
    'data/train.csv' => 'Training dataset',
    'data/test.csv' => 'Testing dataset'
];

foreach ($dataFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}\n";
    } else {
        echo "⚠️  {$description}: {$file} (not found)\n";
        echo "   You can use the sample files: data/sample_train.csv and data/sample_test.csv\n";
    }
}

// Check source files
echo "\n🔧 Source Files Check:\n";
$sourceFiles = [
    'src/DatasetLoader.php' => 'Dataset Loader',
    'src/Preprocessor.php' => 'Data Preprocessor',
    'src/Trainer.php' => 'ML Model Trainer',
    'src/Evaluator.php' => 'Model Evaluator',
    'src/MLPipeline.php' => 'Main Pipeline'
];

foreach ($sourceFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}\n";
    } else {
        echo "❌ {$description}: {$file} (missing)\n";
    }
}

// Check web interface files
echo "\n🌐 Web Interface Check:\n";
$webFiles = [
    'public/index.php' => 'Home Page',
    'public/dataset.php' => 'Dataset Page',
    'public/methodology.php' => 'Methodology Page',
    'public/results.php' => 'Results Page',
    'public/conclusion.php' => 'Conclusion Page'
];

foreach ($webFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}\n";
    } else {
        echo "❌ {$description}: {$file} (missing)\n";
    }
}

// Check if results exist
echo "\n📈 Results Check:\n";
if (file_exists('results/metrics.json') && file_exists('results/confusion.json')) {
    echo "✅ ML pipeline results found\n";
} else {
    echo "⚠️  ML pipeline results not found\n";
    echo "   Run the pipeline: php run_pipeline.php\n";
}

echo "\n🚀 Setup Complete!\n";
echo "\n📖 Next Steps:\n";
echo "1. If dependencies not installed: composer install\n";
echo "2. Place your dataset files in data/ directory\n";
echo "3. Run ML pipeline: php run_pipeline.php\n";
echo "4. Start web server: cd public && php -S localhost:8000\n";
echo "5. Open browser: http://localhost:8000\n";
echo "\n📚 For more information, see README.md\n";
?>
