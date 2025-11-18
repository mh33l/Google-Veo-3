<?php
/**
 * TechGlow - Portofolio Page
 *
 * Displays all portfolio projects
 */

require_once '../includes/config.php';

// Get database connection
$pdo = getDbConnection();

if (!$pdo) {
    die("Koneksi database gagal. Silakan cek konfigurasi.");
}

// Get filter parameters
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build SQL query with filters
$sql = "SELECT * FROM portofolio WHERE 1=1";
$params = [];

if ($status_filter) {
    $sql .= " AND status = :status";
    $params[':status'] = $status_filter;
}

if ($search_query) {
    $sql .= " AND (nama_proyek LIKE :search OR deskripsi LIKE :search OR teknologi LIKE :search)";
    $params[':search'] = "%$search_query%";
}

$sql .= " ORDER BY urutan ASC, tanggal_selesai DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $portofolio_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $portofolio_list = [];
    error_log("Error fetching portfolio: " . $e->getMessage());
}

$page_title = "Portofolio";
require_once '../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-warning text-dark py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="bi bi-briefcase me-2"></i>
                    Portofolio Projects
                </h1>
                <p class="lead">
                    Showcase project development yang telah dikerjakan dengan berbagai teknologi modern
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="search-filter-section py-4 bg-light">
    <div class="container">
        <form method="GET" action="portofolio.php" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Cari project..."
                           value="<?php echo sanitizeOutput($search_query); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="ongoing" <?php echo $status_filter === 'ongoing' ? 'selected' : ''; ?>>Ongoing</option>
                    <option value="archived" <?php echo $status_filter === 'archived' ? 'selected' : ''; ?>>Archived</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-warning w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Portfolio Section -->
<section class="portfolio-section py-5">
    <div class="container">
        <?php if ($search_query || $status_filter): ?>
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                Menampilkan <?php echo count($portofolio_list); ?> project
                <?php if ($search_query): ?>
                    untuk pencarian "<strong><?php echo sanitizeOutput($search_query); ?></strong>"
                <?php endif; ?>
                <?php if ($status_filter): ?>
                    dengan status "<strong><?php echo sanitizeOutput(ucfirst($status_filter)); ?></strong>"
                <?php endif; ?>
                <a href="portofolio.php" class="btn btn-sm btn-outline-primary ms-2">Reset Filter</a>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (empty($portofolio_list)): ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center py-5">
                        <i class="bi bi-exclamation-triangle fs-1 d-block mb-3"></i>
                        <h4>Project Tidak Ditemukan</h4>
                        <p class="mb-3">Tidak ada project yang sesuai dengan pencarian Anda.</p>
                        <a href="portofolio.php" class="btn btn-warning">Lihat Semua Portofolio</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($portofolio_list as $project): ?>
                    <div class="col-lg-6">
                        <div class="card h-100 shadow-sm hover-lift">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="project-icon me-3">
                                        <i class="fas <?php echo sanitizeOutput($project['icon']); ?> fa-3x text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="card-title fw-bold mb-2">
                                            <?php echo sanitizeOutput($project['nama_proyek']); ?>
                                        </h4>
                                        <div class="d-flex gap-2 align-items-center">
                                            <?php
                                            $status_colors = [
                                                'completed' => 'success',
                                                'ongoing' => 'primary',
                                                'archived' => 'secondary'
                                            ];
                                            $status_icons = [
                                                'completed' => 'check-circle',
                                                'ongoing' => 'arrow-repeat',
                                                'archived' => 'archive'
                                            ];
                                            $status = $project['status'];
                                            ?>
                                            <span class="badge bg-<?php echo $status_colors[$status]; ?>">
                                                <i class="bi bi-<?php echo $status_icons[$status]; ?> me-1"></i>
                                                <?php echo sanitizeOutput(ucfirst($status)); ?>
                                            </span>
                                            <?php if ($project['tanggal_selesai']): ?>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-check me-1"></i>
                                                    <?php echo formatTanggal($project['tanggal_selesai']); ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <p class="card-text text-muted mb-3">
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
                                           class="btn btn-warning">
                                            <i class="bi bi-eye me-1"></i>Live Demo
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($project['link_github']): ?>
                                        <a href="<?php echo sanitizeOutput($project['link_github']); ?>"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-outline-dark">
                                            <i class="bi bi-github me-1"></i>View on GitHub
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Stats Section -->
<?php
// Get portfolio statistics
try {
    $stats = [];
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM portofolio");
    $stats['total'] = $stmt->fetch()['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as completed FROM portofolio WHERE status = 'completed'");
    $stats['completed'] = $stmt->fetch()['completed'];

    $stmt = $pdo->query("SELECT COUNT(*) as ongoing FROM portofolio WHERE status = 'ongoing'");
    $stats['ongoing'] = $stmt->fetch()['ongoing'];

    // Get unique technologies count
    $stmt = $pdo->query("SELECT GROUP_CONCAT(teknologi) as all_tech FROM portofolio");
    $all_tech = $stmt->fetch()['all_tech'];
    $tech_array = array_unique(explode(', ', str_replace(', ', ',', $all_tech)));
    $stats['technologies'] = count($tech_array);
} catch (PDOException $e) {
    $stats = ['total' => 0, 'completed' => 0, 'ongoing' => 0, 'technologies' => 0];
}
?>

<section class="stats-section py-5 bg-light">
    <div class="container">
        <h3 class="text-center fw-bold mb-4">Statistik Portofolio</h3>
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-briefcase fs-1 text-warning mb-2"></i>
                        <h2 class="fw-bold mb-0"><?php echo $stats['total']; ?></h2>
                        <p class="text-muted mb-0">Total Projects</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-check-circle fs-1 text-success mb-2"></i>
                        <h2 class="fw-bold mb-0"><?php echo $stats['completed']; ?></h2>
                        <p class="text-muted mb-0">Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-arrow-repeat fs-1 text-primary mb-2"></i>
                        <h2 class="fw-bold mb-0"><?php echo $stats['ongoing']; ?></h2>
                        <p class="text-muted mb-0">Ongoing</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-tools fs-1 text-info mb-2"></i>
                        <h2 class="fw-bold mb-0"><?php echo $stats['technologies']; ?></h2>
                        <p class="text-muted mb-0">Technologies</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
