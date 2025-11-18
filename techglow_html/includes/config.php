<?php
/**
 * TechGlow Database Configuration
 *
 * This file contains database connection settings and helper functions
 * for the TechGlow portfolio website.
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'techglow-35303934d0ae');
define('DB_USER', 'techglow');
define('DB_PASS', 'techglow<?php');
define('DB_CHARSET', 'utf8mb4');

// Site configuration
define('SITE_NAME', 'TechGlow');
define('SITE_URL', 'https://techglow.biz.id');
define('SITE_DESCRIPTION', 'Blog Teknologi, AI Tools & Portfolio');

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Get database connection using PDO
 *
 * @return PDO|null Returns PDO connection or null on failure
 */
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database Connection Error: " . $e->getMessage());
        return null;
    }
}

/**
 * Sanitize output for HTML display
 *
 * @param string $string The string to sanitize
 * @return string Sanitized string
 */
function sanitizeOutput($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Format date to Indonesian format
 *
 * @param string $date Date string
 * @return string Formatted date
 */
function formatTanggal($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = $bulan[(int)date('m', $timestamp)];
    $year = date('Y', $timestamp);

    return "$day $month $year";
}

/**
 * Get current page name for active menu highlighting
 *
 * @return string Current page name
 */
function getCurrentPage() {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    return $page === 'index' ? 'home' : $page;
}

/**
 * Truncate text to specified length
 *
 * @param string $text Text to truncate
 * @param int $length Maximum length
 * @return string Truncated text
 */
function truncateText($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}
?>
