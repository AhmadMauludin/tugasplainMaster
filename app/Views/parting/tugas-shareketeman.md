```
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
```
