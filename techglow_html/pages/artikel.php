<?php
/**
 * TechGlow - Artikel Blog Page
 *
 * Displays all blog articles with filtering and search
 */

require_once '../includes/config.php';

// Get database connection
$pdo = getDbConnection();

if (!$pdo) {
    die("Koneksi database gagal. Silakan cek konfigurasi.");
}

// Get filter parameters
$kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build SQL query with filters
$sql = "SELECT a.*, k.nama_kategori, k.icon as kategori_icon
        FROM artikel a
        JOIN kategori k ON a.kategori_id = k.id
        WHERE a.status = 'published'";

$params = [];

if ($kategori_filter) {
    $sql .= " AND k.slug = :kategori";
    $params[':kategori'] = $kategori_filter;
}

if ($search_query) {
    $sql .= " AND (a.judul LIKE :search OR a.ringkasan LIKE :search OR a.konten LIKE :search)";
    $params[':search'] = "%$search_query%";
}

$sql .= " ORDER BY a.tanggal DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $artikel_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $artikel_list = [];
    error_log("Error fetching articles: " . $e->getMessage());
}

// Fetch all categories for filter
try {
    $stmt = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
    $kategori_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $kategori_list = [];
}

$page_title = "Artikel Blog";
require_once '../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="bi bi-newspaper me-2"></i>
                    Artikel Blog
                </h1>
                <p class="lead">
                    Baca artikel terbaru tentang teknologi, programming, AI, dan development
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="search-filter-section py-4 bg-light">
    <div class="container">
        <form method="GET" action="artikel.php" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Cari artikel..."
                           value="<?php echo sanitizeOutput($search_query); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" name="kategori">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori_list as $kategori): ?>
                        <option value="<?php echo sanitizeOutput($kategori['slug']); ?>"
                                <?php echo $kategori_filter === $kategori['slug'] ? 'selected' : ''; ?>>
                            <?php echo sanitizeOutput($kategori['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Articles Section -->
<section class="articles-section py-5">
    <div class="container">
        <?php if ($search_query || $kategori_filter): ?>
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                Menampilkan <?php echo count($artikel_list); ?> artikel
                <?php if ($search_query): ?>
                    untuk pencarian "<strong><?php echo sanitizeOutput($search_query); ?></strong>"
                <?php endif; ?>
                <?php if ($kategori_filter): ?>
                    dalam kategori "<strong><?php
                        $selected_kategori = array_filter($kategori_list, function($k) use ($kategori_filter) {
                            return $k['slug'] === $kategori_filter;
                        });
                        echo !empty($selected_kategori) ? sanitizeOutput(reset($selected_kategori)['nama_kategori']) : '';
                    ?></strong>"
                <?php endif; ?>
                <a href="artikel.php" class="btn btn-sm btn-outline-primary ms-2">Reset Filter</a>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (empty($artikel_list)): ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center py-5">
                        <i class="bi bi-exclamation-triangle fs-1 d-block mb-3"></i>
                        <h4>Artikel Tidak Ditemukan</h4>
                        <p class="mb-3">Tidak ada artikel yang sesuai dengan pencarian Anda.</p>
                        <a href="artikel.php" class="btn btn-primary">Lihat Semua Artikel</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($artikel_list as $artikel): ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100 shadow-sm hover-lift">
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
                                    <a href="artikel_detail.php?slug=<?php echo urlencode($artikel['slug']); ?>"
                                       class="text-decoration-none text-dark stretched-link">
                                        <?php echo sanitizeOutput($artikel['judul']); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php echo sanitizeOutput(truncateText($artikel['ringkasan'], 120)); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-primary fw-semibold">
                                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                    </span>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i><?php echo number_format($artikel['views']); ?>
                                    </small>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Categories Section -->
<?php if (!empty($kategori_list)): ?>
<section class="categories-section py-5 bg-light">
    <div class="container">
        <h3 class="text-center fw-bold mb-4">Kategori Artikel</h3>
        <div class="row g-3">
            <?php foreach ($kategori_list as $kategori): ?>
                <div class="col-md-4 col-lg-2">
                    <a href="artikel.php?kategori=<?php echo urlencode($kategori['slug']); ?>"
                       class="btn btn-outline-primary w-100 <?php echo $kategori_filter === $kategori['slug'] ? 'active' : ''; ?>">
                        <i class="fas <?php echo sanitizeOutput($kategori['icon']); ?> me-1"></i>
                        <?php echo sanitizeOutput($kategori['nama_kategori']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
