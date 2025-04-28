```
<!-- Menampilkan gambar tugas -->
<center><img src="<?= base_url('uploads/tugas/' . $tugas['foto']) ?>" height="100"></center>
<!-- Menampilkan detail tugas -->
<h3>Detail Tugas</h3>
<p>Id tugas : <?= $tugas['id'] ?></p>
<p>Nama Tugas : <?= $tugas['tugas'] ?></p>
<p>Pembuat : <?= $tugas['nama'] ?></p>
<p>Tanggal, Waktu : <?= $tugas['tanggal'] ?>, <?= $tugas['waktu'] ?> WIB</p>
<p>Status tugas : <strong><?= $tugas['status'] ?></strong></p>

<a href="<?= base_url('tugas/sharedtome'); ?>">Kembali</a>

```
