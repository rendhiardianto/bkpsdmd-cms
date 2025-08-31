<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Tambah Berita</h2>
<form action="save_berita.php" method="POST" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="Judul"><br>
  <textarea name="content" placeholder="Isi berita"></textarea><br>
  <input type="file" name="image"><br>
  <button type="submit">Simpan</button>
</form>

<h2>Tambah Pengumuman</h2>
<form action="save_pengumuman.php" method="POST" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="Judul"><br>
  <textarea name="content" placeholder="Isi pengumuman"></textarea><br>
  <input type="file" name="file"><br>
  <button type="submit">Simpan</button>
</form>
