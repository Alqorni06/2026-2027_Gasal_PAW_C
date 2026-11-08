<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $hp = $_POST['hp'];
    $level = (int) $_POST['level'];

    mysqli_query($koneksi,
        "INSERT INTO `user`
        (username, password, nama, alamat, hp, level)
        VALUES ('$username', '$password', '$nama', '$alamat', '$hp', $level)");

    header("Location: user.php");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM `user`");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>

<h2>Data User</h2>

<form method="POST">
    Username:
    <input type="text" name="username" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    Nama:
    <input type="text" name="nama" required><br><br>

    Alamat:
    <textarea name="alamat"></textarea><br><br>

    HP:
    <input type="text" name="hp"><br><br>

    Level:
    <select name="level">
        <option value="1">Admin</option>
        <option value="2">Kasir</option>
    </select><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>

<h3>Daftar User</h3>

<table border="1" cellpadding="7">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>HP</th>
    <th>Level</th>
</tr>

<?php while ($u = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $u['id_user']; ?></td>
    <td><?= $u['username']; ?></td>
    <td><?= $u['nama']; ?></td>
    <td><?= $u['alamat']; ?></td>
    <td><?= $u['hp']; ?></td>
    <td><?= $u['level']; ?></td>
</tr>
<?php } ?>

</table>

<a href="index.php">Kembali</a>

</body>
</html>
