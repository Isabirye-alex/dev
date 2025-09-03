<div class="card customized-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Manage products</h3>
            <div class="card-tools">
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="col-lg-12">
            <div class="row d-flex justify-content-between align-items-center">
                <!-- Left side buttons -->
                <div id="toolbar" class="mb-4 pb-3 col-lg-6 d-flex">
                    <a href="#" class="btn btn-primary btn-flat btn-sm create_new me-2">
                        <i class="fa fa-plus-circle me-2"></i>Add product
                    </a>
                    <a href="#" class="btn btn-outline-success btn-flat btn-sm edit me-2">
                        <i class="fa fa-edit me-2"></i>Edit
                    </a>
                    <a href="#" class="btn btn-outline-danger btn-flat btn-sm deleteproduct me-1">
                        <i class="fa fa-trash me-2"></i>Delete
                    </a>

                    <a href="#" class="btn btn-outline-dark btn-flat btn-sm viewproduct">
                        <i class="fa fa-eye me-2"></i>View Product Details
                    </a>
                </div>

                <!-- Right side buttons -->
                <div id="customButtonsContainer" class="mb-4 pb-3 col-lg-6 d-flex justify-content-end">
                    <div class="dt-buttons btn-group flex-wrap">          <button class="btn btn-secondary buttons-copy buttons-html5 btn-flat btn-sm" tabindex="0" aria-controls="productstable" type="button"><span><i class="fa fa-copy"></i> Copy</span></button> <button class="btn btn-secondary buttons-csv buttons-html5 btn-success btn-flat btn-sm" tabindex="0" aria-controls="productstable" type="button"><span><i class="fa fa-file-csv"></i> CSV</span></button> <button class="btn btn-secondary buttons-excel buttons-html5 btn-warning btn-flat btn-sm" tabindex="0" aria-controls="productstable" type="button"><span><i class="fa fa-file-excel"></i> Excel</span></button> <button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger btn-flat btn-sm" tabindex="0" aria-controls="productstable" type="button"><span><i class="fa fa-file-pdf"></i> PDF</span></button> <button class="btn btn-secondary buttons-print btn-info" tabindex="0" aria-controls="productstable" type="button"><span><i class="fa fa-print"></i> Print</span></button> </div></div>
            </div>

        </div>
        <?php require_once __DIR__ . '/../features/all-products.php'; ?>
    </div>
</div>