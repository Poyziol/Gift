<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "Dashboard" ?></title>
    <!-- Framework css -->
    <link rel="stylesheet" href="/assets/framework/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/framework/fontawesome-free-6.7.2-web/css/all.min.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <header class="fixed-top shadow">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="/dashboard">
                    <?php include './layouts/logo.php'; ?>
                </a>
                <!-- Toggle Button for Mobile View -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto d-flex gap-2 align-items-center">
                        <li class="nav-item d-flex align-items-center me-3">
                            <i class="fas fa-user text-primary me-2"></i>
                            <span class="fw-bold text-primary"> <?= $username ?></span>
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
                        <a class="nav-link" href="/login/user">Login in an user account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login/admin">Login as another admin</a>
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

    <footer></footer>

    <!-- Framework Scripts -->
    <script src="/assets/framework/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/framework/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Scripts -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/admin.js"></script>
</body>

</html>
</body>

</html>