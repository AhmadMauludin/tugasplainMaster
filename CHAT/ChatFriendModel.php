<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatFriendModel extends Model
{
    protected $table = 'chatfriend';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idfriendship', 'pengirim', 'pesan', 'datetime', 'attachment', 'status'];

    public function getChats($idfriendship)
    {
        return $this->where('idfriendship', $idfriendship)
            ->orderBy('datetime', 'ASC')
            ->findAll();
    }

    public function markAsSeen($idfriendship, $receiverId)
    {
        return $this->where('idfriendship', $idfriendship)
            ->where('pengirim !=', $receiverId)
            ->where('status', 'terkirim')
            ->set('status', 'dilihat')
            ->update();
    }
}
