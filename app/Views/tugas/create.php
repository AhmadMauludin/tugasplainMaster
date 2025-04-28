<!-- Extend layout utama -->
<?= $this->extend('layouts/main'); ?>

<!-- Mulai section 'content' untuk ditampilkan di layout -->
<?= $this->section('content'); ?>

<!-- Form input tugas baru -->
<form action="<?= site_url('tugas/store') ?>" method="post" enctype="multipart/form-data">

    <!-- Input tersembunyi untuk menyimpan ID user yang login -->
    <input name="iduser" type="hidden" value="<?= session()->get('id') ?>" required />

    <!-- Input nama tugas -->
    <p>
        <label for="tugas">Tugas</label><br>
        <input name="tugas" type="text" id="tugas" required />
    </p>

    <!-- Input tanggal tugas -->
    <p>
        <label for="tanggal">Tanggal</label><br>
        <input type="date" name="tanggal" id="tanggal" />
    </p>

    <!-- Input waktu tugas -->
    <p>
        <label for="waktu">Waktu</label><br>
        <input type="time" name="waktu" id="waktu" />
    </p>

    <!-- Dropdown status tugas -->
    <p>
        <label for="status">Status</label><br>
        <select name="status" id="status">
            <option value="To do">To do</option>
            <option value="Berjalan">Berjalan</option>
            <option value="Selesai">Selesai</option>
            <option value="Batal">Batal</option>
        </select>
    </p>

    <!-- Input unggah foto -->
    <p>
        <label for="foto">Foto</label><br>
        <input name="foto" type="file" id="foto" />
    </p>

    <!-- Tombol navigasi dan submit -->
    <p>
        <a href="<?= base_url('tugas'); ?>">Kembali</a>
        <button type="submit">Tambah Tugas</button>
    </p>
</form>

<!-- Akhiri section 'content' -->
<?= $this->endSection(); ?>