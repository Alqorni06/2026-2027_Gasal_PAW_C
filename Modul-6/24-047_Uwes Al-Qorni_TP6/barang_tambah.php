<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $supplier = (int) $_POST['supplier_id'];

    $sql = "INSERT INTO barang
    (kode_barang, nama_barang, harga, stok, supplier_id)
    VALUES ('$kode', '$nama', $harga, $stok, $supplier)";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: barang.php");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

$supplier = mysqli_query($koneksi, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>

<h2>Tambah Barang</h2>

<form method="POST">
    Kode Barang:
    <input type="text" name="kode_barang" required><br><br>

    Nama Barang:
    <input type="text" name="nama_barang" required><br><br>

    Harga:
    <input type="number" name="harga" required><br><br>

    Stok:
    <input type="number" name="stok" required><br><br>

    Supplier:
    <select name="supplier_id" required>
        <option value="">Pilih Supplier</option>
        <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
            <option value="<?= $s['id']; ?>">
                <?= $s['nama']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>

<a href="barang.php">Kembali</a>

</body>
</html>
