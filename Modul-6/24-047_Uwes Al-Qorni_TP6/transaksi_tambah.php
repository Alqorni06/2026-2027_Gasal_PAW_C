<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['waktu_transaksi'];
    $keterangan = $_POST['keterangan'];
    $pelanggan = $_POST['pelanggan_id'];

    mysqli_query($koneksi,
        "INSERT INTO transaksi
        (waktu_transaksi, keterangan, total, pelanggan_id)
        VALUES ('$tanggal', '$keterangan', 0, '$pelanggan')");

    $id = mysqli_insert_id($koneksi);

    header("Location: transaksi_detail.php?id=$id");
    exit;
}

$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
</head>
<body>

<h2>Tambah Transaksi</h2>

<form method="POST">
    Tanggal:
    <input type="date" name="waktu_transaksi" required><br><br>

    Pelanggan:
    <select name="pelanggan_id" required>
        <option value="">Pilih Pelanggan</option>
        <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
            <option value="<?= $p['id']; ?>">
                <?= $p['nama']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    Keterangan:
    <textarea name="keterangan"></textarea><br><br>

    <button type="submit" name="simpan">Simpan Transaksi</button>
</form>

<a href="transaksi.php">Kembali</a>

</body>
</html>
