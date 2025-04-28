<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsModel extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['groupname', 'createdby', 'groupowner', 'createddate', 'photo', 'password', 'description'];

    public function getMembers($groupId)
    {
        // Menggunakan query builder untuk mengambil anggota grup
        $builder = $this->db->table('member');
        $builder->select('member.iduser, user.nama'); // Menampilkan iduser dan nama user
        $builder->join('user', 'user.id = member.iduser');
        $builder->where('member.idgroups', $groupId);
        return $builder->get()->getResultArray(); // Mendapatkan hasil dalam bentuk array
    }
}
