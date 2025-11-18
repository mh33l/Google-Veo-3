# TechGlow Quick Start Guide

Get your TechGlow website up and running in minutes!

## ⚡ Quick Installation (5 Steps)

### Step 1: Download Project
```bash
# You already have the files in: techglow_html/
```

### Step 2: Create Database
```sql
-- Login to MySQL
mysql -u root -p

-- Create database
CREATE DATABASE `techglow-35303934d0ae` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'techglow'@'localhost' IDENTIFIED BY 'your_strong_password';

-- Grant privileges
GRANT ALL PRIVILEGES ON `techglow-35303934d0ae`.* TO 'techglow'@'localhost';
FLUSH PRIVILEGES;

-- Exit MySQL
exit;
```

### Step 3: Import Database
```bash
mysql -u techglow -p techglow-35303934d0ae < database_schema.sql
```

### Step 4: Configure Application
```bash
# Edit config file
nano includes/config.php

# Update these lines:
define('DB_PASS', 'your_strong_password');  # Your actual password
define('SITE_URL', 'https://techglow.biz.id');  # Your domain

# Save and exit (Ctrl+X, Y, Enter)
```

### Step 5: Upload & Test
```bash
# Upload via FTP to:
/home/sites/18a/3/34abd97c7e/techglow_html/

# Or copy if on local server:
cp -r techglow_html/* /var/www/html/

# Set permissions
chmod -R 755 /var/www/html/
chmod 644 /var/www/html/*.php
```

### Step 6: Visit Website
Open browser: `https://techglow.biz.id`

---

## 🖥️ Local Development Setup

### Requirements
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled

### Using PHP Built-in Server

```bash
# Navigate to project directory
cd techglow_html/

# Start PHP server
php -S localhost:8000

# Open browser
http://localhost:8000
```

### Using XAMPP/WAMP

1. Copy `techglow_html` to `htdocs/` or `www/`
2. Create database via phpMyAdmin
3. Import `database_schema.sql`
4. Update `includes/config.php`
5. Visit: `http://localhost/techglow_html/`

---

## 🔍 Verify Installation

### Check 1: Database Connection
```bash
# Create test file
echo '<?php
require_once "includes/config.php";
$pdo = getDbConnection();
echo $pdo ? "✅ Database connected!" : "❌ Connection failed!";
?>' > test.php

# Visit: http://your-domain/test.php
# Delete test.php after verification
```

### Check 2: Pages Loading
Visit each page and verify no errors:
- ✅ Homepage: `/`
- ✅ Artikel: `/pages/artikel.php`
- ✅ Tools: `/pages/tools.php`
- ✅ Portfolio: `/pages/portofolio.php`
- ✅ About: `/pages/tentang.php`
- ✅ Contact: `/pages/kontak.php`

### Check 3: Data Loading
- ✅ Homepage shows 6 articles
- ✅ Homepage shows 6 AI tools
- ✅ Homepage shows 3 portfolio projects
- ✅ Search works on artikel page
- ✅ Filters work on all pages

---

## 🐛 Common Issues & Fixes

### Issue 1: "Database Connection Failed"

**Fix:**
```bash
# Check credentials
cat includes/config.php | grep "DB_"

# Test MySQL connection
mysql -u techglow -p techglow-35303934d0ae -e "SELECT 1"

# Verify user privileges
mysql -u root -p -e "SHOW GRANTS FOR 'techglow'@'localhost'"
```

### Issue 2: "500 Internal Server Error"

**Fix:**
```bash
# Check Apache error log
tail -f /var/log/apache2/error.log

# Check file permissions
ls -la techglow_html/

# Fix permissions if needed
chmod 755 techglow_html/
chmod 644 techglow_html/*.php
```

### Issue 3: "Page Not Found"

**Fix:**
```bash
# Check mod_rewrite is enabled
apache2ctl -M | grep rewrite

# Enable mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2

# Check .htaccess exists
ls -la techglow_html/.htaccess
```

### Issue 4: CSS/JS Not Loading

