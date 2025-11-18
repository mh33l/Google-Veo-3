<?php
/**
 * TechGlow - Artikel Detail Page
 *
 * Displays full article content
 */

require_once '../includes/config.php';

// Get article slug from URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: artikel.php');
    exit;
}

// Get database connection
$pdo = getDbConnection();

if (!$pdo) {
    die("Koneksi database gagal. Silakan cek konfigurasi.");
}

// Fetch article details
try {
    $stmt = $pdo->prepare("
        SELECT a.*, k.nama_kategori, k.icon as kategori_icon, k.slug as kategori_slug
        FROM artikel a
        JOIN kategori k ON a.kategori_id = k.id
        WHERE a.slug = :slug AND a.status = 'published'
    ");
    $stmt->execute([':slug' => $slug]);
    $artikel = $stmt->fetch();

    if (!$artikel) {
        header('Location: artikel.php');
        exit;
    }

    // Increment view count
    $stmt = $pdo->prepare("UPDATE artikel SET views = views + 1 WHERE id = :id");
    $stmt->execute([':id' => $artikel['id']]);
} catch (PDOException $e) {
    error_log("Error fetching article: " . $e->getMessage());
    header('Location: artikel.php');
    exit;
}

// Fetch related articles
try {
    $stmt = $pdo->prepare("
        SELECT a.*, k.nama_kategori
        FROM artikel a
        JOIN kategori k ON a.kategori_id = k.id
        WHERE a.kategori_id = :kategori_id
          AND a.id != :current_id
          AND a.status = 'published'
        ORDER BY a.tanggal DESC
        LIMIT 3
    ");
    $stmt->execute([
        ':kategori_id' => $artikel['kategori_id'],
        ':current_id' => $artikel['id']
    ]);
    $related_articles = $stmt->fetchAll();
} catch (PDOException $e) {
    $related_articles = [];
}

$page_title = $artikel['judul'];
require_once '../includes/header.php';
?>

<!-- Article Header -->
<section class="article-header py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../index.php">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="artikel.php">Artikel</a></li>
                        <li class="breadcrumb-item">
                            <a href="artikel.php?kategori=<?php echo urlencode($artikel['kategori_slug']); ?>">
                                <?php echo sanitizeOutput($artikel['nama_kategori']); ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php echo sanitizeOutput(truncateText($artikel['judul'], 50)); ?>
                        </li>
                    </ol>
                </nav>

                <span class="badge bg-primary mb-3">
                    <i class="fas <?php echo sanitizeOutput($artikel['kategori_icon']); ?> me-1"></i>
                    <?php echo sanitizeOutput($artikel['nama_kategori']); ?>
                </span>

                <h1 class="display-5 fw-bold mb-3">
                    <?php echo sanitizeOutput($artikel['judul']); ?>
                </h1>

                <div class="d-flex gap-3 text-muted mb-3">
                    <span>
                        <i class="bi bi-calendar3 me-1"></i>
                        <?php echo formatTanggal($artikel['tanggal']); ?>
                    </span>
                    <span>
                        <i class="bi bi-eye me-1"></i>
                        <?php echo number_format($artikel['views'] + 1); ?> views
                    </span>
                    <span>
                        <i class="bi bi-clock me-1"></i>
                        <?php echo ceil(str_word_count($artikel['konten']) / 200); ?> min read
                    </span>
                </div>

                <p class="lead text-muted">
                    <?php echo sanitizeOutput($artikel['ringkasan']); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="article-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="card shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="article-text">
                            <?php
                            // Convert line breaks to paragraphs for better formatting
                            $konten = sanitizeOutput($artikel['konten']);
                            $paragraphs = explode("\n\n", $konten);
                            foreach ($paragraphs as $paragraph) {
                                if (trim($paragraph)) {
                                    echo "<p class='mb-4'>" . nl2br(trim($paragraph)) . "</p>";
                                }
                            }
                            ?>
                        </div>

                        <hr class="my-4">

                        <!-- Share Buttons -->
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <strong>Bagikan artikel ini:</strong>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(SITE_URL . '/pages/artikel_detail.php?slug=' . $artikel['slug']); ?>"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm"
                                   title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(SITE_URL . '/pages/artikel_detail.php?slug=' . $artikel['slug']); ?>&text=<?php echo urlencode($artikel['judul']); ?>"
                                   target="_blank"
                                   class="btn btn-outline-info btn-sm"
                                   title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(SITE_URL . '/pages/artikel_detail.php?slug=' . $artikel['slug']); ?>"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm"
                                   title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://wa.me/?text=<?php echo urlencode($artikel['judul'] . ' - ' . SITE_URL . '/pages/artikel_detail.php?slug=' . $artikel['slug']); ?>"
                                   target="_blank"
                                   class="btn btn-outline-success btn-sm"
                                   title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Navigation Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <a href="artikel.php" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali ke Artikel
                    </a>
                    <a href="artikel.php?kategori=<?php echo urlencode($artikel['kategori_slug']); ?>"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-grid me-1"></i>
                        Artikel <?php echo sanitizeOutput($artikel['nama_kategori']); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Articles -->
<?php if (!empty($related_articles)): ?>
<section class="related-articles py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h3 class="fw-bold mb-4">Artikel Terkait</h3>
                <div class="row g-3">
                    <?php foreach ($related_articles as $related): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm hover-lift">
                                <div class="card-body">
                                    <span class="badge bg-primary mb-2">
                                        <?php echo sanitizeOutput($related['nama_kategori']); ?>
                                    </span>
                                    <h6 class="card-title fw-bold">
                                        <a href="artikel_detail.php?slug=<?php echo urlencode($related['slug']); ?>"
                                           class="text-decoration-none text-dark stretched-link">
                                            <?php echo sanitizeOutput($related['judul']); ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?php echo formatTanggal($related['tanggal']); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Meta Tags for SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "<?php echo sanitizeOutput($artikel['judul']); ?>",
  "description": "<?php echo sanitizeOutput($artikel['ringkasan']); ?>",
  "datePublished": "<?php echo $artikel['tanggal']; ?>",
  "dateModified": "<?php echo $artikel['updated_at']; ?>",
  "author": {
    "@type": "Organization",
    "name": "<?php echo SITE_NAME; ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "<?php echo SITE_NAME; ?>",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo SITE_URL; ?>/assets/icons/logo.png"
    }
  }
}
</script>

<?php require_once '../includes/footer.php'; ?>
