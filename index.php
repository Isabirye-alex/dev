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

        <!-- Optional page header -->
<!--        <div class="app-content-header">-->
<!--            <div class="container-fluid">-->
<!--                <div class="row">-->
<!--                    <div class="col-sm-6">-->
<!--                        <h3 class="mb-0">Dashboard</h3>-->
<!--                    </div>-->
<!--                    <div class="col-sm-6">-->
<!--                        <ol class="breadcrumb float-sm-end">-->
<!--                            <li class="breadcrumb-item"><a href="#">Home</a></li>-->
<!--                            <li class="breadcrumb-item active">Dashboard</li>-->
<!--                        </ol>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

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
