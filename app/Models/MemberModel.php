<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idgroups', 'iduser', 'memberlevel'];

    // Fungsi untuk mengambil member berdasarkan id group
    public function getMembersByGroup($idgroups)
    {
        return $this->select('member.*, user.nama, user.foto')
            ->join('user', 'user.id = member.iduser')
            ->where('member.idgroups', $idgroups)
            ->findAll();
    }

    public function getMembersByGroup2($groupId)
    {
        return $this->where('idgroups', $groupId)->findAll();
    }
}
