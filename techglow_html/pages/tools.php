<?php
/**
 * TechGlow - AI Tools Page
 *
 * Displays all AI tools with filtering
 */

require_once '../includes/config.php';

// Get database connection
$pdo = getDbConnection();

if (!$pdo) {
    die("Koneksi database gagal. Silakan cek konfigurasi.");
}

// Get filter parameters
$kategori_filter = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build SQL query with filters
$sql = "SELECT * FROM ai_tools WHERE 1=1";
$params = [];

if ($kategori_filter) {
    $sql .= " AND kategori_tool = :kategori";
    $params[':kategori'] = $kategori_filter;
}

if ($search_query) {
    $sql .= " AND (nama_tool LIKE :search OR deskripsi LIKE :search)";
    $params[':search'] = "%$search_query%";
}

$sql .= " ORDER BY is_favorite DESC, urutan ASC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $tools_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $tools_list = [];
    error_log("Error fetching AI tools: " . $e->getMessage());
}

// Fetch unique categories
try {
    $stmt = $pdo->query("SELECT DISTINCT kategori_tool FROM ai_tools WHERE kategori_tool IS NOT NULL ORDER BY kategori_tool ASC");
    $kategori_list = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $kategori_list = [];
}

$page_title = "AI Tools";
require_once '../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-success text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="bi bi-robot me-2"></i>
                    AI Tools Rekomendasi
                </h1>
                <p class="lead">
                    Koleksi AI tools terbaik untuk meningkatkan produktivitas development dan kreativitas
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="search-filter-section py-4 bg-light">
    <div class="container">
        <form method="GET" action="tools.php" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Cari AI tool..."
                           value="<?php echo sanitizeOutput($search_query); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" name="kategori">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori_list as $kategori): ?>
                        <option value="<?php echo sanitizeOutput($kategori); ?>"
                                <?php echo $kategori_filter === $kategori ? 'selected' : ''; ?>>
                            <?php echo sanitizeOutput($kategori); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</section>

<!-- AI Tools Section -->
<section class="tools-section py-5">
    <div class="container">
        <?php if ($search_query || $kategori_filter): ?>
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                Menampilkan <?php echo count($tools_list); ?> AI tools
                <?php if ($search_query): ?>
                    untuk pencarian "<strong><?php echo sanitizeOutput($search_query); ?></strong>"
                <?php endif; ?>
                <?php if ($kategori_filter): ?>
                    dalam kategori "<strong><?php echo sanitizeOutput($kategori_filter); ?></strong>"
                <?php endif; ?>
                <a href="tools.php" class="btn btn-sm btn-outline-primary ms-2">Reset Filter</a>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (empty($tools_list)): ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center py-5">
                        <i class="bi bi-exclamation-triangle fs-1 d-block mb-3"></i>
                        <h4>AI Tools Tidak Ditemukan</h4>
                        <p class="mb-3">Tidak ada AI tools yang sesuai dengan pencarian Anda.</p>
                        <a href="tools.php" class="btn btn-success">Lihat Semua AI Tools</a>
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
                                       class="btn btn-success w-100 mt-3">
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
    </div>
</section>

<!-- Featured Tools Section -->
<?php
// Get favorite tools for featured section
try {
    $stmt = $pdo->query("SELECT * FROM ai_tools WHERE is_favorite = 1 ORDER BY urutan ASC LIMIT 4");
    $featured_tools = $stmt->fetchAll();
} catch (PDOException $e) {
    $featured_tools = [];
}
?>

<?php if (!empty($featured_tools) && !$search_query && !$kategori_filter): ?>
<section class="featured-tools-section py-5 bg-light">
    <div class="container">
        <h3 class="text-center fw-bold mb-4">
            <i class="bi bi-star-fill text-warning me-2"></i>
            AI Tools Favorit
        </h3>
        <div class="row g-3">
            <?php foreach ($featured_tools as $tool): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card text-center shadow-sm hover-lift">
                        <div class="card-body">
                            <i class="fas <?php echo sanitizeOutput($tool['icon']); ?> fa-3x text-success mb-3"></i>
                            <h6 class="fw-bold"><?php echo sanitizeOutput($tool['nama_tool']); ?></h6>
                            <?php if ($tool['url']): ?>
                                <a href="<?php echo sanitizeOutput($tool['url']); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="btn btn-sm btn-outline-success mt-2">
                                    Kunjungi
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Categories Section -->
<?php if (!empty($kategori_list)): ?>
<section class="categories-section py-5">
    <div class="container">
        <h3 class="text-center fw-bold mb-4">Kategori AI Tools</h3>
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="tools.php" class="btn btn-outline-success <?php echo !$kategori_filter ? 'active' : ''; ?>">
                <i class="bi bi-grid me-1"></i>Semua
            </a>
            <?php foreach ($kategori_list as $kategori): ?>
                <a href="tools.php?kategori=<?php echo urlencode($kategori); ?>"
                   class="btn btn-outline-success <?php echo $kategori_filter === $kategori ? 'active' : ''; ?>">
                    <?php echo sanitizeOutput($kategori); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
