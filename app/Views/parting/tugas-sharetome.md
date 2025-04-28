```
<!-- Tampilkan pesan flash jika ada -->
<?php if (session()->getFlashdata('success')): ?>

    <p><?= session()->getFlashdata('success') ?></p>

<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>

    <p><?= session()->getFlashdata('error') ?></p>

<?php endif; ?>

<!-- Tabel daftar tugas yang dibagikan ke saya -->
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Tugas</th>
            <th>Oleh</th>
            <th>Dibagikan</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($sharedTasks) > 0): ?>
            <?php $no = 1; ?>
            <?php foreach ($sharedTasks as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['tugas']) ?></td>
                    <td><?= esc($row['sharedby_name']) ?></td>
                    <td><?= esc($row['shareddate']) ?></td>
                    <td><?= esc($row['tanggal']) ?> <?= esc($row['waktu']) ?></td>
                    <td>
                        <?php
                        // Cek status tugas dan tampilkan teks status tanpa CSS
                        $status = $row['accepted']; // atau 'status' jika field-nya diganti
                        switch ($status) {
                            case 'shared':
                                echo 'Shared';
                                break;
                            case 'todo':
                                echo 'To Do';
                                break;
                            case 'ongoing':
                                echo 'On Going';
                                break;
                            case 'done':
                                echo 'Done';
                                break;
                            case 'canceled':
                                echo 'Canceled';
                                break;
                            default:
                                echo 'Unknown';
                        }
                        ?>
                    </td>
                    <td>
                        <!-- Link ke detail tugas -->
                        <a href="<?= site_url('tugas/detail/' . $row['idtugas']) ?>">Detail</a> |

                        <!-- Link untuk update status -->
                        <a href="<?= site_url('shared/updateStatusNext/' . $row['id']) ?>">Ubah Status</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" align="center">Belum ada tugas yang dibagikan</td>
            </tr>
        <?php endif; ?>
    </tbody>

</table>
```
