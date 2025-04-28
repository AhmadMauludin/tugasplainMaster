<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<!-- Header Teman -->
<div style="display: flex; align-items: center; padding: 10px; background:rgb(255, 255, 255); border-bottom: 1px solid #ccc;">
    <img src="<?= base_url('uploads/user/' . ($friend['foto'] ?? 'default.jpg')) ?>" alt="Foto" height="40" class="rounded-circle" style="object-fit:cover; width: 40px; margin-right: 10px;">
    <div>
        <strong><?= esc($friend['nama']) ?></strong>
        <small>[ id: <?= esc($friend['id']) ?> ]</small>
    </div>
</div>

<div class="chat-wrapper" style="display:flex; flex-direction:column; height:60vh;">
    <div id="chat-box" style="flex:1; overflow-y:auto; padding:10px;">
        <?php foreach ($chats as $chat): ?>
            <div class="chat-message <?= $chat['pengirim'] == $userId ? 'sent' : 'received' ?>">
                <div class="chat-bubble animate-pop">
                    <?= esc($chat['pesan']) ?>
                    <?php if ($chat['attachment']): ?>
                        <br><a href="<?= base_url('uploads/chat/' . $chat['attachment']) ?>" target="_blank" class="attachment">📎 Lampiran</a>
                    <?php endif; ?>
                    <div class="chat-time">
                        <?= date('H:i', strtotime($chat['datetime'])) ?>
                        <?php if ($chat['pengirim'] == $userId): ?>
                            <?php if ($chat['status'] == 'terkirim'): ?>
                                ✓
                            <?php elseif ($chat['status'] == 'dilihat'): ?>
                                ✓✓
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<br>
<form action="<?= base_url('chatfriend/send') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idfriendship" value="<?= $idfriendship ?>">
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
        position: relative;
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
    // Auto scroll ke bawah setiap reload
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;

    // Refresh otomatis tiap 1 menit
    setInterval(() => {
        location.reload();
    }, 60000);
</script>

<?= $this->endSection(); ?>