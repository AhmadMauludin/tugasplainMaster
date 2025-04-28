<?php

namespace App\Controllers;

use App\Models\FriendshipModel;
use App\Models\UserModel;

class Friendship extends BaseController
{
    protected $friendshipModel;
    protected $userModel;

    public function __construct()
    {
        $this->friendshipModel = new FriendshipModel();
        $this->userModel = new UserModel();
    }

    // Menampilkan data pertemanan
    public function index()
    {
        $userId = session()->get('id');

        $data = [
            'title' => 'Pertemanan Anda',
            'friends' => $this->friendshipModel->getFriends($userId),
            'friendRequests' => $this->friendshipModel->getFriendRequests($userId),
            'sentRequests' => $this->friendshipModel->getSentRequests($userId)
        ];

        return view('friendship/index', $data);
    }

    // Menambahkan teman
    public function add()
    {
        $userId = session()->get('id');
        $friendId = $this->request->getPost('friend_id');

        // Validasi ID tidak kosong, bukan diri sendiri, dan numerik
        if (!$friendId || !is_numeric($friendId) || $friendId == $userId) {
            return redirect()->to('friendship/index')->with('error', 'ID teman tidak valid.');
        }

        // Periksa apakah user tersebut ada
        $friend = $this->userModel->find($friendId);
        if (!$friend) {
            return redirect()->to('friendship/index')->with('error', 'User dengan ID tersebut tidak ditemukan.');
        }

        // Periksa apakah sudah pernah mengirim permintaan atau sudah berteman
        $existing = $this->friendshipModel
            ->where('(user_id = ' . $userId . ' AND friend_id = ' . $friendId . ') 
                    OR (user_id = ' . $friendId . ' AND friend_id = ' . $userId . ')')
            ->first();

        if ($existing) {
            if ($existing['status'] == 'pending') {
                return redirect()->to('friendship/index')->with('info', 'Permintaan pertemanan sudah dikirim.');
            } else {
                return redirect()->to('friendship/index')->with('info', 'Kamu sudah berteman dengan user ini.');
            }
        }

        // Tambahkan permintaan
        $this->friendshipModel->addFriendRequest($userId, $friendId);
        return redirect()->to('friendship/index')->with('success', 'Permintaan pertemanan berhasil dikirim.');
    }

    // Menyetujui Pertemanan
    public function accept($id)
    {
        $this->friendshipModel->acceptFriendRequest($id);
        return redirect()->to('friendship/index')->with('success', 'Permintaan pertemanan diterima.');
    }

    // Menolak Pertemanan
    public function decline($id)
    {
        $this->friendshipModel->declineFriendRequest($id);
        return redirect()->to('friendship/index')->with('success', 'Permintaan pertemanan ditolak.');
    }

    // Menghapus pertemanan
    public function remove($id)
    {
        // Hapus pertemanan berdasarkan ID pertemanan
        $this->friendshipModel->removeFriendById($id);

        return redirect()->to('friendship/index')->with('success', 'Pertemanan berhasil dihapus.');
    }
}
// if this line is still there, it means I just copy paste my friend's UKK application