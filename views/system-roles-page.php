<?php
require_once __DIR__ . '/../config/database_connection.php';
require_once __DIR__ . '/../controllers/roles_controller.php';
require_once __DIR__ . '/modals/uni_modal.php';

// Fetch products from controller
if (!isset($pdo)) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!-- Action Buttons -->
<div class="mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Manage Roles</h3>
            <div class="card-tools">
            </div>
        </div>
    </div>
    <!-- View Button -->
    <button id="addBtn" class="btn me-2 btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">
        <i class="bi bi-plus"></i>Add Role
    </button>

    <button id="viewBtn" class="btn me-2 btn-primary" data-bs-toggle="modal" data-bs-target="#formModal"
            data-title="Add New Product"
            data-url="dashboard/views/forms/add-product.html">
        <i class="bi bi-eye"></i>View
    </button>

    <!-- Update Button -->
    <button id="updateBtn" class="btn me-2"
            style="background-color: #28a745; color: white; font-size: 1.1rem; padding: 0.6rem 1.2rem;">
        <i class="bi bi-pencil-square"></i> Update
    </button>

    <!-- View Product Details Button -->
    <button id="detailsBtn" class="btn me-2"
            style="background-color: #6c757d; color: white; font-size: 1.1rem; padding: 0.6rem 1.2rem;">
        <i class="bi bi-card-list"></i> View Role Details
    </button>

    <!-- Delete Button -->
    <button id="deleteBtn" class="btn me-2"
            style="background-color: #dc3545; color: white; font-size: 1.1rem; padding: 0.6rem 1.2rem;">
        <i class="bi bi-trash-fill"></i> Delete
    </button>

</div>

<!-- DataTable -->
<div class="row">
    <!-- Available Roles Table -->
    <div class="col-md-5">
        <h5>Available Roles</h5>
        <table id="availableRolesTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($roles)): ?>
                <?php foreach ($roles as $role): ?>
                    <tr data-id="<?= htmlspecialchars($role['id'] ?? ''); ?>">
                        <td><?= htmlspecialchars($role['name'] ?? 'NaN'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="text-center">No Roles found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Middle Controls -->
    <div class="col-md-2 d-flex flex-column align-items-center justify-content-center">
        <button id="assignRoleBtn" class="btn btn-success mb-2">
            <i class="bi bi-arrow-right"></i>
        </button>
        <button id="removeRoleBtn" class="btn btn-danger">
            <i class="bi bi-arrow-left"></i>
        </button>
    </div>

    <!-- Assigned Roles Table -->
    <div class="col-md-5">
        <h5>Assigned Roles</h5>
        <table id="assignedRolesTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-center text-muted">
                <td>No roles assigned</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Initialize both tables with only search box
        var availableTable = $('#availableRolesTable').DataTable({
            paging: false, info: false, ordering: false, lengthChange: false,
            dom: 'ft', language: {search: "Search Available:"}
        });

        var assignedTable = $('#assignedRolesTable').DataTable({
            paging: false, info: false, ordering: false, lengthChange: false,
            dom: 'ft', language: {search: "Search Assigned:"}
        });

        var selectedAvailable = null;
        var selectedAssigned = null;

        // Select row in Available table
        $('#availableRolesTable tbody').on('click', 'tr', function () {
            $('#availableRolesTable tbody tr').removeClass('selected-row');
            $(this).addClass('selected-row');
            selectedAvailable = availableTable.row(this);
        });

        // Select row in Assigned table
        $('#assignedRolesTable tbody').on('click', 'tr', function () {
            $('#assignedRolesTable tbody tr').removeClass('selected-row');
            $(this).addClass('selected-row');
            selectedAssigned = assignedTable.row(this);
        });

        // Assign Role → Move from available to assigned
        $('#assignRoleBtn').click(function () {
            if (selectedAvailable) {
                var data = selectedAvailable.data();
                var roleId = $(selectedAvailable.node()).data("id");

                // remove "No roles assigned" placeholder if present
                $('#assignedRolesTable tbody tr.text-muted').remove();

                assignedTable.row.add([
                    data[0]
                ]).node().setAttribute("data-id", roleId);
                assignedTable.draw();

                selectedAvailable.remove().draw();
                selectedAvailable = null;
            } else {
                alert("Please select a role to assign.");
            }
        });

        // Remove Role → Move from assigned back to available
        $('#removeRoleBtn').click(function () {
            if (selectedAssigned) {
                var data = selectedAssigned.data();
                var roleId = $(selectedAssigned.node()).data("id");

                availableTable.row.add([
                    data[0]
                ]).node().setAttribute("data-id", roleId);
                availableTable.draw();

                selectedAssigned.remove().draw();

                // if no rows left in assigned → show placeholder
                if (assignedTable.rows().count() === 0) {
                    $('#assignedRolesTable tbody').append(
                        '<tr class="text-center text-muted"><td>No roles assigned</td></tr>'
                    );
                }

                selectedAssigned = null;
            } else {
                alert("Please select a role to remove.");
            }
        });
    });
</script>

<style>
    #availableRolesTable, #assignedRolesTable {
        margin: 1rem 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        background-color: #fff;
    }

    #availableRolesTable tbody tr.selected-row td,
    #assignedRolesTable tbody tr.selected-row td {
        background-color: #004080 !important;
        color: white !important;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
</style>