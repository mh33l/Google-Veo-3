-- TechGlow Database Schema
-- Database: techglow-35303934d0ae
-- PHP Version: 8.4
-- MySQL Version: 5.7+

-- Create database (if running locally)
-- CREATE DATABASE IF NOT EXISTS `techglow-35303934d0ae` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `techglow-35303934d0ae`;

-- Table: Kategori Artikel
CREATE TABLE IF NOT EXISTS `kategori` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nama_kategori` VARCHAR(100) NOT NULL,
    `icon` VARCHAR(50) DEFAULT 'fa-folder',
    `slug` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: Artikel Blog
CREATE TABLE IF NOT EXISTS `artikel` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `judul` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `ringkasan` TEXT,
    `konten` TEXT NOT NULL,
    `kategori_id` INT(11) NOT NULL,
    `thumbnail` VARCHAR(255) DEFAULT NULL,
    `tanggal` DATE NOT NULL,
    `views` INT(11) DEFAULT 0,
    `status` ENUM('draft', 'published') DEFAULT 'published',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    KEY `kategori_id` (`kategori_id`),
    KEY `tanggal` (`tanggal`),
    CONSTRAINT `fk_artikel_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: AI Tools
CREATE TABLE IF NOT EXISTS `ai_tools` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nama_tool` VARCHAR(150) NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `url` VARCHAR(255) DEFAULT NULL,
    `icon` VARCHAR(50) DEFAULT 'fa-robot',
    `kategori_tool` VARCHAR(100) DEFAULT NULL,
    `is_favorite` TINYINT(1) DEFAULT 0,
    `urutan` INT(11) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: Portofolio
CREATE TABLE IF NOT EXISTS `portofolio` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nama_proyek` VARCHAR(200) NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `teknologi` VARCHAR(255) NOT NULL,
    `link_demo` VARCHAR(255) DEFAULT NULL,
    `link_github` VARCHAR(255) DEFAULT NULL,
    `thumbnail` VARCHAR(255) DEFAULT NULL,
    `icon` VARCHAR(50) DEFAULT 'fa-code',
    `tanggal_selesai` DATE DEFAULT NULL,
    `status` ENUM('completed', 'ongoing', 'archived') DEFAULT 'completed',
    `urutan` INT(11) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Kategori Data
INSERT INTO `kategori` (`nama_kategori`, `icon`, `slug`) VALUES
('Artificial Intelligence', 'fa-brain', 'artificial-intelligence'),
('Web Development', 'fa-code', 'web-development'),
('Mobile Development', 'fa-mobile', 'mobile-development'),
('Database', 'fa-database', 'database'),
('Cloud Computing', 'fa-cloud', 'cloud-computing'),
('Tutorial', 'fa-graduation-cap', 'tutorial');

-- Insert Artikel Data
INSERT INTO `artikel` (`judul`, `slug`, `ringkasan`, `konten`, `kategori_id`, `tanggal`, `views`) VALUES
('Pengenalan Machine Learning untuk Pemula', 'pengenalan-machine-learning-untuk-pemula', 'Pelajari dasar-dasar machine learning dan bagaimana teknologi AI mengubah industri teknologi modern.', 'Machine learning adalah cabang dari artificial intelligence yang memungkinkan komputer untuk belajar dari data tanpa diprogram secara eksplisit. Artikel ini membahas konsep dasar, algoritma populer, dan aplikasi praktis machine learning.', 1, '2025-01-15', 245),
('Membangun REST API dengan PHP 8.4', 'membangun-rest-api-dengan-php-8-4', 'Tutorial lengkap membuat RESTful API menggunakan fitur terbaru PHP 8.4 dan best practices modern.', 'PHP 8.4 membawa banyak fitur baru yang memudahkan pembuatan REST API. Dalam tutorial ini, kita akan membahas routing, middleware, authentication, dan dokumentasi API.', 2, '2025-01-12', 189),
('Flutter vs React Native: Perbandingan 2025', 'flutter-vs-react-native-perbandingan-2025', 'Analisis mendalam tentang kelebihan dan kekurangan kedua framework mobile development terpopuler.', 'Memilih framework mobile development yang tepat sangat penting untuk kesuksesan proyek. Artikel ini membandingkan Flutter dan React Native dari segi performa, ekosistem, dan kemudahan penggunaan.', 3, '2025-01-10', 312),
('Optimasi Query MySQL untuk Performa Maksimal', 'optimasi-query-mysql-untuk-performa-maksimal', 'Tips dan trik mengoptimalkan query database MySQL untuk aplikasi dengan traffic tinggi.', 'Query database yang lambat dapat mempengaruhi performa aplikasi secara keseluruhan. Pelajari teknik indexing, query optimization, dan caching untuk meningkatkan kecepatan database.', 4, '2025-01-08', 156),
('Deploy Aplikasi ke AWS: Panduan Lengkap', 'deploy-aplikasi-ke-aws-panduan-lengkap', 'Panduan step-by-step mendeploy aplikasi web ke Amazon Web Services dengan berbagai layanan.', 'Amazon Web Services menyediakan berbagai layanan cloud computing. Tutorial ini membahas EC2, S3, RDS, dan layanan AWS lainnya untuk deployment aplikasi production-ready.', 5, '2025-01-05', 201),
('CSS Grid vs Flexbox: Kapan Menggunakan Keduanya', 'css-grid-vs-flexbox-kapan-menggunakan-keduanya', 'Memahami perbedaan CSS Grid dan Flexbox serta skenario terbaik untuk menggunakannya.', 'CSS Grid dan Flexbox adalah dua sistem layout powerful di CSS modern. Artikel ini menjelaskan karakteristik masing-masing dan kapan harus menggunakan Grid atau Flexbox.', 2, '2025-01-03', 178),
('Git untuk Tim: Workflow dan Best Practices', 'git-untuk-tim-workflow-dan-best-practices', 'Strategi git branching dan collaboration untuk tim development yang efektif.', 'Bekerja dengan git dalam tim memerlukan workflow yang terstruktur. Pelajari git flow, trunk-based development, dan best practices untuk code review dan merge strategy.', 6, '2025-01-01', 267);

