<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $waktu = $_POST['waktu_bayar'];
    $metode = $_POST['metode'];
    $transaksi_id = (int) $_POST['transaksi_id'];

    $cek = mysqli_query($koneksi,
        "SELECT total FROM transaksi WHERE id = $transaksi_id");

    $t = mysqli_fetch_assoc($cek);

    if (!$t) {
        die("Transaksi tidak ditemukan.");
    }

    $total = (int) $t['total'];

    mysqli_query($koneksi,
        "INSERT INTO pembayaran
        (waktu_bayar, total, metode, transaksi_id)
        VALUES ('$waktu', $total, '$metode', $transaksi_id)");

    header("Location: pembayaran.php");
    exit;
}

$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi");

$data = mysqli_query($koneksi,
    "SELECT * FROM pembayaran ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
</head>
<body>

<h2>Data Pembayaran</h2>

<form method="POST">

    Waktu Bayar:
    <input type="datetime-local" name="waktu_bayar" required><br><br>

    Transaksi:
    <select name="transaksi_id" required>
        <option value="">Pilih Transaksi</option>

        <?php while ($t = mysqli_fetch_assoc($transaksi)) { ?>
            <option value="<?= $t['id']; ?>">
                Transaksi <?= $t['id']; ?> - Total <?= $t['total']; ?>
            </option>
        <?php } ?>

    </select><br><br>

    Metode Pembayaran:
    <select name="metode">
        <option value="TUNAI">Tunai</option>
        <option value="TRANSFER">Transfer</option>
        <option value="EDC">EDC</option>
    </select><br><br>

    <button type="submit" name="simpan">Simpan Pembayaran</button>

</form>

<h3>Daftar Pembayaran</h3>

<table border="1" cellpadding="7">
<tr>
    <th>ID</th>
    <th>Waktu Bayar</th>
    <th>Total</th>
    <th>Metode</th>
    <th>ID Transaksi</th>
</tr>

<?php while ($p = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $p['id']; ?></td>
    <td><?= $p['waktu_bayar']; ?></td>
    <td><?= $p['total']; ?></td>
    <td><?= $p['metode']; ?></td>
    <td><?= $p['transaksi_id']; ?></td>
</tr>
<?php } ?>

</table>

<a href="index.php">Kembali</a>

</body>
</html>
