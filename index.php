<!doctype html>
<html lang="en">
<?php require_once __DIR__ . '/inc/head.php'; ?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- Top Navbar -->
    <?php require_once __DIR__ . '/inc/top-nav-bar.php'; ?>

    <!-- Sidebar -->
    <?php require_once __DIR__ . '/inc/side-nav-bar.php'; ?>

    <!-- Main Content -->
    <main class="app-main">
        <!-- Page Content -->
        <div class="app-content">
            <div class="container-fluid">
                <?php
                if (!empty($_GET['page'])) {
                    $page = basename($_GET['page']);
                    $pageFile = __DIR__ . '/views/' . $page . '.php';
                    if (file_exists($pageFile)) {
                        include $pageFile;
                    } else {
                        echo "<div class='p-4'><h4>404 - Page not found</h4></div>";
                    }
                } else {
                    include __DIR__ . '/views/index.php'; // default content
                }
                ?>
            </div>
        </div>
        <!-- /.app-content -->

    </main>
    <!-- /.app-main -->

    <!-- Footer -->
    <?php require_once __DIR__ . '/inc/footer.php'; ?>

</div>
<!-- /.app-wrapper -->

<?php require_once __DIR__ . '/inc/bottom-scripts.php'; ?>
</body>
</html>
