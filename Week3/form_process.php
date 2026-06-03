<?php
    // Alnoor Store – Form Processor
    // BIT3208: Week 3 – PHP Form Handling

    session_start();

    $name     = "";
    $email    = "";
    $message  = "";
    $errors   = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // Sanitize inputs
        $name  = htmlspecialchars(trim($_POST['reg_name']  ?? $_POST['name']  ?? ''));
        $email = htmlspecialchars(trim($_POST['reg_email'] ?? $_POST['email'] ?? ''));

        // Validate
        if(empty($name)){
            $errors[] = "Name is required.";
        }

        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "A valid email address is required.";
        }

        if(empty($errors)){
            $message = "Welcome, " . $name . "! Your form was submitted successfully.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Response – Alnoor Store</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            padding: 20px 48px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo { font-size: 22px; font-weight: 700; color: #1a7a3c; letter-spacing: -0.5px; }
        .logo span { color: #111; }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 48px;
        }

        .card {
            width: 100%;
            max-width: 480px;
            border: 1.5px solid #f0f0f0;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
        }

        .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 26px;
        }

        .icon-success { background: #f7fcf9; }
        .icon-error   { background: #fff5f5; }

        .card h2 {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .card p {
            font-size: 14px;
            color: #666;
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .error-list {
            text-align: left;
            background: #fff5f5;
            border: 1.5px solid #fce4e4;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 16px 0;
        }

        .error-list li {
            font-size: 13px;
            color: #c0392b;
            margin-bottom: 6px;
            list-style: none;
            padding-left: 16px;
            position: relative;
        }

        .error-list li::before {
            content: '×';
            position: absolute;
            left: 0;
            font-weight: 700;
        }

        .data-block {
            background: #f7fcf9;
            border: 1.5px solid #e0f0e8;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 16px 0;
            text-align: left;
        }

        .data-row {
            display: flex;
            gap: 12px;
            font-size: 13px;
            color: #333;
            margin-bottom: 8px;
        }

        .data-row:last-child { margin-bottom: 0; }

        .data-row .key {
            font-weight: 600;
            color: #555;
            min-width: 80px;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 11px 24px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-green { background: #1a7a3c; color: white; }
        .btn-green:hover { background: #155f30; }

        .btn-outline {
            background: transparent;
            color: #1a7a3c;
            border: 1.5px solid #1a7a3c;
            margin-left: 8px;
        }

        .btn-outline:hover { background: #f7fcf9; }

        footer {
            padding: 18px 48px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
        }

        footer p { font-size: 12px; color: #bbb; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="logo">alnoor<span>store</span></div>
</div>

<div class="container">
    <div class="card">

        <?php if($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>

            <!-- Direct access — no form submitted -->
            <div class="icon icon-error">⚠️</div>
            <h2>No data received</h2>
            <p>This page processes form submissions. Please submit a form to see results.</p>
            <a href="register.html" class="btn btn-green">Go to Register</a>
            <a href="login.html" class="btn btn-outline">Go to Login</a>

        <?php elseif(!empty($errors)): ?>

            <!-- Errors found -->
            <div class="icon icon-error">❌</div>
            <h2>Submission failed</h2>
            <p>Please fix the following errors and try again.</p>
            <ul class="error-list">
                <?php foreach($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="register.html" class="btn btn-green">Try again</a>

        <?php else: ?>

            <!-- Success -->
            <div class="icon icon-success">✅</div>
            <h2>Submission successful</h2>
            <p><?php echo $message; ?></p>

            <div class="data-block">
                <div class="data-row">
                    <span class="key">Name:</span>
                    <span><?php echo $name; ?></span>
                </div>
                <div class="data-row">
                    <span class="key">Email:</span>
                    <span><?php echo $email; ?></span>
                </div>
                <div class="data-row">
                    <span class="key">Time:</span>
                    <span><?php echo date('D, d M Y – H:i:s'); ?></span>
                </div>
            </div>

            <a href="register.html" class="btn btn-green">Back to Register</a>
            <a href="login.html" class="btn btn-outline">Sign in</a>

        <?php endif; ?>

    </div>
</div>

<footer>
    <p>© 2025 Alnoor Store. All rights reserved.</p>
    <p style="color:#bbb; font-size:12px;">BIT3208 – Week 3 PHP Form Processing</p>
</footer>

</body>
</html>