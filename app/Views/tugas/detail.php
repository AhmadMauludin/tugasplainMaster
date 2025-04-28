<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<?php $idu = session('id'); ?>

<!-- Menampilkan gambar tugas -->
<center><img src="<?= base_url('uploads/tugas/' . $tugas['foto']) ?>" height="100"></center>
<!-- Menampilkan detail tugas -->
<h3>Detail Tugas</h3>
<p>Id tugas : <?= $tugas['id'] ?></p>
<p>Nama Tugas : <?= $tugas['tugas'] ?></p>
<p>Pembuat : <?= $tugas['nama'] ?></p>
<p>Tanggal, Waktu : <?= $tugas['tanggal'] ?>, <?= $tugas['waktu'] ?> WIB</p>
<p>Status tugas : <strong><?= $tugas['status'] ?></strong></p>

<!-- Menampilkan attachment -->
<h3>Attachment</h3>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Tipe</th>
            <th>File</th>
            <th>Desk</th>
            <?php if ($tugas['iduser'] == session()->get('id')): ?>
                <th>Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($attachment as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $b['tipe'] ?></td>
                <td>
                    <?php if (!empty($b['file'])): ?>
                        <a href="<?= base_url('uploads/attachment/' . $b['file']) ?>" target="_blank">
                            <?= $b['file'] ?>
                        </a>
                    <?php else: ?>
                        Tidak ada file
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($b['tipe'] === 'maps'): ?>
                        <a href="https://www.google.com/maps?q=<?= urlencode($b['desk']) ?>" target="_blank">
                            <?= esc($b['desk']) ?>
                        </a>
                    <?php elseif ($b['tipe'] === 'link'): ?>
                        <a href="<?= esc($b['desk']) ?>" target="_blank">
                            <?= esc($b['desk']) ?>
                        </a>
                    <?php else: ?>
                        <?= esc($b['desk']) ?>
                    <?php endif; ?>
                </td>
                <?php if ($tugas['iduser'] == session()->get('id')): ?>
                    <td>
                        <form action="<?= base_url('attachment/delete/' . $b['id']) ?>" method="post">
                            <button type="submit" onclick="return confirm('Hapus attachment ini?')">Hapus</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Form tambah attachment -->
<?php if ($tugas['iduser'] == session()->get('id')): ?>
    <h3>Tambah Attachment</h3>
    <form action="<?= base_url('attachment/store') ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idtugas" value="<?= $tugas['id'] ?>">

        <label for="tipeAttachment">Tipe</label>
        <select name="tipe" id="tipeAttachment" required>
            <option value="">Pilih Tipe</option>
            <option value="teks">teks</option>
            <option value="file">file</option>
            <option value="foto">foto</option>
            <option value="link">link</option>
            <option value="maps">maps</option>
            <option value="telp">telp</option>
        </select>

        <input type="text" name="desk" id="deskInput" placeholder="Deskripsi">
        <input type="file" name="foto" id="fileInput">

        <button type="submit">Tambahkan</button>
    </form>
<?php endif; ?>

<!-- Menyisipkan halaman share tugas -->
<?= $this->include('tugas/share') ?>

<!-- Navigasi tombol -->
<br>
<a href="<?= base_url('tugas/sharedtome'); ?>">Kembali</a>

<?php if ($tugas['iduser'] == session()->get('id')): ?>
    <?php if ($tugas['status'] != 'Selesai' && $tugas['status'] != 'Batal'): ?>
        <a href="<?= site_url('tugas/selesai/' . $tugas['id']) ?>" onclick="return confirm('Tandai tugas ini sebagai selesai?')">Selesai</a>
    <?php endif; ?>
    <a href="<?= site_url('tugas/edit/' . $tugas['id']) ?>">Edit</a>
    <a href="<?= site_url('tugas/delete/' . $tugas['id']) ?>" onclick="return confirm('Hapus data?')">Hapus</a>
<?php endif; ?>

<!-- Script untuk sembunyikan dan tampilkan input -->
<script>
    const tipeSelect = document.getElementById('tipeAttachment');
    const deskInput = document.getElementById('deskInput');
    const fileInput = document.getElementById('fileInput');

    function toggleFields() {
        const value = tipeSelect.value;
        if (value === 'teks' || value === 'telp' || value === 'link' || value === 'maps') {
            deskInput.style.display = 'block';
            fileInput.style.display = 'none';
        } else {
            deskInput.style.display = 'none';
            fileInput.style.display = 'block';
        }
    }

    toggleFields(); // saat pertama kali
    tipeSelect.addEventListener('change', toggleFields); // saat pilihan berubah
</script>

<?= $this->endSection(); ?>