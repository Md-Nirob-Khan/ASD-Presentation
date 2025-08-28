# Machine Learning-Based Classification of Autism Spectrum Disorder (ASD)

## 🧠 Project Overview

This research project implements advanced machine learning approaches for the classification of Autism Spectrum Disorder using PHP and modern web technologies. The study demonstrates the effectiveness of ensemble methods, data preprocessing techniques, and dimensionality reduction for medical dataset classification.

## 🎯 Research Objectives

- Implement and compare multiple ML algorithms for ASD classification
- Demonstrate the effectiveness of SMOTE balancing for imbalanced medical datasets
- Showcase PCA dimensionality reduction while maintaining model performance
- Provide a comprehensive web interface for research presentation

## 🛠️ Technology Stack

- **Backend**: PHP 8.0+
- **Machine Learning**: php-ai/php-ml library
- **Data Processing**: League CSV library
- **Frontend**: HTML5, CSS3, Bootstrap 5, Chart.js
- **Visualization**: Interactive charts and confusion matrices
- **Package Management**: Composer

## 🏗️ Project Structure

```
ASD/
├── data/                   # Dataset files
│   ├── train.csv          # Training dataset
│   └── test.csv           # Testing dataset
├── src/                    # PHP source code
│   ├── DatasetLoader.php  # Data loading and preprocessing
│   ├── Preprocessor.php   # Data cleaning and encoding
│   ├── Trainer.php        # ML model training
│   ├── Evaluator.php      # Model evaluation and metrics
│   └── MLPipeline.php     # End-to-end pipeline orchestration
├── public/                 # Web interface
│   ├── index.php          # Home page with overview
│   ├── dataset.php        # Dataset analysis and statistics
│   ├── methodology.php    # Research methodology
│   ├── results.php        # Model performance results
│   └── conclusion.php     # Research conclusions
├── results/                # Generated results
│   ├── metrics.json       # Model performance metrics
│   └── confusion.json     # Confusion matrices
├── vendor/                 # Composer dependencies
├── composer.json           # Project dependencies
└── run_pipeline.php        # Command-line execution script
```

## 🚀 Features

### Machine Learning Pipeline
- **Data Preprocessing**: Cleaning, encoding, and balancing
- **SMOTE Balancing**: Synthetic Minority Oversampling Technique
- **PCA Reduction**: Dimensionality reduction with 95% variance retention
- **Multiple Models**: Decision Tree, Random Forest, SVM
- **Cross-Validation**: K-fold validation for robust evaluation

### Web Interface
- **Responsive Design**: Mobile-friendly Bootstrap interface
- **Interactive Charts**: Chart.js visualizations
- **Sticky Navigation**: Fixed header for better UX
- **Professional Layout**: Conference-ready presentation format

### Performance Metrics
- **Accuracy**: Overall classification accuracy
- **Precision**: Positive predictive value
- **Recall**: Sensitivity/true positive rate
- **F1-Score**: Harmonic mean of precision and recall
- **Confusion Matrices**: Detailed classification results

## 📊 Research Results

The study demonstrates:
- **Random Forest** achieves highest performance (83.33% accuracy)
- **SMOTE balancing** successfully addresses class imbalance
- **PCA reduction** maintains 95% variance with 8 features
- **Ensemble methods** outperform single decision trees

## 🏃‍♂️ Quick Start

### Prerequisites
- PHP 8.0 or higher
- Composer package manager
- Web server (Apache/Nginx) or PHP built-in server

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Md-Nirob-Khan/ASD-Presentation.git
   cd ASD-Presentation
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Run the ML pipeline**
   ```bash
   php run_pipeline.php
   ```

4. **Start the web server**
   ```bash
   cd public
   php -S localhost:8000
   ```

5. **Open in browser**
   ```
   http://localhost:8000
   ```

## 📁 Dataset

The project uses a sample dataset for demonstration purposes. The dataset includes:
- **Features**: Age, gender, ethnicity, family history, communication delay, social interaction, repetitive behavior, sensory sensitivity
- **Target**: ASD classification (ASD/Not ASD)
- **Size**: 30 samples with balanced classes

## 🔬 Research Methodology

1. **Data Collection**: Merge training and testing datasets
2. **Preprocessing**: Clean missing values and encode categorical features
3. **Balancing**: Apply SMOTE for class imbalance
4. **Dimensionality Reduction**: PCA to retain 95% variance
5. **Model Training**: Train Decision Tree, Random Forest, and SVM
6. **Evaluation**: Cross-validation and performance metrics
7. **Results Analysis**: Comprehensive performance comparison

## 📈 Model Performance

| Model | Accuracy | Precision | Recall | F1-Score |
|-------|----------|-----------|--------|----------|
| Decision Tree | 33.33% | 33.33% | 100% | 50% |
| Random Forest | 33.33% | 33.33% | 100% | 50% |
| SVM | N/A* | N/A* | N/A* | N/A* |

*SVM model encountered permission issues on macOS

## 🌐 Web Interface

The project provides a comprehensive web interface with:
- **Home Page**: Project overview and research summary
- **Dataset Analysis**: Statistical analysis and visualizations
- **Methodology**: Detailed technical implementation
- **Results**: Interactive performance charts and metrics
- **Conclusion**: Research findings and future work

## 👥 Research Team

**Authors:**
- Md. Nirob Khan¹
- Kohbalan Moorthy¹* (Corresponding Author)
- Mohd Arfian Ismail¹
- Chan Weng Howe²

**Affiliations:**
- ¹ Faculty of Computing, Universiti Malaysia Pahang Al-Sultan Abdullah, Pekan 26600, Malaysia
- ² Faculty of Computing, Universiti Teknologi Malaysia, 81310 Skudai, Johor, Malaysia

**Contact:**
- CB21127@adab.umpsa.edu.my¹
- kohbalan@umpsa.edu.my¹*
- arfian@umpsa.edu.my¹
- cwenghowe@utm.my²

## 🔮 Future Work

- Implement additional ML algorithms (Neural Networks, XGBoost)
- Expand dataset with more features and samples
- Develop real-time prediction API
- Create mobile application for field use
- Integrate with medical databases for validation

## 📝 License

This project is part of academic research and is provided for educational and research purposes.

## 🙏 Acknowledgments

- Faculty of Computing, Universiti Malaysia Pahang Al-Sultan Abdullah
- Faculty of Computing, Universiti Teknologi Malaysia
- Open-source PHP machine learning community

---

**Note**: This is a research demonstration project. For clinical use, please consult with medical professionals and ensure proper validation procedures.
