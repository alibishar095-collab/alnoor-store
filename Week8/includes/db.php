<?php
// =============================================
// Alnoor Store – Shared Database Connection
// BIT3208: Week 4 – Backend Development
// =============================================

$host     = "localhost";
$username = "root";
$password = "";
$database = "alnoor-store";

$conn = mysqli_connect($host, $username, $password, $database);

if(!$conn){
    die("
        <div style='font-family:Segoe UI,sans-serif;display:flex;justify-content:center;
        align-items:center;height:100vh;background:#fff;'>
        <div style='text-align:center;'>
        <h2 style='color:#c0392b;'>Database connection failed</h2>
        <p style='color:#888;'>".mysqli_connect_error()."</p>
        </div></div>
    ");
}
?>