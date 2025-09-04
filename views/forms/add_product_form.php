<?php
require_once __DIR__ . '/../../config/database_connection.php';
require_once __DIR__ . '/../../controllers/category_controller.php';
require_once __DIR__ . '/../../controllers/brand_controller.php';

if(!isset($pdo)){
    die("Connection failed: " . mysqli_connect_error());
}
if(!isset($category)){
    return ["error"=>true, "message"=>"No category selected"];
}
if(!isset($brands)){
    return ["error"=>true, "message"=>"No category selected"];
}
// Fetch all product tags from the database
try {
    $stmt = $pdo->prepare("SELECT id, tag_name FROM product_tags ORDER BY tag_name ASC");
    $stmt->execute();
    $productTags = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching product tags: " . $e->getMessage());
}
?>
<form action="/dev/controllers/product_controller.php" method="POST" enctype="multipart/form-data" class="container mt-4 form-group form-control fullscreen">
    <input type="hidden" name="add_product" value="1" />

    <div class="mb-3">
        <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="product_name" name="product_name" required />
    </div>

    <div class="mb-3 row">
        <div class="col">
            <label for="product_selling_price" class="form-label">Selling Price <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control" id="product_selling_price" name="product_selling_price" required />
        </div>
        <div class="col">
            <label for="product_stock_price" class="form-label">Stock Price</label>
            <input type="number" step="0.01" class="form-control" id="product_stock_price" name="product_stock_price" />
        </div>
        <div class="col">
            <label for="product_discounted_price" class="form-label">Discounted Price</label>
            <input type="number" step="0.01" class="form-control" id="product_discounted_price" name="product_discounted_price" />
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col">
            <label for="product_stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="product_stock" name="product_stock" />
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col">
            <label for="product_category_id" class="form-label">Category <span class="text-danger">*</span></label>
            <select class="form-select" id="product_category_id" name="product_category_id" required>
                <option value="" selected disabled>Select category</option>
                <?php foreach($category as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col">
            <label for="product_brand_id" class="form-label">Brand <span class="text-danger">*</span></label>
            <select class="form-select" id="product_brand_id" name="product_brand_id" required>
                <option value="" selected disabled>Select brand</option>
                <?php foreach($brands as $brand): ?>
                    <option value="<?= htmlspecialchars($brand['id']) ?>"><?= htmlspecialchars($brand['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label for="product_description" class="form-label">Description</label>
        <textarea class="form-control" id="product_description" name="product_description" rows="4"></textarea>
    </div>

    <div class="mb-3">
        <label for="product_image_url" class="form-label">Product Image</label>
        <input class="form-control" type="file" id="product_image_url" name="product_image_url" accept="image/*" />
    </div>

    <div class="d-flex gap-3 flex-wrap mb-3">
        <label class="form-label w-100">Tags:</label>
        <?php foreach($productTags as $tag): ?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="tag_<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>" />
                <label class="form-check-label" for="tag_<?= $tag['id'] ?>"><?= htmlspecialchars($tag['tag_name']) ?></label>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-primary">Add Product</button>
</form>
