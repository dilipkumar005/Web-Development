<?php
$company_name = "STPDrive";
$company_email = "support@stpdrive.com";
$company_phone = "+1 (555) 123-4567";
$company_address = "123 Drive Street, Cloud City";
?>
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand d-flex align-items-center mb-3">
                    <img src="images/logo.png" alt="logo" width="100" class="me-2">
                    <h4 class="mb-0"><?= $company_name ?></h4>
                </div>
                <p class="text-muted">Secure cloud storage solution for all your files.</p>
                <div class="social-links mt-4">
                    <a href="https://facebook.com/<?= $company_name ?>" target="_blank" class="btn btn-sm btn-outline-light rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/<?= $company_name ?>" target="_blank" class="btn btn-sm btn-outline-light rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com/<?= $company_name ?>" target="_blank" class="btn btn-sm btn-outline-light rounded-circle me-2"><i class="fab fa-instagram"></i></a>
                    <a href="https://linkedin.com/company/<?= $company_name ?>" target="_blank" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h5 class="mb-4">Quick Links</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="index.php" class="nav-link p-0 text-muted">Home</a></li>
                    <li class="nav-item mb-2"><a href="about.php" class="nav-link p-0 text-muted">About</a></li>
                    <li class="nav-item mb-2"><a href="contact.php" class="nav-link p-0 text-muted">Contact</a></li>
                    <li class="nav-item mb-2"><a href="terms.php" class="nav-link p-0 text-muted">Terms</a></li>
                    <li class="nav-item mb-2"><a href="privacy.php" class="nav-link p-0 text-muted">Privacy</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">Contact Us</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2 d-flex align-items-center">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span class="text-muted"><?= $company_address ?></span>
                    </li>
                    <li class="nav-item mb-2 d-flex align-items-center">
                        <i class="fas fa-phone me-2"></i>
                        <span class="text-muted"><?= $company_phone ?></span>
                    </li>
                    <li class="nav-item mb-2 d-flex align-items-center">
                        <i class="fas fa-envelope me-2"></i>
                        <span class="text-muted"><?= $company_email ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">Newsletter</h5>
                <p class="text-muted">Subscribe to our newsletter for updates.</p>
                <form class="mt-3">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your email" aria-label="Your email">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
        <hr class="my-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="mb-0 text-muted">&copy; <?= date('Y') ?> <?= $company_name ?>. All rights reserved.</p>
            <div class="mt-3 mt-md-0">
                <a href="#" class="text-muted me-3">Terms</a>
                <a href="#" class="text-muted">Privacy</a>
            </div>
        </div>
    </div>
</footer>
