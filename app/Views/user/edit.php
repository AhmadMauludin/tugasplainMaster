<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<!-- Menampilkan foto pengguna -->
<p align="center">
    <img src="<?= base_url('uploads/user/' . $user['foto']) ?>" width="50">
</p>
<br>

<!-- Form untuk mengupdate data user -->
<form action="<?= base_url('/user/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">

    <!-- Data lama foto untuk keperluan penggantian -->
    <input type="hidden" name="old_foto" value="<?= $user['foto'] ?>">

    <!-- Input nama user -->
    <p>
        <label for="nama">User:</label><br>
        <input name="nama" type="text" value="<?= $user['nama'] ?>" id="nama" required>
    </p>

    <!-- Input bagian (disembunyikan) -->
    <input name="bagian" type="hidden" value="<?= $user['bagian'] ?>" required>

    <!-- Input password (jika ingin diubah) -->
    <p>
        <label for="password">Password (kosongkan jika tidak diubah):</label><br>
        <input name="password" type="text" id="password" placeholder="kosongkan jika tidak ingin dirubah">
    </p>

    <!-- Input untuk mengganti foto -->
    <p>
        <label for="foto">Foto:</label><br>
        <input name="foto" type="file" id="foto">
    </p>

    <!-- Tombol aksi -->
    <p>
        <a href="<?= base_url('/'); ?>">Kembali</a>
        <button type="submit">Ubah User</button>
    </p>
</form>

<?= $this->endSection(); ?>