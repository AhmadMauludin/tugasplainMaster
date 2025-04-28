```

<?php if ($tugas['iduser'] == session()->get('id')): ?>
    <?php if ($tugas['status'] != 'Selesai' && $tugas['status'] != 'Batal'): ?>
        <a href="<?= site_url('tugas/selesai/' . $tugas['id']) ?>" onclick="return confirm('Tandai tugas ini sebagai selesai?')">Selesai</a>
    <?php endif; ?>
    <a href="<?= site_url('tugas/edit/' . $tugas['id']) ?>">Edit</a>
    <a href="<?= site_url('tugas/delete/' . $tugas['id']) ?>" onclick="return confirm('Hapus data?')">Hapus</a>
<?php endif; ?>
```
