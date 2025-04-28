<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Menampilkan halaman views/user/index (data user, hanya dapaat diakses admin)
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = 10; // Jumlah data per halaman

        if ($keyword) {
            $user = $this->userModel->search($keyword, $perPage);
        } else {
            $user = $this->userModel->paginate($perPage);
        }

        $data = [
            'title'  => 'Data user',
            'user' => $user,
            'pager'  => $this->userModel->pager, // Untuk pagination
            'keyword' => $keyword
        ];
        return view('user/index', $data);
    }

    // Menampilkan halaman views/user/create (halaman daftar user)
    public function create()
    {
        $data = [
            'title'  => 'Tambah user',
        ];
        return view('user/create', $data);
    }

    // Menyimpan data user baru yang diinput dari halaman daftar
    public function store()
    {
        $model = new UserModel();
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'bagian' => $this->request->getPost('bagian'),
            'password' => $password,
            'foto' => $this->uploadFoto()
        ];

        $model->insert($data);
        return redirect()->to('/')->with('success', 'Anda telah terdaftar, silahkan login.');
    }

    // Menampilkan halaman views/user/edit (pengaturan)
    public function edit($id)
    {
        $data = [
            'title'  => 'Tambah user',
        ];

        $model = new UserModel();
        $data['user'] = $model->find($id);
        return view('user/edit', $data);
    }

    // Mengupdate data user yang diubah pada halaman edit (pengaturan)
    public function update($id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        $password = $this->request->getPost('password') ? password_hash($this->request->getPost('password'), PASSWORD_DEFAULT) : $user['password'];

        $data = [
            'nama' => $this->request->getPost('nama'),
            'bagian' => $this->request->getPost('bagian'),
            'password' => $password
        ];

        if ($foto = $this->uploadFoto()) {
            $data['foto'] = $foto;
        }

        $model->update($id, $data);
        return redirect()->to('/')->with('success', 'Data user berhasil diperbarui.');
    }

    // Menghapus data user (Hanya dapat dilakukan oleh admin)
    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to('/user')->with('success', 'Data user berhasil dihapus.');
    }

    // Upload foto untuk tambah atau edit user
    private function uploadFoto()
    {
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/user/', $newName);
            return $newName;
        }
        return null;
    }
}
// if this line is still there, it means I just copy paste my friend's UKK application