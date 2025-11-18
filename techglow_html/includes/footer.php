    </main>
    <!-- End Main Content Container -->

    <!-- Footer -->
    <footer class="footer bg-dark text-light mt-5">
        <div class="container py-5">
            <div class="row">
                <!-- About Section -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                        <?php echo SITE_NAME; ?>
                    </h5>
                    <p class="text-muted">
                        Platform untuk berbagi pengetahuan teknologi, AI tools terbaik, dan showcase portfolio project development.
                    </p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-light me-3" title="GitHub">
                            <i class="fab fa-github fs-4"></i>
                        </a>
                        <a href="#" class="text-light me-3" title="LinkedIn">
                            <i class="fab fa-linkedin fs-4"></i>
                        </a>
                        <a href="#" class="text-light me-3" title="Twitter">
                            <i class="fab fa-twitter fs-4"></i>
                        </a>
                        <a href="#" class="text-light" title="Instagram">
                            <i class="fab fa-instagram fs-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="index.php" class="text-muted text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Beranda
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="pages/artikel.php" class="text-muted text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Artikel Blog
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="pages/tools.php" class="text-muted text-decoration-none">
                                <i class="bi bi-chevron-right"></i> AI Tools
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="pages/portofolio.php" class="text-muted text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Portofolio
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4">
                    <h5 class="mb-3">Kontak</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:info@techglow.biz.id" class="text-muted text-decoration-none">
                                info@techglow.biz.id
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-globe me-2"></i>
                            <a href="<?php echo SITE_URL; ?>" class="text-muted text-decoration-none">
                                techglow.biz.id
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            Indonesia
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-4 bg-secondary">

            <!-- Copyright -->
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted">
                        &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-muted">
                        Built with <i class="bi bi-heart-fill text-danger"></i> using PHP 8.4 & Bootstrap 5
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="btn btn-warning btn-floating" title="Back to top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>
