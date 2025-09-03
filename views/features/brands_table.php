<?php
require_once __DIR__ . '/../../config/database_connection.php';
require_once __DIR__ . '/../../controllers/brand_controller.php';
require_once __DIR__ . '/../modals/uni_modal.php';

// Fetch products from controller
if (!isset($pdo)) {
    die("Connection failed: " . mysqli_connect_error());
}
$brandModel = new Brand($pdo, '','');
$brands = $brandModel->getBrands();

if (!isset($brands)) {
    return ['No Brands found.'];
}
?>

<!-- Action Buttons -->
<div class="mb-3">
    <!-- View Button -->
    <button id="addBtn" class="btn me-2 btn-primary" data-bs-toggle="modal" data-bs-target="#formModal"
            data-title="Add Brand"
            data-url="views/forms/add_product_form.php">
        <i class="bi bi-plus"></i>Add Brand
    </button>

    <button id="viewBtn" class="btn me-2 btn-primary" data-bs-toggle="modal" data-bs-target="#formModal"
            data-title="Add New Product"
            data-url="dashboard/views/forms/add-product.html">
        <i class="bi bi-eye"></i>View
    </button>

    <!-- Update Button -->
    <button id="updateBtn" class="btn me-2" style="background-color: #28a745; color: white; font-size: 1.1rem; padding: 0.6rem 1.2rem;">
        <i class="bi bi-pencil-square"></i> Update
    </button>

    <!-- View Product Details Button -->
    <button id="detailsBtn" class="btn me-2" style="background-color: #6c757d; color: white; font-size: 1.1rem; padding: 0.6rem 1.2rem;">
        <i class="bi bi-card-list"></i> View Brand Details
    </button>

    <!-- Delete Button -->
    <button id="deleteBtn" class="btn me-2" style="background-color: #dc3545; color: white; font-size: 1.1rem; padding: 0.6rem 1.2rem;">
        <i class="bi bi-trash-fill"></i> Delete
    </button>

</div>

<!-- DataTable -->
<table id="brandTable" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Brand Name</th>
        <th>Date of creation</th>
        <th>Date of update</th>

    </tr>
    </thead>
    <tbody>
    <?php if (!empty($brands)): ?>
        <?php foreach ($brands as $brand): ?>
            <tr data-id="<?= htmlspecialchars($brand['id'] ?? ''); ?>">
                <td><?= htmlspecialchars($brand['name'] ?? 'NaN'); ?></td>
                <td><?= htmlspecialchars($brand['created_at'] ?? 0); ?></td>
                <td><?= htmlspecialchars($brand['updated_at'] ?? 0); ?></td>
                            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center">No products found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        var table = $('#brandTable').DataTable({
            ordering: true,
            pageLength: 10,
            lengthChange: true,
            language: {search: "Search:", paginate: {previous: "&laquo;", next: "&raquo;"}}
        });

        var selectedId = null;

        // Handle row selection
        $('#brandTable tbody').on('click', 'tr', function (e) {
            $('#brandTable tbody tr').removeClass('selected-row');
            $(this).addClass('selected-row');
            selectedId = $(this).data('id');
            console.log('Selected id = ', selectedId);
            e.stopPropagation();
        });

        // Deselect row when clicking outside the table
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#brandTable').length) {
                $('#brandTable tbody tr').removeClass('selected-row');
                selectedId = null;
                console.log("Selection cleared");
            }
        });


        // View Product button
        $("#viewBtn").click(function () {
            if (selectedId) {
                $("#formModal .modal-title").text("View Brand");
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
    #brandTable {
        margin: 2rem 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        background-color: #fff;
    }
    #brandTable th,
    #brandTable td {
        vertical-align: middle;
    }
    #brandTable tbody tr.selected-row td {
        background-color: #004080 !important; /* deep blue */
        color: white !important;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
</style>
