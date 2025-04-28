<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div style="padding:10px; border-bottom:1px solid #ccc; display:flex; align-items:center;">
    <img src="<?= base_url('uploads/groups/' . ($group['photo'] ?? 'default.jpg')) ?>" alt="Group Photo" height="50" class="rounded-circle" style="object-fit:cover; margin-right:10px;">
    <div>
        <strong><?= esc($group['groupname']) ?></strong><br>
        <small><?= count($members) ?> anggota</small> <a href="<?= site_url('groups/detail/' . $group['id']) ?>"><i class="bx bx-show me-1"></i></a>
    </div>
</div>

<div class="chat-wrapper" style="display:flex; flex-direction:column; height:60vh;">
    <div id="chat-box" style="flex:1; overflow-y:auto; padding:10px;">
        <?php foreach ($chats as $chat): ?>
            <div class="chat-message <?= $chat['pengirim'] == $userId ? 'sent' : 'received' ?>">
                <div class="chat-bubble animate-pop">
                    <img src="<?= base_url('uploads/user/' . ($chat['foto'] ?? 'default.jpg')) ?>" alt="Foto" height="30" class="rounded-circle" style="object-fit:cover; margin-right:5px;">
                    <strong><?= esc($chat['nama']) ?></strong> pada
                    <?= date('H:i', strtotime($chat['datetime'])) ?>

                    <hr>

                    <?= esc($chat['pesan']) ?>
                    <?php if ($chat['attachment']): ?>
                        <br><a href="<?= base_url('uploads/chatgroups/' . $chat['attachment']) ?>" target="_blank" class="attachment">📎 Lampiran</a>
                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<br>
<form action="<?= base_url('chatgroup/send') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idgroups" value="<?= $idgroup ?>">
    <div class="input-group">
        <input type="text" name="pesan" placeholder="Ketik pesan..." class="form-control" required>
        <input type="file" name="attachment" class="form-control">
        <button type="submit" class="btn btn-primary">Kirim</button>
    </div>
</form>
<style>
    .chat-message {
        display: flex;
        margin-bottom: 10px;
    }

    .chat-message.sent {
        justify-content: flex-end;
    }

    .chat-message.received {
        justify-content: flex-start;
    }

    .chat-bubble {
        max-width: 70%;
        padding: 10px;
        border-radius: 15px;
        background: #DCF8C6;
        box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
        word-wrap: break-word;
        font-size: 14px;
        animation: pop 0.3s ease-out;
    }

    .chat-message.received .chat-bubble {
        background: #ffffff;
    }

    .chat-time {
        font-size: 10px;
        color: #666;
        text-align: right;
        margin-top: 5px;
    }

    .attachment {
        color: #007bff;
        text-decoration: none;
        font-size: 12px;
    }

    @keyframes pop {
        from {
            transform: scale(0.8);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<script>
    // Auto scroll ke bawah
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;

    // Refresh tiap 1 menit
    setInterval(() => {
        location.reload();
    }, 60000);
</script>

<?= $this->endSection(); ?>