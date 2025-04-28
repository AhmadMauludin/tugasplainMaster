<?php if ($tugas['iduser'] == session()->get('id')): ?>

    <!-- Menampilkan pesan sukses atau error -->
    <?php if (session()->getFlashdata('success')) : ?>
        <p><?= session()->getFlashdata('success') ?></p>
    <?php elseif (session()->getFlashdata('error')) : ?>
        <p><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <!-- Form untuk membagikan tugas ke teman -->
    <p><b>Share Tugas ke Teman</b></p>
    <form action="<?= base_url('/shared/store') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="idtugas" value="<?= $tugas['id'] ?>">

        <label>Share ke teman:</label><br>
        <select name="sharedto" id="sharedto" required>
            <option value="">Pilih Teman</option>
            <?php foreach ($friends as $friend): ?>
                <option value="<?= esc($friend['user_id']) ?>">
                    <?= esc($friend['user_id']) ?> - <?= esc($friend['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Share</button>
    </form>

    <br>

    <!-- Form untuk membagikan tugas ke grup -->
    <p><b>Share Tugas ke Grup</b></p>
    <form action="<?= site_url('shared/shareToGroup/' . $idtugas) ?>" method="post">
        <label>Share ke grup:</label><br>
        <select name="idgroups" id="idgroups">
            <option value="">Pilih Group</option>
            <?php foreach ($membership as $membership): ?>
                <option value="<?= $membership['idgroups'] ?>">
                    <?= $membership['idgroups'] ?> - <?= $membership['groupname'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="idtugas" value="<?= $idtugas ?>">
        <button type="submit">Share</button>
    </form>

<?php endif; ?>

<!-- Daftar tugas yang sudah dibagikan -->
<p><b>Terbagikan kepada:</b></p>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Tipe</th>
            <th>Nama Penerima</th>
            <th>Tanggal Dibagikan</th>
            <th>Status</th>
            <th>Diupdate pada</th>
            <?php if ($tugas['iduser'] == session()->get('id')): ?>
                <th>Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($sharedList)) : ?>
            <?php $no = 1; ?>
            <?php foreach ($sharedList as $shared) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= ucfirst($shared['sharedtype']) ?></td>
                    <td>
                        <?= $shared['sharedtype'] === 'user' ? $shared['namauser'] : $shared['namagroup'] ?>
                    </td>
                    <td><?= $shared['shareddate'] ?></td>
                    <td><?= $shared['accepted'] ?></td>
                    <td><?= $shared['acceptdate'] ?></td>
                    <?php if ($tugas['iduser'] == session()->get('id')): ?>
                        <td>
                            <form action="<?= site_url('shared/delete/' . $shared['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus sharing ini?')">
                                <?= csrf_field() ?>
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="7" align="center">Belum ada data sharing</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>

<!-- Script sederhana untuk filter opsi (jika fitur ini masih digunakan) -->
<script>
    document.getElementById('sharedtype')?.addEventListener('change', function() {
        const type = this.value;
        const options = document.querySelectorAll('#sharedto option');

        options.forEach(opt => {
            if (!opt.value) return;
            opt.style.display = (opt.dataset.type === type) ? 'block' : 'none';
        });

        document.getElementById('sharedto').value = '';
    });
</script>