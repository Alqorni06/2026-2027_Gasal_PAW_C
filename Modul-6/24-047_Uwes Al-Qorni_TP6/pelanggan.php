<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jk = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi,
        "INSERT INTO pelanggan
        (id, nama, jenis_kelamin, telp, alamat)
        VALUES ('$id', '$nama', '$jk', '$telp', '$alamat')");

    header("Location: pelanggan.php");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
</head>
<body>

<h2>Data Pelanggan</h2>

<form method="POST">
    ID Pelanggan:
    <input type="text" name="id" required><br><br>

    Nama:
    <input type="text" name="nama" required><br><br>

    Jenis Kelamin:
    <select name="jenis_kelamin">
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select><br><br>

    Telepon:
    <input type="text" name="telp"><br><br>

    Alamat:
    <textarea name="alamat"></textarea><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>

<h3>Daftar Pelanggan</h3>

<table border="1" cellpadding="7">
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Jenis Kelamin</th>
    <th>Telepon</th>
    <th>Alamat</th>
</tr>

<?php while ($p = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $p['id']; ?></td>
    <td><?= $p['nama']; ?></td>
    <td><?= $p['jenis_kelamin']; ?></td>
    <td><?= $p['telp']; ?></td>
    <td><?= $p['alamat']; ?></td>
</tr>
<?php } ?>

</table>

<a href="index.php">Kembali</a>

</body>
</html>
