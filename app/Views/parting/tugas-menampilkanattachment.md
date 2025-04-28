```
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
```
