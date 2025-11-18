<?php
/**
 * TechGlow - Homepage
 *
 * Displays blog articles, AI tools, and portfolio sections
 */

require_once 'includes/config.php';

// Get database connection
$pdo = getDbConnection();

if (!$pdo) {
    die("Koneksi database gagal. Silakan cek konfigurasi.");
}

// Fetch latest 6 articles
try {
    $stmt = $pdo->prepare("
        SELECT a.*, k.nama_kategori, k.icon as kategori_icon
        FROM artikel a
        JOIN kategori k ON a.kategori_id = k.id
        WHERE a.status = 'published'
        ORDER BY a.tanggal DESC
        LIMIT 6
    ");
    $stmt->execute();
    $artikel_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $artikel_list = [];
    error_log("Error fetching articles: " . $e->getMessage());
}

// Fetch 6 AI Tools (prioritize favorites)
try {
    $stmt = $pdo->prepare("
        SELECT *
        FROM ai_tools
        ORDER BY is_favorite DESC, urutan ASC
        LIMIT 6
    ");
    $stmt->execute();
    $tools_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $tools_list = [];
    error_log("Error fetching AI tools: " . $e->getMessage());
}

// Fetch 3 latest portfolio projects
try {
    $stmt = $pdo->prepare("
        SELECT *
        FROM portofolio
        WHERE status = 'completed'
        ORDER BY urutan ASC, tanggal_selesai DESC
        LIMIT 3
    ");
    $stmt->execute();
    $portofolio_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $portofolio_list = [];
    error_log("Error fetching portfolio: " . $e->getMessage());
}

$page_title = "Beranda";
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section bg-gradient text-white py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-lightning-charge-fill text-warning"></i>
                    Selamat Datang di TechGlow
                </h1>
                <p class="lead mb-4">
                    Portal teknologi untuk artikel blog, AI tools terbaik, dan showcase portfolio development projects
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="pages/artikel.php" class="btn btn-warning btn-lg">
                        <i class="bi bi-newspaper me-2"></i>Baca Artikel
                    </a>
                    <a href="pages/tools.php" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-robot me-2"></i>Lihat AI Tools
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Artikel Blog Section -->
<section class="artikel-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold">
                <i class="bi bi-newspaper text-primary me-2"></i>
                Artikel Blog Terbaru
            </h2>
            <p class="text-muted">Baca artikel terbaru tentang teknologi, programming, dan development</p>
        </div>

        <div class="row g-4">
            <?php if (empty($artikel_list)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada artikel tersedia.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($artikel_list as $artikel): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-lift">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-primary me-2">
                                        <i class="fas <?php echo sanitizeOutput($artikel['kategori_icon']); ?> me-1"></i>
                                        <?php echo sanitizeOutput($artikel['nama_kategori']); ?>
                                    </span>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?php echo formatTanggal($artikel['tanggal']); ?>
                                    </small>
                                </div>
                                <h5 class="card-title fw-bold">
                                    <?php echo sanitizeOutput($artikel['judul']); ?>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php echo sanitizeOutput(truncateText($artikel['ringkasan'], 120)); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="pages/artikel_detail.php?slug=<?php echo urlencode($artikel['slug']); ?>"
                                       class="btn btn-outline-primary btn-sm">
                                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i><?php echo number_format($artikel['views']); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($artikel_list)): ?>
            <div class="text-center mt-4">
                <a href="pages/artikel.php" class="btn btn-primary btn-lg">
                    Lihat Semua Artikel <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- AI Tools Section -->
<section class="tools-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold">
                <i class="bi bi-robot text-success me-2"></i>
                AI Tools Rekomendasi
            </h2>
            <p class="text-muted">Koleksi AI tools terbaik untuk meningkatkan produktivitas development</p>
        </div>

        <div class="row g-4">
            <?php if (empty($tools_list)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada AI tools tersedia.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($tools_list as $tool): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-lift">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="tool-icon me-3">
                                        <i class="fas <?php echo sanitizeOutput($tool['icon']); ?> fa-2x text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title fw-bold mb-1">
                                            <?php echo sanitizeOutput($tool['nama_tool']); ?>
                                            <?php if ($tool['is_favorite']): ?>
                                                <i class="bi bi-star-fill text-warning ms-1" title="Favorit"></i>
                                            <?php endif; ?>
                                        </h5>
                                        <?php if ($tool['kategori_tool']): ?>
                                            <span class="badge bg-success-subtle text-success">
                                                <?php echo sanitizeOutput($tool['kategori_tool']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <p class="card-text text-muted">
                                    <?php echo sanitizeOutput($tool['deskripsi']); ?>
                                </p>
                                <?php if ($tool['url']): ?>
                                    <a href="<?php echo sanitizeOutput($tool['url']); ?>"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn btn-outline-success btn-sm mt-2">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>
                                        Kunjungi Website
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($tools_list)): ?>
            <div class="text-center mt-4">
                <a href="pages/tools.php" class="btn btn-success btn-lg">
                    Lihat Semua AI Tools <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Portofolio Section -->
<section class="portofolio-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold">
                <i class="bi bi-briefcase text-warning me-2"></i>
                Portofolio Projects
            </h2>
            <p class="text-muted">Showcase project development yang telah dikerjakan</p>
        </div>

        <div class="row g-4">
            <?php if (empty($portofolio_list)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada portofolio tersedia.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($portofolio_list as $project): ?>
                    <div class="col-lg-4">
                        <div class="card h-100 shadow-sm hover-lift">
                            <div class="card-body">
                                <div class="project-icon mb-3">
                                    <i class="fas <?php echo sanitizeOutput($project['icon']); ?> fa-3x text-warning"></i>
                                </div>
                                <h5 class="card-title fw-bold">
                                    <?php echo sanitizeOutput($project['nama_proyek']); ?>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php echo sanitizeOutput($project['deskripsi']); ?>
                                </p>
                                <div class="mb-3">
                                    <strong class="d-block mb-2">
                                        <i class="bi bi-tools me-1"></i>Teknologi:
                                    </strong>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php
                                        $teknologi_array = explode(', ', $project['teknologi']);
                                        foreach ($teknologi_array as $tech):
                                        ?>
                                            <span class="badge bg-secondary"><?php echo sanitizeOutput($tech); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <?php if ($project['link_demo']): ?>
                                        <a href="<?php echo sanitizeOutput($project['link_demo']); ?>"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye me-1"></i>Demo
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($project['link_github']): ?>
                                        <a href="<?php echo sanitizeOutput($project['link_github']); ?>"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-outline-dark btn-sm">
                                            <i class="bi bi-github me-1"></i>GitHub
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($portofolio_list)): ?>
            <div class="text-center mt-4">
                <a href="pages/portofolio.php" class="btn btn-warning btn-lg">
                    Lihat Semua Portofolio <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
