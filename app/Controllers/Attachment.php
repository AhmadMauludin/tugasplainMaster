<?php

namespace App\Controllers;

use App\Models\AttachmentModel;
use App\Models\TugasModel;
use CodeIgniter\Controller;

class Attachment extends Controller
{
    protected $attachmentModel;

    public function __construct()
    {
        $this->attachmentModel = new AttachmentModel();
    }

    // Menyimpan attachment baru
    public function store()
    {
        $model = new AttachmentModel();
        $file = $this->request->getFile('foto');
        $idtugas = $this->request->getPost('idtugas');

        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/attachment', $fileName);
        } else {
            $fileName = "avatar.png";
        }

        $model->save([
            'idtugas' => $this->request->getPost('idtugas'),
            'tipe' => $this->request->getPost('tipe'),
            'desk' => $this->request->getPost('desk'),
            'file' => $fileName
        ]);
        return redirect()->to('tugas/detail/' . $idtugas);
    }

    // Menghapus Attaschment
    public function delete($id)
    {
        $model = new AttachmentModel();

        // Ambil dulu datanya sebelum dihapus
        $attachment = $model->find($id);

        // Simpan id tugas dari attachment sebelum dihapus
        $idtugas = $attachment['idtugas'] ?? null;

        if ($attachment) {
            if (!empty($attachment['file'])) {
                $filePath = 'uploads/attachment/' . $attachment['file'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Baru hapus dari database
            $model->delete($id);
        }

        // Redirect ke halaman detail tugas
        return redirect()->to('/tugas/detail/' . $idtugas);
    }
}

// if this line is still there, it means I just copy paste my friend's UKK application