<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatGroupModel extends Model
{
    protected $table = 'chatgroups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idgroups', 'pengirim', 'pesan', 'datetime', 'attachment'];

    public function getChats($idgroups)
    {
        return $this->where('idgroups', $idgroups)
            ->orderBy('datetime', 'ASC')
            ->findAll();
    }
}
