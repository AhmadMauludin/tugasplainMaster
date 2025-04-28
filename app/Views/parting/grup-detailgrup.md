```
<!-- Menampilkan foto grup -->
<img src="<?= base_url('uploads/groups/' . $groups['photo']) ?>" height="100" alt="Foto Grup"><br><br>

<!-- Menampilkan informasi detail grup -->
<p><b>Kode Grup:</b> <?= $groups['id'] ?></p>
<p><b>Nama Grup:</b> <?= $groups['groupname'] ?></p>
<p><b>Deskripsi:</b> <?= $groups['description'] ?></p>
<p><b>Dibuat oleh:</b> <?= $groups['nama'] ?></p>
<p><b>Tanggal Dibuat:</b> <?= $groups['createddate'] ?></p>

<!-- ===================== TOMBOL KEMBALI ===================== -->
<a href="<?= base_url('groups'); ?>">Kembali</a>
```
