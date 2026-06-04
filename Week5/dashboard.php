<?php
// =============================================
// Alnoor Store – Dashboard
// BIT3208: Week 4 – Backend Development
// =============================================

session_start();

// Protect page – redirect if not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/includes/db.php';

// Fetch stats
$total_users    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];

// Fetch recent users
$recent_users = mysqli_query($conn, "SELECT full_name, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 5");

// Fetch products
$products = mysqli_query($conn, "SELECT name, category, price, stock FROM products ORDER BY id DESC LIMIT 5");

$pageTitle  = "Dashboard";
$activePage = "dashboard";
$cssPath    = "css/style.css";
$homePath   = "index.php";
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>

<!-- Dashboard body -->
<div class="dashboard-body">

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php" class="sidebar-item active">
            <span class="icon">📊</span> Dashboard
        </a>
        <a href="products/index.php" class="sidebar-item">
            <span class="icon">📦</span> Products
        </a>
        <?php if($_SESSION['user_role'] === 'admin'): ?>
        <a href="products/add.php" class="sidebar-item">
            <span class="icon">➕</span> Add Product
        </a>
        <?php endif; ?>
        <a href="index.php" class="sidebar-item">
            <span class="icon">🏪</span> Storefront
        </a>
        <a href="register.php" class="sidebar-item">
            <span class="icon">👥</span> Customers
        </a>
        <hr class="sidebar-divider">
        <a href="logout.php" class="sidebar-item" style="color:#c0392b;">
            <span class="icon">🚪</span> Logout
        </a>
    </div>

    <!-- Main content -->
    <div class="main-content">

        <!-- Page title -->
        <div class="page-title">
            Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋
        </div>
        <div class="page-subtitle">
            Here's what's happening at Alnoor Store today.
        </div>

        <!-- Stat cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Sales</div>
                <div class="stat-value green">KSh 84,200</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Orders</div>
                <div class="stat-value">142</div>
            </div>
            <a href="products/index.php" style="text-decoration:none;">
                <div class="stat-card" style="cursor:pointer;"
                     onmouseover="this.style.borderColor='#1a7a3c'"
                     onmouseout="this.style.borderColor='#f0f0f0'">
                    <div class="stat-label">Products</div>
                    <div class="stat-value"><?php echo $total_products; ?></div>
                </div>
            </a>
            <div class="stat-card">
                <div class="stat-label">Customers</div>
                <div class="stat-value"><?php echo $total_users; ?></div>
            </div>
        </div>

        <!-- Recent users table -->
        <div style="margin-bottom:10px; display:flex; justify-content:space-between; align-items:center;">
            <p style="font-size:14px; font-weight:700; color:#111;">Recent Customers</p>
            <span class="badge badge-info">Live from database</span>
        </div>

        <div class="table-wrapper" style="margin-bottom:32px;">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($recent_users) > 0): ?>
                        <?php while($user = mysqli_fetch_assoc($recent_users)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span class="badge <?php echo $user['role'] === 'admin' ? 'badge-warning' : 'badge-success'; ?>">
                                        <?php echo ucfirst($user['role']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center; color:#888;">No customers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Products table -->
        <div style="margin-bottom:10px; display:flex; justify-content:space-between; align-items:center;">
            <p style="font-size:14px; font-weight:700; color:#111;">Product Inventory</p>
            <div style="display:flex; gap:10px; align-items:center;">
                <span class="badge badge-info">Live from database</span>
                <?php if($_SESSION['user_role'] === 'admin'): ?>
                    <a href="products/add.php" class="btn btn-primary btn-sm">+ Add product</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <?php if($_SESSION['user_role'] === 'admin'): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($products) > 0): ?>
                        <?php
                        // Re-fetch with ID for edit/delete links
                        $products_with_id = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 5");
                        while($product = mysqli_fetch_assoc($products_with_id)):
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                <td>KSh <?php echo number_format($product['price'], 2); ?></td>
                                <td>
                                    <span class="badge <?php echo $product['stock'] > 10 ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo $product['stock']; ?> units
                                    </span>
                                </td>
                                <?php if($_SESSION['user_role'] === 'admin'): ?>
                                    <td style="display:flex; gap:8px;">
                                        <a href="products/edit.php?id=<?php echo $product['id']; ?>"
                                           class="btn btn-sm"
                                           style="background:#f0f6ff; color:#2980b9; text-decoration:none;">Edit</a>
                                        <a href="products/delete.php?id=<?php echo $product['id']; ?>"
                                           class="btn btn-sm btn-danger"
                                           style="text-decoration:none;"
                                           onclick="return confirm('Delete this product?')">Delete</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; color:#888;">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Quick links -->
        <div style="margin-top:32px; display:flex; gap:12px; flex-wrap:wrap;">
            <a href="products/index.php" class="btn btn-outline">View all products</a>
            <a href="index.php" class="btn btn-gray">Go to storefront</a>
            <?php if($_SESSION['user_role'] === 'admin'): ?>
                <a href="products/add.php" class="btn btn-primary">+ Add new product</a>
            <?php endif; ?>
        </div>

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