<?php
include "koneksi.php";

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];

    $cek = mysqli_query($koneksi, "SELECT * FROM transaksi_detail WHERE barang_id = $id");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Barang tidak bisa dihapus karena sudah digunakan dalam transaksi.'); window.location='barang.php';</script>";
    } else {
        mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
        header("Location: barang.php");
        exit;
    }
}
$query = "SELECT barang.*, supplier.nama AS nama_supplier 
          FROM barang 
          LEFT JOIN supplier ON barang.supplier_id = supplier.id";

$data = mysqli_query($koneksi, $query);
if (!$data) {
    die("Error Query SQL: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>

<h2>Data Barang</h2>

<a href="index.php">Beranda</a> |
<a href="barang_tambah.php">Tambah Barang</a>

<br><br>

<table border="1" cellpadding="7">
<tr>
    <th>ID</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Supplier</th>
    <th>Aksi</th>
</tr>

<?php while ($b = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $b['id']; ?></td>
    <td><?= $b['kode_barang']; ?></td>
    <td><?= $b['nama_barang']; ?></td>
    <td><?= $b['harga']; ?></td>
    <td><?= $b['stok']; ?></td>
    <td><?= $b['nama_supplier']; ?></td>
    <td>
        <a href="barang_edit.php?id=<?= $b['id']; ?>">Edit</a> |
        <a href="barang.php?hapus=<?= $b['id']; ?>" onclick="return confirm('Yakin hapus barang?')">Hapus</a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>