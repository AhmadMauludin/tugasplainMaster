<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SharedModel;
use App\Models\MemberModel;
use App\Models\TugasModel;
use App\Models\UserModel;
use App\Models\GroupsModel;

class shared extends BaseController
{
    protected $sharedModel;

    public function __construct()
    {
        $this->sharedModel = new SharedModel();
    }

    // Menyimpan data sharing tugas ke user
    public function store()
    {
        $idtugas = $this->request->getPost('idtugas');
        $sharedto = $this->request->getPost('sharedto');
        $sharedtype = $this->request->getPost('sharedtype');
        $sharedby = session()->get('id');

        // Cek apakah sudah pernah dibagikan sebelumnya
        $alreadyShared = $this->sharedModel
            ->where('idtugas', $idtugas)
            ->where('sharedto', $sharedto)
            ->where('sharedtype', $sharedtype)
            ->first();

        if ($alreadyShared) {
            return redirect()->back()->with('error', 'Tugas sudah pernah dibagikan ke tujuan yang sama.');
        }

        $this->sharedModel->save([
            'idtugas'    => $idtugas,
            'sharedto'   => $sharedto,
            'sharedtype' => 'user',
            'sharedby'   => $sharedby,
            'shareddate' => date('Y-m-d H:i:s'),
            'accepted'   => "shared",
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil dibagikan');
    }

    // Menyimpan data sharing tugas ke group
    public function shareToGroup($idtugas)
    {
        $sharedModel = new SharedModel();
        $groupModel = new GroupsModel();
        $memberModel = new MemberModel();

        $groupId = $this->request->getPost('idgroups');
        $members = $memberModel->where('idgroups', $groupId)->findAll();

        $currentUserId = session()->get('id');

        foreach ($members as $member) {
            $targetUserId = $member['iduser'];

            // Skip jika user sama dengan yang sedang login
            if ($targetUserId == $currentUserId) {
                continue;
            }

            // Cek apakah sudah pernah dibagikan sebelumnya
            $alreadyShared = $sharedModel
                ->where('idtugas', $idtugas)
                ->where('sharedto', $targetUserId)
                ->where('sharedby', $currentUserId)
                ->first();

            // Jika belum pernah dibagikan, simpan
            if (!$alreadyShared) {
                $sharedModel->save([
                    'idtugas'     => $idtugas,
                    'sharedto'    => $targetUserId,
                    'sharedby'    => $currentUserId,
                    'sharedtype'  => 'user',
                    'accepted'    => 'shared',
                    'shareddate'  => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->to('tugas/detail/' . $idtugas)->with('success', 'Tugas berhasil dibagikan ke grup.');
    }

    // Menghapus sharing tugas dari halaman views/tugas/detail/share
    public function delete($id)
    {
        $model = new SharedModel();
        $shared = $model->find($id);

        if ($shared) {
            $idtugas = $shared['idtugas'];
            $model->delete($id);
            return redirect()->to('/tugas/detail/' . $idtugas)->with('success', 'Sharing berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data sharing tidak ditemukan.');
    }

    // Update status shared tugas pada halaman views/tugas/sharedtome
    public function updateStatusNext($id)
    {
        $sharedModel = new SharedModel();
        $shared = $sharedModel->find($id);

        if (!$shared) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Daftar urutan status
        $statusList = ['shared', 'todo', 'ongoing', 'done', 'canceled'];

        // Tentukan status saat ini
        $currentStatus = $shared['accepted'] ?? 'shared';

        // Cari indeks status saat ini
        $currentIndex = array_search($currentStatus, $statusList);

        // Tentukan status berikutnya (loop kembali ke awal jika sudah terakhir)
        $nextIndex = ($currentIndex + 1) % count($statusList);
        $nextStatus = $statusList[$nextIndex];

        // Siapkan data untuk update
        $dataToUpdate = ['accepted' => $nextStatus];
        $dataToUpdate['acceptdate'] = date('Y-m-d H:i:s');

        // Update data
        $sharedModel->update($id, $dataToUpdate);

        return redirect()->back()->with('success', 'Status tugas diperbarui menjadi: ' . ucfirst($nextStatus));
    }
}
// if this line is still there, it means I just copy paste my friend's UKK application