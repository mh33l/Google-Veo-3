# TechGlow Portfolio Website

![TechGlow](https://img.shields.io/badge/TechGlow-Portfolio-blue)
![PHP](https://img.shields.io/badge/PHP-8.4-purple)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-blue)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)

Portfolio website modern dengan PHP Native 8.4, Bootstrap 5, dan MySQL untuk menampilkan artikel blog, AI tools, dan portfolio projects.

## 📋 Deskripsi Project

TechGlow adalah platform website portfolio yang menampilkan:
- **Artikel Blog** - Konten teknologi dan programming
- **AI Tools Directory** - Rekomendasi AI tools terbaik
- **Portfolio Showcase** - Galeri project development

## 🚀 Fitur Utama

- ✅ Responsive Design (Mobile-First)
- ✅ Modular PHP Architecture
- ✅ Database-Driven Content
- ✅ Search & Filter Functionality
- ✅ Modern UI/UX dengan Bootstrap 5
- ✅ SEO-Friendly Structure
- ✅ Social Media Integration
- ✅ Interactive JavaScript Enhancements

## 🛠️ Tech Stack

### Backend
- **PHP 8.4** - Native PHP tanpa framework
- **MySQL** - Database management
- **PDO** - Database connection dengan prepared statements

### Frontend
- **Bootstrap 5.3** - CSS framework
- **Bootstrap Icons** - Icon library
- **FontAwesome 6.5** - Additional icons
- **Vanilla JavaScript** - No jQuery dependency

### Hosting
- **Provider**: StackCP
- **Server**: sdb-83.hosting.stackcp.net
- **Domain**: techglow.biz.id

## 📁 Struktur File

```
techglow_html/
├── assets/
│   ├── css/
│   │   └── style.css          # Custom CSS styling
│   ├── js/
│   │   └── main.js            # JavaScript enhancements
│   └── icons/
├── includes/
│   ├── config.php             # Database config & helper functions
│   ├── header.php             # Modular header component
│   └── footer.php             # Modular footer component
├── pages/
│   ├── artikel.php            # Artikel listing page
│   ├── artikel_detail.php     # Single artikel page
│   ├── tools.php              # AI Tools directory
│   ├── portofolio.php         # Portfolio showcase
│   ├── tentang.php            # About page
│   └── kontak.php             # Contact page
├── index.php                  # Homepage
├── database_schema.sql        # Database structure
└── README.md                  # Documentation
```

## 🔧 Instalasi

### 1. Persiapan Database

```sql
-- Import database schema
mysql -u username -p database_name < database_schema.sql
```

### 2. Konfigurasi Database

Edit file `includes/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'techglow-35303934d0ae');
define('DB_USER', 'techglow');
define('DB_PASS', 'your_password');
```

### 3. Upload ke Server

Upload semua file ke directory: `/home/sites/18a/3/34abd97c7e/techglow_html`

### 4. Set Permissions

```bash
chmod 755 techglow_html
chmod 644 techglow_html/*.php
chmod 755 techglow_html/assets
```

### 5. Akses Website

Buka browser dan akses: `https://techglow.biz.id`

## 📊 Database Schema

### Tabel Utama

1. **kategori** - Kategori artikel
2. **artikel** - Blog articles
3. **ai_tools** - AI tools directory
4. **portofolio** - Portfolio projects

### Relasi Database

```
kategori (1) ----< (N) artikel
```

## 🎨 Halaman Website

### 1. Beranda (index.php)
- Hero section
- 6 artikel terbaru
- 6 AI tools rekomendasi
- 3 portfolio projects

### 2. Artikel (artikel.php)
- Listing semua artikel
- Search functionality
- Filter by kategori
- Pagination ready

### 3. AI Tools (tools.php)
- Directory AI tools
- Filter by kategori
- Favorite tools section

### 4. Portofolio (portofolio.php)
- Portfolio showcase
- Project details
- Tech stack badges
- Statistics dashboard

### 5. Tentang (tentang.php)
- About platform
- Mission & vision
- Tech stack info
- Features highlight

### 6. Kontak (kontak.php)
- Contact form
- Contact information
- FAQ section
- Social media links

## 🔐 Security Features

- ✅ PDO Prepared Statements (SQL Injection Prevention)
- ✅ HTML Output Sanitization (XSS Prevention)
- ✅ Input Validation
- ✅ CSRF Protection Ready
- ✅ Secure Session Handling

## 📱 Responsive Breakpoints

- **Mobile**: < 576px
- **Tablet**: 576px - 768px
- **Desktop**: 768px - 992px
- **Large Desktop**: > 992px

## 🎯 Helper Functions

### config.php Functions

```php
getDbConnection()        // Get PDO database connection
sanitizeOutput($string)  // Sanitize HTML output
formatTanggal($date)     // Format date to Indonesian
getCurrentPage()         // Get current page name
truncateText($text)      // Truncate long text
```

## 🔄 Maintenance

### Update Content

1. **Artikel**: Edit via database `artikel` table
2. **AI Tools**: Edit via database `ai_tools` table
3. **Portfolio**: Edit via database `portofolio` table

### Backup Database

```bash
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
```

### Update Styling

Edit `assets/css/style.css` untuk custom styling

## 🌟 Best Practices

1. **Modular Code** - Gunakan includes untuk reusable components
2. **Security First** - Always sanitize input & output
3. **Performance** - Optimize database queries
4. **SEO** - Use semantic HTML & meta tags
5. **Accessibility** - Follow WCAG guidelines

## 📈 Performance Optimization

- ✅ Minified CSS & JS (production)
- ✅ CDN untuk Bootstrap & Icons
- ✅ Database indexing
- ✅ Lazy loading images
- ✅ Browser caching headers

## 🐛 Troubleshooting

### Database Connection Error
```php
// Check config.php credentials
// Verify MySQL service is running
// Check user permissions
```

### 404 Error on Pages
```apache
# Check .htaccess for rewrite rules
# Verify file paths are correct
```

### Styling Not Loading
```html
<!-- Verify CDN links in header.php -->
<!-- Check CSS file path -->
<!-- Clear browser cache -->
```

## 🤝 Contributing

Untuk berkontribusi:
1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📞 Kontak

- **Website**: https://techglow.biz.id
- **Email**: info@techglow.biz.id
- **GitHub**: https://github.com/techglow

## 📄 License

Copyright © 2025 TechGlow. All rights reserved.

## 🙏 Credits

- **Bootstrap**: https://getbootstrap.com
- **FontAwesome**: https://fontawesome.com
- **Bootstrap Icons**: https://icons.getbootstrap.com
- **PHP**: https://www.php.net

## 📝 Changelog

### Version 1.0.0 (2025-01-18)
- ✅ Initial release
- ✅ Complete website structure
- ✅ All main pages functional
- ✅ Database schema implemented
- ✅ Responsive design complete
- ✅ Security features implemented

---

**Built with ❤️ using PHP 8.4 & Bootstrap 5**

Generated with blackbox.ai
