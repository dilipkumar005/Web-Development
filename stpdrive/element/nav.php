<?php 
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top py-2 shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="logo" width="140" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item mx-2">
                    <a class="nav-link position-relative <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">
                        Home
                        <?php if($current_page == 'index.php'): ?>
                        <span class="position-absolute bottom-0 start-50 translate-middle-x bg-primary" style="height: 2px; width: 20px;"></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pages
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="pagesDropdown">
                        
                        <li><a class="dropdown-item d-flex align-items-center" href="about.php"><i class="fas fa-info-circle me-2"></i> About</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="contact.php"><i class="fas fa-envelope me-2"></i> Contact</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="terms.php"><i class="fas fa-file-contract me-2"></i> Terms</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="privacy.php"><i class="fas fa-shield-alt me-2"></i> Privacy</a></li>
                    </ul>
                </li>
                <?php if(empty($_SESSION['user'])): ?>
                <li class="nav-item ms-2">
                    <a class="nav-link btn btn-primary rounded-pill px-3 py-1" href="login.php">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item ms-2">
                    <a class="nav-link btn btn-outline-light rounded-pill px-3 py-1" href="profile.php">
                        <i class="fas fa-user me-1"></i> Profile
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
