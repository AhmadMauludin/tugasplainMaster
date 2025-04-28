<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\GroupsModel;
use App\Models\MemberModel;
use App\Models\UserModel;

class Groups extends Controller
{
    protected $groupsModel;
    protected $MemberModel;
    protected $userModel;

    public function __construct()
    {
        $this->groupsModel  = new GroupsModel();
        $this->MemberModel  = new MemberModel();
        $this->userModel    = new UserModel();
    }

    // Menampilkan halaman views/groups/detail
    public function detail($id)
    {
        $data['title'] = 'Detail Group & Member';

        // Ambil detail grup beserta nama pembuatnya
        $data['groups'] = $this->groupsModel
            ->select('groups.*, user.nama, user.foto')
            ->join('user', 'user.id = groups.createdby', 'left')
            ->where('groups.id', $id)
            ->first();

        if (!$data['groups']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Group dengan id $id tidak ditemukan.");
        }

        // Ambil member grup berdasarkan id group
        $data['member'] = $this->MemberModel->getMembersByGroup($id);

        // Ambil user yang belum menjadi member grup
        $data['user'] = $this->userModel->getUsersNotInGroup($id);

        // Cek apakah user yang login adalah admin dalam grup
        $userId = session()->get('id');
        $adminCheck = $this->MemberModel
            ->where('idgroups', $id)
            ->where('iduser', $userId)
            ->where('memberlevel', 'admin')
            ->first();

        $data['isAdmin'] = $adminCheck ? true : false;

        return view('groups/detail', $data);
    }

    // Menambahkan anggota groups dari halaman views/groups/detail
    public function addMember()
    {
        $idgroups = $this->request->getPost('idgroups');
        $iduser  = $this->request->getPost('iduser');
        $memberlevel  = $this->request->getPost('memberlevel');


        // Validasi data jika diperlukan, misalnya memastikan parameter tidak kosong

        // Simpan data ke tabel group_members
        $this->MemberModel->save([
            'idgroups' => $idgroups,
            'iduser'  => $iduser,
            'memberlevel'  => $memberlevel

        ]);

        return redirect()->to(base_url('groups/detail/' . $idgroups));
    }

    // Menghapus member groups
    public function removeMember($id)
    {
        // Ambil dulu data member untuk mendapatkan idgroups
        $membership = $this->MemberModel->find($id);
        $groups_id   = $membership['idgroups'] ?? null;

        if ($membership) {
            $this->MemberModel->delete($id);
        }

        return redirect()->to(base_url('groups/detail/' . $groups_id));
    }

    // Menampilkan halaman views/groups/index
    public function index()
    {
        $groupModel = new \App\Models\GroupsModel();
        $memberModel = new \App\Models\MemberModel();
        $userId = session()->get('id');

        $data = [
            'title' => 'Group Anda'
        ];

        // Ambil semua data member yang usernya adalah user login
        $memberships = $memberModel->where('iduser', $userId)->findAll();

        if (empty($memberships)) {
            // Jika user belum tergabung dalam grup manapun
            $data['groups'] = [];
            return view('groups/index', $data);
        }

        $groupIds = array_column($memberships, 'idgroups');

        // Ambil data grup berdasarkan idgroups yang dimiliki user
        $groups = $groupModel->whereIn('id', $groupIds)->findAll();

        foreach ($groups as &$group) {
            // Hitung jumlah anggota
            $group['total_member'] = $memberModel
                ->where('idgroups', $group['id'])
                ->countAllResults();

            // Ambil memberlevel user login
            foreach ($memberships as $member) {
                if ($member['idgroups'] == $group['id']) {
                    $group['memberlevel'] = $member['memberlevel'];
                    break;
                }
            }
        }

        $data['groups'] = $groups;
        return view('groups/index', $data);
    }

    // Menampilkan halaman views/groups/create
    public function create()
    {
        $data = [
            'title' => 'Tambah Group',
        ];
        return view('groups/create', $data);
    }

    // Menyimpan groups baru yang dibuat pada halaman views/groups/create
    public function store()
    {
        $model = new GroupsModel();
        $photo = $this->uploadFoto();

        $data = [
            'groupname'   => $this->request->getPost('groupname'),
            'description' => $this->request->getPost('description'),
            'photo'       => $photo,
            'createdby'   => $this->request->getPost('idu'),
            'groupowner'  => $this->request->getPost('idu'),
            'createddate' => date('Y-m-d H:i:s'),
            'password'    => $this->generatePassword()
        ];

        $model->insert($data);

        $memberModel = new MemberModel();
        $idGroupBaru = $model->getInsertID();

        $memberModel->save([
            'idgroups' => $idGroupBaru,
            'iduser' => $this->request->getPost('idu'),
            'memberlevel' => 'admin'
        ]);


        return redirect()->to('/groups')->with('success', 'Grup berhasil ditambahkan.');
    }

    // Upload foto groups untuk store atau update
    private function uploadFoto()
    {
        $file = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/groups/', $newName);
            return $newName;
        }
        return null;
    }

    // Generate password groups
    private function generatePassword($length = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }

    // Menampilkan halaman views/groups/edit
    public function edit($id)
    {
        $groups = $this->groupsModel->find($id);
        if (!$groups) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Group tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Group',
            'groups' => $groups
        ];
        return view('groups/edit', $data);
    }

    // Mengupdate data groups yang diubah pada halaman views/groups/edit
    public function update($id)
    {
        $group = $this->groupsModel->find($id);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Group tidak ditemukan');
        }

        $password = $this->request->getPost('password')
            ? ($this->request->getPost('password'))
            : $group['password'];

        $data = [
            'groupname'   => $this->request->getPost('groupname'),
            'createdby'   => $this->request->getPost('createdby'),
            'groupowner'  => $this->request->getPost('groupowner'),
            'description' => $this->request->getPost('description'),
            'password'    => $password
        ];

        if ($photo = $this->uploadFoto()) {
            $data['photo'] = $photo;
        }

        $this->groupsModel->update($id, $data);
        return redirect()->to('/groups')->with('success', 'Group berhasil diperbarui.');
    }

    // Menghapus groups
    public function delete($id)
    {
        $this->groupsModel->delete($id);
        return redirect()->to('/groups')->with('success', 'Group berhasil dihapus.');
    }
}
// if this line is still there, it means I just copy paste my friend's UKK application