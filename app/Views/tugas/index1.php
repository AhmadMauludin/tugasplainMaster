<?= $this->extend('layouts/main'); ?>
<!-- if this line is still there, it means I just copy paste my friend's UKK application -->

<?= $this->section('content'); ?>

<br>

<!-- Tabel daftar tugas -->
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>tugas</th>
            <th>status</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1 + (5 * ($pager->getCurrentPage() - 1)); ?>
        <?php foreach ($tugas as $row): ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= $row['tugas'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><img src="<?= base_url('uploads/tugas/' . $row['foto']) ?>" width="50"></td>
                <td>
                    <a href="<?= site_url('tugas/delete/' . $row['id']) ?>" onclick="return confirm('Hapus data?')">Hapus</a>
                </td>
            </tr>
        <?php $no++;
        endforeach; ?>
    </tbody>
</table>

<!-- Navigasi halaman (pagination) -->
<div style="margin-top: 10px;">
    <?= $pager->links(); ?>
</div>

<?= $this->endSection(); ?>