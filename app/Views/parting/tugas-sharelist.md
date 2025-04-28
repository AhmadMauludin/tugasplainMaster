```

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
```
