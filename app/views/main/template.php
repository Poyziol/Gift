<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "Main" ?></title>
    <!-- Framework css -->
    <link rel="stylesheet" href="/assets/framework/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/framework/fontawesome-free-6.7.2-web/css/all.min.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/account.css">
    <link rel="stylesheet" href="/assets/css/loading.css">
</head>

<body>
    <!-- Loading animation -->
    <?php include './layouts/loading.php' ?>

    <header class="fixed-top shadow">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="/main">
                    <?php include './layouts/logo.php'; ?>
                </a>

                <!-- Toggle Button for Mobile View -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Start -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/main">Home</a>
                        </li>
                        <!-- Smooth Scroll Link -->
                        <li class="nav-item">
                            <a class="nav-link" href="#deposit-form">Make a deposit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/main/account">Your account</a>
                        </li>
                    </ul>

                    <!-- End -->
                    <ul class="navbar-nav ms-auto d-flex gap-2 align-items-center">
                        <!-- Username and balance -->
                        <li class="nav-item d-flex align-items-center">
                            <i class="fas fa-user text-primary me-2"></i>
                            <span class="fw-bold text-primary"> <?= $username ?></span>
                        </li>
                        <li class="nav-item me-3" id="balance" value="<?= "$balance" ?>">
                            <?= "$$balance" ?>
                        </li>
                        
                        <!-- Theme Switch Button -->
                        <li class="nav-item me-3">
                            <?php include './layouts/btn-theme.php'; ?>
                        </li>
                        <!-- Offcanvas Button (Always Visible) -->
                        <li class="nav-item me-3">
                            <button class="btn btn-success" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                                <i class="fas fa-cog"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Offcanvas Navbar -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">User Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/login/user">Login in another account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login/admin">Login as admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="">
        <?php include $page . '.php' ?>
    </main>


    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p></p> <!-- The message will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Framework Scripts -->
    <script src="/assets/framework/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/framework/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Scripts -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/gift.js"></script>
    <script src="/assets/js/account.js"></script>
    <script src="/assets/js/deposit.js"></script>
    <!-- Loading animation, not to use jquery for these -->
    <script>
        <?php if (isset($_SESSION['loading']) && $_SESSION['loading'] === true): ?>
            document.querySelector('#loading').style.display = 'flex';
            document.querySelector('main').style.display = 'none';
            setTimeout(function () {
                document.querySelector('#loading').style.display = 'none';
                document.querySelector('main').style.display = 'block';
            }, 2500);
        <?php endif; ?>
        <?php unset($_SESSION['loading']); ?>
    </script>

    <!-- Message modal, also not to use jquery -->
    <?php if (!empty($message)): ?>
        <script>
            var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
            document.querySelector('#messageModal .modal-body p').textContent = "<?= $message ?>";
            messageModal.show();
        </script>
    <?php endif; ?>

</body>

</html>
</body>

</html>