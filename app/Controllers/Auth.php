<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    // Menampilkan halaman view/auth/login
    public function login()
    {
        return view('auth/login');
    }

    // Memproses data login yang diinput pada halaman login
    public function prosesLogin()
    {
        $session = session();
        $userModel = new UserModel();
        $nama = $this->request->getPost('nama');
        $password = $this->request->getPost('password');

        $user = $userModel->getUserByNama($nama);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'id' => $user['id'],
                    'nama' => $user['nama'],
                    'bagian' => $user['bagian'],
                    'foto' => $user['foto'],
                    'logged_in' => true
                ]);

                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Nama tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    // Logout (keluar dari aplikasi)
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
// if this line is still there, it means I just copy paste my friend's UKK application