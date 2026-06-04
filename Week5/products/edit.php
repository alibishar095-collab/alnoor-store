<?php
// =============================================
// Alnoor Store – Edit Product (CRUD: Update)
// BIT3208: Week 5 – Database & CRUD Operations
// =============================================

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$errors  = [];
$success = "";

// Get product ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id === 0){
    header("Location: index.php");
    exit();
}

// Fetch existing product
$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result  = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if(!$product){
    header("Location: index.php");
    exit();
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name        = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price       = trim($_POST['price']);
    $category    = htmlspecialchars(trim($_POST['category']));
    $stock       = trim($_POST['stock']);

    // Validate
    if(empty($name)){
        $errors[] = "Product name is required.";
    }

    if(empty($price) || !is_numeric($price) || $price <= 0){
        $errors[] = "Please enter a valid price.";
    }

    if(empty($category)){
        $errors[] = "Please select a category.";
    }

    if(empty($stock) || !is_numeric($stock) || $stock < 0){
        $errors[] = "Please enter a valid stock quantity.";
    }

    // Update database
    if(empty($errors)){
        $stmt = mysqli_prepare($conn,
            "UPDATE products
             SET name = ?, description = ?, price = ?, category = ?, stock = ?
             WHERE id = ?"
        );
        mysqli_stmt_bind_param($stmt, "ssdsii", $name, $description, $price, $category, $stock, $id);

        if(mysqli_stmt_execute($stmt)){
            header("Location: index.php?updated=1");
            exit();
        } else {
            $errors[] = "Failed to update product. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }

    // Update local product array for form repopulation
    $product['name']        = $name;
    $product['description'] = $description;
    $product['price']       = $price;
    $product['category']    = $category;
    $product['stock']       = $stock;
}

$pageTitle  = "Edit Product";
$activePage = "products";
$cssPath    = "../css/style.css";
$homePath   = "../index.php";
?>

<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
    .edit-page {
        flex: 1;
        padding: 40px 48px;
        max-width: 700px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #888;
        text-decoration: none;
        margin-bottom: 24px;
        transition: color 0.2s;
    }

    .back-link:hover { color: #1a7a3c; }

    .product-id-badge {
        display: inline-block;
        background: #f7fcf9;
        border: 1.5px solid #e0f0e8;
        border-radius: 6px;
        padding: 4px 12px;
        font-size: 12px;
        color: #1a7a3c;
        font-weight: 600;
        margin-bottom: 20px;
    }
</style>

<div class="edit-page">

    <a href="index.php" class="back-link">← Back to products</a>

    <div class="page-title">Edit Product</div>
    <div class="page-subtitle">Update the details for this product.</div>

    <div class="product-id-badge">Product ID: #<?php echo $id; ?></div>

    <!-- Errors -->
    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <?php echo $error; ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?php echo $id; ?>">

        <div class="form-group">
            <label for="name">Product name</label>
            <input type="text" id="name" name="name"
                   value="<?php echo htmlspecialchars($product['name']); ?>"
                   placeholder="e.g. Wireless Headphones">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"
                      placeholder="Brief product description..."><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price">Price (KSh)</label>
                <input type="number" id="price" name="price" min="1" step="0.01"
                       value="<?php echo htmlspecialchars($product['price']); ?>"
                       placeholder="0.00">
            </div>
            <div class="form-group">
                <label for="stock">Stock quantity</label>
                <input type="number" id="stock" name="stock" min="0"
                       value="<?php echo htmlspecialchars($product['stock']); ?>"
                       placeholder="0">
            </div>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category">
                <option value="">Select a category</option>
                <option value="Electronics"   <?php echo $product['category'] === 'Electronics'   ? 'selected' : ''; ?>>Electronics</option>
                <option value="Fashion"       <?php echo $product['category'] === 'Fashion'       ? 'selected' : ''; ?>>Fashion</option>
                <option value="Home & Living" <?php echo $product['category'] === 'Home & Living' ? 'selected' : ''; ?>>Home & Living</option>
                <option value="Groceries"     <?php echo $product['category'] === 'Groceries'     ? 'selected' : ''; ?>>Groceries</option>
            </select>
        </div>

        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="index.php" class="btn btn-gray">Cancel</a>
        </div>

    </form>
</div>

<!-- Footer -->
<footer>
    <p>© 2025 Alnoor Store. All rights reserved.</p>
    <nav>
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
        <a href="#">Contact</a>
    </nav>
</footer>

</body>
</html>