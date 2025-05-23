<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['id_level'] != 1) {
    header("Location: ../login.php");
    exit();
}
require_once '../includes/db_connect.php';

$message = "";

// Tambah Menu Baru
if (isset($_POST['add_menu'])) {
    $nama_masakan = $_POST['nama_masakan'];
    $harga = $_POST['harga'];
    $status_masakan = $_POST['status_masakan'];

    $sql = "INSERT INTO masakan (nama_masakan, harga, status_masakan) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $nama_masakan, $harga, $status_masakan);
    if ($stmt->execute()) {
        $message = "Menu berhasil ditambahkan.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Update Menu
if (isset($_POST['update_menu'])) {
    $id_masakan = $_POST['id_masakan'];
    $nama_masakan = $_POST['nama_masakan'];
    $harga = $_POST['harga'];
    $status_masakan = $_POST['status_masakan'];

    $sql = "UPDATE masakan SET nama_masakan = ?, harga = ?, status_masakan = ? WHERE id_masakan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $nama_masakan, $harga, $status_masakan, $id_masakan);
    if ($stmt->execute()) {
        $message = "Menu berhasil diperbarui.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Hapus Menu
if (isset($_GET['delete_id'])) {
    $id_masakan = $_GET['delete_id'];

    $sql = "DELETE FROM masakan WHERE id_masakan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_masakan);
    if ($stmt->execute()) {
        $message = "Menu berhasil dihapus.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Ambil semua menu
$sql_select_menu = "SELECT * FROM masakan";
$result_select_menu = $conn->query($sql_select_menu);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="header">
        <h1>Kelola Menu Makanan</h1>
        <a href="index.php">Kembali ke Dashboard Admin</a> | <a href="../logout.php">Logout</a>
    </div>

    <div class="container">
        <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>

        <h3>Tambah Menu Baru</h3>
        <form action="manage_menu.php" method="POST">
            <div class="form-group">
                <label for="nama_masakan">Nama Masakan:</label>
                <input type="text" id="nama_masakan" name="nama_masakan" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="status_masakan">Status:</label>
                <select id="status_masakan" name="status_masakan">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
            </div>
            <button type="submit" name="add_menu">Tambah Menu</button>
        </form>

        <h3>Daftar Menu</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Masakan</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_select_menu->num_rows > 0) {
                    while ($row = $result_select_menu->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_masakan'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_masakan']) . "</td>";
                        echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                        echo "<td>" . htmlspecialchars($row['status_masakan']) . "</td>";
                        echo "<td>";
                        echo "<a href='#' onclick='openEditForm(" . json_encode($row) . ")'>Edit</a> | ";
                        echo "<a href='manage_menu.php?delete_id=" . $row['id_masakan'] . "' onclick='return confirm(\"Yakin ingin menghapus menu ini?\")'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada menu tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div id="editFormContainer" style="display:none; margin-top: 20px; border-top: 1px solid #ccc; padding-top: 20px;">
            <h3>Edit Menu</h3>
            <form action="manage_menu.php" method="POST">
                <input type="hidden" id="edit_id_masakan" name="id_masakan">
                <div class="form-group">
                    <label for="edit_nama_masakan">Nama Masakan:</label>
                    <input type="text" id="edit_nama_masakan" name="nama_masakan" required>
                </div>
                <div class="form-group">
                    <label for="edit_harga">Harga:</label>
                    <input type="number" id="edit_harga" name="harga" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="edit_status_masakan">Status:</label>
                    <select id="edit_status_masakan" name="status_masakan">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <button type="submit" name="update_menu">Update Menu</button>
                <button type="button" onclick="closeEditForm()">Batal</button>
            </form>
        </div>
    </div>

    <script>
        function openEditForm(menuData) {
            document.getElementById('edit_id_masakan').value = menuData.id_masakan;
            document.getElementById('edit_nama_masakan').value = menuData.nama_masakan;
            document.getElementById('edit_harga').value = menuData.harga;
            document.getElementById('edit_status_masakan').value = menuData.status_masakan;
            document.getElementById('editFormContainer').style.display = 'block';
            window.scrollTo(0, document.body.scrollHeight); // Scroll to bottom
        }

        function closeEditForm() {
            document.getElementById('editFormContainer').style.display = 'none';
        }
    </script>
</body>
</html>
<?php
$conn->close();
?>