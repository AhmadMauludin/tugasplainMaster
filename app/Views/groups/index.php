<!-- Memanggil layout utama bernama 'main' dari folder layouts -->
<?= $this->extend('layouts/main'); ?>

<!-- Membuka section 'content' untuk meletakkan konten halaman -->
<?= $this->section('content'); ?>

<!-- Tombol untuk menambah grup baru, mengarah ke route groups/create -->
<div>
    <a href="<?= site_url('groups/create') ?>" class="btn btn-success">Tambah</a>
</div>
<br>

<!-- Tabel responsif untuk menampilkan daftar grup -->
<div>

    <!-- Jika tidak ada grup yang ditemukan -->
    <?php if (empty($groups)): ?>
        <!-- Tampilkan pesan info -->
        <div class="alert alert-info">Anda belum tergabung dalam grup manapun.</div>

    <?php else: ?>
        <!-- Jika ada grup, tampilkan dalam bentuk tabel -->
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Grup</th>
                    <th>Anggota</th>
                    <th>Anda Sebagai</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Variabel untuk nomor urut -->
                <?php $no = 1; ?>

                <!-- Looping setiap data grup -->
                <?php foreach ($groups as $row): ?>
                    <tr>
                        <!-- Nomor urut -->
                        <td><?= $no++ ?></td>

                        <!-- Nama grup -->
                        <td><strong><?= $row['groupname'] ?></strong></td>

                        <!-- Jumlah anggota dalam grup -->
                        <td><?= $row['total_member'] ?> orang</td>

                        <!-- Level user dalam grup (admin/member) -->
                        <td><?= $row['memberlevel'] ?></td>

                        <!-- Tampilkan foto grup jika ada -->
                        <td>
                            <?php if ($row['photo']): ?>
                                <img src="<?= base_url('uploads/groups/' . $row['photo']) ?>" width="50" alt="Foto Grup">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <!-- Aksi: detail, edit, hapus -->
                        <td>
                            <!-- Link untuk melihat detail grup -->
                            <a href="<?= site_url('groups/detail/' . $row['id']) ?>">[Lihat]</a>

                            <!-- Jika user adalah pemilik grup, tampilkan edit dan hapus -->
                            <?php if (session()->get('id') == $row['groupowner']): ?>
                                <!-- Link edit grup -->
                                <a href="<?= site_url('groups/edit/' . $row['id']) ?>">[Edit]</a>

                                <!-- Link hapus grup dengan konfirmasi -->
                                <a href="<?= site_url('groups/delete/' . $row['id']) ?>" onclick="return confirm('Hapus data?')">[Hapus]</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Menutup section 'content' -->
<?= $this->endSection(); ?>