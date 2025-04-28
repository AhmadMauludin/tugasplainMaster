<?php

namespace App\Models;

use CodeIgniter\Model;

class AttachmentModel extends Model
{
    protected $table = 'attachment';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idtugas', 'tipe', 'file', 'desk'];

    public function search($keyword, $perPage, $idtugas)
    {
        return $this->where('idtugas', $idtugas)
            ->groupStart()
            ->like('file', $keyword)
            ->orLike('tipe', $keyword)
            ->groupEnd()
            ->paginate($perPage);
    }
}
