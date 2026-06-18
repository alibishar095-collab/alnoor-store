<?php
// =============================================
// Alnoor Store – Shared Header
// BIT3208: Week 4 – Backend Development
// =============================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' – Alnoor Store' : 'Alnoor Store'; ?></title>
    <link rel="stylesheet" href="<?php echo isset($cssPath) ? $cssPath : 'css/style.css'; ?>">
</head>
<body>

<!-- Topbar -->
<div class="topbar">
    <a href="<?php echo isset($homePath) ? $homePath : 'index.php'; ?>" class="logo">alnoor<span>store</span></a>

    <nav class="topbar-nav">
        <a href="<?php echo isset($homePath) ? $homePath : 'index.php'; ?>" 
           class="<?php echo (isset($activePage) && $activePage === 'home') ? 'active' : ''; ?>">Home</a>
        <a href="#" class="<?php echo (isset($activePage) && $activePage === 'products') ? 'active' : ''; ?>">Products</a>
        <a href="#" class="<?php echo (isset($activePage) && $activePage === 'about') ? 'active' : ''; ?>">About</a>
        <a href="#" class="<?php echo (isset($activePage) && $activePage === 'contact') ? 'active' : ''; ?>">Contact</a>
    </nav>

    <div class="topbar-actions">
        <?php if(isset($_SESSION['user_id'])): ?>
            <span style="font-size:13px; color:#555;">
                Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </span>
            <a href="dashboard.php" class="btn btn-outline btn-sm">Dashboard</a>
            <a href="logout.php" class="btn btn-gray btn-sm">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline btn-sm">Sign in</a>
            <a href="register.php" class="btn btn-primary btn-sm">Register</a>
        <?php endif; ?>
    </div>
</div>