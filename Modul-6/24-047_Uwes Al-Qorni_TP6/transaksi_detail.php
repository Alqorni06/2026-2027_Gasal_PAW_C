<?php
include "koneksi.php";

$id = (int) $_GET['id'];

if (isset($_POST['tambah'])) {
    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    $cek = mysqli_query($koneksi,
        "SELECT * FROM barang WHERE id = $barang_id");

    $barang = mysqli_fetch_assoc($cek);

    $sudah = mysqli_query($koneksi,
        "SELECT * FROM transaksi_detail
         WHERE transaksi_id = $id
         AND barang_id = $barang_id");

    if (!$barang) {
        echo "Barang tidak ditemukan.";
    } elseif (mysqli_num_rows($sudah) > 0) {
        echo "Barang sudah dimasukkan ke transaksi ini.";
    } elseif ($qty < 1) {
        echo "Jumlah minimal 1.";
    } elseif ($qty > $barang['stok']) {
        echo "Stok tidak mencukupi.";
    } else {
        $harga = $barang['harga'];

        mysqli_begin_transaction($koneksi);

        $simpan = mysqli_query($koneksi,
            "INSERT INTO transaksi_detail
            (transaksi_id, barang_id, harga, qty)
            VALUES ($id, $barang_id, $harga, $qty)");

        $stok = mysqli_query($koneksi,
            "UPDATE barang
             SET stok = stok - $qty
             WHERE id = $barang_id");

        $total = mysqli_query($koneksi,
            "UPDATE transaksi
             SET total = (
                 SELECT COALESCE(SUM(harga * qty), 0)
                 FROM transaksi_detail
                 WHERE transaksi_id = $id
             )
             WHERE id = $id");

        if ($simpan && $stok && $total) {
            mysqli_commit($koneksi);
            header("Location: transaksi_detail.php?id=$id");
            exit;
        } else {
            mysqli_rollback($koneksi);
            echo "Gagal menyimpan detail: " . mysqli_error($koneksi);
        }
    }
}

// Barang yang sudah dipilih tidak ditampilkan lagi.
$barang = mysqli_query($koneksi,
    "SELECT * FROM barang
     WHERE stok > 0
     AND id NOT IN (
         SELECT barang_id
         FROM transaksi_detail
         WHERE transaksi_id = $id
     )");

// Menampilkan detail transaksi.
$detail = mysqli_query($koneksi,
    "SELECT transaksi_detail.*, barang.nama_barang
     FROM transaksi_detail
     JOIN barang ON transaksi_detail.barang_id = barang.id
     WHERE transaksi_detail.transaksi_id = $id");

$transaksi = mysqli_query($koneksi,
    "SELECT total FROM transaksi WHERE id = $id");

$t = mysqli_fetch_assoc($transaksi);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
</head>
<body>

<h2>Detail Transaksi Nomor <?= $id; ?></h2>

<form method="POST">

    Pilih Barang:
    <select name="barang_id" required>
        <option value="">Pilih Barang</option>

        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id']; ?>">
                <?= $b['nama_barang']; ?>
                - Rp <?= $b['harga']; ?>
                - Stok <?= $b['stok']; ?>
            </option>
        <?php } ?>

    </select><br><br>

    Jumlah:
    <input type="number" name="qty" min="1" required><br><br>

    <button type="submit" name="tambah">Tambah Barang</button>

</form>

<h3>Daftar Barang Transaksi</h3>

<table border="1" cellpadding="7">
<tr>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>

<?php while ($d = mysqli_fetch_assoc($detail)) { ?>
<tr>
    <td><?= $d['nama_barang']; ?></td>
    <td><?= $d['harga']; ?></td>
    <td><?= $d['qty']; ?></td>
    <td><?= $d['harga'] * $d['qty']; ?></td>
</tr>
<?php } ?>

<tr>
    <th colspan="3">TOTAL TRANSAKSI</th>
    <th><?= $t['total']; ?></th>
</tr>

</table>

<br>
<a href="transaksi.php">Kembali</a>

</body>
</html>
