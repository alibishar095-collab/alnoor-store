<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "alnoor-store";

    $conn = mysqli_connect($host, $username, $password, $database);

    if($conn){
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>DB Connection – Alnoor Store</title>
            <style>
                body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background: #f4f4f4; }
                .box { text-align: center; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                h2 { color: #27ae60; }
                p { color: #555; }
            </style>
        </head>
        <body>
            <div class='box'>
                <h2>✅ Connected Successfully</h2>
                <p>PHP is connected to the <strong>alnoor-store</strong> database.</p>
                <p><em>Week 1 – Database Connection Test</em></p>
            </div>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>DB Connection – Alnoor Store</title>
        </head>
        <body>
            <h2 style='color:red;'>❌ Connection Failed</h2>
            <p>" . mysqli_connect_error() . "</p>
        </body>
        </html>";
    }
?>