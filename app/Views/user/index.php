<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<!-- Form pencarian user -->
<form action="<?= base_url('user') ?>" method="GET">
    <label for="search">Cari user:</label>
    <input
        type="text"
        name="keyword"
        id="search"
        value="<?= esc($_GET['keyword'] ?? '') ?>"
        placeholder="Search..." />
</form>

<br>

<!-- Tabel daftar user -->
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Nama</th>
            <th>Bagian</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1 + (5 * ($pager->getCurrentPage() - 1)); ?>
        <?php foreach ($user as $row): ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['bagian'] ?></td>
                <td><img src="<?= base_url('uploads/user/' . $row['foto']) ?>" width="50"></td>
                <td>
                    <a href="<?= site_url('user/delete/' . $row['id']) ?>" onclick="return confirm('Hapus data?')">Hapus</a>
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