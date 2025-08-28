# 🚀 Quick Start Guide - ASD Classification Research

Get up and running with the ASD Classification research application in minutes!

## ⚡ Quick Setup (5 minutes)

### 1. Install Dependencies
```bash
composer install
```

### 2. Check Setup
```bash
php setup.php
```

### 3. Use Sample Data (Optional)
If you don't have real ASD datasets, copy the sample files:
```bash
cp data/sample_train.csv data/train.csv
cp data/sample_test.csv data/test.csv
```

### 4. Run ML Pipeline
```bash
php run_pipeline.php
```

### 5. Start Web Interface
```bash
cd public
php -S localhost:8000
```

### 6. Open Browser
Navigate to: `http://localhost:8000`

## 🎯 What You'll See

### Home Page (`/`)
- Research overview and navigation
- Beautiful gradient design
- Author information

### Dataset Page (`/dataset.php`)
- Dataset statistics and charts
- Preprocessing pipeline visualization
- Class distribution analysis

### Methodology Page (`/methodology.php`)
- Step-by-step ML pipeline
- Technical implementation details
- Algorithm explanations

### Results Page (`/results.php`)
- Model performance metrics
- Confusion matrices
- Performance comparison charts

### Conclusion Page (`/conclusion.php`)
- Research findings summary
- Future work recommendations
- Technical recommendations

## 🔧 Troubleshooting

### Common Issues & Solutions

**"Class not found" error:**
```bash
composer dump-autoload
```

**"Data files not found":**
- Ensure `train.csv` and `test.csv` are in `data/` directory
- Or use sample files: `data/sample_train.csv` and `data/sample_test.csv`

**Memory issues:**
- Increase PHP memory limit in `php.ini`
- Use smaller datasets for testing

**Web server issues:**
- Check PHP version (requires 8.0+)
- Verify file permissions

## 📊 Sample Data Format

Your CSV files should have this structure:
```csv
age,gender,ethnicity,family_history,communication_delay,social_interaction,repetitive_behavior,sensory_sensitivity,class
5,Male,White,Yes,Yes,Yes,Yes,Yes,ASD
6,Female,Hispanic,No,No,No,No,No,Not ASD
...
```

## 🎉 Success Indicators

When everything works correctly, you should see:
- ✅ Setup script shows all green checkmarks
- ✅ ML pipeline runs without errors
- ✅ Results files generated in `results/` directory
- ✅ Web interface loads all pages
- ✅ Charts and visualizations display properly

## 🆘 Need Help?

1. **Check the setup script:** `php setup.php`
2. **Read the full README.md**
3. **Check error logs** in your web server
4. **Verify PHP version:** `php -v`

## 🚀 Next Steps

After successful setup:
1. **Replace sample data** with real ASD datasets
2. **Customize the research** for your specific needs
3. **Extend the models** with additional algorithms
4. **Deploy to production** for clinical use

---

**Happy Researching! 🧠✨**
