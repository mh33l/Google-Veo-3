<?php
/**
 * TechGlow - Kontak Page
 *
 * Contact page with form and information
 */

require_once '../includes/config.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = 'Semua field harus diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Email tidak valid.';
    } else {
        // In production, you would send email or save to database
        // For now, we'll just show success message
        $success_message = 'Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.';

        // Optional: Save to database
        try {
            $pdo = getDbConnection();
            if ($pdo) {
                // Uncomment if you want to save messages to database
                /*
                $stmt = $pdo->prepare("
                    INSERT INTO kontak_messages (name, email, subject, message, created_at)
                    VALUES (:name, :email, :subject, :message, NOW())
                ");
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':subject' => $subject,
                    ':message' => $message
                ]);
                */
            }
        } catch (PDOException $e) {
            error_log("Error saving contact message: " . $e->getMessage());
        }

        // Clear form
        $_POST = [];
    }
}

$page_title = "Kontak";
require_once '../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="bi bi-envelope me-2"></i>
                    Hubungi Kami
                </h1>
                <p class="lead">
                    Ada pertanyaan atau ingin berkolaborasi? Silakan hubungi kami
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Kirim Pesan</h3>

                        <?php if ($success_message): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>
                                <?php echo sanitizeOutput($success_message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($error_message): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <?php echo sanitizeOutput($error_message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="kontak.php" class="needs-validation" novalidate>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="name"
                                           name="name"
                                           value="<?php echo isset($_POST['name']) ? sanitizeOutput($_POST['name']) : ''; ?>"
                                           required>
                                    <div class="invalid-feedback">
                                        Nama harus diisi.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                           class="form-control"
                                           id="email"
                                           name="email"
                                           value="<?php echo isset($_POST['email']) ? sanitizeOutput($_POST['email']) : ''; ?>"
                                           required>
                                    <div class="invalid-feedback">
                                        Email valid harus diisi.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="subject" class="form-label">
                                        Subjek <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="subject"
                                           name="subject"
                                           value="<?php echo isset($_POST['subject']) ? sanitizeOutput($_POST['subject']) : ''; ?>"
                                           required>
                                    <div class="invalid-feedback">
                                        Subjek harus diisi.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="message" class="form-label">
                                        Pesan <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control"
                                              id="message"
                                              name="message"
                                              rows="6"
                                              required><?php echo isset($_POST['message']) ? sanitizeOutput($_POST['message']) : ''; ?></textarea>
                                    <div class="invalid-feedback">
                                        Pesan harus diisi.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-send me-2"></i>
                                        Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Informasi Kontak</h3>

                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <i class="bi bi-envelope fs-3 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email</h6>
                                <a href="mailto:info@techglow.biz.id" class="text-muted text-decoration-none">
                                    info@techglow.biz.id
                                </a>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <i class="bi bi-globe fs-3 text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Website</h6>
                                <a href="<?php echo SITE_URL; ?>" class="text-muted text-decoration-none">
                                    techglow.biz.id
                                </a>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <i class="bi bi-geo-alt fs-3 text-warning"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Lokasi</h6>
                                <p class="text-muted mb-0">Indonesia</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-clock fs-3 text-info"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Jam Operasional</h6>
                                <p class="text-muted mb-0">
                                    Senin - Jumat: 09:00 - 17:00 WIB<br>
                                    Sabtu - Minggu: Tutup
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-primary btn-lg">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-lg">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-lg">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-lg">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Pertanyaan Umum</h2>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Bagaimana cara berkontribusi artikel?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat mengirimkan proposal artikel melalui email ke info@techglow.biz.id
                                dengan subjek "Kontribusi Artikel". Tim kami akan meninjau dan memberikan feedback.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Bagaimana cara menambahkan AI tool ke directory?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kirimkan informasi lengkap tentang AI tool yang ingin ditambahkan melalui
                                form kontak di atas. Sertakan nama tool, deskripsi, dan link website.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Apakah bisa berkolaborasi untuk project?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tentu! Kami terbuka untuk kolaborasi project development. Hubungi kami
                                melalui email atau form kontak dengan detail project yang diinginkan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
