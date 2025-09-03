<?php
require_once __DIR__ . '/../config/database_connection.php';
require_once __DIR__ . '/../controllers/category_controller.php';
require_once __DIR__ . '/modals/uni_modal.php';

// Fetch products from controller
if (!isset($pdo)) {
    die("Connection failed: " . mysqli_connect_error());
}
$categoryModel = new Category($pdo, []);
$categories = $categoryModel->getCategories();

if (!isset($categories)) {
    return ['No Categories found.'];
}
?>

<div class="col-lg-12 mb-3 px-3">
    <div class="row align-items-center">
        <!-- Left side buttons -->
        <div class="col-md-6 col-12 d-flex flex-wrap gap-2 mb-3 mt-3">
            <!-- Add Button -->
            <button id="addBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal"
                    data-title="Add Category"
                    data-url="views/forms/add_product_form.php">
                <i class="bi bi-plus"></i> Add
            </button>

            <!-- View Button -->
            <button id="viewBtn" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#formModal"
                    data-title="View Category"
                    data-url="dashboard/views/forms/add-product.html">
                <i class="bi bi-eye"></i> View
            </button>

            <!-- Update Button -->
            <button id="updateBtn" class="btn btn-success">
                <i class="bi bi-pencil-square"></i> Update
            </button>

            <!-- Details Button -->
            <button id="detailsBtn" class="btn btn-secondary">
                <i class="bi bi-card-list"></i> Details
            </button>

            <!-- Delete Button -->
            <button id="deleteBtn" class="btn btn-danger">
                <i class="bi bi-trash-fill"></i> Delete
            </button>
        </div>

        <!-- Right side buttons -->
        <div id="customButtonsContainer" class="col-md-6 col-12 d-flex justify-content-md-end justify-content-start mb-3 mt-3">
            <div class="dt-buttons btn-group flex-wrap">
                <button class="btn btn-secondary btn-sm"><i class="fa fa-copy"></i> Copy</button>
                <button class="btn btn-success btn-sm"><i class="fa fa-file-csv"></i> CSV</button>
                <button class="btn btn-warning btn-sm"><i class="fa fa-file-excel"></i> Excel</button>
                <button class="btn btn-danger btn-sm"><i class="fa fa-file-pdf"></i> PDF</button>
                <button class="btn btn-info btn-sm"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>

    <!-- DataTable -->
    <div class="shadow-lg rounded bg-white mb-3 px-2 py-2">
        <div class="table-responsive">
            <table id="categoryTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Date of creation</th>
                    <th>Date of update</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <tr data-id="<?= htmlspecialchars($category['id'] ?? ''); ?>">
                            <td><?= htmlspecialchars($category['name'] ?? 'NaN'); ?></td>
                            <td><?= htmlspecialchars($category['created_at'] ?? 0); ?></td>
                            <td><?= htmlspecialchars($category['updated_at'] ?? 0); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No products found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var table = $('#categoryTable').DataTable({
            ordering: true,
            pageLength: 10,
            lengthChange: true,
            responsive: true, // ✅ makes table controls responsive
            language: {
                search: "Search:",
                paginate: {previous: "&laquo;", next: "&raquo;"}
            }
        });

        var selectedId = null;

        // Handle row selection
        $('#categoryTable tbody').on('click', 'tr', function (e) {
            $('#categoryTable tbody tr').removeClass('selected-row');
            $(this).addClass('selected-row');
            selectedId = $(this).data('id');
            console.log('Selected id = ', selectedId);
            e.stopPropagation();
        });

        // Deselect row when clicking outside the table
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#categoryTable').length) {
                $('#categoryTable tbody tr').removeClass('selected-row');
                selectedId = null;
                console.log("Selection cleared");
            }
        });

        // View Product button
        $("#viewBtn").click(function () {
            if (selectedId) {
                $("#formModal .modal-title").text("View category");
                $("#formModal .modal-body").load("view.php?id=" + selectedId);
                $("#formModal").modal("show");
            } else {
                alert("Please select a product to view.");
            }
        });

        // Update Product button
        $("#updateBtn").click(function () {
            if (selectedId) {
                window.location.href = "update.php?id=" + selectedId;
            } else {
                alert("Please select a product to update.");
            }
        });

        // View Product Details button
        $("#detailsBtn").click(function () {
            if (selectedId) {
                window.location.href = "details.php?id=" + selectedId;
            } else {
                alert("Please select a product to view details.");
            }
        });

        // Delete Product button
        $("#deleteBtn").click(function () {
            if (selectedId) {
                if (confirm("Are you sure you want to delete this product?")) {
                    window.location.href = "delete.php?id=" + selectedId;
                }
            } else {
                alert("Please select a product to delete.");
            }
        });
    });
</script>

<style>
    #categoryTable {
        margin: 2rem 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        background-color: #fff;
    }
    #categoryTable th,
    #categoryTable td {
        vertical-align: middle;
    }
    #categoryTable tbody tr.selected-row td {
        background-color: #004080 !important; /* deep blue */
        color: white !important;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
</style>
