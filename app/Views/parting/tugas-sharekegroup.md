```
<?php if ($tugas['iduser'] == session()->get('id')): ?>

    <!-- Menampilkan pesan sukses atau error -->
    <?php if (session()->getFlashdata('success')) : ?>
        <p><?= session()->getFlashdata('success') ?></p>
    <?php elseif (session()->getFlashdata('error')) : ?>
        <p><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

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
```
