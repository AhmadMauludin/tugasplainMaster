<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'bagian', 'password', 'foto'];

    public function getUserByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }

    public function search($keyword, $perPage)
    {
        return $this->like('nama', $keyword)
            ->orLike('bagian', $keyword)
            ->paginate($perPage);
    }

    public function getUsersNotInGroup($idgroups)
    {
        // Subquery: user yang sudah ada di grup
        $subquery = $this->db->table('member')
            ->select('iduser')
            ->where('idgroups', $idgroups);

        // Ambil user yang tidak di subquery dan bukan bagian admin
        return $this->whereNotIn('id', $subquery)
            ->where('bagian !=', 'admin') // HINDARI user bagian admin
            ->findAll();
    }
}
