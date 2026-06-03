<?php
    // Alnoor Store – Database Connection
    // BIT3208: Week 3 – Database Connection Practice

    $host     = "localhost";
    $username = "root";
    $password = "";
    $database = "alnoor-store";

    $conn = mysqli_connect($host, $username, $password, $database);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB Connection – Alnoor Store</title>
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
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
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

        .data-block {
            background: #f7fcf9;
            border: 1.5px solid #e0f0e8;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
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
            min-width: 120px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .badge-success { background: #eaf3de; color: #1a7a3c; }
        .badge-error   { background: #fce4e4; color: #c0392b; }

        .error-block {
            background: #fff5f5;
            border: 1.5px solid #fce4e4;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 16px 0;
            text-align: left;
            font-size: 13px;
            color: #c0392b;
        }

        .code-block {
            background: #111;
            border-radius: 10px;
            padding: 16px 20px;
            margin: 20px 0;
            text-align: left;
        }

        .code-block pre {
            color: #a8ff9a;
            font-size: 12px;
            font-family: 'Courier New', monospace;
            line-height: 1.8;
            white-space: pre-wrap;
        }

        .code-block .comment { color: #6a9955; }
        .code-block .keyword { color: #569cd6; }
        .code-block .string  { color: #ce9178; }

        .btn {
            display: inline-block;
            margin-top: 16px;
            padding: 11px 24px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-green { background: #1a7a3c; color: white; }
        .btn-green:hover { background: #155f30; }

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

        <?php if($conn): ?>

            <!-- Success -->
            <div class="icon icon-success">🗄️</div>
            <span class="status-badge badge-success">Connected</span>
            <h2>Database connected</h2>
            <p>PHP successfully established a connection to the MySQL database using <code>mysqli_connect()</code>.</p>

            <div class="data-block">
                <div class="data-row">
                    <span class="key">Database:</span>
                    <span><?php echo $database; ?></span>
                </div>
                <div class="data-row">
                    <span class="key">Host:</span>
                    <span><?php echo $host; ?></span>
                </div>
                <div class="data-row">
                    <span class="key">Username:</span>
                    <span><?php echo $username; ?></span>
                </div>
                <div class="data-row">
                    <span class="key">Server info:</span>
                    <span><?php echo mysqli_get_server_info($conn); ?></span>
                </div>
                <div class="data-row">
                    <span class="key">Connected at:</span>
                    <span><?php echo date('D, d M Y – H:i:s'); ?></span>
                </div>
            </div>

            <div class="code-block">
                <pre>
<span class="comment">// PHP Database Connection</span>
<span class="keyword">$conn</span> = mysqli_connect(
    <span class="string">"localhost"</span>,
    <span class="string">"root"</span>,
    <span class="string">""</span>,
    <span class="string">"alnoor-store"</span>
);

<span class="keyword">if</span>(<span class="keyword">$conn</span>){
    echo <span class="string">"Connected Successfully"</span>;
}
                </pre>
            </div>

        <?php else: ?>

            <!-- Failed -->
            <div class="icon icon-error">❌</div>
            <span class="status-badge badge-error">Failed</span>
            <h2>Connection failed</h2>
            <p>Could not connect to the <strong>alnoor-store</strong> database. Check that XAMPP is running and the database exists.</p>

            <div class="error-block">
                Error: <?php echo mysqli_connect_error(); ?>
            </div>

            <a href="http://localhost/phpmyadmin" class="btn btn-green">Open phpMyAdmin</a>

        <?php endif; ?>

    </div>
</div>

<footer>
    <p>© 2025 Alnoor Store. All rights reserved.</p>
    <p style="color:#bbb; font-size:12px;">BIT3208 – Week 3 Database Connection</p>
</footer>

</body>
</html>