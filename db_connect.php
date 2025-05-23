<?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "kasir-resto";   

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>