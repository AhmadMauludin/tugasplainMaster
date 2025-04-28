<?php

namespace App\Controllers;

use App\Models\TugasModel;
use App\Models\UserModel;
use App\Models\SharedModel;
use App\Models\AttachmentModel;
use App\Models\FriendshipModel;
use CodeIgniter\Controller;

class Tugas extends Controller
{
    protected $tugasModel;
    protected $sharedModel;
    protected $userModel;
    protected $friendshipModel;

    public function __construct()
    {
        $this->tugasModel = new TugasModel();
        $this->userModel = new UserModel();
        $this->sharedModel = new SharedModel();
        $this->friendshipModel = new FriendshipModel();
    }

    // menampilkan halaman views/tugas/create
    public function create()
    {
        $data['title'] = 'Tambah tugas';
        return view('tugas/create', $data);
    }

    // simpan data tugas dari views/tugas/create.php
    public function store()
    {
        $tugasModel = new TugasModel();
        $sharedModel = new SharedModel();

        $file = $this->request->getFile('foto');

        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/tugas', $fileName);
        } else {
            $fileName = "avatar.png";
        }

        $dataTugas = [
            'iduser' => $this->request->getPost('iduser'),
            'tugas' => $this->request->getPost('tugas'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
            'foto' => $fileName
        ];

        // Simpan data tugas
        $tugasModel->save($dataTugas);

        // Ambil ID tugas yang baru disimpan
        $idtugas = $tugasModel->insertID();

        // Tambahkan ke shared untuk user itu sendiri
        $sharedModel->insert([
            'idtugas'    => $idtugas,
            'sharedto'   => $this->request->getPost('iduser'),
            'sharedtype' => 'user',
            'sharedby'   => $this->request->getPost('iduser'),
            'accepted'   => 'todo',
            'shareddate' => date('Y-m-d H:i:s'),
            'acceptdate' => date('Y-m-d H:i:s'),

        ]);

        return redirect()->to('tugas/index1')->with('success', 'Tugas berhasil dibuat dan dibagikan ke diri sendiri.');
    }

    // Menampilkan views/tugas/edit
    public function edit($id)
    {
        $data['title'] = 'Edit tugas';
        $model = new TugasModel();
        $data['tugas'] = $model->find($id);
        return view('tugas/edit', $data);
    }

    // Mengupdate data tugas dari views/tugas/edit
    public function update($id)
    {
        $model = new TugasModel();
        $file = $this->request->getFile('foto');

        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/tugas', $fileName);
        } else {
            $fileName = $this->request->getPost('old_foto');
        }

        $model->update($id, [
            'tugas' => $this->request->getPost('tugas'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
            'foto' => $fileName
        ]);
        return redirect()->to('tugas/index1');
    }

    //Menghapus data tugas
    public function delete($id)
    {
        $model = new TugasModel();
        $tugas = $model->find($id);

        if ($tugas && $tugas['foto']) {
            unlink('uploads/tugas/' . $tugas['foto']);
        }

        $model->delete($id);
        return redirect()->to('tugas/index1');
    }

    // Menampilkan halaman views/tugas/detail dan share.php
    public function detail($id)
    {
        $data['title'] = 'Detail tugas';
        $model = new AttachmentModel();
        $sharedModel = new SharedModel();
        $userModel = new \App\Models\UserModel();
        $memberModel = new \App\Models\MemberModel();
        $friendshipModel = new \App\Models\FriendshipModel();

        $data['attachment'] = $model->select('attachment.*')
            ->where('attachment.idtugas', $id)
            ->findAll();

        $data['tugas'] = $this->tugasModel
            ->select('tugas.*, user.nama')
            ->join('user', 'user.id = tugas.iduser', 'left')
            ->where('tugas.id', $id)
            ->first();

        $data['users'] = $userModel->where('bagian !=', 'admin')->findAll(); // exclude admin

        $userId = session()->get('id');
        $data['friends'] = $friendshipModel
            ->select('user.nama, user.foto, friendships.*')
            ->join('user', 'user.id = IF(friendships.user_id = ' . $userId . ', friendships.friend_id, friendships.user_id)')
            ->where('friendships.status', 'accepted')
            ->groupStart()
            ->where('friendships.user_id', $userId)
            ->orWhere('friendships.friend_id', $userId)
            ->groupEnd()
            ->findAll();

        $data['membership'] = $memberModel
            ->select('member.*, groups.groupname')
            ->join('groups', 'groups.id = member.idgroups')
            ->where('member.iduser', $userId)
            ->findAll();

        $data['idtugas'] = $id;

        $data['sharedList'] = $sharedModel
            ->select('shared.*, user.nama as namauser, groups.groupname as namagroup')
            ->join('user', 'user.id = shared.sharedto AND shared.sharedtype = "user"', 'left')
            ->join('groups', 'groups.id = shared.sharedto AND shared.sharedtype = "group"', 'left')
            ->where('idtugas', $id)
            ->findAll();

        return view('tugas/detail', $data); // pastikan `detail.php` menyertakan `share.php`
    }

    // Menampilkan halaman views/tugas/sharetome
    public function sharedToMe()
    {
        $sharedModel = new SharedModel();
        $userId = session()->get('id');

        $keyword = $this->request->getGet('keyword');

        // Semua tugas yang dibagikan ke user ini
        $sharedQuery = $sharedModel
            ->select('shared.*, tugas.tugas, tugas.tanggal, tugas.waktu, u.nama as sharedby_name')
            ->join('tugas', 'tugas.id = shared.idtugas')
            ->join('user u', 'u.id = shared.sharedby')
            ->where('shared.sharedto', $userId)
            ->where('shared.sharedtype', 'user');

        if ($keyword) {
            $sharedQuery->like('tugas.tugas', $keyword);
        }

        $sharedTasks = $sharedQuery->orderBy('shared.shareddate', 'DESC')->paginate(10);

        // Tugas yang belum diterima saja
        $pendingTasks = $sharedModel
            ->select('shared.*, tugas.tugas, tugas.tanggal, u.nama as sharedby_name')
            ->join('tugas', 'tugas.id = shared.idtugas')
            ->join('user u', 'u.id = shared.sharedby')
            ->where('shared.sharedto', $userId)
            ->where('shared.sharedtype', 'user')
            ->where('shared.accepted', 0)
            ->orderBy('shared.shareddate', 'DESC')
            ->findAll();

        return view('tugas/sharedtome', [
            'sharedTasks' => $sharedTasks,
            'title'   => 'Data Tugas',
            'pendingTasks' => $pendingTasks,
            'pager' => $sharedModel->pager,
        ]);
    }

    // Merubah status tugas menjadi Selesai
    public function selesai($id)
    {
        $tugasModel = new \App\Models\TugasModel();

        // Cari tugas berdasarkan ID
        $tugas = $tugasModel->find($id);

        // Update status menjadi "Selesai"
        $tugasModel->update($id, [
            'status' => 'Selesai'
        ]);

        return redirect()->to('/tugas/detail/' . $id)->with('success', 'Tugas berhasil ditandai sebagai selesai.');
    }

    public function index1()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = 10; // Jumlah data per halaman

        if ($keyword) {
            $tugas = $this->tugasModel->search($keyword, $perPage);
        } else {
            $tugas = $this->tugasModel->paginate($perPage);
        }

        $data = [
            'title'  => 'Data tugas',
            'tugas' => $tugas,
            'pager'  => $this->tugasModel->pager, // Untuk pagination
            'keyword' => $keyword
        ];
        return view('tugas/index1', $data);
    }
}


// if this line is still there, it means I just copy paste my friend's UKK application