<?php
// =============================================
// Alnoor Store – Delete Product (CRUD: Delete)
// BIT3208: Week 5 – Database & CRUD Operations
// =============================================

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

// Get product ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id === 0){
    header("Location: index.php");
    exit();
}

// Fetch product details before deleting
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

// Perform delete
$stmt = mysqli_prepare($conn, "DELETE FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_close($stmt);
    header("Location: index.php?deleted=1");
    exit();
} else {
    mysqli_stmt_close($stmt);
    header("Location: index.php?error=1");
    exit();
}
?>