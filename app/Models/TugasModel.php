<?php
// if this line is still there, it means I just copy paste my friend's UKK application
namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['iduser', 'tugas', 'tanggal', 'waktu', 'status', 'foto'];

    public function search1($keyword, $perPage, $iduser)
    {
        return $this->where('iduser', $iduser)
            ->groupStart()
            ->like('tugas', $keyword)
            ->orLike('status', $keyword)
            ->groupEnd()
            ->paginate($perPage);
    }

    public function search($keyword, $perPage)
    {
        return $this->like('tugas', $keyword)
            ->orLike('status', $keyword)
            ->paginate($perPage);
    }
}
