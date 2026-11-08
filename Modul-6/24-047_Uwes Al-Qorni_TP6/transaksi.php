<?php
include "koneksi.php";

$data = mysqli_query($koneksi,
    "SELECT transaksi.*, pelanggan.nama
     FROM transaksi
     JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
</head>
<body>

<h2>Data Transaksi</h2>

<a href="transaksi_tambah.php">Tambah Transaksi</a>

<table border="1" cellpadding="7">
<tr>
    <th>ID</th>
    <th>Tanggal</th>
    <th>Keterangan</th>
    <th>Pelanggan</th>
    <th>Total</th>
    <th>Detail</th>
</tr>

<?php while ($t = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $t['id']; ?></td>
    <td><?= $t['waktu_transaksi']; ?></td>
    <td><?= $t['keterangan']; ?></td>
    <td><?= $t['nama']; ?></td>
    <td><?= $t['total']; ?></td>
    <td>
        <a href="transaksi_detail.php?id=<?= $t['id']; ?>">
            Tambah Detail
        </a>
    </td>
</tr>
<?php } ?>

</table>

<a href="index.php">Kembali</a>

</body>
</html>
