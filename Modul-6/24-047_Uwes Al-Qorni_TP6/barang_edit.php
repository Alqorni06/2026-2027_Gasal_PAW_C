<?php
include "koneksi.php";

$id = (int) $_GET['id'];

$data = mysqli_query($koneksi,
    "SELECT * FROM barang WHERE id = $id");

$b = mysqli_fetch_assoc($data);

if (!$b) {
    die("Barang tidak ditemukan.");
}

if (isset($_POST['update'])) {
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $supplier = (int) $_POST['supplier_id'];

    $sql = "UPDATE barang SET
        kode_barang='$kode',
        nama_barang='$nama',
        harga=$harga,
        stok=$stok,
        supplier_id=$supplier
        WHERE id=$id";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: barang.php");
        exit;
    } else {
        echo mysqli_error($koneksi);
    }
}

$supplier = mysqli_query($koneksi, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>

<h2>Edit Barang</h2>

<form method="POST">

    Kode Barang:
    <input type="text" name="kode_barang"
    value="<?= htmlspecialchars($b['kode_barang']); ?>" required><br><br>

    Nama Barang:
    <input type="text" name="nama_barang"
    value="<?= htmlspecialchars($b['nama_barang']); ?>" required><br><br>

    Harga:
    <input type="number" name="harga"
    value="<?= $b['harga']; ?>" required><br><br>

    Stok:
    <input type="number" name="stok"
    value="<?= $b['stok']; ?>" required><br><br>

    Supplier:
    <select name="supplier_id" required>
        <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
            <option value="<?= $s['id']; ?>"
                <?= $s['id'] == $b['supplier_id'] ? 'selected' : ''; ?>>
                <?= $s['nama']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit" name="update">Update</button>

</form>

<a href="barang.php">Kembali</a>

</body>
</html>
