# TechGlow Deployment Guide

Panduan lengkap untuk mendeploy TechGlow Portfolio Website ke StackCP hosting.

## 📋 Pre-Deployment Checklist

- [ ] Akun hosting StackCP aktif
- [ ] Domain techglow.biz.id terhubung
- [ ] Database MySQL telah dibuat
- [ ] FTP/SFTP credentials tersedia
- [ ] File project telah disiapkan

## 🚀 Deployment Steps

### 1. Setup Database

#### A. Create Database via StackCP Panel

1. Login ke StackCP control panel
2. Navigate ke **MySQL Databases**
3. Create database dengan nama: `techglow-35303934d0ae`
4. Create user: `techglow`
5. Set password: (sesuai konfigurasi)
6. Grant ALL PRIVILEGES

#### B. Import Database Schema

**Via phpMyAdmin:**
1. Login ke phpMyAdmin
2. Select database `techglow-35303934d0ae`
3. Click tab **Import**
4. Choose file `database_schema.sql`
5. Click **Go** button

**Via SSH/Terminal:**
```bash
mysql -u techglow -p techglow-35303934d0ae < database_schema.sql
```

#### C. Verify Database

```sql
-- Check tables created
SHOW TABLES;

-- Check sample data
SELECT COUNT(*) FROM artikel;
SELECT COUNT(*) FROM ai_tools;
SELECT COUNT(*) FROM portofolio;
```

### 2. Configure Application

#### Update config.php

Edit `includes/config.php`:

```php
// Database credentials
define('DB_HOST', 'localhost'); // or your MySQL host
define('DB_NAME', 'techglow-35303934d0ae');
define('DB_USER', 'techglow');
define('DB_PASS', 'your_actual_password'); // CHANGE THIS!

// Site configuration
define('SITE_URL', 'https://techglow.biz.id');

// Error reporting (PRODUCTION)
error_reporting(0);
ini_set('display_errors', 0);
```

**IMPORTANT**:
- Set error reporting to 0 in production
- Update SITE_URL with your actual domain
- Use strong database password

### 3. Upload Files

#### Via FTP/SFTP (Recommended)

**Using FileZilla:**

1. Open FileZilla
2. Enter connection details:
   - **Host**: sdb-83.hosting.stackcp.net
   - **Username**: your_ftp_username
   - **Password**: your_ftp_password
   - **Port**: 21 (FTP) or 22 (SFTP)

3. Navigate to: `/home/sites/18a/3/34abd97c7e/techglow_html`

4. Upload all files:
   ```
   techglow_html/
   ├── assets/
   ├── includes/
   ├── pages/
   ├── .htaccess
   ├── index.php
   └── database_schema.sql (optional, for backup)
   ```

#### Via cPanel File Manager

1. Login to cPanel
2. Open **File Manager**
3. Navigate to `techglow_html` directory
4. Click **Upload**
5. Upload all project files
6. Extract if uploaded as ZIP

### 4. Set File Permissions

#### Via FTP Client

Set permissions for directories and files:

```
Directories: 755
Files: 644
.htaccess: 644
```

#### Via SSH

```bash
# Navigate to project directory
cd /home/sites/18a/3/34abd97c7e/techglow_html

# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make sure index.php is readable
chmod 644 index.php
```

### 5. Configure Web Server

#### Apache (.htaccess)

The `.htaccess` file is already configured for:
- HTTPS redirect
- Security headers
- Compression
- Browser caching
- Error pages

Verify `.htaccess` is uploaded and active.

#### Verify mod_rewrite

Create test file `test_rewrite.php`:

```php
<?php
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo in_array('mod_rewrite', $modules) ? 'mod_rewrite enabled' : 'mod_rewrite disabled';
} else {
    echo 'Cannot determine';
}
```

### 6. DNS Configuration

Verify domain is pointing to correct server:

```bash
# Check DNS records
nslookup techglow.biz.id

# Should point to StackCP server IP
```

### 7. SSL Certificate

#### Via StackCP Panel

1. Navigate to **SSL/TLS**
2. Select **Let's Encrypt**
3. Generate certificate for `techglow.biz.id`
4. Enable auto-renewal

#### Verify SSL

```bash
# Test SSL certificate
curl -I https://techglow.biz.id
```

### 8. Test Deployment

#### A. Basic Connectivity

```bash
# Test homepage
curl -I https://techglow.biz.id

# Should return 200 OK
```

#### B. Database Connection

Create `test_db.php` (remove after testing):

```php
<?php
require_once 'includes/config.php';
$pdo = getDbConnection();
if ($pdo) {
    echo "Database connected successfully!";
} else {
    echo "Database connection failed!";
}
?>
```

Access: `https://techglow.biz.id/test_db.php`

