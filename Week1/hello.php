<?php
    $siteName = "Alnoor Store";
    $message = "Hello World from the server!";
    $week = "Week 1 – PHP Test Page";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World – Alnoor Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #2c3e50; }
        p { color: #555; }
        .tag { 
            background: #2c3e50; 
            color: white; 
            padding: 5px 15px; 
            border-radius: 20px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $siteName; ?></h1>
        <p><?php echo $message; ?></p>
        <p><span class="tag"><?php echo $week; ?></span></p>
    </div>
</body>
</html>