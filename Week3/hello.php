<?php
    // Alnoor Store – PHP Syntax Practice
    // BIT3208: Week 3 – Introduction to PHP

    $siteName = "Alnoor Store";
    $week     = "Week 3";
    $unit     = "BIT3208 – Advanced Web Design and Development";
    $student  = "Ali Bishar";

    $items = ["Fashion", "Electronics", "Home & Living", "Groceries"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Practice – Alnoor Store</title>
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
            padding: 48px;
            max-width: 700px;
        }

        .tag {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #1a7a3c;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .subtitle { font-size: 14px; color: #888; margin-bottom: 36px; }

        .info-block {
            background: #f7fcf9;
            border: 1.5px solid #e0f0e8;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .info-block h3 {
            font-size: 13px;
            font-weight: 700;
            color: #1a7a3c;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 14px;
        }

        .info-row {
            display: flex;
            gap: 12px;
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
        }

        .info-row .key {
            font-weight: 600;
            color: #555;
            min-width: 120px;
        }

        .category-list {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 4px;
        }

        .category-list li {
            background: #1a7a3c;
            color: white;
            font-size: 12px;
            padding: 5px 14px;
            border-radius: 20px;
        }

        .code-block {
            background: #111;
            border-radius: 10px;
            padding: 20px 24px;
            margin-bottom: 24px;
        }

        .code-block pre {
            color: #a8ff9a;
            font-size: 13px;
            font-family: 'Courier New', monospace;
            line-height: 1.8;
            white-space: pre-wrap;
        }

        .code-block .comment { color: #6a9955; }
        .code-block .keyword { color: #569cd6; }
        .code-block .string  { color: #ce9178; }

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
    <div class="tag">Week 3 – PHP Syntax Practice</div>
    <h1>Hello from PHP</h1>
    <p class="subtitle">Demonstrating PHP variables, echo, and loops on the server side.</p>

    <!-- PHP output block -->
    <div class="info-block">
        <h3>PHP Variables Output</h3>
        <div class="info-row">
            <span class="key">Site name:</span>
            <span><?php echo $siteName; ?></span>
        </div>
        <div class="info-row">
            <span class="key">Student:</span>
            <span><?php echo $student; ?></span>
        </div>
        <div class="info-row">
            <span class="key">Week:</span>
            <span><?php echo $week; ?></span>
        </div>
        <div class="info-row">
            <span class="key">Unit:</span>
            <span><?php echo $unit; ?></span>
        </div>
        <div class="info-row">
            <span class="key">Server time:</span>
            <span><?php echo date('D, d M Y – H:i:s'); ?></span>
        </div>
    </div>

    <!-- PHP loop output -->
    <div class="info-block">
        <h3>PHP Loop – Product Categories</h3>
        <ul class="category-list">
            <?php foreach($items as $item): ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Code display -->
    <div class="code-block">
        <pre>
<span class="comment">// PHP Variables</span>
<span class="keyword">$siteName</span> = <span class="string">"Alnoor Store"</span>;
<span class="keyword">$student</span>  = <span class="string">"Ali Bishar"</span>;

<span class="comment">// Echo output</span>
echo <span class="keyword">$siteName</span>;

<span class="comment">// PHP Loop</span>
<span class="keyword">foreach</span>(<span class="keyword">$items</span> as <span class="keyword">$item</span>){
    echo <span class="keyword">$item</span>;
}
        </pre>
    </div>
</div>

<footer>
    <p>© 2025 Alnoor Store. All rights reserved.</p>
    <p style="color:#bbb; font-size:12px;">BIT3208 – Week 3 PHP Practice</p>
</footer>

</body>
</html>