<?php
// =============================================
// Alnoor Store – Logout
// BIT3208: Week 4 – Backend Development
// =============================================

session_start();

// Store name briefly for goodbye message
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'there';

// Destroy session completely
$_SESSION = [];
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signed Out – Alnoor Store</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .logout-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 48px;
        }

        .logout-card {
            width: 100%;
            max-width: 420px;
            text-align: center;
            border: 1.5px solid #f0f0f0;
            border-radius: 12px;
            padding: 48px 40px;
        }

        .logout-icon {
            font-size: 40px;
            margin-bottom: 20px;
        }

        .logout-card h2 {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .logout-card p {
            font-size: 14px;
            color: #888;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .countdown {
            font-size: 12px;
            color: #bbb;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Topbar -->
<div class="topbar">
    <a href="index.php" class="logo">alnoor<span>store</span></a>
</div>

<!-- Logout card -->
<div class="logout-container">
    <div class="logout-card">
        <div class="logout-icon">👋</div>
        <h2>Goodbye, <?php echo htmlspecialchars($user_name); ?>!</h2>
        <p>You have been signed out successfully. Thank you for shopping at Alnoor Store.</p>

        <a href="login.php" class="btn btn-primary">Sign in again</a>
        &nbsp;
        <a href="index.php" class="btn btn-outline">Back to home</a>

        <div class="countdown" id="countdown">
            Redirecting to home in <span id="timer">5</span> seconds...
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

<script>
    // Auto redirect countdown
    let seconds = 5;
    const timer = document.getElementById('timer');

    const interval = setInterval(function(){
        seconds--;
        timer.textContent = seconds;
        if(seconds <= 0){
            clearInterval(interval);
            window.location.href = 'index.php';
        }
    }, 1000);
</script>

</body>
</html>