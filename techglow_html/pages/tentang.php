<?php
/**
 * TechGlow - Tentang Page
 *
 * About page with information about the platform
 */

require_once '../includes/config.php';

$page_title = "Tentang Kami";
require_once '../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="bi bi-person me-2"></i>
                    Tentang TechGlow
                </h1>
                <p class="lead">
                    Platform untuk berbagi pengetahuan teknologi dan showcase portfolio
                </p>
            </div>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-image text-center">
                    <i class="bi bi-lightning-charge-fill text-warning" style="font-size: 10rem;"></i>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Apa itu TechGlow?</h2>
                <p class="text-muted text-justify">
                    TechGlow adalah platform digital yang didedikasikan untuk berbagi pengetahuan tentang teknologi,
                    programming, dan development. Kami menyediakan artikel blog berkualitas, rekomendasi AI tools terbaik,
                    dan showcase portfolio project yang telah dikerjakan.
                </p>
                <p class="text-muted text-justify">
                    Dengan fokus pada teknologi modern seperti PHP 8.4, JavaScript, AI Tools, dan framework terkini,
                    TechGlow bertujuan menjadi sumber informasi terpercaya bagi developer dan tech enthusiast.
                </p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-12">
                <h2 class="fw-bold text-center mb-4">Misi Kami</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-book text-primary fs-1 mb-3"></i>
                                <h5 class="fw-bold">Edukasi</h5>
                                <p class="text-muted">
                                    Menyediakan artikel dan tutorial berkualitas untuk membantu developer
                                    meningkatkan skill mereka.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-lightbulb text-warning fs-1 mb-3"></i>
                                <h5 class="fw-bold">Inspirasi</h5>
                                <p class="text-muted">
                                    Menampilkan project portfolio dan AI tools untuk menginspirasi
                                    inovasi dan kreativitas.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-people text-success fs-1 mb-3"></i>
                                <h5 class="fw-bold">Komunitas</h5>
                                <p class="text-muted">
                                    Membangun komunitas tech yang solid dan saling berbagi
                                    pengetahuan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold text-center mb-4">Tech Stack</h2>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-3 text-center">
                            <div class="col-6 col-md-3">
                                <div class="p-3">
                                    <i class="fab fa-php text-primary fs-1 mb-2"></i>
                                    <p class="fw-semibold mb-0">PHP 8.4</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3">
                                    <i class="fab fa-bootstrap text-purple fs-1 mb-2"></i>
                                    <p class="fw-semibold mb-0">Bootstrap 5</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3">
                                    <i class="fas fa-database text-warning fs-1 mb-2"></i>
                                    <p class="fw-semibold mb-0">MySQL</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3">
                                    <i class="fab fa-js-square text-success fs-1 mb-2"></i>
                                    <p class="fw-semibold mb-0">JavaScript</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Fitur Utama</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-newspaper text-primary fs-2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Artikel Blog</h5>
                        <p class="text-muted">
                            Koleksi artikel tentang programming, AI, web development, dan teknologi terkini
                            dengan pembahasan mendalam dan praktis.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-robot text-success fs-2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">AI Tools Directory</h5>
                        <p class="text-muted">
                            Kumpulan AI tools terbaik untuk coding, design, research, dan produktivitas
                            dengan review dan rekomendasi.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-briefcase text-warning fs-2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Portfolio Showcase</h5>
                        <p class="text-muted">
                            Galeri project development dengan berbagai teknologi stack, complete dengan
                            demo dan source code.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-phone text-danger fs-2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Responsive Design</h5>
                        <p class="text-muted">
                            Website yang fully responsive dan mobile-friendly, optimal di semua
                            device dan ukuran layar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
