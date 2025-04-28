<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<!-- Menampilkan gambar tugas -->
<center>
    <img src="<?= base_url('uploads/tugas/' . $tugas['foto']) ?>" width="50">
</center>
<br>

<!-- Form untuk mengupdate data tugas -->
<form action="<?= site_url('tugas/update/' . $tugas['id']) ?>" method="post" enctype="multipart/form-data">

    <!-- Hidden input untuk menyimpan foto lama jika tidak diubah -->
    <input type="hidden" name="old_foto" value="<?= $tugas['foto'] ?>">

    <!-- Input untuk Nama Tugas -->
    <p>
        <label>Tugas</label><br>
        <input name="tugas" type="text" value="<?= $tugas['tugas'] ?>" required>
    </p>

    <!-- Input untuk Tanggal -->
    <p>
        <label>Tanggal</label><br>
        <input type="date" name="tanggal" value="<?= $tugas['tanggal'] ?>">
    </p>

    <!-- Input untuk Waktu -->
    <p>
        <label>Waktu</label><br>
        <input type="time" name="waktu" value="<?= $tugas['waktu'] ?>">
    </p>

    <!-- Input untuk Status -->
    <p>
        <label>Status</label><br>
        <select name="status">
            <option value="To do" <?= $tugas['status'] == 'To do' ? 'selected' : '' ?>>To do</option>
            <option value="Berjalan" <?= $tugas['status'] == 'Berjalan' ? 'selected' : '' ?>>Berjalan</option>
            <option value="Selesai" <?= $tugas['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            <option value="Batal" <?= $tugas['status'] == 'Batal' ? 'selected' : '' ?>>Batal</option>
        </select>
    </p>

    <!-- Input untuk Foto Baru -->
    <p>
        <label>Foto</label><br>
        <input name="foto" type="file">
    </p>

    <!-- Tombol Aksi -->
    <p>
        <a href="<?= base_url('tugas/sharedtome'); ?>">Kembali</a>
        <button type="submit">Ubah Tugas</button>
    </p>
</form>

<?= $this->endSection(); ?>