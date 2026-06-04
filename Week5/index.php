<?php
// =============================================
// Alnoor Store – Homepage
// BIT3208: Week 4 – Backend Development
// =============================================

session_start();

require_once __DIR__ . '/includes/db.php';

// Fetch featured products from database
$products = mysqli_query($conn,
    "SELECT id, name, description, price, category, stock
     FROM products
     ORDER BY id DESC
     LIMIT 8"
);

// Fetch categories
$categories = mysqli_query($conn,
    "SELECT DISTINCT category FROM products ORDER BY category ASC"
);

$pageTitle  = "Home";
$activePage = "home";
$cssPath    = "css/style.css";
$homePath   = "index.php";
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>

<style>
    /* ── Hero ── */
    .hero {
        background: #f7fcf9;
        border-bottom: 1px solid #f0f0f0;
        padding: 72px 48px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        align-items: center;
    }

    .hero-left .tag {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #1a7a3c;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .hero-left h1 {
        font-size: 48px;
        font-weight: 700;
        color: #111;
        line-height: 1.1;
        letter-spacing: -2px;
        margin-bottom: 18px;
    }

    .hero-left h1 span { color: #1a7a3c; }

    .hero-left p {
        font-size: 15px;
        color: #666;
        line-height: 1.8;
        max-width: 420px;
        margin-bottom: 32px;
    }

    .hero-actions { display: flex; gap: 12px; }

    .hero-right {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .hero-stat {
        background: #fff;
        border: 1.5px solid #f0f0f0;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
    }

    .hero-stat .value {
        font-size: 28px;
        font-weight: 700;
        color: #1a7a3c;
        letter-spacing: -1px;
    }

    .hero-stat .label {
        font-size: 12px;
        color: #888;
        margin-top: 4px;
    }

    /* ── Categories ── */
    .section {
        padding: 48px;
        border-bottom: 1px solid #f0f0f0;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #111;
        letter-spacing: -0.5px;
    }

    .categories-grid {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .category-pill {
        padding: 10px 22px;
        border-radius: 30px;
        border: 1.5px solid #e8e8e8;
        font-size: 13px;
        color: #555;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 500;
    }

    .category-pill:hover,
    .category-pill.active {
        background: #1a7a3c;
        color: #fff;
        border-color: #1a7a3c;
    }

    /* ── Products grid ── */
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
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-body { padding: 16px; }

    .product-category {
        font-size: 11px;
        color: #1a7a3c;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        color: #111;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .product-desc {
        font-size: 12px;
        color: #888;
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-price {
        font-size: 16px;
        font-weight: 700;
        color: #111;
        letter-spacing: -0.5px;
    }

    .product-stock {
        font-size: 11px;
        color: #888;
    }

    .add-to-cart {
        width: 100%;
        margin-top: 12px;
        padding: 9px;
        background: #1a7a3c;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .add-to-cart:hover { background: #155f30; }

    /* Category icons map */
    .cat-icon { font-size: 40px; }

    /* ── Banner ── */
    .banner {
        background: #1a7a3c;
        padding: 48px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .banner h2 {
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.5px;
        margin-bottom: 8px;
    }

    .banner p { font-size: 14px; color: #a8ddb9; }

    .banner .btn-white {
        background: #fff;
        color: #1a7a3c;
        padding: 12px 28px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .banner .btn-white:hover { background: #f7fcf9; }

    /* No products */
    .empty-state {
        text-align: center;
        padding: 48px;
        color: #888;
        font-size: 14px;
        grid-column: 1 / -1;
    }

    @media (max-width: 768px) {
        .hero { grid-template-columns: 1fr; padding: 40px 24px; }
        .hero-left h1 { font-size: 32px; }
        .hero-right { grid-template-columns: 1fr 1fr; }
        .products-grid { grid-template-columns: 1fr 1fr; }
        .section { padding: 32px 24px; }
        .banner { flex-direction: column; gap: 20px; padding: 32px 24px; text-align: center; }
    }
</style>

<!-- Hero -->
<div class="hero">
    <div class="hero-left">
        <div class="tag">Welcome to Alnoor Store</div>
        <h1>Quality products,<br><span>great prices.</span></h1>
        <p>Shop thousands of products across fashion, electronics, home essentials, groceries and more — delivered right to your door.</p>
        <div class="hero-actions">
            <a href="#products" class="btn btn-primary">Shop now</a>
            <?php if(!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn btn-outline">Create account</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn btn-outline">My dashboard</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="hero-right">
        <div class="hero-stat">
            <div class="value">500+</div>
            <div class="label">Products</div>
        </div>
        <div class="hero-stat">
            <div class="value">24/7</div>
            <div class="label">Support</div>
        </div>
        <div class="hero-stat">
            <div class="value">Fast</div>
            <div class="label">Delivery</div>
        </div>
        <div class="hero-stat">
            <div class="value">100%</div>
            <div class="label">Secure</div>
        </div>
    </div>
</div>

<!-- Categories -->
<div class="section">
    <div class="section-header">
        <div class="section-title">Browse Categories</div>
    </div>
    <div class="categories-grid">
        <a href="#products" class="category-pill active">All Products</a>
        <?php
        mysqli_data_seek($categories, 0);
        while($cat = mysqli_fetch_assoc($categories)):
        ?>
            <a href="#products" class="category-pill">
                <?php echo htmlspecialchars($cat['category']); ?>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<!-- Products -->
<div class="section" id="products">
    <div class="section-header">
        <div class="section-title">Featured Products</div>
        <span class="badge badge-success">Live from database</span>
    </div>
    <div class="products-grid">
        <?php if(mysqli_num_rows($products) > 0): ?>
            <?php
            $icons = [
                'Electronics'  => '💻',
                'Fashion'      => '👗',
                'Home & Living'=> '🏠',
                'Groceries'    => '🛒',
            ];
            while($product = mysqli_fetch_assoc($products)):
                $icon = $icons[$product['category']] ?? '📦';
            ?>
                <div class="product-card">
                    <div class="product-image">
                        <span class="cat-icon"><?php echo $icon; ?></span>
                    </div>
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
                        <div class="product-footer">
                            <div class="product-price">
                                KSh <?php echo number_format($product['price'], 2); ?>
                            </div>
                            <div class="product-stock">
                                <?php echo $product['stock']; ?> in stock
                            </div>
                        </div>
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <button class="add-to-cart">Add to cart</button>
                        <?php else: ?>
                            <a href="login.php" class="add-to-cart"
                               style="display:block; text-align:center; text-decoration:none;">
                                Sign in to buy
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                No products found. Add some in phpMyAdmin.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Banner -->
<div class="banner">
    <div>
        <h2>Ready to start shopping?</h2>
        <p>Join thousands of happy customers across Kenya.</p>
    </div>
    <?php if(!isset($_SESSION['user_id'])): ?>
        <a href="register.php" class="btn-white">Create free account</a>
    <?php else: ?>
        <a href="dashboard.php" class="btn-white">Go to dashboard</a>
    <?php endif; ?>
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