<?php
session_start();
 if (!isset($_SESSION['username'])) {
  header("Location: login.php");
   exit();
 }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - RM.ema</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="topbar">
        <div class="title">RM.ema</div>
        <div class="menu-header">Order</div>
        <div class="menu-header">Menu</div>
    </div>

    <div class="container">
        <div class="sidebar">
            <ul>
                <li>stok</li>
                <li>order</li>
                <li>transaksi</li>
                <li>laporan</li>
            </ul>
            <div class="logout"><a href="login.php" style="color:white; text-decoration:none;">keluar</a></div>
        </div>

        <div class="order-panel">
            <div class="order-header"></div>
            <div class="order-body">
                <p style="color: #444;">[Daftar pesanan]</p>
            </div>
            <div class="order-footer">
                <div class="total">total : Rp.52.000</div>
                <button class="pay-button">Bayar</button>
            </div>
        </div>

        <div class="menu-panel">
            <?php
            for ($i = 1; $i <= 6; $i++) {
                echo '<div class="menu-item">
                        <div class="menu-image">gambar</div>
                        <div class="price">harga</div>
                      </div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