-- Insert AI Tools Data
INSERT INTO `ai_tools` (`nama_tool`, `deskripsi`, `url`, `icon`, `kategori_tool`, `is_favorite`, `urutan`) VALUES
('Blackbox AI', 'AI coding assistant terbaik untuk generate code, refactor, dan debugging. Mendukung berbagai bahasa pemrograman.', 'https://blackbox.ai', 'fa-code', 'Development', 1, 1),
('ChatGPT', 'AI conversational model dari OpenAI untuk berbagai keperluan termasuk coding, writing, dan problem solving.', 'https://chat.openai.com', 'fa-comments', 'General', 1, 2),
('GitHub Copilot', 'AI pair programmer yang terintegrasi dengan IDE untuk code completion dan suggestions.', 'https://github.com/features/copilot', 'fa-github', 'Development', 1, 3),
('Google Gemini', 'AI multimodal dari Google yang dapat memproses text, image, dan code dengan kemampuan reasoning tinggi.', 'https://gemini.google.com', 'fa-gem', 'General', 1, 4),
('Midjourney', 'AI image generator untuk membuat artwork, desain, dan visualisasi kreatif dengan kualitas tinggi.', 'https://midjourney.com', 'fa-image', 'Design', 0, 5),
('Claude AI', 'AI assistant dari Anthropic dengan kemampuan analisis mendalam dan coding yang powerful.', 'https://claude.ai', 'fa-robot', 'General', 0, 6),
('Cursor', 'AI-powered code editor dengan fitur autocompletion dan refactoring cerdas.', 'https://cursor.sh', 'fa-edit', 'Development', 0, 7),
('Perplexity AI', 'AI search engine yang memberikan jawaban akurat dengan source citation untuk research.', 'https://perplexity.ai', 'fa-search', 'Research', 0, 8);

-- Insert Portofolio Data
INSERT INTO `portofolio` (`nama_proyek`, `deskripsi`, `teknologi`, `link_demo`, `link_github`, `icon`, `tanggal_selesai`, `status`, `urutan`) VALUES
('TechGlow Portfolio Website', 'Website portfolio modern dengan PHP native dan Bootstrap 5. Menampilkan artikel blog, AI tools, dan project showcase dengan database MySQL.', 'PHP 8.4, Bootstrap 5, MySQL, JavaScript', 'https://techglow.biz.id', 'https://github.com/techglow/portfolio', 'fa-globe', '2025-01-18', 'completed', 1),
('E-Commerce Dashboard', 'Dashboard admin untuk toko online dengan fitur manajemen produk, orders, dan analytics real-time menggunakan Chart.js.', 'Laravel 11, Vue.js, MySQL, TailwindCSS', 'https://demo.techglow.biz.id/ecommerce', 'https://github.com/techglow/ecommerce-dashboard', 'fa-shopping-cart', '2024-12-20', 'completed', 2),
('API Gateway Microservices', 'API Gateway untuk arsitektur microservices dengan authentication, rate limiting, dan load balancing. Dokumentasi lengkap dengan OpenAPI.', 'Node.js, Express, Redis, Docker', NULL, 'https://github.com/techglow/api-gateway', 'fa-network-wired', '2024-11-15', 'completed', 3);

-- Create indexes for performance
CREATE INDEX idx_artikel_status_tanggal ON artikel(status, tanggal DESC);
CREATE INDEX idx_ai_tools_favorite ON ai_tools(is_favorite, urutan);
CREATE INDEX idx_portofolio_status_urutan ON portofolio(status, urutan);

-- Views count increment function (optional, can be done in PHP)
-- This shows the database structure is prepared for analytics
