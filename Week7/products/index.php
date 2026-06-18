<?php
// =============================================
// Alnoor Store – Product Catalog (CRUD: Read)
// BIT3208: Week 5 – Database & CRUD Operations
// =============================================

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

// Search & filter
$search   = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';
$category = isset($_GET['category']) ? htmlspecialchars(trim($_GET['category'])) : '';

$where = "WHERE 1=1";
if(!empty($search)){
    $where .= " AND (name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'
                OR description LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')";
}
if(!empty($category)){
    $where .= " AND category = '" . mysqli_real_escape_string($conn, $category) . "'";
}

$products   = mysqli_query($conn, "SELECT * FROM products $where ORDER BY id DESC");
$categories = mysqli_query($conn, "SELECT DISTINCT category FROM products ORDER BY category ASC");
$total      = mysqli_num_rows($products);

$pageTitle  = "Products";
$activePage = "products";
$cssPath    = "../css/style.css";
$homePath   = "../index.php";
?>

<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
    .products-page { flex: 1; padding: 40px 48px; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
    }

    .search-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .search-bar input,
    .search-bar select {
        padding: 10px 16px;
        border: 1.5px solid #e8e8e8;
        border-radius: 8px;
        font-size: 13px;
        color: #111;
        background: #fafafa;
        transition: all 0.2s;
        font-family: 'Segoe UI', sans-serif;
    }

    .search-bar input { flex: 1; min-width: 200px; }

    .search-bar input:focus,
    .search-bar select:focus {
        outline: none;
        border-color: #1a7a3c;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(26,122,60,0.08);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .product-card {
        border: 1.5px solid #f0f0f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.2s;
    }

    .product-card:hover {
        border-color: #1a7a3c;
        box-shadow: 0 4px 20px rgba(26,122,60,0.08);
        transform: translateY(-2px);
    }

    .product-image {
        background: #f7fcf9;
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 44px;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-body { padding: 14px; }

    .product-category {
        font-size: 11px;
        color: #1a7a3c;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        color: #111;
        margin-bottom: 4px;
    }

    .product-desc {
        font-size: 12px;
        color: #888;
        margin-bottom: 10px;
        line-height: 1.5;
    }

    .product-price {
        font-size: 16px;
        font-weight: 700;
        color: #111;
        margin-bottom: 4px;
    }

    .product-stock {
        font-size: 11px;
        color: #888;
        margin-bottom: 12px;
    }

    .product-actions {
        display: flex;
        gap: 8px;
    }

    .product-actions a {
        flex: 1;
        text-align: center;
        padding: 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-edit {
        background: #f0f6ff;
        color: #2980b9;
    }

    .btn-edit:hover { background: #d0e4ff; }

    .btn-delete {
        background: #fce4e4;
        color: #c0392b;
    }

    .btn-delete:hover { background: #f5b7b1; }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px;
        color: #888;
    }

    .empty-state p { font-size: 14px; margin-bottom: 16px; }

    @media(max-width:768px){
        .products-page { padding: 24px; }
        .products-grid { grid-template-columns: 1fr 1fr; }
        .page-header { flex-direction: column; gap: 14px; }
    }
</style>

<div class="products-page">

    <!-- Page header -->
    <div class="page-header">
        <div>
            <div class="page-title">Products</div>
            <div class="page-subtitle">
                <?php echo $total; ?> product<?php echo $total !== 1 ? 's' : ''; ?> found
            </div>
        </div>
        <?php if($_SESSION['user_role'] === 'admin'): ?>
            <a href="add.php" class="btn btn-primary">+ Add product</a>
        <?php endif; ?>
    </div>

    <!-- Success / error messages -->
    <?php if(isset($_GET['added'])): ?>
        <div class="alert alert-success">Product added successfully.</div>
    <?php endif; ?>
    <?php if(isset($_GET['updated'])): ?>
        <div class="alert alert-success">Product updated successfully.</div>
    <?php endif; ?>
    <?php if(isset($_GET['deleted'])): ?>
        <div class="alert alert-error">Product deleted.</div>
    <?php endif; ?>

    <!-- Search & filter -->
    <form method="GET" action="index.php">
        <div class="search-bar">
            <input type="text" name="search"
                   placeholder="Search products..."
                   value="<?php echo $search; ?>">
            <select name="category">
                <option value="">All categories</option>
                <?php
                mysqli_data_seek($categories, 0);
                while($cat = mysqli_fetch_assoc($categories)):
                ?>
                    <option value="<?php echo $cat['category']; ?>"
                        <?php echo $category === $cat['category'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['category']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="index.php" class="btn btn-gray">Clear</a>
        </div>
    </form>

    <!-- Products grid -->
    <div class="products-grid">
        <?php
        $icons = [
            'Electronics'   => '💻',
            'Fashion'       => '👗',
            'Home & Living' => '🏠',
            'Groceries'     => '🛒',
        ];

        if(mysqli_num_rows($products) > 0):
            while($product = mysqli_fetch_assoc($products)):
                $icon = $icons[$product['category']] ?? '📦';
        ?>
            <div class="product-card">
                <div class="product-image"><?php echo $icon; ?></div>
                <div class="product-body">
                    <div class="product-category">
                        <?php echo htmlspecialchars($product['category']); ?>
                    </div>
                    <div class="product-name">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </div>
                    <div class="product-desc">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </div>
                    <div class="product-price">
                        KSh <?php echo number_format($product['price'], 2); ?>
                    </div>
                    <div class="product-stock">
                        <?php echo $product['stock']; ?> in stock
                    </div>
                    <?php if($_SESSION['user_role'] === 'admin'): ?>
                        <div class="product-actions">
                            <a href="edit.php?id=<?php echo $product['id']; ?>"
                               class="btn-edit">Edit</a>
                            <a href="delete.php?id=<?php echo $product['id']; ?>"
                               class="btn-delete"
                               onclick="return confirm('Delete this product?')">Delete</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php
            endwhile;
        else:
        ?>
            <div class="empty-state">
                <p>No products found.</p>
                <?php if($_SESSION['user_role'] === 'admin'): ?>
                    <a href="add.php" class="btn btn-primary">Add your first product</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
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