**Fix:**
```bash
# Check file paths
ls -la techglow_html/assets/css/
ls -la techglow_html/assets/js/

# Clear browser cache
Ctrl+Shift+R (hard refresh)

# Check CDN links
curl -I https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css
```

---

## 📦 Production Deployment Checklist

### Before Going Live:

- [ ] Change database password to strong password
- [ ] Update SITE_URL in config.php
- [ ] Set error_reporting to 0 in config.php
- [ ] Remove test files (test.php, test_db.php)
- [ ] Configure SSL certificate
- [ ] Set up automated backups
- [ ] Configure email for contact form
- [ ] Add Google Analytics (optional)
- [ ] Test all pages on mobile devices
- [ ] Run security scan
- [ ] Enable HTTPS redirect
- [ ] Set up monitoring

### Production config.php Settings:

```php
// PRODUCTION SETTINGS
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/logs/php_errors.log');

define('SITE_URL', 'https://techglow.biz.id');
```

---

## 🔐 Security Best Practices

### 1. Strong Passwords
```bash
# Generate strong password
openssl rand -base64 32
```

### 2. Protect Config File
```apache
# Already in .htaccess
<FilesMatch "^config\.php$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### 3. Database Backups
```bash
# Manual backup
mysqldump -u techglow -p techglow-35303934d0ae > backup_$(date +%Y%m%d).sql

# Automated daily backup (crontab)
0 2 * * * mysqldump -u techglow -p'password' techglow-35303934d0ae > /backups/backup_$(date +\%Y\%m\%d).sql
```

### 4. Update Regularly
- Keep PHP updated
- Keep MySQL updated
- Monitor security advisories
- Update dependencies

---

## 📊 Performance Optimization

### Enable OPcache
```ini
; Add to php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
```

### Database Optimization
```sql
-- Run monthly
ANALYZE TABLE artikel, ai_tools, portofolio, kategori;
OPTIMIZE TABLE artikel, ai_tools, portofolio, kategori;
```

### Enable Compression
```apache
# Already in .htaccess
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css application/javascript
</IfModule>
```

---

## 🎨 Customization Tips

### Change Colors
Edit `assets/css/style.css`:
```css
:root {
    --primary-color: #0d6efd;    /* Your primary color */
    --warning-color: #ffc107;    /* Your accent color */
}
```

### Add New Page
1. Copy `pages/tentang.php`
2. Rename and edit content
3. Add link to `includes/header.php`

### Add Content
```sql
-- Add new article
INSERT INTO artikel (judul, slug, ringkasan, konten, kategori_id, tanggal)
VALUES ('Your Title', 'your-slug', 'Summary', 'Content', 1, CURDATE());

-- Add new AI tool
INSERT INTO ai_tools (nama_tool, deskripsi, url, icon, kategori_tool)
VALUES ('Tool Name', 'Description', 'https://...', 'fa-icon', 'Category');

-- Add new portfolio
INSERT INTO portofolio (nama_proyek, deskripsi, teknologi, link_demo, status)
VALUES ('Project Name', 'Description', 'Tech1, Tech2', 'https://...', 'completed');
```

---

## 📞 Getting Help

### Resources
- 📖 **README.md** - Full documentation
- 🚀 **DEPLOYMENT_GUIDE.md** - Detailed deployment steps
- 📋 **PROJECT_SUMMARY.md** - Project overview

### Contact
- **Email**: info@techglow.biz.id
- **Website**: https://techglow.biz.id

### Troubleshooting Steps
1. Check error logs
2. Verify database connection
3. Test file permissions
4. Review configuration
5. Search for error message online
6. Contact hosting support

---

## ✅ Installation Complete!

Your TechGlow website should now be running successfully!

**Next Steps:**
1. Add your own content to database
2. Customize colors and styling
3. Add your social media links
4. Configure contact form email
5. Set up analytics
6. Start blogging!

---

**Happy coding! 🚀**

Built with ❤️ using PHP 8.4, Bootstrap 5, and MySQL