#### C. Test All Pages

Visit each page and verify:
- [ ] https://techglow.biz.id/ (Homepage)
- [ ] https://techglow.biz.id/pages/artikel.php
- [ ] https://techglow.biz.id/pages/tools.php
- [ ] https://techglow.biz.id/pages/portofolio.php
- [ ] https://techglow.biz.id/pages/tentang.php
- [ ] https://techglow.biz.id/pages/kontak.php

### 9. Performance Optimization

#### Enable OPcache (via php.ini)

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

#### Database Optimization

```sql
-- Analyze tables
ANALYZE TABLE artikel, ai_tools, portofolio, kategori;

-- Optimize tables
OPTIMIZE TABLE artikel, ai_tools, portofolio, kategori;
```

### 10. Security Hardening

#### A. Protect Sensitive Files

```apache
# In .htaccess (already included)
<FilesMatch "^(config\.php|database_schema\.sql)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

#### B. Update Passwords

Change default database password:

```sql
ALTER USER 'techglow'@'localhost' IDENTIFIED BY 'new_strong_password';
FLUSH PRIVILEGES;
```

#### C. Disable Error Display (Production)

In `includes/config.php`:

```php
error_reporting(0);
ini_set('display_errors', 0);
error_log('/path/to/error.log'); // Set error log path
```

### 11. Monitoring Setup

#### A. Enable Error Logging

```php
// In config.php
ini_set('log_errors', 1);
ini_set('error_log', '/home/sites/18a/3/34abd97c7e/logs/php_errors.log');
```

#### B. Monitor Traffic

Use StackCP analytics or install Google Analytics:

```html
<!-- Add to includes/header.php before </head> -->
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_TRACKING_ID');
</script>
```

### 12. Backup Strategy

#### Automated Database Backup

Create backup script `backup.sh`:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/sites/18a/3/34abd97c7e/backups"
DB_NAME="techglow-35303934d0ae"
DB_USER="techglow"
DB_PASS="your_password"

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/backup_$DATE.sql

# Keep only last 7 days
find $BACKUP_DIR -name "backup_*.sql" -mtime +7 -delete
```

Set cron job:

```bash
# Edit crontab
crontab -e

# Add daily backup at 2 AM
0 2 * * * /home/sites/18a/3/34abd97c7e/backup.sh
```

## ✅ Post-Deployment Validation

### Checklist

- [ ] Homepage loads successfully
- [ ] All navigation links work
- [ ] Database connection successful
- [ ] Articles display correctly
- [ ] AI Tools page functional
- [ ] Portfolio page shows projects
- [ ] Contact form works
- [ ] Responsive design on mobile
- [ ] HTTPS certificate active
- [ ] No console errors
- [ ] No PHP errors
- [ ] Images load correctly
- [ ] CSS/JS files load
- [ ] Search functionality works
- [ ] Filters work properly

### Performance Tests

```bash
# Test page load speed
curl -o /dev/null -s -w "Time: %{time_total}s\n" https://techglow.biz.id

# Test with compression
curl -H "Accept-Encoding: gzip" -I https://techglow.biz.id
```

### Security Tests

- [ ] SQL injection protection (try in search)
- [ ] XSS protection (try in forms)
- [ ] CSRF tokens (if implemented)
- [ ] Secure headers present
- [ ] SSL certificate valid
- [ ] No sensitive files accessible

## 🔧 Troubleshooting

### Common Issues

#### 1. "500 Internal Server Error"

**Solution:**
- Check `.htaccess` syntax
- Verify file permissions (755 for directories, 644 for files)
- Check PHP error logs
- Disable `.htaccess` temporarily to test

#### 2. "Database Connection Failed"

**Solution:**
- Verify database credentials in `config.php`
- Check if database exists
- Verify user has proper privileges
- Test MySQL connection via command line

#### 3. "Page Not Found" (404 errors)

**Solution:**
- Verify file paths are correct
- Check if mod_rewrite is enabled
- Review `.htaccess` rewrite rules
- Ensure all files uploaded correctly

#### 4. CSS/JS Not Loading

**Solution:**
- Check CDN links in `header.php`
- Verify file paths
- Check browser console for errors
- Clear browser cache

#### 5. Images Not Displaying

**Solution:**
- Verify image paths in database
- Check file permissions
- Ensure images uploaded to correct directory

## 📞 Support

If you encounter issues:

1. Check error logs: `/logs/php_errors.log`
2. Enable debug mode temporarily (in config.php)
3. Contact StackCP support for server-specific issues
4. Review this deployment guide again

## 🎉 Success!

Your TechGlow website should now be live at:
**https://techglow.biz.id**

Enjoy your new portfolio website!

---

**Last Updated**: January 2025
**Version**: 1.0.0
