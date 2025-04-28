```
<!-- Form tambah attachment -->
<?php if ($tugas['iduser'] == session()->get('id')): ?>
    <h3>Tambah Attachment</h3>
    <form action="<?= base_url('attachment/store') ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idtugas" value="<?= $tugas['id'] ?>">

        <label for="tipeAttachment">Tipe</label>
        <select name="tipe" id="tipeAttachment" required>
            <option value="">Pilih Tipe</option>
            <option value="teks">teks</option>
            <option value="file">file</option>
            <option value="foto">foto</option>
            <option value="link">link</option>
            <option value="maps">maps</option>
            <option value="telp">telp</option>
        </select>

        <input type="text" name="desk" id="deskInput" placeholder="Deskripsi">
        <input type="file" name="foto" id="fileInput">

        <button type="submit">Tambahkan</button>
    </form>
<?php endif; ?>

<!-- Script untuk sembunyikan dan tampilkan input | Disimpan di paling bawah -->
<script>
    const tipeSelect = document.getElementById('tipeAttachment');
    const deskInput = document.getElementById('deskInput');
    const fileInput = document.getElementById('fileInput');

    function toggleFields() {
        const value = tipeSelect.value;
        if (value === 'teks' || value === 'telp' || value === 'link' || value === 'maps') {
            deskInput.style.display = 'block';
            fileInput.style.display = 'none';
        } else {
            deskInput.style.display = 'none';
            fileInput.style.display = 'block';
        }
    }

    toggleFields(); // saat pertama kali
    tipeSelect.addEventListener('change', toggleFields); // saat pilihan berubah
</script>
```
